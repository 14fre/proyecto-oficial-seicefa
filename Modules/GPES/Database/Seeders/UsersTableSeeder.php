<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\Person;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Administrador
        $person = Person::where('document_number', 1081152142)->first(); // Consultar Persona
        User::updateOrCreate(['nickname' => 'andresGonzalo'], [ // Actualizar o crear usuario
            'person_id' => $person->id,
            'email' => 'admingpes@gmail.com'  //Anba2142
        ]);


         // Administrador Vigilante
        $person = Person::where('document_number', 1234567890)->first(); // Consultar Persona
        User::updateOrCreate(['nickname' => 'marianaLopez'], [ // Actualizar o crear usuario
            'person_id' => $person->id,
            'email' => 'marianalopez@gmail.com', // Malo7890
        ]);



        // Usuario APRENDIZ - Laura Marcela Ramírez Pérez
        $person = Person::where('document_number', 1081152143)->first();
        User::updateOrCreate(['nickname' => 'lauraRamirez'], [
            'person_id' => $person->id,
            'email' => 'lauramgpes@gmail.com', // Lara2143
        ]);


        // Usuario INSTRUCTOR - Carlos Eduardo Morales Gómez
        $person = Person::where('document_number', 1081152144)->first();
        User::updateOrCreate(['nickname' => 'carlosMorales'], [
            'person_id' => $person->id,
            'email' => 'carlosmgpes@gmail.com', // Car2144
        ]);

        // Usuario PASANTE - Diana Carolina Torres López
        $person = Person::where('document_number', 1081152145)->first();
        User::updateOrCreate(['nickname' => 'dianaTorres'], [
            'person_id' => $person->id,
            'email' => 'dianatgpes@gmail.com', // Dia2145
        ]);
    } 
}
