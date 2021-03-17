@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <a class="text-success" href="{{ route('user.index') }}">&leftarrow; Voltar para a listagem</a>

                        @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-type') }} message-alert">{{ Session::get('message') }}</div>
                            @endif

                        <form action="{{ route('user.store') }}" method="post" class="mt-4" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="nameUsuario">Nome do Usuário</label> <span class="obrigatorio">*</span>
                                <input type="text" class="form-control" id="nameUsuario" autofocus maxlength="255" placeholder="Insira o nome completo do usuário"
                                       name="name" value="{{ old('name') }}">
                                       @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                            </div>
                            <div class="form-group">
                                <label for="emailUsuario">E-mail</label> <span class="obrigatorio">*</span>
                                <input type="email" class="form-control" id="emailUsuario" maxlength="255" placeholder="Insira o e-mail do usuário"
                                       name="email" value="{{ old('email') }}">
                                       @if($errors->has('email'))
                                            <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                            </div>
                            <div class="form-group">
                                <label for="passwordUsuario">Senha</label> <span class="obrigatorio">*</span>
                                <input type="password" class="form-control" id="passwordUsuario" maxlength="16" placeholder="Insira uma senha"
                                       name="password" value="{{ old('password') }}">
                                       @if($errors->has('password'))
                                            <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                            </div>

                            <button type="submit" class="btn btn-block btn-success">Cadastrar Novo Usuário</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
