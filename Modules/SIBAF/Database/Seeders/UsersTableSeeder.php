<?php

namespace Modules\SIBAF\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SICA\Entities\Person;

class UsersTableSeeder extends Seeder
{
    public function run()
    {    //rol admin
        $person = Person::where('document_number', 1029880871)->first();
        User::updateOrCreate(['nickname' => 'BREINERLLANOS'], [
            'person_id' => $person->id,
            'email' => 'breinerjosellanoslopez@gmail.com' //Brll0871
        ]);
            //rol soporte
        $person = Person::where('document_number', 1077227238)->first();
        User::updateOrCreate(['nickname' => 'FREIMAR14'], [
            'person_id' => $person->id,
            'email' => 'freimarespitia24@gmail.com' //Fres7238
        ]);
               //rol de instructor
        $person = Person::where('document_number', 1075225007)->first();
        User::updateOrCreate(['nickname' => 'FRE1345'], [
            'person_id' => $person->id,
            'email' => 'juanjosegarcia@gmail.com' //Juga5007
        ]);     
    }
}