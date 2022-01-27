<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        Event::create([
            'nom' => 'Séminaire',
            'description'=>'Seméniare Etudiant Master',
            'debut'=>'2022-01-27 11:00:00',
            'fin'=>'2022-01-27 16:00:00',
        ]);
        Event::create([
            'nom' => 'Séance sport',
            'description'=>'Salle Basic Fit',
            'debut'=>'2022-01-28 18:00:00',
            'fin'=>'2022-01-28 20:00:00',
        ]);
        Event::create([
            'nom' => 'Examen',
            'description'=>'Matière Gestion du projet',
            'debut'=>'2022-01-27 09:00:00',
            'fin'=>'2022-01-27 10:30:00',
        ]);
        Event::create([
            'nom' => 'Projet',
            'description'=>'Mission Test LARAVEL',
            'debut'=>'2022-01-25 09:00:00',
            'fin'=>'2022-01-27 22:30:00',
        ]);
    }
}