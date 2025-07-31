<?php

namespace Modules\SIBAF\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $app = App::where('name', 'SIBAF')->firstOrFail();

        $roladmin = Role::updateOrCreate(['slug' => 'sibaf.admin'], [
            'name' => 'Administrador',
            'description' => 'Rol administrador de la aplicación AGROSOFT',
            'description_english' => 'SIBAFT application administrator role',
            'full_access' => 'No',
            'app_id' => $app->id
        ]);

        $useradministrador = User::where('nickname', 'BREINERLLANOS')->firstOrFail();

        $useradministrador->roles()->syncWithoutDetaching([$roladmin->id]);

        $rolsoporte = Role::updateOrCreate(['slug' => 'sibaf.soporte'], [
            'name' => 'mesa ayuda',
            'description' => 'Rol de mesa de ayuda de la aplicación AGROSOFT',
            'description_english' => ' SIBAFT application help desk role',
            'full_access' => 'No',
            'app_id' => $app->id
        ]);

        $usersoporte= User::where('nickname', 'FREIMAR14')->firstOrFail();

        $usersoporte->roles()->syncWithoutDetaching([$rolsoporte->id]);
        //instructor
        $rolinstructor = Role::updateOrCreate(['slug' => 'sibaf.instructor'], [
            'name' => 'instructor',
            'description' => 'Rol de instructor de la aplicación SIBAFT',
            'description_english' => ' SIBAFT application instructor role',
            'full_access' => 'No',
            'app_id' => $app->id
        ]);

            $userinstructor = User::where('nickname', 'FRE1345')->firstOrFail();

        $userinstructor->roles()->syncWithoutDetaching([$rolinstructor->id]);
    }

    

    
}