<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Borrow; // Import Borrow model
use App\Models\Editor; // Assuming Editor is needed for Book factory
use App\Enums\UserRole;
use App\Enums\CopyStatus;
use Laravel\Sanctum\Sanctum;

class CopyApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure an editor and book exist for copy creation
        Editor::factory()->create();
        Book::factory()->create();
    }

    /**
     * Test that an Admin user can view all copies.
     *
     * @return void
     */
    public function test_admin_can_view_all_copies()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create some copies
        $book = Book::factory()->create();
        Copy::factory()->count(5)->create(['id_book' => $book->id_book]);

        // Send a GET request to the copies index endpoint
        $response = $this->getJson('/api/copies');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all copies
        $response->assertJsonCount(5, 'data'); // Assuming the response uses a 'data' key

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'date_achat',
                    'etat_copy_liv',
                    // Add other expected copy attributes in the resource
                    'book' => [
                        'id',
                        'title',
                        // Add other expected book attributes
                    ],
                ]
            ]
        ]);
    }

    /**
     * Test that non-Admin users cannot view all copies.
     *
     * @return void
     */
    public function test_non_admin_cannot_view_all_copies()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);
        $studentUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::STUDENT->value,
        ]);
        $professorUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::PROFESSOR->value,
        ]);

        // Create some copies
        $book = Book::factory()->create();
        Copy::factory()->count(5)->create(['id_book' => $book->id_book]);

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->getJson('/api/copies');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/copies');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->getJson('/api/copies');
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can create a copy.
     *
     * @return void
     */
    public function test_admin_can_create_copy()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a book
        $book = Book::factory()->create();

        // Generate copy data
        $copyData = Copy::factory()->make([
            'id_book' => $book->id_book,
        ])->toArray();

        // Send a POST request to the copies store endpoint
        $response = $this->postJson('/api/copies', $copyData);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the copy is created in the database
        $this->assertDatabaseHas('copies', [
            'id_book' => $book->id_book,
            'date_achat' => $copyData['date_achat'],
            'etat_copy_liv' => $copyData['etat_copy_liv'],
        ]);
    }

    /**
     * Test that non-Admin users cannot create a copy.
     *
     * @return void
     */
    public function test_non_admin_cannot_create_copy()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);
        $studentUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::STUDENT->value,
        ]);
        $professorUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::PROFESSOR->value,
        ]);

        // Create a book
        $book = Book::factory()->create();

        // Generate copy data
        $copyData = Copy::factory()->make([
            'id_book' => $book->id_book,
        ])->toArray();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->postJson('/api/copies', $copyData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/copies', $copyData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/copies', $copyData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that any authenticated user can view a specific copy (if authorized).
     *
     * @return void
     */
    public function test_authenticated_user_can_view_specific_copy_if_authorized()
    {
        // Create a user (any authenticated user should be able to view copies)
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create a book and a copy
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);

        // Send a GET request to the copies show endpoint for the specific copy
        $response = $this->getJson('/api/copies/' . $copy->id_exemplaire);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct copy
        $response->assertJson([
            'data' => [
                'id' => $copy->id_exemplaire,
                'id_book' => $book->id_book,
                // Add other expected copy attributes in the resource
            ]
        ]);
    }

    /**
     * Test that an Admin user can update a copy.
     *
     * @return void
     */
    public function test_admin_can_update_copy()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a book and a copy to update
        $book = Book::factory()->create();
        $copyToUpdate = Copy::factory()->create(['id_book' => $book->id_book]);

        // Generate updated copy data
        $updatedCopyData = [
            'etat_copy_liv' => CopyStatus::ON_LOAN->value,
            'date_achat' => '2024-01-01',
        ];

        // Send a PUT request to the copies update endpoint for the specific copy
        $response = $this->putJson('/api/copies/' . $copyToUpdate->id_exemplaire, $updatedCopyData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the copy's details are updated in the database
        $this->assertDatabaseHas('copies', [
            'id_exemplaire' => $copyToUpdate->id_exemplaire,
            'etat_copy_liv' => CopyStatus::ON_LOAN->value,
            'date_achat' => '2024-01-01',
        ]);
    }

    /**
     * Test that non-Admin users cannot update a copy.
     *
     * @return void
     */
    public function test_non_admin_cannot_update_copy()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);
        $studentUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::STUDENT->value,
        ]);
        $professorUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::PROFESSOR->value,
        ]);

        // Create a book and a copy to update
        $book = Book::factory()->create();
        $copyToUpdate = Copy::factory()->create(['id_book' => $book->id_book]);

        // Generate updated copy data
        $updatedCopyData = [
            'etat_copy_liv' => CopyStatus::ON_LOAN->value,
        ];

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->putJson('/api/copies/' . $copyToUpdate->id_exemplaire, $updatedCopyData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->putJson('/api/copies/' . $copyToUpdate->id_exemplaire, $updatedCopyData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->putJson('/api/copies/' . $copyToUpdate->id_exemplaire, $updatedCopyData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can delete a copy with no active borrows.
     *
     * @return void
     */
    public function test_admin_can_delete_copy_with_no_active_borrows()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a book and a copy to delete (no borrows associated)
        $book = Book::factory()->create();
        $copyToDelete = Copy::factory()->create(['id_book' => $book->id_book]);

        // Send a DELETE request to the copies destroy endpoint for the specific copy
        $response = $this->deleteJson('/api/copies/' . $copyToDelete->id_exemplaire);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the copy is deleted from the database
        $this->assertDatabaseMissing('copies', [
            'id_exemplaire' => $copyToDelete->id_exemplaire,
        ]);
    }

    /**
     * Test that an Admin user cannot delete a copy with active borrows.
     *
     * @return void
     */
    public function test_admin_cannot_delete_copy_with_active_borrows()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a book, copy, and an active borrow for the copy
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $copyToDelete = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN->value]);
        Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copyToDelete->id_exemplaire,
            'status' => \App\Enums\BorrowStatus::ACTIVE->value,
        ]);

        // Send a DELETE request to the copies destroy endpoint for the specific copy
        $response = $this->deleteJson('/api/copies/' . $copyToDelete->id_exemplaire);

        // Assert bad request status (or forbidden if policy handles this)
        $response->assertStatus(400); // Assuming 400 Bad Request based on controller logic
        $response->assertJson(['message' => 'لا يمكن حذف النسخة لوجود إعارات نشطة مرتبطة بها.']);
    }

    /**
     * Test that non-Admin users cannot delete a copy.
     *
     * @return void
     */
    public function test_non_admin_cannot_delete_copy()
    {
        // Create non-Admin users
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);
        $studentUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::STUDENT->value,
        ]);
        $professorUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::PROFESSOR->value,
        ]);

        // Create a book and a copy to delete
        $book = Book::factory()->create();
        $copyToDelete = Copy::factory()->create(['id_book' => $book->id_book]);

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->deleteJson('/api/copies/' . $copyToDelete->id_exemplaire);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->deleteJson('/api/copies/' . $copyToDelete->id_exemplaire);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->deleteJson('/api/copies/' . $copyToDelete->id_exemplaire);
        $response->assertStatus(403); // Assert Forbidden
    }
}
