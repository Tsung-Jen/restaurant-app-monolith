<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surname' => $this->faker->lastName(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional()->safeEmail(),
            'reservation_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'session' => $this->faker->randomElement(['lunch', 'dinner']),
            'reservation_time' => $this->faker->time('H:i'),
            'number_of_guests' => $this->faker->numberBetween(1, 10),
            'notes' => $this->faker->optional()->text(100),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }

    /**
     * Indicate that the reservation should be confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the reservation should be pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the reservation should be cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
