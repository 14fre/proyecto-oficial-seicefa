<?php

namespace Modules\GPES\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\SICA\Entities\Role;

// modelos necesarios para el funcionamiento de GPES
// use Modules\SICA\Entities\Environment;
// use Modules\SICA\Entities\Apprentice;

class GPESController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function  welcome()
    {
        return view('gpes::welcome');
    }


    public function AuthRolesUser($rolSeleccionado)
    {


        // $rolesGpes = [
        //     "Admin GPES",
        //     "Apprentice GPES",
        //     "Instructor GPES",
        //     "Intern GPES"
        // ];






    }

    
    public static  function listRoles()
    {

        if (Auth::check()) {

            $user = User::find(Auth::user()->id);
            $roles = $user->roles;

            return $roles;
        } else {
            $roles = [];
            return view("gpes::welcome", compact("roles"));
        }
    }

    public function testing()
    {


        $roles = $this->listRoles();

        return view("gpes::testing", compact("roles"));
    }


}
