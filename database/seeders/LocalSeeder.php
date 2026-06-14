<?php
/**
 * @author Benoit Tremblay.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        DB::table('locals')->insert([
            ['campus_id' => 1, 'numeroLocal' => 'A101', 'capacite' => 30 , 'disponibilite' => true],
            ['campus_id' => 1, 'numeroLocal' => 'B102', 'capacite' => 25, 'disponibilite' => true],
            ['campus_id' => 1, 'numeroLocal' => 'C103', 'capacite' => 40, 'disponibilite' => true],
            ['campus_id' => 2, 'numeroLocal' => 'D201', 'capacite' => 50 ,'disponibilite' => true],
            ['campus_id' => 2, 'numeroLocal' => 'E202', 'capacite' => 35 , 'disponibilite' => true],
            ['campus_id' => 2, 'numeroLocal' => 'F203', 'capacite' => 27, 'disponibilite' => true],
            ['campus_id' => 2, 'numeroLocal' => 'H048', 'capacite' => 28 ,'disponibilite' => true],
        ]);
    }
}


