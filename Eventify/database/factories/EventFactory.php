<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'organized_id' => 1, // ID válido de un usuario existente
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => 1, // ID válido de una categoría existente
            'start_time' => $this->faker->dateTimeBetween('+1 day', '+2 days'),
            'end_time' => $this->faker->dateTimeBetween('+3 days', '+4 days'),
            'location' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'max_attendees' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image_url' => 'default.jpg', // Ruta de la imagen
            'deleted' => 0,
        ];
    }
}
