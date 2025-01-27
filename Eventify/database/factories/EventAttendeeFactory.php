<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EventAttendee;
use App\Models\User;
use App\Models\Event;

class EventAttendeeFactory extends Factory
{
    protected $model = EventAttendee::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(), // Crea un evento ficticio
            'user_id' => User::factory(),   // Crea un usuario ficticio
            'status' => 'CONFIRMED',        // Estado por defecto
            'register_at' => now(),
            'deleted' => 0,
        ];
    }
}
