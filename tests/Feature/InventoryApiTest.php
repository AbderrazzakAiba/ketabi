<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Copy;
use App\Enums\UserRole;
use App\Enums\CopyStatus;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that an employee can view the book inventory.
     */
    public function test_employee_can_view_book_inventory(): void
    {
        // Create an employee user
        $employee = User::factory()->create([
            'role' => UserRole::Employee->value,
            'status' => \App\Enums\UserStatus::APPROVED,
        ]);

        // Create a book with copies
        $book = Book::factory()->create();
        $copy1 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::AVAILABLE->value]);
        $copy2 = Copy::factory()->create(['id_book' => $book->id_book, 'etat_copy_liv' => CopyStatus::BORROWED->value]);

        // Act as the employee user
        $response = $this->actingAs($employee, 'sanctum')->getJson('/api/books/inventory');

        // Assert the response
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
     * Test that a non-employee cannot view the book inventory.
     */
    public function test_non_employee_cannot_view_book_inventory(): void
    {
        // Create a non-employee user (e.g., student)
        $student = User::factory()->create([
            'role' => UserRole::Student->value,
            'status' => \App\Enums\UserStatus::APPROVED,
        ]);

        // Act as the student user
        $response = $this->actingAs($student, 'sanctum')->getJson('/api/books/inventory');

        // Assert the response status is 403 (Forbidden)
        $response->assertStatus(403);
    }
}
