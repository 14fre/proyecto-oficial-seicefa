<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Consultar aplicación SICA para registrar los roles
        $app = App::where('name', 'GPES')->firstOrFail();


      
        // Registrar o actualizar rol de ADMINISTRADOR
        $rol_admin = Role::updateOrCreate(['slug' => 'gpes.admin'], [
            'name' => 'Admin GPES',
            'description' => 'Rol administrador de la aplicación GPES',
            'description_english' => 'Administrator role for the GPES application',
            'full_access' => 'no',
            'app_id' => $app->id
        ]);

          // Registrar o actualizar rol de ADMINISTRADOR
        $rol_vigilat = Role::updateOrCreate(['slug' => 'gpes.vigilant'], [
            'name' => 'Admin vigilant',
            'description' => 'Rol vigilante de la aplicación GPES',
            'description_english' => 'vigilant role for the GPES application',
            'full_access' => 'no',
            'app_id' => $app->id
        ]);

        // Registrar o actualizar rol de aprendiz
        $rol_apprentice = Role::updateOrCreate(['slug' => 'gpes.apprentice'], [
            'name' => 'Apprentice GPES',
            'description' => 'Rol del aprendiz en la aplicación GPES',
            'description_english' => 'Apprentice role in the GPES application',
            'full_access' => 'no',
            'app_id' => $app->id
        ]);

        // Registrar o actualizar rol de instructor
        $rol_instructor = Role::updateOrCreate(['slug' => 'gpes.instructor'], [
            'name' => 'Instructor GPES',
            'description' => 'Rol del instructor en la aplicación GPES',
            'description_english' => 'Instructor role in the GPES application',
            'full_access' => 'no',
            'app_id' => $app->id
        ]);

        // Registrar o actualizar rol de pasante
        $rol_intern = Role::updateOrCreate(['slug' => 'gpes.pasante'], [
            'name' => 'Intern GPES',
            'description' => 'Rol del pasante en la aplicación GPES',
            'description_english' => 'Intern role in the GPES application',
            'full_access' => 'no',
            'app_id' => $app->id
        ]);


        // // Consultar rol  de superadministrador
        // $rol_superadmin = Role::where('slug', 'superadmin')->firstOrFail();
        // $user_superadmin = User::where('nickname', 'JDGM0331')->firstOrFail(); // Usuario Super Administrador (Jesús David Guevara Munar)
        // $user_superadmin->roles()->syncWithoutDetaching([$rol_superadmin->id]);
        
        
        // Consulta de usuarios según los nuevos nicknames
        $user_admin = User::where('nickname', 'andresGonzalo')->firstOrFail();         // Usuario Administrador - Andres Gonzalo Barrera Cortes
        $user_vigilat = User::where('nickname', 'marianaLopez')->firstOrFail();     // Usuario vigilante  - 
        $user_apprentice = User::where('nickname', 'lauraRamirez')->firstOrFail();     // Usuario Aprendiz - Laura Marcela Ramírez Pérez
        $user_instructor = User::where('nickname', 'carlosMorales')->firstOrFail();    // Usuario Instructor - Carlos Eduardo Morales Gómez
        $user_intern = User::where('nickname', 'dianaTorres')->firstOrFail();          // Usuario Pasante - Diana Carolina Torres López



        // Asignación de roles (sin eliminar relaciones anteriores)
        $user_admin->roles()->syncWithoutDetaching([$rol_admin->id]);
        $user_admin->roles()->syncWithoutDetaching([$rol_vigilat->id]);
        
        $user_vigilat->roles()->syncWithoutDetaching([$rol_vigilat->id]);
        $user_apprentice->roles()->syncWithoutDetaching([$rol_apprentice->id]);
        $user_instructor->roles()->syncWithoutDetaching([$rol_instructor->id]);
        $user_intern->roles()->syncWithoutDetaching([$rol_intern->id]);
    }
}
