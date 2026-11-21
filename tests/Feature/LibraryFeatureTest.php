<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
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
        $response = $this->actingAs($admin)->post(route('books.store'), ['category_id' => $category->id, 'isbn' => '9780000000001', 'title' => 'Buku Uji', 'author' => 'Penulis', 'stock' => 2]);
        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'Buku Uji']);
    }

    public function test_petugas_can_manage_members(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $this->actingAs($petugas)->get(route('members.index'))->assertOk();
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
}
