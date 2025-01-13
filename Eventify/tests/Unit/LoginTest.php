<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testMostrarFormularioDeLogin()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testLoginConCredencialesValidas()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginConCredencialesInvalidas()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function testCamposObligatorios()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function testEmailInvalido()
    {
        $response = $this->post('/login', [
            'email' => 'email-invalido',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function testRedireccionDespuesDelLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
    }
}