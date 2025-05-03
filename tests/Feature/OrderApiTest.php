<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\OrderLiv;
use App\Models\Editor; // Assuming Editor is needed for Book factory
use App\Enums\UserRole;
use App\Enums\OrderStatus;
use Laravel\Sanctum\Sanctum;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure an editor and book exist for order creation
        Editor::factory()->create();
        Book::factory()->create();
    }

    /**
     * Test that an Admin user can view all orders.
     *
     * @return void
     */
    public function test_admin_can_view_all_orders()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create some orders
        $user = User::factory()->create(); // User who placed the order
        $book = Book::factory()->create();
        OrderLiv::factory()->count(5)->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
        ]);

        // Send a GET request to the orders index endpoint
        $response = $this->getJson('/api/orders');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains all orders
        $response->assertJsonCount(5, 'data'); // Assuming the response uses a 'data' key

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'order_date',
                    'status',
                    // Add other expected order attributes in the resource
                    'user' => [
                        'id',
                        'first_name',
                        // Add other expected user attributes
                    ],
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
     * Test that non-Admin users can only view their own orders.
     *
     * @return void
     */
    public function test_non_admin_can_view_only_own_orders()
    {
        // Create an employee user (assuming employees place orders)
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create some orders for this user
        $book1 = Book::factory()->create();
        OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book1->id_book,
        ]);

        $book2 = Book::factory()->create();
        OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book2->id_book,
            'status' => OrderStatus::COMPLETED,
        ]);

        // Create orders for another user
        $otherUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book3 = Book::factory()->create();
        OrderLiv::factory()->create([
            'id_User' => $otherUser->id_User,
            'id_book' => $book3->id_book,
        ]);

        // Send a GET request to the orders index endpoint
        $response = $this->getJson('/api/orders');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains only the user's orders
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
        $response->assertJsonFragment(['id' => $employeeUser->id_User]);
        $response->assertJsonMissing(['id' => $otherUser->id_User]);
    }

    /**
     * Test that an Employee user can create an order.
     *
     * @return void
     */
    public function test_employee_can_create_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create a book to order
        $book = Book::factory()->create();

        // Generate order data
        $orderData = OrderLiv::factory()->make([
            'id_User' => $employeeUser->id_User, // Order placed by this employee
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING, // New orders are pending by default
        ])->toArray();

        // Send a POST request to the orders store endpoint
        $response = $this->postJson('/api/orders', $orderData);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the order is created in the database
        $this->assertDatabaseHas('order_liv', [
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING->value,
        ]);
    }

    /**
     * Test that non-Employee users cannot create an order.
     *
     * @return void
     */
    public function test_non_employee_cannot_create_order()
    {
        // Create non-Employee users
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
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

        // Create a book to order
        $book = Book::factory()->create();

        // Generate order data
        $orderData = OrderLiv::factory()->make([
            'id_book' => $book->id_book,
        ])->toArray();

        // Test as Admin
        Sanctum::actingAs($adminUser);
        $response = $this->postJson('/api/orders', $orderData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->postJson('/api/orders', $orderData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->postJson('/api/orders', $orderData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can view a specific order.
     *
     * @return void
     */
    public function test_admin_can_view_specific_order()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an order to view
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToView = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
        ]);

        // Send a GET request to the orders show endpoint for the specific order
        $response = $this->getJson('/api/orders/' . $orderToView->id_demande);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct order
        $response->assertJson([
            'data' => [
                'id' => $orderToView->id_demande,
                'user' => [
                    'id' => $user->id_User,
                ],
                'book' => [
                    'id' => $book->id_book,
                ],
            ]
        ]);
    }

    /**
     * Test that an Employee can view a specific order they placed.
     *
     * @return void
     */
    public function test_employee_can_view_own_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create an order placed by this employee
        $book = Book::factory()->create();
        $orderToView = OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
        ]);

        // Send a GET request to view the order
        $response = $this->getJson('/api/orders/' . $orderToView->id_demande);

        // Assert successful status
        $response->assertStatus(200);

        // Assert that the response contains the details of the correct order
        $response->assertJson([
            'data' => [
                'id' => $orderToView->id_demande,
                'user' => [
                    'id' => $employeeUser->id_User,
                ],
                'book' => [
                    'id' => $book->id_book,
                ],
            ]
        ]);
    }

    /**
     * Test that other non-Admin/non-Employee users cannot view a specific order.
     *
     * @return void
     */
    public function test_other_users_cannot_view_any_order()
    {
        // Create non-Admin/non-Employee users
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

        // Create an order
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToView = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
        ]);

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->getJson('/api/orders/' . $orderToView->id_demande);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->getJson('/api/orders/' . $orderToView->id_demande);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can update an order.
     *
     * @return void
     */
    public function test_admin_can_update_order()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an order to update
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToUpdate = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING,
        ]);

        // Generate updated order data
        $updatedOrderData = [
            'status' => OrderStatus::COMPLETED->value,
        ];

        // Send a PUT request to the orders update endpoint for the specific order
        $response = $this->putJson('/api/orders/' . $orderToUpdate->id_demande, $updatedOrderData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the order's details are updated in the database
        $this->assertDatabaseHas('order_liv', [
            'id_demande' => $orderToUpdate->id_demande,
            'status' => OrderStatus::COMPLETED->value,
        ]);
    }

    /**
     * Test that an Employee can update their own pending order.
     *
     * @return void
     */
    public function test_employee_can_update_own_pending_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create a pending order placed by this employee
        $book = Book::factory()->create();
        $orderToUpdate = OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING,
        ]);

        // Generate updated order data (e.g., changing book or status if allowed by policy)
        // Assuming for this test that an employee can change the status of their pending order
        $updatedOrderData = [
            'status' => OrderStatus::CANCELLED->value,
        ];

        // Send a PUT request to update the order
        $response = $this->putJson('/api/orders/' . $orderToUpdate->id_demande, $updatedOrderData);

        // Assert successful status
        $response->assertStatus(200);

        // Assert that the order's status is updated in the database
        $this->assertDatabaseHas('order_liv', [
            'id_demande' => $orderToUpdate->id_demande,
            'status' => OrderStatus::CANCELLED->value,
        ]);
    }

    /**
     * Test that an Employee cannot update an order that is not pending.
     *
     * @return void
     */
    public function test_employee_cannot_update_non_pending_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create a completed order placed by this employee
        $book = Book::factory()->create();
        $orderToUpdate = OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::COMPLETED, // Not pending
        ]);

        // Generate updated order data
        $updatedOrderData = [
            'status' => OrderStatus::CANCELLED->value,
        ];

        // Send a PUT request to update the order
        $response = $this->putJson('/api/orders/' . $orderToUpdate->id_demande, $updatedOrderData);

        // Assert forbidden status
        $response->assertStatus(403);
    }

    /**
     * Test that non-Admin/non-Employee users cannot update an order.
     *
     * @return void
     */
    public function test_other_users_cannot_update_any_order()
    {
        // Create non-Admin/non-Employee users
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

        // Create an order to update
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToUpdate = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING,
        ]);

        // Generate updated order data
        $updatedOrderData = [
            'status' => OrderStatus::CANCELLED->value,
        ];

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->putJson('/api/orders/' . $orderToUpdate->id_demande, $updatedOrderData);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->putJson('/api/orders/' . $orderToUpdate->id_demande, $updatedOrderData);
        $response->assertStatus(403); // Assert Forbidden
    }

    /**
     * Test that an Admin user can delete an order.
     *
     * @return void
     */
    public function test_admin_can_delete_order()
    {
        // Create an Admin user
        $adminUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::ADMIN->value,
        ]);

        // Authenticate as the Admin user
        Sanctum::actingAs($adminUser);

        // Create an order to delete
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToDelete = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
        ]);

        // Send a DELETE request to the orders destroy endpoint for the specific order
        $response = $this->deleteJson('/api/orders/' . $orderToDelete->id_demande);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the order is deleted from the database
        $this->assertDatabaseMissing('order_liv', [
            'id_demande' => $orderToDelete->id_demande,
        ]);
    }

    /**
     * Test that an Employee can delete their own pending order.
     *
     * @return void
     */
    public function test_employee_can_delete_own_pending_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create a pending order placed by this employee
        $book = Book::factory()->create();
        $orderToDelete = OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::PENDING, // Pending order
        ]);

        // Send a DELETE request to delete the order
        $response = $this->deleteJson('/api/orders/' . $orderToDelete->id_demande);

        // Assert successful status
        $response->assertStatus(200);

        // Assert that the order is deleted from the database
        $this->assertDatabaseMissing('order_liv', [
            'id_demande' => $orderToDelete->id_demande,
        ]);
    }

    /**
     * Test that an Employee cannot delete an order that is not pending.
     *
     * @return void
     */
    public function test_employee_cannot_delete_non_pending_order()
    {
        // Create an employee user
        $employeeUser = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => UserRole::EMPLOYEE->value,
        ]);

        // Authenticate as the employee user
        Sanctum::actingAs($employeeUser);

        // Create a completed order placed by this employee
        $book = Book::factory()->create();
        $orderToDelete = OrderLiv::factory()->create([
            'id_User' => $employeeUser->id_User,
            'id_book' => $book->id_book,
            'status' => OrderStatus::COMPLETED, // Not pending
        ]);

        // Send a DELETE request to delete the order
        $response = $this->deleteJson('/api/orders/' . $orderToDelete->id_demande);

        // Assert forbidden status
        $response->assertStatus(403);
    }

    /**
     * Test that non-Admin/non-Employee users cannot delete an order.
     *
     * @return void
     */
    public function test_other_users_cannot_delete_any_order()
    {
        // Create non-Admin/non-Employee users
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

        // Create an order to delete
        $user = User::factory()->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);
        $book = Book::factory()->create();
        $orderToDelete = OrderLiv::factory()->create([
            'id_User' => $user->id_User,
            'id_book' => $book->id_book,
        ]);

        // Test as Student
        Sanctum::actingAs($studentUser);
        $response = $this->deleteJson('/api/orders/' . $orderToDelete->id_demande);
        $response->assertStatus(403); // Assert Forbidden

        // Test as Professor
        Sanctum::actingAs($professorUser);
        $response = $this->deleteJson('/api/orders/' . $orderToDelete->id_demande);
        $response->assertStatus(403); // Assert Forbidden
    }
}
