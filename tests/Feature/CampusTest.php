<?php

/**
 * @author Benoit Tremblay
 */

//use Illuminate\Foundation\Testing\RefreshDatabase;
namespace Tests\Feature;

use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Local;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CampusTest extends TestCase
{

    use DatabaseTransactions;

    public function test_utilise_les_champs_fillable_corrects():void
    {
        $campus = new Campus();

        $this->assertEquals(['id', 'nom'], $campus->getFillable());
    }
    public function test_utilise_le_nom_de_table_correct()
    {
        $campus = new Campus();

        $this->assertEquals('campuses', $campus->getTable());
    }

}
