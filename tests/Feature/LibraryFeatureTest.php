<?php

namespace Tests\Feature;

use App\Enums\LoanStatus;
use App\LoanService;
use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_book(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('books.store'), [
            'category_id' => $category->id,
            'isbn' => '9780000000001',
            'title' => 'Buku Uji',
            'author' => 'Penulis',
            'stock' => 2,
        ]);

        $response->assertRedirect(route('books.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('books', ['title' => 'Buku Uji']);
    }

    public function test_petugas_can_manage_members(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($petugas)->get(route('members.index'))->assertOk();

        $this->actingAs($petugas)->post(route('members.store'), [
            'member_code' => 'AGT-9999',
            'name' => 'Anggota Baru',
            'email' => 'anggota@example.test',
            'joined_at' => '2026-11-22',
            'is_active' => true,
        ])->assertRedirect(route('members.index'));

        $this->assertDatabaseHas('members', [
            'member_code' => 'AGT-9999',
            'email' => 'anggota@example.test',
            'joined_at' => '2026-11-22 00:00:00',
        ]);
    }

    public function test_admin_can_borrow_and_return_book(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create(['stock' => 1]);
        $member = Member::factory()->create();

        $this->actingAs($admin)->post(route('loans.store'), ['book_id' => $book->id, 'member_id' => $member->id])->assertRedirect(route('loans.index'));
        $loan = $member->loans()->first();

        $this->assertSame(0, $book->fresh()->stock);

        $this->actingAs($admin)->post(route('loans.return', $loan))->assertRedirect(route('loans.index'));
        $this->assertNotNull($loan->fresh()->returned_at);
        $this->assertSame(1, $book->fresh()->stock);
    }

    public function test_reports_can_be_filtered_by_date_range(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $inRange = Loan::factory()->create(['loan_date' => '2026-11-10', 'due_date' => '2026-11-17']);
        $outRange = Loan::factory()->create(['loan_date' => '2026-10-01', 'due_date' => '2026-10-08']);

        $response = $this->actingAs($user)->get(route('reports.index', [
            'start_date' => '2026-11-01',
            'end_date' => '2026-11-30',
        ]));

        $response->assertOk();
        $response->assertSee($inRange->book->title);
        $response->assertDontSee($outRange->book->title);
    }

    public function test_petugas_cannot_access_admin_only_routes(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $category = Category::factory()->create();
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $this->actingAs($petugas)->get(route('categories.index'))->assertForbidden();
        $this->actingAs($petugas)->delete(route('books.destroy', $book))->assertForbidden();
        $this->actingAs($petugas)->delete(route('members.destroy', $member))->assertForbidden();
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_book_with_loan_history_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create();
        Loan::factory()->for($book)->create(['returned_at' => now(), 'status' => LoanStatus::Dikembalikan]);

        $response = $this->actingAs($admin)->delete(route('books.destroy', $book));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    public function test_mark_overdue_creates_fines_for_late_loans(): void
    {
        $loan = Loan::factory()->create([
            'loan_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(3)->toDateString(),
            'returned_at' => null,
            'status' => LoanStatus::Dipinjam,
        ]);

        $updated = app(LoanService::class)->markOverdue();

        $this->assertSame(1, $updated);
        $this->assertDatabaseHas('loans', ['id' => $loan->id, 'status' => LoanStatus::Terlambat->value]);
        $this->assertDatabaseHas('fines', ['loan_id' => $loan->id, 'status' => 'belum_dibayar', 'days_late' => 3]);
        $this->assertSame(3000, (int) Fine::where('loan_id', $loan->id)->value('amount'));
    }
}
