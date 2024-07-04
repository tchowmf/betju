@extends('templates.blank')
@section('title', "Bet Juuu - Editar Aposta")

@section('contents')

@if(session('success'))
  <div class="alert alert-success sm-2">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger sm-2">{{ session('error') }}</div>
@endif

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
                            <input type="text" name="title" id="title" class="form-control" 
                            value="{{ $event->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="player1">Jogador 1:</label>
                            <input type="text" name="player1" id="player1" class="form-control" 
                            value="{{ $event->player1 }}" required>
                        </div>
                        <div class="form-group">
                            <label for="player2">Jogador 2:</label>
                            <input type="text" name="player2" id="player2" class="form-control" 
                            value="{{ $event->player2 }}" required>
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
                            <input type="datetime-local" name="time_limit" id="time_limit" class="form-control" 
                            value="{{ $event->time_limit }}" required>
                        </div>
                        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Aposta</button>
                    </form>

                    <br>
                    <form action="{{ route('events.resolve', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="winner">Selecione o Vencedor</label>
                            <select name="winner" id="winner" class="form-control">
                                <option value="{{ $event->player1 }}">{{ $event->player1 }}</option>
                                <option value="{{ $event->player2 }}">{{ $event->player2 }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Selecionar Vencedor</button>
                    </form>
                    
                    <br>
                    <form action="{{ route('events.cancel', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Cancelar Aposta</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection