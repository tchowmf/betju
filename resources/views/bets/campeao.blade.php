<!-- resources/views/bets/inspect2.blade.php -->

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
                    <h1>{{ $event->title }}</h1>
                    <br>
                    <p>Tempo restante: <span id="countdown{{$event->id}}"></span></p>
                    <form action="{{ route('bet.storeCAMPEAO') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="form-group">
                            <label for="bet_type">Tipo da Aposta:</label>
                            <input type="text" name="bet_type" id="bet_type" class="form-control" value="winner" readonly="">
                        </div>
                    
                        <div class="form-group">
                            <label for="bet_value">Opção de Aposta:</label>
                            <select name="bet_value" id="bet_value" class="form-control">
                                <option value="Rivael e Maga">Rivael e Maga</option> ok
                                <option value="José Chaves e Gisele">José Chaves e Gisele</option> ok
                                <option value="Ande e Eloisa">Ande e Eloisa</option> ok
                                <option value="Caio Leite e Camila">Caio Leite e Camila</option>
                                <option value="Palharin e Carol Machado">Palharini e Carol Machado</option>
                                <option value="Lucas Lopes e Iara">Lucas Lopes e Iara</option>
                                <option value="Juliano P e Andressa">Juliano P e Andressa</option>
                                <option value="Sergio S e Dani Borsato">Sergio S e Dani Borsato</option>
                                <option value="Caio Silva e Isabela">Caio Silva e Isabela</option>
                                <option value="Vitor Garnica e Rina">Vitor Garnica e Luma</option>
                                <option value="Alex Ruiz e Denise">Alex Ruiz e Denise</option>
                                <option value="Schmidt e Paula">Schmidt e Paula</option>
                                <option value="Adalberto e Lucilene">Adalberto e Lucilene</option>
                                <option value="Pedro e Pati">Pedro e Paty</option>
                                <option value="Jacob e Maria Fernanda">Jacob e Maria Fernanda</option>
                                <option value="Gabriel Batista e Luiza">Gabriel Batista e Luisa</option>
                                <option value="Vitor e Liris">Vitor e Liris</option>
                                <option value="Rob e Nadia">Robi e Nadia</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="bet_amount">Valor da Aposta:</label>
                            <input type="number" name="bet_amount" id="bet_amount" class="form-control" value="15.00" readonly>
                        </div>

                        <div>
                            <p>JuuuCoins disponíveis: {{ auth()->user()->credits }}</p>
                        </div>
                        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Fazer Aposta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    (function() {
        const countdownElement = document.getElementById('countdown{{$event->id}}');
        const eventTime = new Date("{{ \Carbon\Carbon::parse($event->time_limit)->setTimezone('America/Sao_Paulo')->format('Y-m-d\TH:i:s') }}-03:00").getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = eventTime - now;

            if (distance < 0) {
                countdownElement.innerHTML = "Apostas encerradas";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>

@endsection
