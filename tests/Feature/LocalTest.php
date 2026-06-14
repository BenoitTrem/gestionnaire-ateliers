<?php


/**
 * @author Benoit Tremblay , John Sebastian Zuleta Franco
 */

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Local;
use App\Models\Campus;
use App\Models\User;
use \Illuminate\Foundation\Testing\WithFaker;

class LocalTest extends TestCase
{

    ///
    use DatabaseTransactions, WithFaker;


    private User $admin;


    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 1]);
        $this->actingAs($this->admin);
    }
    /**
     * A basic test example.
     */

    public function test_creation_Local_enregistre_bd():void {

        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);


        $this->assertDatabaseMissing('locals', [

            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $this->post(route('locaux.store'), [
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $this->assertDatabaseHas('locals', [
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);
    }

    public function test_creation_local_redirige_index():void {

        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $reponse = $this->post(route('locaux.store'), [
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $reponse->assertRedirect(route('locaux.index'));
    }

    public function test_creation_local_donnees_valides():void {
        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $reponse = $this->post(route('locaux.store'), [
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $reponse->assertValid();
    }

    public function test_creation_local_nom_caractere_invalide():void {

        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $reponse = $this->post(route('locaux.store'), [
            'numeroLocal' => 1,
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $reponse->assertSessionHasErrors([
            'numeroLocal' => "Le champ numero local doit être une chaîne de caractères."
        ]);
    }



    public function test_modification_local_affiche_message_succes(): void
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

        $nouvelleCapacite = 35;
        $nouveauNumLocal = '102B';

        $reponse = $this->put(route('locaux.update', $local->id), [
            'numeroLocal' => $nouveauNumLocal,
            'capacite' => $nouvelleCapacite,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);

        $reponse->assertRedirect(route('locaux.index'));

        $this->assertDatabaseHas('locals', [
            'id' => $local->id,
            'numeroLocal' => $nouveauNumLocal,
            'capacite' => $nouvelleCapacite,
        ]);

    }



    public function test_suppression_local_retire_bd():void {

        $campus = Campus::factory()->create([
            'nom' => 'Campus Test',
        ]);

        $local = Local::factory()->create([
            'numeroLocal' => '101A',
            'capacite' => 30,
            'disponibilite' => true,
            'campus_id' => $campus->id,
        ]);
        $response = $this->delete(route('locaux.destroy', $local->id));
        $this->assertDatabaseMissing('locals', [
            'numeroLocal' => $local->numeroLocal,
            'capacite' => $local->capacite,
            'disponibilite' => $local->disponibilite,
            'campus_id' => $local->campus_id,
        ]);
        $response->assertRedirect(route('locaux.index'));
        $response->assertSessionHas('local_supprime');

    }






}
