<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Borrow;
use App\Models\Editor; // Assuming Editor is needed for Book factory
use App\Enums\UserRole;
use App\Enums\BorrowStatus;
use App\Enums\CopyStatus;
use App\Enums\LoanType;
use Laravel\Sanctum\Sanctum;
use Carbon\Carbon;

class BorrowApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure an editor exists for book creation
        Editor::factory()->create();
    }

    /**
     * Test that an Admin user can view all borrows.
     *
     * @return void
     */
    public function test_admin_can_view_all_borrows()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create some borrows
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        Borrow::factory()->count(5)->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
        ]);

        // Send a GET request to the borrows index endpoint
        $response = $this->getJson('/api/borrows');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all borrows
        $response->assertJsonCount(5, 'data'); // Assuming the response uses a 'data' key

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'borrow_date',
                    'status',
                    // Add other expected borrow attributes in the resource
                    'user' => [
                        'id',
                        'first_name',
                        // Add other expected user attributes
                    ],
                    'copy' => [
                        'id',
                        'book' => [
                            'id',
                            'title',
                            // Add other expected book attributes
                        ],
                    ],
                ]
            ]
        ]);
    }

    /**
     * Test that non-Admin users can only view their own borrows.
     *
     * @return void
     */
    public function test_non_admin_can_view_only_own_borrows()
    {
        // Create a regular user (e.g., Student)
        $user = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create some borrows for this user
        $book1 = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book1->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy1->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);

        $book2 = Book::factory()->create();
        $copy2 = Copy::factory()->create(['id_book' => $book2->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy2->id_exemplaire,
            'status' => BorrowStatus::RETURNED,
        ]);

        // Create borrows for another user
        $otherUser = User::factory()->create();
        $book3 = Book::factory()->create();
        $copy3 = Copy::factory()->create(['id_book' => $book3->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        Borrow::factory()->create([
            'id_User' => $otherUser->id_User,
            'id_exemplaire' => $copy3->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);


        // Send a GET request to the borrows index endpoint
        $response = $this->getJson('/api/borrows');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains only the user's borrows
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user' => [
                        'id',
                    ],
                ]
            ]
        ]);
        $response->assertJsonFragment(['id' => $user->id_User]);
        $response->assertJsonMissing(['id' => $otherUser->id_User]);
    }

    /**
     * Test that any authenticated user can view a specific borrow (if authorized).
     *
     * @return void
     */
    public function test_authenticated_user_can_view_specific_borrow_if_authorized()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create a borrow for this user
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $borrow = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
        ]);

        // Send a GET request to the borrows show endpoint for the specific borrow
        $response = $this->getJson('/api/borrows/' . $borrow->id_pret);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct borrow
        $response->assertJson([
            'data' => [
                'id' => $borrow->id_pret,
                'user' => [
                    'id' => $user->id_User,
                ],
                'copy' => [
                    'id' => $copy->id_exemplaire,
                ],
            ]
        ]);
    }

    /**
     * Test that a user cannot view a borrow they are not authorized to view.
     *
     * @return void
     */
    public function test_user_cannot_view_unauthorized_borrow()
    {
        // Create a user (e.g., Student)
        $user = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create a borrow for another user
        $otherUser = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $otherBorrow = Borrow::factory()->create([
            'id_User' => $otherUser->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
        ]);

        // Send a GET request to view the other user's borrow
        $response = $this->getJson('/api/borrows/' . $otherBorrow->id_pret);

        // Assert Forbidden status
        $response->assertStatus(403);
    }

    /**
     * Test that a user can create a borrow request.
     *
     * @return void
     */
    public function test_user_can_create_borrow_request()
    {
        // Create a user (e.g., Student)
        $user = User::factory()->create([
            'role' => UserRole::STUDENT,
            'status' => \App\Enums\UserStatus::APPROVED, // User must be approved to borrow
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create an available copy
        $book = Book::factory()->create();
        $availableCopy = Copy::factory()->create([
            'id_book' => $book->id_book,
            'etat_copy_liv' => CopyStatus::AVAILABLE,
        ]);

        // Borrow data
        $borrowData = [
            'copy_id' => $availableCopy->id_exemplaire,
            'type' => LoanType::EXTERNAL->value,
        ];

        // Send a POST request to create a borrow
        $response = $this->postJson('/api/borrows', $borrowData);

        // Assert successful creation
        $response->assertStatus(201);

        // Assert borrow record is created in the database
        $this->assertDatabaseHas('borrows', [
            'id_User' => $user->id_User,
            'id_exemplaire' => $availableCopy->id_exemplaire,
            'type' => LoanType::EXTERNAL->value,
            'status' => BorrowStatus::ACTIVE->value,
        ]);

        // Assert copy status is updated to ON_LOAN
        $this->assertDatabaseHas('copies', [
            'id_exemplaire' => $availableCopy->id_exemplaire,
            'etat_copy_liv' => CopyStatus::ON_LOAN->value,
        ]);
    }

    /**
     * Test that a user cannot create a borrow request for an unavailable copy.
     *
     * @return void
     */
    public function test_user_cannot_borrow_unavailable_copy()
    {
        // Create a user
        $user = User::factory()->create([
             'status' => \App\Enums\UserStatus::APPROVED,
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create an unavailable copy
        $book = Book::factory()->create();
        $unavailableCopy = Copy::factory()->create([
            'id_book' => $book->id_book,
            'etat_copy_liv' => CopyStatus::ON_LOAN, // Or any other unavailable status
        ]);

        // Borrow data
        $borrowData = [
            'copy_id' => $unavailableCopy->id_exemplaire,
            'type' => LoanType::EXTERNAL->value,
        ];

        // Send a POST request to create a borrow
        $response = $this->postJson('/api/borrows', $borrowData);

        // Assert forbidden or bad request status
        $response->assertStatus(400); // Assuming 400 Bad Request for business logic error
        $response->assertJson(['message' => 'هذه النسخة غير متاحة للاستعارة حاليًا.']);
    }

    /**
     * Test that a user cannot exceed their borrowing limit.
     *
     * @return void
     */
    public function test_user_cannot_exceed_borrowing_limit()
    {
        // Create a student user with a limit of 3
        $user = User::factory()->create([
            'role' => UserRole::STUDENT,
            'status' => \App\Enums\UserStatus::APPROVED,
        ]);

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Create 3 active borrows for this user
        $book = Book::factory()->create();
        for ($i = 0; $i < 3; $i++) {
            $copy = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
            Borrow::factory()->create([
                'id_User' => $user->id_User,
                'id_exemplaire' => $copy->id_exemplaire,
                'status' => BorrowStatus::ACTIVE,
            ]);
        }

        // Create another available copy
        $anotherBook = Book::factory()->create();
        $availableCopy = Copy::factory()->create([
            'id_book' => $anotherBook->id_book,
            'etat_copy_liv' => CopyStatus::AVAILABLE,
        ]);

        // Attempt to create a 4th borrow
        $borrowData = [
            'copy_id' => $availableCopy->id_exemplaire,
            'type' => LoanType::EXTERNAL->value,
        ];

        $response = $this->postJson('/api/borrows', $borrowData);

        // Assert forbidden or bad request status
        $response->assertStatus(400); // Assuming 400 Bad Request for business logic error
        $response->assertJson(['message' => 'لقد وصلت إلى الحد الأقصى من الإعارات المسموح بها (3 كتب).']);
    }

    /**
     * Test that an Employee can return a borrowed book.
     *
     * @return void
     */
    public function test_employee_can_return_borrowed_book()
    {
        // Create an Employee user
        $employeeUser = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
        ]);

        // Authenticate as the Employee user
        Sanctum::actingAs($employeeUser);

        // Create a user who borrowed a book
        $borrowingUser = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        $borrow = Borrow::factory()->create([
            'id_User' => $borrowingUser->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);

        // Send a POST request to the return endpoint
        $response = $this->postJson('/api/borrows/' . $borrow->id_pret . '/return');

        // Assert successful return
        $response->assertStatus(200);

        // Assert borrow status is updated to RETURNED
        $this->assertDatabaseHas('borrows', [
            'id_pret' => $borrow->id_pret,
            'status' => BorrowStatus::RETURNED->value,
        ]);

        // Assert copy status is updated to AVAILABLE
        $this->assertDatabaseHas('copies', [
            'id_exemplaire' => $copy->id_exemplaire,
            'etat_copy_liv' => CopyStatus::AVAILABLE->value,
        ]);
    }

    /**
     * Test that non-Employee users cannot return a borrowed book.
     *
     * @return void
     */
    public function test_non_employee_cannot_return_borrowed_book()
    {
        // Create non-Employee users
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);
        $studentUser = User::factory()->create([
            'role' => UserRole::STUDENT,
        ]);
        $professorUser = User::factory()->create([
            'role' => UserRole::PROFESSOR,
        ]);

        // Create a borrow
        $borrowingUser = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        $borrow = Borrow::factory()->create([
            'id_User' => $borrowingUser->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);

        // Test as Admin
        Sanctum::actingAs($adminUser);
        $response = $this->postJson('/api/borrows/' . $borrow->id_pret . '/return');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/borrows/' . $borrow->id_pret . '/return');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/borrows/' . $borrow->id_pret . '/return');
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can update a borrow.
     *
     * @return void
     */
    public function test_admin_can_update_borrow()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a borrow to update
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $borrowToUpdate = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);

        // Generate updated borrow data
        $updatedBorrowData = [
            'status' => BorrowStatus::RETURNED->value,
            'return_date' => Carbon::now()->toDateString(),
        ];

        // Send a PUT request to the borrows update endpoint for the specific borrow
        $response = $this->putJson('/api/borrows/' . $borrowToUpdate->id_pret, $updatedBorrowData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the borrow's details are updated in the database
        $this->assertDatabaseHas('borrows', [
            'id_pret' => $borrowToUpdate->id_pret,
            'status' => BorrowStatus::RETURNED->value,
            'return_date' => $updatedBorrowData['return_date'],
        ]);
    }

    /**
     * Test that non-Admin users cannot update a borrow.
     *
     * @return void
     */
    public function test_non_admin_cannot_update_borrow()
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

        // Create a borrow to update
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $borrowToUpdate = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::ACTIVE,
        ]);

        // Generate updated borrow data
        $updatedBorrowData = [
            'status' => BorrowStatus::RETURNED->value,
        ];

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->putJson('/api/borrows/' . $borrowToUpdate->id_pret, $updatedBorrowData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->putJson('/api/borrows/' . $borrowToUpdate->id_pret, $updatedBorrowData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->putJson('/api/borrows/' . $borrowToUpdate->id_pret, $updatedBorrowData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can delete a borrow that is not active.
     *
     * @return void
     */
    public function test_admin_can_delete_non_active_borrow()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a non-active borrow to delete
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $borrowToDelete = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::RETURNED, // Not active
        ]);

        // Send a DELETE request to the borrows destroy endpoint for the specific borrow
        $response = $this->deleteJson('/api/borrows/' . $borrowToDelete->id_pret);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the borrow is deleted from the database
        $this->assertDatabaseMissing('borrows', [
            'id_pret' => $borrowToDelete->id_pret,
        ]);
    }

    /**
     * Test that an Admin user cannot delete an active borrow.
     *
     * @return void
     */
    public function test_admin_cannot_delete_active_borrow()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an active borrow to attempt to delete
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::ON_LOAN]);
        $borrowToDelete = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::ACTIVE, // Active
        ]);

        // Send a DELETE request to the borrows destroy endpoint for the specific borrow
        $response = $this->deleteJson('/api/borrows/' . $borrowToDelete->id_pret);

        // Assert bad request status (or forbidden if policy handles this)
        $response->assertStatus(400); // Assuming 400 Bad Request based on controller logic
        $response->assertJson(['message' => 'لا يمكن حذف إعارة نشطة.']);
    }

    /**
     * Test that non-Admin users cannot delete a borrow.
     *
     * @return void
     */
    public function test_non_admin_cannot_delete_borrow()
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

        // Create a borrow to delete
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $copy = Copy::factory()->create(['id_book' => $book->id_book]);
        $borrowToDelete = Borrow::factory()->create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'status' => BorrowStatus::RETURNED,
        ]);

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->deleteJson('/api/borrows/' . $borrowToDelete->id_pret);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->deleteJson('/api/borrows/' . $borrowToDelete->id_pret);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->deleteJson('/api/borrows/' . $borrowToDelete->id_pret);
        $response->assertStatus(403); // Assert Forbidden
    }
}
