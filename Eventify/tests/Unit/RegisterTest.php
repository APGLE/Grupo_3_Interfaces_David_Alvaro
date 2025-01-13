<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testMostrarFormularioDeRegistro()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function testRegistroConDatosValidos()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Agregar mensajes de depuración
        if (!$response->isRedirect()) {
            dd('No redirigido', $response->getContent());
        }

        $response->assertRedirect('/home');

        if (!auth()->check()) {
            dd('Usuario no autenticado');
        }

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function testRegistroConEmailDuplicado()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function testCamposObligatorios()
    {
        $response = $this->post('/register', []);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function testPasswordConfirmacionNoCoincide()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function testEmailInvalido()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'email-invalido',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}