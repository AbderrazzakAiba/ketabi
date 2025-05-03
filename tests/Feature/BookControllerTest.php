<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Editor;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Enums\CopyStatus;
use Laravel\Sanctum\Sanctum;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $adminUser;
    protected $employeeUser;
    protected $studentUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users with different roles
        $this->adminUser = User::factory()->create([
            'role' => UserRole::Admin->value,
            'status' => UserStatus::APPROVED,
        ]);
        $this->employeeUser = User::factory()->create([
            'role' => UserRole::Employee->value,
            'status' => UserStatus::APPROVED,
        ]);
        $this->studentUser = User::factory()->create([
            'role' => UserRole::Student->value,
            'status' => UserStatus::APPROVED,
        ]);
    }

    /**
     * Test that an admin can view all books.
     */
    public function test_admin_can_view_all_books(): void
    {
        Book::factory()->count(3)->create();

        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test that an employee can view all books.
     */
    public function test_employee_can_view_all_books(): void
    {
        Book::factory()->count(3)->create();

        Sanctum::actingAs($this->employeeUser);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test that a student can view all books.
     */
    public function test_student_can_view_all_books(): void
    {
        Book::factory()->count(3)->create();

        Sanctum::actingAs($this->studentUser);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test that an unauthorized user cannot view all books.
     */
    public function test_unauthorized_user_cannot_view_all_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(401); // Unauthorized
    }

    /**
     * Test that an admin can view a specific book.
     */
    public function test_admin_can_view_specific_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $book->title]);
    }

    /**
     * Test that an employee can view a specific book.
     */
    public function test_employee_can_view_specific_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->employeeUser);

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $book->title]);
    }

    /**
     * Test that a student can view a specific book.
     */
    public function test_student_can_view_specific_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->studentUser);

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $book->title]);
    }

    /**
     * Test that an unauthorized user cannot view a specific book.
     */
    public function test_unauthorized_user_cannot_view_specific_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(401); // Unauthorized
    }

    /**
     * Test that an admin can create a book.
     */
    public function test_admin_can_create_book(): void
    {
        $editor = Editor::factory()->create();
        $bookData = [
            'title' => $this->faker->sentence,
            'auteur' => $this->faker->name,
            'num_page' => $this->faker->numberBetween(50, 500),
            'num_RGE' => $this->faker->unique()->randomNumber(5),
            'category' => $this->faker->word,
            'quantite' => $this->faker->numberBetween(1, 10),
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->adminUser);

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => $bookData['title']]);

        $this->assertDatabaseHas('books', ['title' => $bookData['title']]);
        $this->assertDatabaseCount('copies', $bookData['quantite']);
    }

    /**
     * Test that an employee can create a book.
     */
    public function test_employee_can_create_book(): void
    {
        $editor = Editor::factory()->create();
        $bookData = [
            'title' => $this->faker->sentence,
            'auteur' => $this->faker->name,
            'num_page' => $this->faker->numberBetween(50, 500),
            'num_RGE' => $this->faker->unique()->randomNumber(5),
            'category' => $this->faker->word,
            'quantite' => $this->faker->numberBetween(1, 10),
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->employeeUser);

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => $bookData['title']]);

        $this->assertDatabaseHas('books', ['title' => $bookData['title']]);
        $this->assertDatabaseCount('copies', $bookData['quantite']);
    }

    /**
     * Test that a student cannot create a book.
     */
    public function test_student_cannot_create_book(): void
    {
        $editor = Editor::factory()->create();
        $bookData = [
            'title' => $this->faker->sentence,
            'auteur' => $this->faker->name,
            'num_page' => $this->faker->numberBetween(50, 500),
            'num_RGE' => $this->faker->unique()->randomNumber(5),
            'category' => $this->faker->word,
            'quantite' => $this->faker->numberBetween(1, 10),
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->studentUser);

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('books', ['title' => $bookData['title']]);
    }

    /**
     * Test that an unauthorized user cannot create a book.
     */
    public function test_unauthorized_user_cannot_create_book(): void
    {
        $editor = Editor::factory()->create();
        $bookData = [
            'title' => $this->faker->sentence,
            'auteur' => $this->faker->name,
            'num_page' => $this->faker->numberBetween(50, 500),
            'num_RGE' => $this->faker->unique()->randomNumber(5),
            'category' => $this->faker->word,
            'quantite' => $this->faker->numberBetween(1, 10),
            'id_editor' => $editor->id,
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(401); // Unauthorized
        $this->assertDatabaseMissing('books', ['title' => $bookData['title']]);
    }

    /**
     * Test that an admin can update a book.
     */
    public function test_admin_can_update_book(): void
    {
        $book = Book::factory()->create();
        $editor = Editor::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'auteur' => 'Updated Author',
            'num_page' => 600,
            'num_RGE' => '98765',
            'category' => 'Updated Category',
            'quantite' => 5, // Note: Quantity update logic is not fully implemented in controller
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->adminUser);

        $response = $this->putJson('/api/books/' . $book->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }

    /**
     * Test that an employee can update a book.
     */
    public function test_employee_can_update_book(): void
    {
        $book = Book::factory()->create();
        $editor = Editor::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'auteur' => 'Updated Author',
            'num_page' => 600,
            'num_RGE' => '98765',
            'category' => 'Updated Category',
            'quantite' => 5, // Note: Quantity update logic is not fully implemented in controller
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->employeeUser);

        $response = $this->putJson('/api/books/' . $book->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }

    /**
     * Test that a student cannot update a book.
     */
    public function test_student_cannot_update_book(): void
    {
        $book = Book::factory()->create();
        $editor = Editor::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'auteur' => 'Updated Author',
            'num_page' => 600,
            'num_RGE' => '98765',
            'category' => 'Updated Category',
            'quantite' => 5,
            'id_editor' => $editor->id,
        ];

        Sanctum::actingAs($this->studentUser);

        $response = $this->putJson('/api/books/' . $book->id, $updatedData);

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('books', ['title' => 'Updated Title']);
    }

    /**
     * Test that an unauthorized user cannot update a book.
     */
    public function test_unauthorized_user_cannot_update_book(): void
    {
        $book = Book::factory()->create();
        $editor = Editor::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'auteur' => 'Updated Author',
            'num_page' => 600,
            'num_RGE' => '98765',
            'category' => 'Updated Category',
            'quantite' => 5,
            'id_editor' => $editor->id,
        ];

        $response = $this->putJson('/api/books/' . $book->id, $updatedData);

        $response->assertStatus(401); // Unauthorized
        $this->assertDatabaseMissing('books', ['title' => 'Updated Title']);
    }

    /**
     * Test that an admin can delete a book.
     */
    public function test_admin_can_delete_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->adminUser);

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Book deleted successfully.']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test that an employee can delete a book.
     */
    public function test_employee_can_delete_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->employeeUser);

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Book deleted successfully.']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test that a student cannot delete a book.
     */
    public function test_student_cannot_delete_book(): void
    {
        $book = Book::factory()->create();

        Sanctum::actingAs($this->studentUser);

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    /**
     * Test that an unauthorized user cannot delete a book.
     */
    public function test_unauthorized_user_cannot_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(401); // Unauthorized
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    /**
     * Test that an admin can view the book inventory.
     */
    public function test_admin_can_view_book_inventory(): void
    {
        // Create a book with copies
        $book = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::AVAILABLE->value]);
        $copy2 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::BORROWED->value]);

        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/books/inventory');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'title',
                             'auteur',
                             'num_page',
                             'num_RGE',
                             'category',
                             'quantite',
                             'etat_liv',
                             'id_editor',
                             'copies' => [
                                 '*' => [
                                     'id',
                                     'id_book',
                                     'etat_copy_liv',
                                     'date_achat',
                                 ]
                             ]
                         ]
                     ]
                 ])
                 ->assertJsonCount(1, $response['data']) // Assert one book
                 ->assertJsonCount(2, $response['data'][0]['copies']); // Assert two copies for the book
    }

    /**
     * Test that an employee can view the book inventory.
     */
    public function test_employee_can_view_book_inventory(): void
    {
        // Create a book with copies
        $book = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::AVAILABLE->value]);
        $copy2 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::BORROWED->value]);

        Sanctum::actingAs($this->employeeUser);

        $response = $this->getJson('/api/books/inventory');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'title',
                             'auteur',
                             'num_page',
                             'num_RGE',
                             'category',
                             'quantite',
                             'etat_liv',
                             'id_editor',
                             'copies' => [
                                 '*' => [
                                     'id',
                                     'id_book',
                                     'etat_copy_liv',
                                     'date_achat',
                                 ]
                             ]
                         ]
                     ]
                 ])
                 ->assertJsonCount(1, $response['data']) // Assert one book
                 ->assertJsonCount(2, $response['data'][0]['copies']); // Assert two copies for the book
    }

    /**
     * Test that a student cannot view the book inventory.
     */
    public function test_student_cannot_view_book_inventory(): void
    {
        // Create a book with copies
        $book = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::AVAILABLE->value]);
        $copy2 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::BORROWED->value]);

        Sanctum::actingAs($this->studentUser);

        $response = $this->getJson('/api/books/inventory');

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test that an unauthorized user cannot view the book inventory.
     */
    public function test_unauthorized_user_cannot_view_book_inventory(): void
    {
        // Create a book with copies
        $book = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::AVAILABLE->value]);
        $copy2 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::BORROWED->value]);

        $response = $this->getJson('/api/books/inventory');

        $response->assertStatus(401); // Unauthorized
    }
}
