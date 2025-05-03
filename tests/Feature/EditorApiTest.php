<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Editor;
use App\Enums\UserRole;
use Laravel\Sanctum\Sanctum;

class EditorApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that an Admin user can view all editors.
     *
     * @return void
     */
    public function test_admin_can_view_all_editors()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create some editors
        Editor::factory()->count(5)->create();

        // Send a GET request to the editors index endpoint
        $response = $this->getJson('/api/editors');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all editors
        $response->assertJsonCount(5, 'data'); // Assuming the response uses a 'data' key

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name_ed',
                    'email_ed',
                    // Add other expected editor attributes in the resource
                ]
            ]
        ]);
    }

    /**
     * Test that non-Admin users cannot view all editors.
     *
     * @return void
     */
    public function test_non_admin_cannot_view_all_editors()
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

        // Create some editors
        Editor::factory()->count(5)->create();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->getJson('/api/editors');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/editors');
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->getJson('/api/editors');
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can create an editor.
     *
     * @return void
     */
    public function test_admin_can_create_editor()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Generate editor data
        $editorData = Editor::factory()->make()->toArray();

        // Send a POST request to the editors store endpoint
        $response = $this->postJson('/api/editors', $editorData);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the editor is created in the database
        $this->assertDatabaseHas('editors', [
            'name_ed' => $editorData['name_ed'],
            'email_ed' => $editorData['email_ed'],
        ]);
    }

    /**
     * Test that non-Admin users cannot create an editor.
     *
     * @return void
     */
    public function test_non_admin_cannot_create_editor()
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

        // Generate editor data
        $editorData = Editor::factory()->make()->toArray();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->postJson('/api/editors', $editorData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/editors', $editorData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/editors', $editorData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can view a specific editor.
     *
     * @return void
     */
    public function test_admin_can_view_specific_editor()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor to view
        $editorToView = Editor::factory()->create();

        // Send a GET request to the editors show endpoint for the specific editor
        $response = $this->getJson('/api/editors/' . $editorToView->id_editor);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct editor
        $response->assertJson([
            'data' => [
                'id' => $editorToView->id_editor,
                'name_ed' => $editorToView->name_ed,
                'email_ed' => $editorToView->email_ed,
                // Add other expected editor attributes in the resource
            ]
        ]);
    }

    /**
     * Test that non-Admin users cannot view a specific editor.
     *
     * @return void
     */
    public function test_non_admin_cannot_view_specific_editor()
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

        // Create an editor to view
        $editorToView = Editor::factory()->create();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->getJson('/api/editors/' . $editorToView->id_editor);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/editors/' . $editorToView->id_editor);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->getJson('/api/editors/' . $editorToView->id_editor);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can update an editor.
     *
     * @return void
     */
    public function test_admin_can_update_editor()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor to update
        $editorToUpdate = Editor::factory()->create();

        // Generate updated editor data
        $updatedEditorData = [
            'name_ed' => 'Updated Editor Name',
            'city_ed' => 'Updated City',
        ];

        // Send a PUT request to the editors update endpoint for the specific editor
        $response = $this->putJson('/api/editors/' . $editorToUpdate->id_editor, $updatedEditorData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the editor's details are updated in the database
        $this->assertDatabaseHas('editors', [
            'id_editor' => $editorToUpdate->id_editor,
            'name_ed' => 'Updated Editor Name',
            'city_ed' => 'Updated City',
        ]);
    }

    /**
     * Test that non-Admin users cannot update an editor.
     *
     * @return void
     */
    public function test_non_admin_cannot_update_editor()
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

        // Create an editor to update
        $editorToUpdate = Editor::factory()->create();

        // Generate updated editor data
        $updatedEditorData = [
            'name_ed' => 'Attempted Updated Name',
        ];

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->putJson('/api/editors/' . $editorToUpdate->id_editor, $updatedEditorData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->putJson('/api/editors/' . $editorToUpdate->id_editor, $updatedEditorData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->putJson('/api/editors/' . $editorToUpdate->id_editor, $updatedEditorData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can delete an editor.
     *
     * @return void
     */
    public function test_admin_can_delete_editor()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an editor to delete
        $editorToDelete = Editor::factory()->create();

        // Send a DELETE request to the editors destroy endpoint for the specific editor
        $response = $this->deleteJson('/api/editors/' . $editorToDelete->id_editor);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the editor is deleted from the database
        $this->assertDatabaseMissing('editors', [
            'id_editor' => $editorToDelete->id_editor,
        ]);
    }

    /**
     * Test that non-Admin users cannot delete an editor.
     *
     * @return void
     */
    public function test_non_admin_cannot_delete_editor()
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

        // Create an editor to delete
        $editorToDelete = Editor::factory()->create();

        // Test as Employee
        Sanctum::actingAs($employeeUser);
        $response = $this->deleteJson('/api/editors/' . $editorToDelete->id_editor);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->deleteJson('/api/editors/' . $editorToDelete->id_editor);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->deleteJson('/api/editors/' . $editorToDelete->id_editor);
        $response->assertStatus(403); // Assert Forbidden
    }
}
