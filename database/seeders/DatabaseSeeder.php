<?php

namespace Database\Seeders;

use App\Models\Atelier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'nom' => 'Bergeron',
            'prenom' => 'Claire',
            'role' => 1,
            'email' => 'organisateur@cegep.qc.ca',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'nom' => 'Fontaine',
            'prenom' => 'Luc',
            'role' => 2,
            'email' => 'admin@cegep.qc.ca',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'nom' => 'Savard',
            'prenom' => 'Julie',
            'role' => 3,
            'email' => 'julie.savard@etudiant.cegep.qc.ca',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'nom' => 'Côté',
            'prenom' => 'Mathieu',
            'role' => 3,
            'email' => 'mathieu.cote@etudiant.cegep.qc.ca',
            'password' => bcrypt('password'),
        ]);



        $this->call([
            CampusSeeder::class,
            LocalSeeder::class,
            AnimateurSeeder::class,
            AtelierSeeder::class,
        ]);

    }
}
