@extends('templates.blank')
@section('title', "Bet Juuu - Criar Aposta")

@section('contents')
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1>Criar Aposta</h1>
                    <form action="{{ route('events.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Título do Evento:</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="player1">Jogador 1:</label>
                            <input type="text" name="player1" id="player1" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="player2">Jogador 2:</label>
                            <input type="text" name="player2" id="player2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="resolvido">Resolvido</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bet_end_time">Limite de Tempo para Aposta:</label>
                            <input type="datetime-local" name="time_limit" id="time_limit" class="form-control" required>
                        </div>
                        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Criar Evento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection