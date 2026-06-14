<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }


    /**
     * @author John Sebastian Zuleta Franco
     * Je profite du Test pour tester la transformation du Nom et Prénom
     */

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'nom' => 'uSer',
            'prenom' => 'tEst',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'nom' => 'User',
            'prenom' => 'Test',
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));

    }
}
