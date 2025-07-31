<?php

namespace Modules\SIBAF\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\EPS;
use Modules\SICA\Entities\PensionEntity;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\PopulationGroup;

class PeopleTableSeeder extends Seeder
{
    public function run()
    {
        $population_group = PopulationGroup::firstOrCreate(['name' => 'NINGUNA']);
        $eps = EPS::firstOrCreate(['name' => 'NO REGISTRA']);
        $pension_entity = PensionEntity::firstOrCreate(['name' => 'NO REGISTRA']);

        Person::firstOrCreate(['document_number' => 1029880871], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'BREINER',
            'first_last_name' => 'LLANOS',
            'second_last_name' => 'LOPEZ',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        Person::firstOrCreate(['document_number' => 1077227238], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'FREIMAR',
            'first_last_name' => 'ESPITIA',
            'second_last_name' => 'VANEGAS',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        Person::firstOrCreate(['document_number' => 1075225007], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'JUAN',
            'first_last_name' => 'GARCIA',
            'second_last_name' => 'GARCIA', 
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);
    }
}