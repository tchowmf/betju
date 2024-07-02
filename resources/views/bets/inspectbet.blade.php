@extends('templates.blank')
@section('title', "Bet Juuu - Realizar Aposta")

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
                    <h1>{{ $bet->title }}</h1>
                    <br>
                    <span>{{ $bet->player1 }}</span> x <span>{{ $bet->player2 }}</span>
                    <br><br>
                    <form action="{{ route('bet.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $bet->id }}">

                        <div class="form-group">
                            <label for="bet_type">Tipo de Aposta:</label>
                            <select name="bet_type" id="bet_type" class="form-control">
                                <option value="winner">Vencedor</option>
                                <option value="games">Número de Games</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="bet_value">Opção de Aposta:</label>
                            <select name="bet_value" id="bet_value" class="form-control">
                                <option value="{{ $bet->player1 }}">{{ $bet->player1 }}</option>
                                <option value="{{ $bet->player2 }}">{{ $bet->player2 }}</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="bet_amount">Valor da Aposta:</label>
                            <input type="number" name="bet_amount" id="bet_amount" class="form-control" value="15.00" readonly>
                        </div>

                        <div>
                            <p>Créditos disponíveis: {{ auth()->user()->credits }}</p>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Fazer Aposta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const betTypeSelect = document.getElementById('bet_type');
    const betOptionSelect = document.getElementById('bet_value');

    betTypeSelect.addEventListener('change', function () {
        const betType = this.value;

        // Limpa as opções atuais
        betOptionSelect.innerHTML = '';

        if (betType === 'winner') {
            // Adiciona as opções de jogador
            betOptionSelect.innerHTML = `
                <option value="{{ $bet->player1 }}">{{ $bet->player1 }}</option>
                <option value="{{ $bet->player2 }}">{{ $bet->player2 }}</option>
            `;
        } else if (betType === 'games') {
            // Adiciona as opções de número de games
            betOptionSelect.innerHTML = `
                <option value="0-4">0 ~ 4</option>
                <option value="5-8">5 ~ 8</option>
                <option value="9-12">9 ~ 12</option>
            `;
        }
    });
});
</script>

@endsection
