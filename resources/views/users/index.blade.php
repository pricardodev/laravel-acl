@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a class="text-success" href="{{ route('user.create') }}">&plus; Cadastrar Usuários</a>

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger mt-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuários</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                           @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td class="d-flex">
                                        <a class="mr-3 btn btn-sm btn-outline-success" href="{{ route('user.edit', ['user' => $user->id] ) }}">Editar</a>
                                        <a class="mr-3 btn btn-sm btn-outline-info" href="{{ route('user.roles', ['user' => $user->id]) }}">Perfis</a>
                                        <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input class="btn btn-sm btn-outline-danger" type="submit" value="Remover">
                                        </form>
                                    </td>
                                </tr>
                          @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
