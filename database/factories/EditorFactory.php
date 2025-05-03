<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Editor; // Import the Editor model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Editor>
 */
class EditorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Editor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
        ];
    }
}
