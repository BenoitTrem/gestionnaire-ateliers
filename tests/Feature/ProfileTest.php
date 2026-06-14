<?php

namespace Tests\Feature;



use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * John : Ne pas oublier de executer npm run dev avant.
 * Sinon erreur
 */


class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'prenom' => 'Test',
                'nom' => 'User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('User', $user->nom);
        $this->assertSame('Test', $user->prenom);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'nom' => 'User',
                'prenom' => 'Test',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    /**
     * @author John Sebastian Zuleta Franco
     * 2 Tests de autorisations
     * 2 Tests de authentification
     */


    public function test_utilisateur_simple_ne_peut_pas_acceder_a_la_page_admin(): void
    {
        $user = User::factory()->create([
            'role' => 3,
        ]);

        $response = $this->actingAs($user)->get('/profile/overview');

        $response->assertForbidden(); // 403 attendu
    }

    public function test_organisateur_peut_acceder_a_la_page_admin(): void
    {
        $user = User::factory()->create([
            'role' => 1,
        ]);

        $response = $this->actingAs($user)->get('/profile/overview');

        $response->assertStatus(200);
    }

    public function test_user_peut_acceder_dashboard_authentifie(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
    }

    public function test_guest_rediriger_login_si_essaye_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }



}
