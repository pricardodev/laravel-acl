@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <a class="text-success" href="{{ route('role.index') }}">&leftarrow; Voltar para a listagem</a>

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger mt-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <form action="{{ route('role.store') }}" method="post" class="mt-4" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nome do Perfil</label>
                                <input type="text" class="form-control" id="name" placeholder="Insira o nome completo"
                                       name="name" value="{{ old('name') }}">
                            </div>
                            <button type="submit" class="btn btn-block btn-success">Cadastrar Novo Perfil</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
