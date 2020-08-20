<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    private $users;
    private $user;
    private $rolesRequest;

    public function __construct(){
        $users = $this->users;
        $user = $this->user;
        $rolesRequest = $this->rolesRequest;
    }
   
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect()->route('user.index');

    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->password))
        {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.index');

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user.index');
    }

    public function roles($user) 
    {
        $user = User::where('id', $user)->first();
        $roles = Role::all();

        foreach($roles as $role)
        {
            //Verificando se o usuario tem a perfil
            if($user->hasRole($role->name))
            {
                $role->can = true; //criando novo atributo como flag para setar na view
            }else {
                $role->can = false;
            }
        }

        return view('users.roles', compact('user','roles'));
    }

    public function rolesSync(Request $request, $user) 
    {
        //Limpando o array
       $rolesRequest = $request->except(['_token','_method']);
       //Recuperando a chave para setar na busca dos modelos
       foreach($rolesRequest as $key => $value)
       {
           //Recuperando os medelos de objetos 
            $roles[] = Role::where('id',$key)->first();
       }
       //Sobrescrevendo a variavél que vem via parametro da função
       $user = User::where('id',$user)->first();

       if(!empty($roles))
       {
            //Método do Spatie que espera receber um array ou null
            $user->syncRoles($roles);
       } else {
            $user->syncRoles(null);
       }
       //Recebendo role->id do modelo e não da string passada por parametro.
       return redirect()->route('user.roles', ['user' => $user->id]);

    }
}
