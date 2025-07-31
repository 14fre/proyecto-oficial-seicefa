<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\EPS;
use Modules\SICA\Entities\PensionEntity;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\PopulationGroup;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $population_group = PopulationGroup::firstOrCreate(['name' => 'NINGUNA']); // Consultar o registrar Grupo Poblacional
        $eps = EPS::firstOrCreate(['name' => 'NO REGISTRA']); // Consultar o registrar EPS
        $pension_entity = PensionEntity::firstOrCreate(['name' => 'NO REGISTRA']); // Consultar o registrar Entidad de pensiones


        Person::firstOrCreate(['document_number' => 1081152142], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'Andres Gonzalo',
            'first_last_name' => 'Barrera',
            'second_last_name' => 'Cortes',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Anba2142 -> contraseña de este usuario

        Person::firstOrCreate(['document_number' => 1234567890], [
            'document_type' => 'Tarjeta de identidad',
            'first_name' => 'Mariana',
            'first_last_name' => 'Lopez',
            'second_last_name' => 'García',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Contraseña sugerida: Malo7890

        // Usuario 1
        Person::firstOrCreate(['document_number' => 1081152143], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'Laura Marcela',
            'first_last_name' => 'Ramírez',
            'second_last_name' => 'Pérez',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Lara2143 -> contraseña de este usuario

        // Usuario 2
        Person::firstOrCreate(['document_number' => 1081152144], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'Carlos Eduardo',
            'first_last_name' => 'Morales',
            'second_last_name' => 'Gómez',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Camo2144 -> contraseña de este usuario

        // Usuario 3
        Person::firstOrCreate(['document_number' => 1081152145], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'Diana Carolina',
            'first_last_name' => 'Torres',
            'second_last_name' => 'López',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Dito2145 -> contraseña de este usuario

        // Usuario 4
        Person::firstOrCreate(['document_number' => 1081152146], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'Juan Sebastián',
            'first_last_name' => 'Martínez',
            'second_last_name' => 'Rojas',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]); // Juma2146 -> contraseña de este usuario


    }
}
