<?php


/**
 * @author Benoit Tremblay , John Sebastian Zuleta Franco
 */

//use Illuminate\Foundation\Testing\RefreshDatabase;
namespace Tests\Feature;

use App\Models\Animateur;
use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Local;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AtelierTest extends TestCase
{

    use DatabaseTransactions, WithFaker;

    private User $admin;


    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 1]);
        $this->actingAs($this->admin);
    }

    public function test_organisateur_peut_creer_un_atelier(): void
    {
        $organisateur = User::factory()->create(['role' => 1]);
        $this->actingAs($organisateur);

        $response = $this->post(route('ateliers.store'), [
            'nom' => 'Atelier Organisateur',
            'description' => 'Description test',
            'local_id' => null,
            'campus_id' => null,
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 60,
            'url_inscription' => 'https://exemple.com/inscription',
            'animateurs' => null,
        ]);

        $response->assertRedirect(route('ateliers.index'));
        $this->assertDatabaseHas('ateliers', ['nom' => 'Atelier Organisateur']);
    }

    public function test_organisateur_peut_modifier_un_atelier(): void
    {
        $organisateur = User::factory()->create(['role' => 1]);
        $this->actingAs($organisateur);

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie de Jean Test',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);

        $atelier = Atelier::factory()->create([
            'nom' => 'Atelier Original',
            'description' => 'Description originale',
            'local_id' => null,
            'campus_id' => null,
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 60,
            'url_inscription' => 'https://exemple.com/inscription',
        ]);

        $atelier->animateurs()->attach($animateur->id);

        $updatedData = [
            'nom' => 'Atelier Modifié',
            'description' => 'Description modifiée',
            'local_id' => null,
            'campus_id' => null,
            'date' => '2025-03-21',
            'heure_debut' => '11:00',
            'duree_minutes' => 90,
            'url_inscription' => 'https://exemple.com/inscription-modifiee',
            'animateurs' => [$animateur->id],
        ];

        $response = $this->put(route('ateliers.update', $atelier), $updatedData);

        $response->assertRedirect(route('ateliers.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ateliers', [
            'id' => $atelier->id,
            'nom' => 'Atelier Modifié',
            'description' => 'Description modifiée',
            'heure_debut' => '11:00',
            'duree_minutes' => 90,
            'url_inscription' => 'https://exemple.com/inscription-modifiee',
        ]);

        $this->assertDatabaseHas('animateur_atelier', [
            'atelier_id' => $atelier->id,
            'animateur_id' => $animateur->id,
        ]);
    }

    public function test_organisateur_peut_supprimer_un_atelier(): void
    {
        $organisateur = User::factory()->create(['role' => 1]);
        $this->actingAs($organisateur);

        $atelier = Atelier::factory()->create([
            'nom' => 'Atelier à supprimer',
            'description' => 'Description atelier',
            'local_id' => null,
            'campus_id' => null,
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 60,
            'url_inscription' => 'https://exemple.com/inscription',
        ]);

        $response = $this->delete(route('ateliers.destroy', $atelier));

        $response->assertRedirect(route('ateliers.index'));

        $response->assertSessionHas('atelier_supprime');
        $response->assertSessionHas('succes');

        $this->assertDatabaseMissing('ateliers', [
            'id' => $atelier->id,
        ]);

        $this->assertDatabaseMissing('animateur_atelier', [
            'atelier_id' => $atelier->id,
        ]);
    }

    public function test_estAdmin_ne_peut_pas_supprimer_un_atelier(): void
    {
        $estAdmin = User::factory()->create(['role' => 2]);
        $this->actingAs($estAdmin);

        $atelier = Atelier::factory()->create([
            'nom' => 'Atelier à ne pas supprimer',
            'description' => 'Description atelier',
            'local_id' => null,
            'campus_id' => null,
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 60,
            'url_inscription' => 'https://exemple.com/inscription',
        ]);

        $response = $this->delete(route('ateliers.destroy', $atelier));

        $response->assertStatus(403);

        $this->assertDatabaseHas('ateliers', [
            'id' => $atelier->id,
        ]);
    }

    public function test_utilisateur_ne_peut_pas_acceder_a_la_page_creation_atelier(): void
    {
        $utilisateur = User::factory()->create(['role' => 3]);
        $this->actingAs($utilisateur);

        $response = $this->get(route('ateliers.create'));

        $response->assertStatus(403);
    }




    public function test_creation_atelier_redirige_et_message_succes(): void
    {
        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $local = Local::factory()->create([
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie de Jean Test',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);

        $Datevalid = '2025-03-21';
        $response = $this->post(route('ateliers.store'), [
            'nom' => 'Atelier Test',
            'description' => 'Une description d’atelier.',
            'local_id' => strval($local->id),
            'campus_id' => strval($campus->id),
            'date' => $Datevalid,
            'heure_debut' => '10:00',
            'duree_minutes' => 90,
            'url_inscription' => 'https://exemple.com/inscription',
            'animateurs' => [$animateur->id],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('ateliers.index'));
        $response->assertSessionHas('success', 'Atelier créé avec succès.');
        $atelier = Atelier::where('nom', 'Atelier Test')->first();
        $this->assertNotNull($atelier, 'Atelier pas créé.');
        $this->assertDatabaseHas('ateliers', ['nom' => 'Atelier Test']);
        $this->assertDatabaseHas('animateur_atelier', [
            'atelier_id' => $atelier->id,
            'animateur_id' => $animateur->id,
        ]);
    }


    public function test_creation_atelier_nom_caractere_invalide(): void
    {
        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $local = Local::factory()->create([
            'numeroLocal' => '102B',
            'capacite' => 25,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie de Jean Test',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);

        $Dateinvalid = 'test';
        $response = $this->post(route('ateliers.store'), [
            'nom' => '',
            'description' => 'Une description d’atelier.',
            'local_id' => strval($local->id),
            'campus_id' => strval($campus->id),
            'date' => $Dateinvalid,
            'heure_debut' => '10:00',
            'duree_minutes' => 1,
            'url_inscription' => 'https://exemple.com/inscription',
            'animateurs' => [$animateur->id],
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'nom',
            'date',
            'duree_minutes'
        ]);


    }

    public function test_modification_atelier_redirige_et_message_succes(): void
    {
        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $local = Local::factory()->create([
            'numeroLocal' => '102B',
            'capacite' => 25,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie de Jean Test',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);

        $atelier = Atelier::factory()->create([
            'nom' => 'Atelier Test',
            'description' => 'Une description d’atelier.',
            'local_id' => strval($local->id),
            'campus_id' => strval($campus->id),
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 90,
            'url_inscription' => 'https://exemple.com/inscription',

        ]);

        $atelier->animateurs()->attach($animateur->id);

        $nouveauNom = 'Nom modifié';
        $nouvelleDescription = 'Description modifiée';

        $response = $this->put(route('ateliers.update', $atelier), [
            'nom' => $nouveauNom,
            'description' => $nouvelleDescription,
            'local_id' => strval($local->id),
            'campus_id' => strval($campus->id),
            'date' => $atelier->date,
            'heure_debut' => $atelier->heure_debut,
            'duree_minutes' => $atelier->duree_minutes,
            'animateurs' => [$animateur->id],
        ]);

        $response->assertRedirect(route('ateliers.index'));
        $response->assertSessionHas('success', 'Atelier modifié avec succès.');
        $this->assertDatabaseHas('ateliers', [
            'nom' => $nouveauNom,
            'description' => $nouvelleDescription,
        ]);
    }
    public function test_suppression_atelier_redirige_et_message_succes(): void
    {
        $campus = Campus::factory()->create(['nom' => 'Campus Test']);

        $local = Local::factory()->create([
            'numeroLocal' => '102B',
            'capacite' => 25,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);

        $atelier = Atelier::factory()->create([
            'nom' => 'Atelier Test',
            'description' => 'Une description',
            'local_id' => $local->id,
            'campus_id' => $campus->id,
            'date' => '2025-03-21',
            'heure_debut' => '10:00',
            'duree_minutes' => 90,
            'url_inscription' => 'https://exemple.com',
        ]);

        $atelier->animateurs()->attach($animateur->id);

        $response = $this->delete(route('ateliers.destroy', $atelier));

        $response->assertRedirect(route('ateliers.index'));
        $this->assertDatabaseMissing('ateliers', ['id' => $atelier->id]);
        $response->assertSessionHas('atelier_supprime');
        $response->assertSessionHas('succes');
    }
}
