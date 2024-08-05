@extends('templates.blank')
@section('title', "Bet Juuu - Enviar Resultado")

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
                    <h1>Enviar Resultado</h1>

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

                        <div class="form-group">
                            <label for="loser_games">Games Perdedor</label>
                            <select name="loser_games" id="loser_games" class="form-control">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Enviar Resultado</button>
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