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

                        <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" class="mt-4" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Nome do Usuário</label> <span class="obrigatorio">*</span>
                                <input type="text" class="form-control" id="name" placeholder="Insira o nome completo"
                                       name="name" value="{{ old('name') ?? $user->name }}">
                                       @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label> <span class="obrigatorio">*</span>
                                <input type="email" class="form-control" id="email" placeholder="Insira o e-mail do usuário"
                                       name="email" value="{{ old('email') ?? $user->email }}">
                                       @if($errors->has('email'))
                                            <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label> 
                                <input type="password" class="form-control" id="password" placeholder="digite uma nova senha"
                                       name="password" value="{{ old('password') }}">
                                       @if($errors->has('password'))
                                            <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                            </div>

                            <button type="submit" class="btn btn-block btn-success">Editar Usuário</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
