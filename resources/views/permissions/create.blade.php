@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <a class="text-success" href="{{ route('permission.index') }}">&leftarrow; Voltar para a listagem</a>
                                   
                        @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-type') }} message-alert">{{ Session::get('message') }}</div>
                            @endif

                        <form action="{{ route('permission.store') }}" method="post" class="mt-4" autocomplete="off">
                            @csrf
                                            
                            <div class="form-group">
                                <label for="descriptionPermission">Descrição da Permissão</label> <span class="obrigatorio">*</span>
                                <input type="text" class="form-control" id="descriptionPermission" maxlength="255" autofocus placeholder="Insira uma descrição para a permissão"
                                       name="description" value="{{ old('description') }}">
                                       @if($errors->has('description'))
                                            <div class="error">{{ $errors->first('description') }}</div>
                                        @endif
                            </div>

                            <div class="form-group">
                                <label for="namePermission">Nome da Permissão</label> <span class="obrigatorio">*</span>
                                <input type="text" class="form-control" id="namePermission" maxlength="255" placeholder="Insira uma permissão"
                                       name="name" value="{{ old('name') }}">
                                       @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                            </div>

                            <button type="submit" class="btn btn-block btn-success">Cadastrar Novs Permissão</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
