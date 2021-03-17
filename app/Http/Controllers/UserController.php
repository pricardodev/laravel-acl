<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    private $users;
    private $roles;
    
    private $rolesRequest;

    public function __construct(User $users, Role $roles){
        
        $this->users = $users;
        $this->roles = $roles;
        $rolesRequest = $this->rolesRequest;
    }
   
    public function index()
    {
        $users = $this->users->select('id', 'name', 'email')->orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    // Validacao dos dados do formulário
    private function validaForm($request, $method=null) {
        if($method === null)
        {
            $validacao = $request->validate
            ([
                'name' => 'required|max:255',
                'email' => 'required|unique:users,email|email:rfc,dns|max:255',
                'password' => 'required|max:16',
             ]);

        }else{

            $validacao = $request->validate
            ([
                'name' => 'required|max:255',
                'password' => 'max:16',
            ]);

        }

   }

    public function store(Request $request)
    {

        $this->validaForm($request);
        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->users->where(['name'=> $request->name, 'email' => $request->email])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{
    
            $user = $this->users;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            try {

                $user->save();
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
        $user = $this->users->where('id', $id)->first();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $this->validaForm($request, $method='put');

        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->users->where(['name'=> $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{

            $user = $this->users->where('id', $id)->first();

            if($user === null)
            {
                $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
                return back()->with($notifications);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            if(!empty($request->password))
            {
                $user->password = bcrypt($request->password);
            }
               
            try {

                $user->update();
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
        $user = $this->users->where('id', $id)->first();

        if($user === null)
        {
            $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
            return back()->with($notifications);
        }

        try
        {
            $user->delete();
            $notifications = array('message' => 'Registro deletado com sucesso!', 'alert-type' => 'alert-success');
            return back()->with($notifications);
           
        }catch(\Illuminate\Database\QueryException $e){

            $notifications = array('message' => 'Erro ao deletar, Registro sendo utilizado pelo sistema!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }
    }

    public function roles($user) 
    {
        $user = $this->users->where('id', $user)->first();
        $roles = $this->roles->select('id', 'name')->orderBy('name', 'asc')->get();

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
            $roles[] = $this->roles->where('id',$key)->first();
       }
       //Sobrescrevendo a variavél que vem via parametro da função
       $user = $this->users->where('id',$user)->first();

       if(!empty($roles))
       {
            //Método do Spatie que espera receber um array ou null
            $user->syncRoles($roles);
       } else {
            $user->syncRoles(null);
       }

       $notifications = array('message' => 'Perfil sincronizado com sucesso!', 'alert-type' => 'alert-success');
       return back()->with($notifications);

    }
}
