@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Adicionar Tarefa</div>

                <div class="card-body">
                   <form method="post" action="{{route('tarefa.store')}}">
                        @csrf
                        <div class="form-group">
                            <label>Tarefa</label>
                            <input type="text" class="form-control" name="tarefa">
                            
                        </div>
                        <div class="form-group mt-2">
                            <label >Data limite conclusão</label>
                            <input type="date" class="form-control" name="data_limite_conclusao">
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
