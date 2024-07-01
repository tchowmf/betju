@extends('templates.blank')
@section('title', "Bet Juuuuu - Criar Aposta")

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
                        <button type="submit" class="btn btn-primary">Criar Aposta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection