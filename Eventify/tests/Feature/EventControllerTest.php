<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Event;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testMostrarFormularioDeCreacionDeEventos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/events/create');
        $response->assertStatus(200);
        $response->assertViewIs('events.create_event');
    }

    public function testCrearEvento()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('event.jpg');

        $response = $this->postJson('/events/create', [
            'title' => 'Evento de prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento',
            'start_time' => now()->addDay()->toDateTimeString(),
            'end_time' => now()->addDays(2)->toDateTimeString(),
            'location' => 'Lugar de prueba',
            'latitude' => 40.416775,
            'longitude' => -3.703790,
            'max_attendees' => 100,
            'price' => 50.00,
            'image' => $file,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', [
            'title' => 'Evento de prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento',
        ]);
        Storage::disk('public')->assertExists('images/' . $file->hashName());
    }

    public function testValidacionDeCamposObligatoriosAlCrearEvento()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/events/create', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'title',
            'category_id',
            'description',
            'start_time',
            'end_time',
            'image',
        ]);
    }

    public function testEliminarEvento()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $event = Event::factory()->create(['organized_id' => $user->id]);
        $response = $this->deleteJson("/events/{$event->id}");
        $response->assertStatus(200);
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    public function testSuscribirseAUnEvento()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/events/' . $event->id . '/subscribe');
        $response->assertStatus(302);
        $this->assertDatabaseHas('event_attendees', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'CONFIRMED',
        ]);
    }

    public function testCancelarSuscripcionAUnEvento()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $this->actingAs($user);
        \App\Models\EventAttendee::factory()->create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'CONFIRMED',
        ]);
        $response = $this->post('/events/' . $event->id . '/unsubscribe');
        $response->assertStatus(302);
        $this->assertDatabaseHas('event_attendees', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'CANCELLED',
            'deleted' => 1,
        ]);
    }
}
