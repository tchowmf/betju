@extends('templates.blank')
@section('title', "Bet Juuu - Editar Aposta")

@section('contents')
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1>Editar Aposta</h1>
                    <form action="{{ route('events.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Título do Evento:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $event->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="player1">Jogador 1:</label>
                            <input type="text" name="player1" id="player1" class="form-control" value="{{ $event->player1 }}" required>
                        </div>
                        <div class="form-group">
                            <label for="player2">Jogador 2:</label>
                            <input type="text" name="player2" id="player2" class="form-control" value="{{ $event->player2 }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Aposta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection