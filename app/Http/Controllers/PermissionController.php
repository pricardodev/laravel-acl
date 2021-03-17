<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
 
    public function index()
    {
        $permissions = $this->permission->select('id', 'description', 'name')->orderBy('description', 'asc')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }
    // Validacao dos dados do formulário
    private function validaForm($request) {
        $validacao = $request->validate
       ([
           'description' => 'required|max:255',
           'name' => 'required|max:255',
       ]);
   }

    public function store(Request $request)
    {
        $this->validaForm($request);
        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->permission->where(['description'=> $request->description, 'name' => $request->name])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{
    
            $permission = $this->permission;
            $permission->description = $request->description;
            $permission->name = $request->name;

            try {

                $permission->save();
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
        $permission = $this->permission->where('id', $id)->first();
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $this->validaForm($request);

        // verifica se já existe registro no banco com mesmos dados do formulário, evitando duplicidade
        $verifica_registro_duplicado = $this->permission->where(['description'=> $request->description, 'name' => $request->name])->exists();

        if($verifica_registro_duplicado === true) {

            $notifications = array('message' => 'Registro ja existe na base de dados!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }else{

            $permission = $this->permission->where('id', $id)->first();

            if($permission === null)
            {
                $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
                return back()->with($notifications);
            }

            $permission->description = $request->description;
            $permission->name = $request->name;
               
            try {

                $permission->update();
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
        $permission = $this->permission->where('id', $id)->first();

        if($permission === null)
        {
            $notifications = array('message' => 'Erro inesperado!', 'alert-type' => 'alert-danger');
            return back()->with($notifications);
        }

        try
        {
            $permission->delete();
            $notifications = array('message' => 'Registro deletado com sucesso!', 'alert-type' => 'alert-success');
            return back()->with($notifications);
           
        }catch(\Illuminate\Database\QueryException $e){

            $notifications = array('message' => 'Erro ao deletar, Registro sendo utilizado pelo sistema!', 'alert-type' => 'alert-warning');
            return back()->with($notifications);

        }

    }
}
