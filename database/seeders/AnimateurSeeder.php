<?php

/**
 * @author John Sebastian Zuleta Franco
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimateurSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }
        /**
         * Création de 5 enregistrements de animateurs.
         * Chagtp
         */

        DB::table('animateurs')->insert([
            [
                'prenom' => 'Jean',
                'nom' => 'Dupont',
                'biographie' => 'Expert en développement web et Laravel.',
                'expertise' => 'Laravel, Vue.js, PHP',
                'email' => 'jean.dupont@example.com',

            ],
            [
                'prenom' => 'Sophie',
                'nom' => 'Martin',
                'biographie' => 'Spécialiste en intelligence artificielle et data science.',
                'expertise' => 'Python, Machine Learning, Data Science',
                'email' => 'sophie.martin@example.com',

            ],
            [
                'prenom' => 'Lucas',
                'nom' => 'Moreau',
                'biographie' => 'Passionné par la cybersécurité et le hacking éthique.',
                'expertise' => 'Sécurité informatique, Ethical Hacking',
                'email' => 'lucas.moreau@example.com',

            ],
            [
                'prenom' => 'Emma',
                'nom' => 'Lemoine',
                'biographie' => 'Développeuse full-stack avec une expertise en React et Node.js.',
                'expertise' => 'JavaScript, React, Node.js',
                'email' => 'emma.lemoine@example.com',

            ],
            [
                'prenom' => 'David',
                'nom' => 'Bernard',
                'biographie' => 'Ingénieur cloud et DevOps, certifié AWS.',
                'expertise' => 'AWS, Docker, Kubernetes',
                'email' => 'david.bernard@example.com',

            ],
        ]);
    }
}
