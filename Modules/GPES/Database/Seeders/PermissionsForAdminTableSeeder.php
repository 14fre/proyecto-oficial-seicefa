<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\SICA\Entities\Permission;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Role;





use App\Models\User;
use Modules\SICA\Entities\Person;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PermissionsForAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Definir arreglos de PERMISOS que van ser asignados a los ROLES
        $permissions_admin = []; // Permisos para Administrador


        // Consultar aplicación SICA para registrar los roles
        $app = App::where('name', 'GPES')->first();


        // ===================== Registro de todos los permisos de la aplicación   GPES ==================


        // Vista principal del administrador
        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.dashboard'], [ // Registro o actualización de permiso
            'name' => 'Vista dashboard GPES',
            'description' => 'para poder visualizar las vista dashboard de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);

        $permissions_admin[] = $permission->id; // Almacenar permiso para rol


        //  permisos para administrar las categorias



        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.index'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol



        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.destroy'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol

        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.update'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol

        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.edit'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol

        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.store'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol


        $permission = Permission::updateOrCreate(['slug' => 'gpes.admin.category.create'], [ // Registro o actualización de permiso
            'name' => 'Vista category GPES',
            'description' => 'para poder visualizar las vista category de GPES',
            'description_english' => 'You can see the main view of the administrator of GPES',
            'app_id' => $app->id
        ]);


        $permissions_admin[] = $permission->id; // Almacenar permiso para rol


        // Consulta de ROLES
        $rol_admin = Role::where('slug', 'gpes.admin')->first(); // Rol Administrador


        // Asignación de PERMISOS para los ROLES de la aplicación CAFETO (Sincronización de las relaciones sin eliminar las relaciones existentes)
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);
    }
}
