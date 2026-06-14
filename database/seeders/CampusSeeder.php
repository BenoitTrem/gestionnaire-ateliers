<?php
/**
 * @author Benoit Tremblay.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        DB::table('campuses')->insert([
            ['nom' => 'Félix-Leclerc'],
            ['nom' => 'Gabrielle-Roy'],
        ]);
    }
}

