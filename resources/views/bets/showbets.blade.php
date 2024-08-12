@extends('templates.blank')
@section('title', "Bet Juuu - Apostas Abertas")

@section('contents')
<!-- Page Heading -->
<div class="d-flex justify-content-between mb-3">
    <h2 class="h3 mb-0 text-gray-800">APOSTAS ABERTAS</h2>
</div>

@if(session('success'))
  <div class="alert alert-success sm-2">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger sm-2">{{ session('error') }}</div>
@endif

<div id="content" class="d-flex flex-wrap">
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <a href="#collapseCardCampeao" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardCampeao">
                <h6 class="m-0 font-weight-bold text-primary">Campeonato de Duplas</h6>
            </a>
            <div class="collapse show" id="collapseCardCampeao">
                <div class="card-body">
                    <p>Faça sua aposta para o CAMPEÃO de duplas!</p>
                    <a href="{{ route('bet.campeao') }}" class="btn btn-info btn-sm">
                        <span class="text">Ver Aposta</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @foreach ($events as $event)
    @if($event->status == 'ativo')
    <div class="col-lg-3">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCard{{ $event->id }}" class="d-block card-header py-3" data-toggle="collapse" role="button" 
                aria-expanded="true" aria-controls="collapseCard{{ $event->id }}">
                <h6 class="m-0 font-weight-bold text-primary">{{ $event->title }}</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCard{{ $event->id }}">
                <div class="card-body">
                    <div class="text-center mb-3">Vencedor do jogo</div>
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col-auto" style="width: 100px;">
                            <div class="mb-0 mr-3 font-weight-bold text-gray-800">{{ $event->player1 }}</div>
                        </div>
                        <div class="col">
                            <div>{{ $event->player1Total }}</div>
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $event->player1Percentage }}%" 
                                    aria-valuenow="{{ $event->player1Percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">x</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto" style="width: 100px;">
                            <div class="mb-0 mr-3 font-weight-bold text-gray-800">{{ $event->player2 }}</div>
                        </div>
                        <div class="col">
                            <div>{{ $event->player2Total }}</div>
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $event->player2Percentage }}%" 
                                    aria-valuenow="{{ $event->player2Percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center my-3">Games</div>
                    @foreach (['0-4', '5-8', '9-12'] as $interval)
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col-auto" style="width: 100px;">
                            <div class="mb-0 font-weight-bold text-gray-800">Games {{ $interval }}</div>
                        </div>
                        <div class="col">
                            <div>{{ $event->gameBets[$interval] ?? 0 }}</div>
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $event->totalGameBets > 0 ? ($event->gameBets[$interval] / $event->totalGameBets) * 100 : 0 }}%" 
                                    aria-valuenow="{{ $event->totalGameBets > 0 ? ($event->gameBets[$interval] / $event->totalGameBets) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <p>Tempo restante: <span id="countdown{{ $event->id }}"></span></p>
                    <br>
                    <a href="{{ route('bet.inspect', $event->id) }}" class="btn btn-info btn-sm">
                        <span class="text">Ver Aposta</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

@endsection

@section('scripts')
<script>
    @foreach ($events as $event)
    @if($event->status == 'ativo')
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
    @endif
    @endforeach
</script>
@endsection
