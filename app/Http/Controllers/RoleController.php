<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $roles;
    private $permissions;

    public function __construct(Role $roles, Permission $permissions) {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function index()
    {
        $roles = $this->roles->select('id', 'name')->orderBy('name', 'asc')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    // Validacao dos dados do formulário
    private function validaForm($request) {
        $validacao = $request->validate
       ([
           'name' => 'required|max:255'
       ]);
   }

    public function store(Request $request)
    {
        $this->validaForm($request);
        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->roles->where(['name' => $request->name])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{
    
            $role = $this->roles;
            $role->name = $request->name;

            try {

                $role->save();
                $notifications = array('message' => 'Cadastro efetuado com sucesso!', 'alert-type' => 'alert-success');
                return back()->with($notifications);

            }catch(\Illuminate\Database\QueryException $e) {
                $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
                return back()->with($notifications);
            }
    
           
        }
    }

    public function edit($id)
    {
        $role = $this->roles->where('id',$id)->first();
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $this->validaForm($request);

        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->roles->where(['name' => $request->name])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{

            $role = $this->roles->where('id', $id)->first();

            if($role === null)
            {
                $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
                return back()->with($notifications);
            }

            $role->name = $request->name;
               
            try {

                $role->update();
                $notifications = array('message' => 'Cadastro editado com sucesso!', 'alert-type' => 'alert-success');
                return back()->with($notifications);

            }catch(\Illuminate\Database\QueryException $e) {
                $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
                return back()->with($notifications);
            }

        }
    }

    public function destroy($id)
    {
        $role = $this->roles->where('id', $id)->first();

        if($role === null)
        {
            $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
            return back()->with($notifications);
        }

        try
        {
            $role->delete();
            $notifications = array('message' => 'Registro deletado com sucesso!', 'alert-type' => 'alert-success');
            return back()->with($notifications);
           
        }catch(\Illuminate\Database\QueryException $e){

            $notifications = array('message' => 'Erro ao deletar, Registro sendo utilizado pelo sistema!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }

    }

    public function permissions($role) 
    {
        $role = $this->roles->where('id', $role)->first();
        $permissions = $this->permissions->select('id', 'description', 'name')->orderBy('name', 'asc')->get();

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
            $permissions[] = $this->permissions->where('id',$key)->first();
       }
       //Sobrescrevendo a variavél que vem via parametro da função
       $role = $this->roles->where('id',$role)->first();

       if(!empty($permissions))
       {
            //Método do Spatie que espera receber um array ou null
            $role->syncPermissions($permissions);
       } else {
            $role->syncPermissions(null);
       }
     
       $notifications = array('message' => 'Permissão sincronizada com sucesso!', 'alert-type' => 'alert-success');
       return back()->with($notifications);

    }

}
