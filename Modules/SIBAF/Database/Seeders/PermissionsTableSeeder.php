<?php

namespace Modules\SIBAF\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Permission;
use Modules\SICA\Entities\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una lista de permisos para el rol 
        $permissions_admin = []; // Lista de permisos para el rol de administrador
        $permissions_soporte = [];
        // Consultar aplicación SICA para registrar los roles
        $app = App::where('name', 'SIBAF')->first();


        // Vista de configuración (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'sibaf.admin.welcome'], [ // Registro o actualización de permiso
            'name' => 'Acceso al Rol de Administrador',
            'description' => 'Acceso al Rol de Administrador',
            'description_english' => 'Access to the Administrator Role',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id; // Almacenar permiso para rol

     

        // Consulta de ROLES
        $rol_admin = Role::where('slug', 'sibaf.admin')->first(); // Rol Administrador
       
        // Asignación de PERMISOS para los ROLES de la aplicación AGROSOFT (Sincronización de las relaciones sin eliminar las relaciones existentes)
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);

       // permisos para el rol de inventario
       $permissions_inventario = [];
       $permission = Permission::updateOrCreate(['slug' => 'sibaf.inventory.view'], [
        'name' => 'Ver Inventario de Equipos',
        'description' => 'Permite al usuario ver el inventario de equipos',
        'description_english' => 'Allows the user to view the equipment inventory',
        'app_id' => $app->id
       ]);      
       $permissions_inventario[] = $permission->id;

       // Consulta de ROLES
       $rol_admin = Role::where('slug', 'sibaf.admin')->first(); // Rol admin

       // Asignación de PERMISOS para los ROLES de la aplicación AGROSOFT (Sincronización de las relaciones sin eliminar las relaciones existentes)
       $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);

        // asignación de permisos para el rol de soporte
        $permissions_soporte = []; // Lista de permisos para el rol de soporte  
        
        
         // Consultar aplicación SICA para registrar los roles
         $app = App::where('name', 'SIBAF')->first();
          // Vista de configuración (Soporte)
         $permission = Permission::updateOrCreate(['slug' => 'sibaf.soporte.welcomesoporte'], [ // Registro o actualización de permiso
             'name' => 'Acceso al Rol de soporte',
             'description' => 'Acceso al Rol de soporte',
             'description_english' => 'Access to the support role',
             'app_id' => $app->id
         ]);
         $permissions_soporte[] = $permission->id; // Almacenar permiso para rol
 
      
 
         // Consulta de ROLES
         $rol_soporte = Role::where('slug', 'sibaf.soporte')->first(); // Rol Soporte
        
 
         // Asignación de PERMISOS para los ROLES de la aplicación AGROSOFT (Sincronización de las relaciones sin eliminar las relaciones existentes)
         $rol_soporte->permissions()->syncWithoutDetaching($permissions_soporte);
 

       //asignación de permisos para el rol de instructor
       $permissions_instructor = []; // Lista de permisos para el rol de instructor
       $permission = Permission::updateOrCreate(['slug' => 'sibaf.instructor.masterinstructor'], [ // Registro o actualización de permiso
        'name' => 'Acceso al Rol de instructor',
        'description' => 'Acceso al Rol de instructor',
        'description_english' => 'Access to the instructor role',
        'app_id' => $app->id
       ]);              
       $permissions_instructor[] = $permission->id; // Almacenar permiso para rol

       // Consulta de ROLES
       $rol_instructor = Role::where('slug', 'sibaf.instructor ')->first(); // Rol Instructor
       $rol_instructor = Role::where('slug', 'sibaf.instructor')->first(); // Rol Instructor

       // Asignación de PERMISOS para los ROLES de la aplicación AGROSOFT (Sincronización de las relaciones sin eliminar las relaciones existentes)
       $rol_instructor->permissions()->syncWithoutDetaching($permissions_instructor);   
    }
}