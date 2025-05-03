<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Editor;
use App\Enums\UserRole;
use Laravel\Sanctum\Sanctum;

class BookApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that any authenticated user can view all books.
     *
     * @return void
     */
    public function test_authenticated_user_can_view_all_books()
    {
        // Create a user (any authenticated user should be able to view books)
        $user = User::factory()->create();

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create some books
        Editor::factory()->create(); // Ensure an editor exists for books
        Book::factory()->count(5)->create();

        // Send a GET request to the books index endpoint
        $response = $this->getJson('/api/books');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all books
        $response->assertJsonCount(5, 'data'); // Assuming the response uses a 'data' key

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'auteur',
                    // Add other expected book attributes in the resource
                ]
            ]
        ]);
    }

    /**
     * Test that an Admin user can create a book.
     *
     * @return void
     */
    public function test_admin_can_create_book()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor
        $editor = Editor::factory()->create();

        // Generate book data
        $bookData = Book::factory()->make([
            'id_editor' => $editor->id_editor,
        ])->toArray();

        // Send a POST request to the books store endpoint
        $response = $this->postJson('/api/books', $bookData);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the book is created in the database
        $this->assertDatabaseHas('books', [
            'title' => $bookData['title'],
            'auteur' => $bookData['auteur'],
            'id_editor' => $editor->id_editor,
        ]);
    }

    /**
     * Test that non-Admin users cannot create a book.
     *
     * @return void
     */
    public function test_non_admin_cannot_create_book()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
        ]);
        $studentUser = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);
        $professorUser = User::factory()->create([
            'role' => UserRole::PROFESSOR,
        ]);

        // Create an editor
        $editor = Editor::factory()->create();

        // Generate book data
        $bookData = Book::factory()->make([
            'id_editor' => $editor->id_editor,
        ])->toArray();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->postJson('/api/books', $bookData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/books', $bookData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/books', $bookData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that any authenticated user can view a specific book.
     *
     * @return void
     */
    public function test_authenticated_user_can_view_specific_book()
    {
        // Create a user (any authenticated user should be able to view books)
        $user = User::factory()->create();

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create an editor and a book
        $editor = Editor::factory()->create();
        $book = Book::factory()->create([
            'id_editor' => $editor->id_editor,
        ]);

        // Send a GET request to the books show endpoint for the specific book
        $response = $this->getJson('/api/books/' . $book->id_book);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct book
        $response->assertJson([
            'data' => [
                'id' => $book->id_book,
                'title' => $book->title,
                'auteur' => $book->auteur,
                // Add other expected book attributes in the resource
            ]
        ]);
    }

    /**
     * Test that an Admin user can update a book.
     *
     * @return void
     */
    public function test_admin_can_update_book()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor and a book to update
        $editor = Editor::factory()->create();
        $bookToUpdate = Book::factory()->create([
            'id_editor' => $editor->id_editor,
        ]);

        // Generate updated book data
        $updatedBookData = [
            'title' => 'Updated Book Title',
            'auteur' => 'Updated Author',
            'num_page' => 500,
            'category' => 'Updated Category',
        ];

        // Send a PUT request to the books update endpoint for the specific book
        $response = $this->putJson('/api/books/' . $bookToUpdate->id_book, $updatedBookData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the book's details are updated in the database
        $this->assertDatabaseHas('books', [
            'id_book' => $bookToUpdate->id_book,
            'title' => 'Updated Book Title',
            'auteur' => 'Updated Author',
            'num_page' => 500,
            'category' => 'Updated Category',
        ]);
    }

    /**
     * Test that non-Admin users cannot update a book.
     *
     * @return void
     */
    public function test_non_admin_cannot_update_book()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
        ]);
        $studentUser = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);
        $professorUser = User::factory()->create([
            'role' => UserRole::PROFESSOR,
        ]);

        // Create an editor and a book to update
        $editor = Editor::factory()->create();
        $bookToUpdate = Book::factory()->create([
            'id_editor' => $editor->id_editor,
        ]);

        // Generate updated book data
        $updatedBookData = [
            'title' => 'Attempted Updated Title',
        ];

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->putJson('/api/books/' . $bookToUpdate->id_book, $updatedBookData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->putJson('/api/books/' . $bookToUpdate->id_book, $updatedBookData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->putJson('/api/books/' . $bookToUpdate->id_book, $updatedBookData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can delete a book.
     *
     * @return void
     */
    public function test_admin_can_delete_book()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor and a book to delete
        $editor = Editor::factory()->create();
        $bookToDelete = Book::factory()->create([
            'id_editor' => $editor->id_editor,
        ]);

        // Send a DELETE request to the books destroy endpoint for the specific book
        $response = $this->deleteJson('/api/books/' . $bookToDelete->id_book);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the book is deleted from the database
        $this->assertDatabaseMissing('books', [
            'id_book' => $bookToDelete->id_book,
        ]);
    }

    /**
     * Test that non-Admin users cannot delete a book.
     *
     * @return void
     */
    public function test_non_admin_cannot_delete_book()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
        ]);
        $studentUser = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);
        $professorUser = User::factory()->create([
            'role' => UserRole::PROFESSOR,
        ]);

        // Create an editor and a book to delete
        $editor = Editor::factory()->create();
        $bookToDelete = Book::factory()->create([
            'id_editor' => $editor->id_editor,
        ]);

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->deleteJson('/api/books/' . $bookToDelete->id_book);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->deleteJson('/api/books/' . $bookToDelete->id_book);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->deleteJson('/api/books/' . $bookToDelete->id_book);
        $response->assertStatus(403); // Assert Forbidden
    }
}
