<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private ReservationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ReservationService::class);
    }

    /**
     * Test that a customer can create a reservation
     */
    public function test_customer_can_create_reservation()
    {
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => '2026-05-20',
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
            'notes' => 'Window seat preferred',
        ]);

        $response->assertRedirect(route('landing'));
        $this->assertDatabaseHas('reservations', [
            'surname' => 'Smith',
            'number_of_guests' => 4,
            'session' => 'lunch',
        ]);
    }

    /**
     * Test that reservation date must be today or later
     */
    public function test_reservation_date_must_be_today_or_later()
    {
        $yesterday = now()->subDay()->toDateString();

        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => $yesterday,
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
        ]);

        $response->assertSessionHasErrors('reservation_date');
    }

    /**
     * Test that number of guests must be between 1 and 55
     */
    public function test_number_of_guests_validation()
    {
        // Test with 0 guests
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => '2026-05-20',
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '0',
        ]);
        $response->assertSessionHasErrors('number_of_guests');

        // Test with 56 guests
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => '2026-05-20',
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '56',
        ]);
        $response->assertSessionHasErrors('number_of_guests');
    }

    /**
     * Test that session must be lunch or dinner
     */
    public function test_session_must_be_valid()
    {
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => '2026-05-20',
            'session' => 'breakfast',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
        ]);

        $response->assertSessionHasErrors('session');
    }

    /**
     * Test that capacity calculation is correct
     */
    public function test_get_total_guests_for_session()
    {
        $date = '2026-05-20';
        $session = 'lunch';

        // Create 3 reservations
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 10,
            'status' => 'confirmed',
        ]);

        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 15,
            'status' => 'pending',
        ]);

        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 20,
            'status' => 'confirmed',
        ]);

        // Cancelled reservation should not count
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 100,
            'status' => 'cancelled',
        ]);

        $total = $this->service->getTotalGuestsForSession($date, $session);
        $this->assertEquals(45, $total);
    }

    /**
     * Test remaining capacity calculation
     */
    public function test_get_remaining_capacity()
    {
        $date = '2026-05-20';
        $session = 'lunch';

        // Fill 30 of 55 capacity
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 30,
            'status' => 'confirmed',
        ]);

        $remaining = $this->service->getRemainingCapacity($date, $session);
        $this->assertEquals(25, $remaining);
    }

    /**
     * Test fully booked detection with exact capacity
     */
    public function test_is_session_fully_booked_at_capacity()
    {
        $date = '2026-05-20';
        $session = 'lunch';

        // Fill exactly to capacity
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 55,
            'status' => 'confirmed',
        ]);

        $isFullyBooked = $this->service->isSessionFullyBooked($date, $session, 1);
        $this->assertTrue($isFullyBooked);
    }

    /**
     * Test fully booked detection with overfull
     */
    public function test_is_session_fully_booked_overfull()
    {
        $date = '2026-05-20';
        $session = 'dinner';

        // Fill 50 of 55
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => $session,
            'number_of_guests' => 50,
            'status' => 'confirmed',
        ]);

        // Try to add 10 guests (would exceed capacity)
        $isFullyBooked = $this->service->isSessionFullyBooked($date, $session, 10);
        $this->assertTrue($isFullyBooked);

        // But 5 guests should fit
        $isFullyBooked = $this->service->isSessionFullyBooked($date, $session, 5);
        $this->assertFalse($isFullyBooked);
    }

    /**
     * Test that can't create reservation when fully booked
     */
    public function test_cannot_create_reservation_when_fully_booked()
    {
        $date = '2026-05-20';

        // Fill the lunch session
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => 'lunch',
            'number_of_guests' => 55,
            'status' => 'confirmed',
        ]);

        // Try to create another reservation
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => $date,
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
        ]);

        $response->assertSessionHasErrors('number_of_guests');
        $this->assertDatabaseCount('reservations', 1);
    }

    /**
     * Test that different sessions have independent capacity
     */
    public function test_different_sessions_have_independent_capacity()
    {
        $date = '2026-05-20';

        // Fill lunch session
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => 'lunch',
            'number_of_guests' => 55,
            'status' => 'confirmed',
        ]);

        // Should be able to create dinner reservation
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'john@example.com',
            'reservation_date' => $date,
            'session' => 'dinner',
            'reservation_time' => '19:30',
            'number_of_guests' => '30',
        ]);

        $response->assertRedirect(route('landing'));
        $this->assertDatabaseHas('reservations', [
            'session' => 'dinner',
            'number_of_guests' => 30,
        ]);
    }

    /**
     * Test get capacity stats
     */
    public function test_get_capacity_stats()
    {
        $date = '2026-05-20';

        // Create lunch reservation for 20 guests
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => 'lunch',
            'number_of_guests' => 20,
            'status' => 'confirmed',
        ]);

        // Create dinner reservation for 30 guests
        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => 'dinner',
            'number_of_guests' => 30,
            'status' => 'confirmed',
        ]);

        $stats = $this->service->getCapacityStats($date);

        $this->assertEquals(20, $stats['lunch']['total']);
        $this->assertEquals(35, $stats['lunch']['remaining']);
        $this->assertFalse($stats['lunch']['is_fully_booked']);

        $this->assertEquals(30, $stats['dinner']['total']);
        $this->assertEquals(25, $stats['dinner']['remaining']);
        $this->assertFalse($stats['dinner']['is_fully_booked']);
    }

    /**
     * Test check availability API endpoint
     */
    public function test_check_availability_endpoint()
    {
        $date = '2026-05-20';

        Reservation::factory()->create([
            'reservation_date' => $date,
            'session' => 'lunch',
            'number_of_guests' => 30,
            'status' => 'confirmed',
        ]);

        $response = $this->get('/reservations/check-availability', [
            'date' => $date,
            'session' => 'lunch',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'total_guests' => 30,
            'remaining_capacity' => 25,
            'is_fully_booked' => false,
        ]);
    }

    /**
     * Test invalid phone number validation
     */
    public function test_phone_number_validation()
    {
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => 'invalid',
            'email' => 'john@example.com',
            'reservation_date' => '2026-05-20',
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
        ]);

        $response->assertSessionHasErrors('phone_number');
    }

    /**
     * Test invalid email validation
     */
    public function test_email_validation()
    {
        $response = $this->post('/reservations', [
            'surname' => 'Smith',
            'phone_number' => '+1 (555) 123-4567',
            'email' => 'not-an-email',
            'reservation_date' => '2026-05-20',
            'session' => 'lunch',
            'reservation_time' => '12:30',
            'number_of_guests' => '4',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
