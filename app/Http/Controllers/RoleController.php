<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::where('id',$id)->first();
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::where('id',$id)->first();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index');
    }

    public function destroy($id)
    {
        $role = Role::where('id',$id)->first();
        $role->delete();

        return redirect()->route('role.index');
    }

    public function permissions($role) 
    {
        $role = Role::where('id', $role)->first();
        $permissions = Permission::all();

        foreach($permissions as $permission)
        {
            //Verificando se o perfil tem a permissão
            if($role->hasPermissionTo($permission->name)){
                $permission->can = true; //criando novo atributo como flag para setar na view
            }else {
                $permission->can = false;
            }
        }

        return view('roles.permissions', compact('role','permissions'));
    }

    public function permissionsSync(Request $request, $role) 
    {
        //Limpando o array
       $permissionsRequest = $request->except(['_token','_method']);
       //Recuperando a chave para setar na busca dos modelos
       foreach($permissionsRequest as $key => $value)
       {
           //Recuperando os medelos de objetos 
            $permissions[] = Permission::where('id',$key)->first();
       }
       //Sobrescrevendo a variavél que vem via parametro da função
       $role = Role::where('id',$role)->first();

       if(!empty($permissions))
       {
            //Método do Spatie que espera receber um array ou null
            $role->syncPermissions($permissions);
       } else {
            $role->syncPermissions(null);
       }
       //Recebendo role->id do modelo e não da string passada por parametro.
       return redirect()->route('role.permissions', ['role' => $role->id]);

    }

}
