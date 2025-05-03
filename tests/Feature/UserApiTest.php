<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Import User model
use App\Enums\UserRole; // Import UserRole enum
use Laravel\Sanctum\Sanctum; // Import Sanctum for API authentication

class UserApiTest extends TestCase
{
    use RefreshDatabase; // Use RefreshDatabase trait to reset the database for each test
    use WithFaker; // Use WithFaker trait for generating fake data

    /**
     * Test that an Admin user can view all users.
     *
     * @return void
     */
    public function test_admin_can_view_all_users()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user using Sanctum
        Sanctum::actingAs($adminUser);

        // Create some other users
        User::factory()->count(5)->create();

        // Send a GET request to the users index endpoint
        $response = $this->getJson('/api/users');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all users (Admin + 5 others)
        $response->assertJsonCount(6, 'data'); // Assuming the response uses a 'data' key for the collection

        // Assert that the response structure is as expected (optional but recommended)
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    // Add other expected user attributes in the resource
                ]
            ]
        ]);
    }

    /**
     * Test that non-Admin users cannot view all users.
     *
     * @return void
     */
    public function test_non_admin_cannot_view_all_users()
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

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->getJson('/api/users');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/users');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->getJson('/api/users');
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can create users with different roles.
     *
     * @return void
     */
    public function test_admin_can_create_users_with_different_roles()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Test creating an Admin user
        $adminUserData = User::factory()->make([
            'role' => UserRole::ADMIN,
        ])->toArray();
        $response = $this->postJson('/api/users', $adminUserData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $adminUserData['email'], 'role' => UserRole::ADMIN]);
        // No associated model for Admin

        // Test creating an Employee user
        $employeeUserData = User::factory()->make([
            'role' => UserRole::EMPLOYEE,
        ])->toArray();
        $response = $this->postJson('/api/users', $employeeUserData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $employeeUserData['email'], 'role' => UserRole::EMPLOYEE]);
        $createdUser = User::where('email', $employeeUserData['email'])->first();
        $this->assertDatabaseHas('employers', ['id_User' => $createdUser->id_User]);

        // Test creating a Student user
        $studentUserData = User::factory()->make([
            'role' => UserRole::STUDENT,
        ])->toArray();
        // Add student-specific fields (matricule, level, academic_year, speciality)
        $studentUserData['matricule'] = $this->faker->unique()->randomNumber(8);
        $studentUserData['level'] = $this->faker->word;
        $studentUserData['academic_year'] = $this->faker->date();
        $studentUserData['speciality'] = $this->faker->word;

        $response = $this->postJson('/api/users', $studentUserData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $studentUserData['email'], 'role' => UserRole::STUDENT]);
        $createdUser = User::where('email', $studentUserData['email'])->first();
        $this->assertDatabaseHas('etudiants', ['id_User' => $createdUser->id_User, 'matricule' => $studentUserData['matricule']]);

        // Test creating a Professor user
        $professorUserData = User::factory()->make([
            'role' => UserRole::PROFESSOR,
        ])->toArray();
        // Add professor-specific fields (affiliation)
        $professorUserData['affiliation'] = $this->faker->word;

        $response = $this->postJson('/api/users', $professorUserData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $professorUserData['email'], 'role' => UserRole::PROFESSOR]);
        $createdUser = User::where('email', $professorUserData['email'])->first();
        $this->assertDatabaseHas('professors', ['id_User' => $createdUser->id_User, 'affiliation' => $professorUserData['affiliation']]);
    }

    /**
     * Test that non-Admin users cannot create users.
     *
     * @return void
     */
    public function test_non_admin_cannot_create_users()
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

        // Create dummy user data to attempt creation
        $newUserData = User::factory()->make()->toArray();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->postJson('/api/users', $newUserData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/users', $newUserData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/users', $newUserData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can view a specific user.
     *
     * @return void
     */
    public function test_admin_can_view_specific_user()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create another user to view
        $userToView = User::factory()->create();

        // Send a GET request to the users show endpoint for the specific user
        $response = $this->getJson('/api/users/' . $userToView->id_User);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct user
        $response->assertJson([
            'data' => [
                'id' => $userToView->id_User,
                'first_name' => $userToView->first_name,
                'last_name' => $userToView->last_name,
                'email' => $userToView->email,
                // Add other expected user attributes in the resource
            ]
        ]);
    }

    /**
     * Test that a user can view their own profile.
     *
     * @return void
     */
    public function test_user_can_view_own_profile()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate as the user
        Sanctum::actingAs($user);

        // Send a GET request to the users show endpoint for the user's own profile
        $response = $this->getJson('/api/users/' . $user->id_User);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct user (themselves)
        $response->assertJson([
            'data' => [
                'id' => $user->id_User,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                // Add other expected user attributes in the resource
            ]
        ]);
    }

    /**
     * Test that non-Admin users cannot view other users' profiles (unless allowed by policy).
     *
     * @return void
     */
    public function test_non_admin_cannot_view_other_users()
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

        // Create another user to attempt to view
        $otherUser = User::factory()->create();

        // Test as Employee trying to view another user (Policy allows Employee to view any user)
        // This test case is not needed based on the current UserPolicy.

        // Test as Student trying to view another user (Policy does NOT allow Student to view other users)
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/users/' . $otherUser->id_User);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor trying to view another user (Policy allows Professor to view any user)
        // This test case is not needed based on the current UserPolicy.
    }

    /**
     * Test that an Admin user can update a user.
     *
     * @return void
     */
    public function test_admin_can_update_user()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create a user to update
        $userToUpdate = User::factory()->create();

        // Generate updated user data
        $updatedUserData = [
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updated' . $this->faker->unique()->safeEmail,
            'adress' => 'Updated Address',
            'city' => 'Updated City',
            'phone_number' => '9876543210',
            'status' => \App\Enums\UserStatus::APPROVED->value,
            'role' => UserRole::EMPLOYEE->value, // Change role
        ];

        // Send a PUT request to the users update endpoint for the specific user
        $response = $this->putJson('/api/users/' . $userToUpdate->id_User, $updatedUserData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the user's details are updated in the database
        $this->assertDatabaseHas('users', [
            'id_User' => $userToUpdate->id_User,
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => $updatedUserData['email'],
            'adress' => 'Updated Address',
            'city' => 'Updated City',
            'phone_number' => '9876543210',
            'status' => \App\Enums\UserStatus::APPROVED->value,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Assert that the old associated model (if any) is deleted and the new one is created
        // This requires checking the specific role change.
        // For this general update test, we'll just check the user table update.
        // More specific tests for role changes might be needed.
    }

    /**
     * Test that a user can update their own profile.
     *
     * @return void
     */
    public function test_user_can_update_own_profile()
    {
        // Create a user
        $userToUpdate = User::factory()->create();

        // Authenticate as the user
        Sanctum::actingAs($userToUpdate);

        // Generate updated user data (excluding role and status as users cannot change these for themselves)
        $updatedUserData = [
            'first_name' => 'SelfUpdatedFirstName',
            'last_name' => 'SelfUpdatedLastName',
            'email' => 'selfupdated' . $this->faker->unique()->safeEmail,
            'adress' => 'Self Updated Address',
            'city' => 'Self Updated City',
            'phone_number' => '0123456789',
            // Role and status should not be updatable by the user themselves
        ];

        // Send a PUT request to the users update endpoint for the user's own profile
        $response = $this->putJson('/api/users/' . $userToUpdate->id_User, $updatedUserData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the user's details are updated in the database
        $this->assertDatabaseHas('users', [
            'id_User' => $userToUpdate->id_User,
            'first_name' => 'SelfUpdatedFirstName',
            'last_name' => 'SelfUpdatedLastName',
            'email' => $updatedUserData['email'],
            'adress' => 'Self Updated Address',
            'city' => 'Self Updated City',
            'phone_number' => '0123456789',
            // Role and status should remain unchanged
            'role' => $userToUpdate->role,
            'status' => $userToUpdate->status,
        ]);
    }
}
