<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testCargarFormularioLogin()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testIniciarSesionConCredencialesValidas()
    {
        $usuario = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt($clave = 'clave_valida'),
        ]);

        $response = $this->post('/login', [
            'email' => 'usuario@example.com',
            'password' => $clave,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($usuario);
    }

    public function testIniciarSesionConCredencialesInvalidas()
    {
        $usuario = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt('clave_valida'),
        ]);

        $response = $this->post('/login', [
            'email' => 'usuario@example.com',
            'password' => 'clave_invalida',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function testValidarCamposObligatorios()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function testCorreoElectronicoInvalido()
    {
        $response = $this->post('/login', [
            'email' => 'correo_invalido',
            'password' => 'clave_valida',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function testRedireccionCorrectaDespuesDelLogin()
    {
        $usuario = User::factory()->create([
            'email' => 'correo@example.com',
            'password' => bcrypt($clave = 'clave_valida'),
        ]);

        $response = $this->post('/login', [
            'email' => 'correo@example.com',
            'password' => $clave,
        ]);

        $response->assertRedirect('/home');
    }
}
