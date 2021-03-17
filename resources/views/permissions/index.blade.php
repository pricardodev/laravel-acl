@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        
                        <a class="text-success" href="{{ route('permission.create') }}">&plus; Cadastrar Permissões</a>

                        @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-type') }} message-alert">{{ Session::get('message') }}</div>
                            @endif
                            
                        <table class="table table-bordered table-hover table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Permissões</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                           @forelse($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->description }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td class="d-flex">
                                        <a class="mr-3 btn btn-sm btn-outline-success" href="{{ route('permission.edit', ['permission' => $permission->id] ) }}">Editar</a>
                                      
                                        <button class="btn btn-sm btn-outline-danger" type="button" value="Deletar" data-toggle="modal" data-target="#deletar{{ $permission->id }}">Deletar</button>
                                       
                                        <div class="modal fade" id="deletar{{ $permission->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deletar{{ $permission->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletar{{ $permission->id }}Label">Exclusão de Registro</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                O registro <b>{{ $permission->description }}</b> será deletado da base de dados.
                                                <p>Deseja realmente executar esta ação?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('permission.destroy', ['permission' => $permission->id]) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-success" type="submit" value="Deletar">Comfirmar</button>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>

                                    </td>
                                </tr>
                          @empty
                          <tr>
                            <td colspan="3" style="background-color:white !important">
                                 <div class="alert alert-info"> Nenhum registro cadastrado! </div> 
                            </td>
                          </tr>
                          @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
