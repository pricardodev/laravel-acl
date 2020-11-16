@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <a class="text-success" href="{{ route('post.index') }}">&leftarrow; Voltar para a listagem</a>

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger mt-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <form action="{{ route('post.store') }}" method="post" class="mt-4" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="title">Título</label>
                                <input type="text" class="form-control" id="title"
                                       placeholder="Insira o título do artigo"
                                       name="title" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="content">Conteúdo</label>
                                <textarea class="form-control" id="content" rows="3" name="content"
                                          placeholder="Insira o conteúdo..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="content">Publicado</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="published" value="1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="published" value="0">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Não
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block btn-success">Cadastrar Artigo</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
