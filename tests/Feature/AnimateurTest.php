<?php


/**
 * @author John Sebastian Zuleta Franco
 */

//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Local;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Animateur;
use App\Models\User;
use \Illuminate\Foundation\Testing\WithFaker;

class AnimateurTest extends TestCase
{


    ///
    use DatabaseTransactions, WithFaker;


    private User $admin;


    protected function setUp(): void{
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 1]);
        $this->actingAs($this->admin);

    }
    /**
     * A basic test example.
     */

    public function test_creation_Animateur_enregistre_bd():void {

        $this->assertDatabaseMissing('animateurs', [
            'prenom' => 'Test',
            'nom' => 'Test',
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);

        $this->post(route('animateurs.store'), [
            'prenom' => 'Test',
            'nom' => 'Test',
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);

        $this->assertDatabaseHas('animateurs', [
            'prenom' => 'Test',
            'nom' => 'Test',
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);
    }

    public function test_creation_animateurs_redirige_index():void {

        $reponse = $this->post(route('animateurs.store'), [
            'prenom' => 'Test',
            'nom' => 'Test',
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);

        $reponse->assertRedirect(route('animateurs.index'));
    }

    public function test_creation_animateurs_donnees_valides():void {

        $reponse = $this->post(route('animateurs.store'), [
            'prenom' => 'Test',
            'nom' => 'Test',
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);

        $reponse->assertValid();
    }

    public function test_creation_animateurs_nom_caractere_invalide():void {

        $reponse = $this->post(route('animateurs.store'), [
            'prenom' => 'Test',
            'nom' => 1,
            'biographie' => 'Expert en développement web et Laravel.',
            'expertise' => 'Test, Test, PHP',
            'email' => 'test.dupont@example.com',
        ]);

        $reponse->assertSessionHasErrors([
            'nom' => "Le champ nom doit contenir uniquement des lettres."
        ]);
    }



    public function test_modification_animateur_succes():void {


        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);


        $nouveauPrenom = 'Prenommodifié';
        $nouveauNom = 'Nommodifie';

        $reponse = $this->put(route('animateurs.update', $animateur->id), [
            'prenom' => $nouveauPrenom,
            'nom' => $nouveauNom,
            'biographie' => $animateur->biographie,
            'expertise' => $animateur->expertise,
            'email' => $animateur->email,
        ]);

        $this->assertDatabaseHas('animateurs', [
            'prenom' => $nouveauPrenom,
            'nom' => $nouveauNom,
        ]);

        $reponse->assertRedirect(route('animateurs.index'));

        // données de session
        $reponse->assertSessionHas('animateur_modifier');
        $reponse->assertSessionHas('prenom_animateur', $nouveauPrenom);
        $reponse->assertSessionHas('nom_animateur', $nouveauNom);

        // Suivre la redirection
        $reponse = $this->followRedirects($reponse);
        $reponse->assertSee($nouveauPrenom . ' ' . $nouveauNom);
        $reponse->assertSee('a été modifié avec succès');

    }
    public function test_modification_animateur_echec(): void
    {

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);


        $reponse = $this->put(route('animateurs.update', $animateur->id), [
            'prenom' => '',  // Invalid
            'nom' => '',     // Invalid
            'biographie' => $animateur->biographie,
            'expertise' => $animateur->expertise,
            'email' => $animateur->email,
        ]);


        $reponse->assertSessionHasErrors(['prenom', 'nom']);


        $this->assertDatabaseHas('animateurs', [
            'id' => $animateur->id,
            'prenom' => 'Jean',
            'nom' => 'Test',
        ]);
    }



    public function test_suppression_animateur_retire_bd():void {

        $animateur = Animateur::factory()->create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'biographie' => 'Biographie',
            'expertise' => 'Programmation',
            'email' => 'jean.test@example.com',
        ]);
        $response = $this->delete(route('animateurs.destroy', $animateur->id));
        $this->assertDatabaseMissing('animateurs', [
            'prenom' => $animateur->prenom,
            'nom' => $animateur->nom,
            'biographie' => $animateur->biographie,
            'expertise' => $animateur->expertise,
            'email' => $animateur->email,

        ]);
        $response->assertRedirect(route('animateurs.index'));
        $response->assertSessionHas('animateur_supprime');

    }

    public function test_atelier_ajout_ajoute_animateur_a_atelier()
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


        Gate::shouldReceive('authorize')
            ->once()
            ->with('atelier_ajout', [$animateur, $atelier]);


        $response = $this->post(route('animateur.atelier_ajout', [$animateur->id, $atelier->id]));


        $this->assertDatabaseHas('animateur_atelier', [
            'animateur_id' => $animateur->id,
            'atelier_id' => $atelier->id,
        ]);

        $response->assertRedirect(route('ateliers.index'))
            ->assertSessionHas('success', 'Animateur lié à atelier via Url/Route avec succès.');
    }

    public function test_atelier_ajout_ne_duplique_pas_la_liaison()
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
        $animateur->ateliers()->attach($atelier);

        Gate::shouldReceive('authorize')
            ->once()
            ->with('atelier_ajout', [$animateur, $atelier]);

        $response = $this->post(route('animateur.atelier_ajout', [$animateur->id, $atelier->id]));

        $this->assertEquals(1, $animateur->ateliers()->where('atelier_id', $atelier->id)->count());

        $response->assertRedirect(route('ateliers.index'))
            ->assertSessionMissing('success');
    }



}
