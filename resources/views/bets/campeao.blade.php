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
                            <input type="hidden" name="bet_type" id="bet_type" class="form-control" value="winner" readonly="">
                        </div>
                    
                        <div class="form-group">
                            <label for="bet_value">Opção de Aposta:</label>
                            <select name="bet_value" id="bet_value" class="form-control">
                                <option value="Rivael / Leo">Rivael / Leo</option>
                                <option value="Palharin / Carol Salgado">Palharin / Carol Salgado</option>
                                <option value="Ricardo / Artur">Ricardo / Artur</option>
                                <option value="Claudio / Juliano">Claudio / Juliano</option>
                                <option value="Luciano / Cristiano">Luciano / Cristiano</option>
                                <option value="Diego Pavanato / Caju">Diego Pavanato / Caju</option>
                                <option value="Schmdit / Vitor M F">Schmdit / Vitor M F</option>
                                <option value="Vitor G / Guaxi">Vitor G / Guaxi</option>
                                <option value="Jacob / Alex Ruiz">Jacob / Alex Ruiz</option>
                                <option value="Marcel / Pedro Beltramini">Marcel / Pedro Beltramini</option>
                                <option value="Sergio Sorze / Dani Borsato">Sergio Sorze / Dani Borsato</option>
                                <option value="Matheus / Gui Ortolani">Matheus / Gui Ortolani</option>
                                <option value="Val / Plets">Val / Plets</option>
                                <option value="Vpau / Enaldo">Vpau / Enaldo</option>
                                <option value="Ande / Guilherme">Ande / Guilherme</option>
                                <option value="Harisson / Marcondes">Harisson / Marcondes</option>
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
