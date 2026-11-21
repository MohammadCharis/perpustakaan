<?php
namespace Database\Seeders;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder { public function run(): void { User::factory()->create(['name' => 'Librarian', 'email' => 'librarian@example.com']); $categories = collect(['Fiction', 'Technology', 'History'])->map(fn (string $name) => Category::create(['name' => $name])); Book::factory(15)->recycle($categories)->create(); Member::factory(8)->create(); } }
