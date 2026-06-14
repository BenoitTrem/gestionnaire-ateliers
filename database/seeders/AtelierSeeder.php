<?php
/**
 * @author Benoit Tremblay.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtelierSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        DB::table('ateliers')->insert([
            [
                'id' => 1,
                'nom' => 'Conquête verte',
                'description' => "Repenser notre rapport à la nature à l'ère de l'Anthropocène",
                'campus_id' => 1,
                'local_id' => 2,
                'url_inscription' => 'https://www.google.ca/?hl=fr',
                'date' => '2025-03-17',
                'heure_debut' => '08:00:00',
                'duree_minutes' => 60,
                'statut' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nom' => 'À la conquête du Savoir',
                'description' => 'Histoire du livre et des bibliothèques',
                'campus_id' => 2,
                'local_id' => 6,
                'url_inscription' => 'https://www.google.ca/?hl=fr',
                'date' => '2025-03-21',
                'heure_debut' => '13:00:00',
                'duree_minutes' => 120,
                'statut' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nom' => 'Lutte contre les inégalités dans la douleur',
                'description' => 'Une conquête urgente',
                'campus_id' => 2,
                'local_id' => 7,
                'url_inscription' => 'https://www.google.ca/?hl=fr',
                'date' => '2025-03-18',
                'heure_debut' => '09:00:00',
                'duree_minutes' => 300,
                'statut' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('animateur_atelier')->insert([
            ['atelier_id' => 1, 'animateur_id' => 1],
            ['atelier_id' => 2, 'animateur_id' => 1],
            ['atelier_id' => 3, 'animateur_id' => 1],
            ['atelier_id' => 3, 'animateur_id' => 2],
        ]);
    }
}
