@extends('templates.blank')
@section('title', 'Bet Juuu - Conta')

@section('contents')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-800">CONTA</h1>
</div>

<body>
    <div class="row">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ asset('img/undraw_profile.svg') }}" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h3>{{ $user->username }}</h3>

                        <!-- Divider -->
                        <hr class="sidebar-divider">

                        <a class="nav-link" href="{{ route('profile.index') }}" style="color: black; text-decoration: none;">
                            Conta
                        </a>

                        <a class="nav-link" href="{{ route('profile.edit') }}" style="color: black; text-decoration: none;">
                            Alterar senha
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="nav-link" href="" data-toggle="modal" data-target="#logoutModal" style="color: black; text-decoration: none;">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-1">
            <div class="card mb-3 content">
                <h2 class="m-3 pt-3">Logado como: {{ $user->username }}</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body border-left-info d-flex align-items-center">
                                    <img src="/img/games.svg" alt="">
                                    <div class="text-left">
                                        <div>
                                            JOGOS
                                        </div>
                                        <span><strong>{{ $user->bets->count() }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body border-left-info d-flex align-items-center">
                                    <img src="/img/wins.svg" alt="">
                                    <div class="text-left">
                                        <div>
                                            ACERTOS
                                        </div>
                                        <span>{{ $wonBetsCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body d-flex align-items-center {{ $netEarnings >= 0 ? 'border-left-success' : 'border-left-danger' }}">
                                    <img src="/img/profit.svg" alt="">
                                    <div class="text-left">
                                        <div>
                                            {{ $netEarnings >= 0 ? 'LUCRO' : 'PERDA' }}
                                        </div>
                                        <span>R${{ number_format($netEarnings, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card mb-3 content">
                <h2 class="m-3 pt-3">Estatísticas</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Participou de:</h5>
                        </div>
                        <span>
                            <br>{{ $user->bets->count() }} Apostas
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Última atividade:</h5>
                        </div>
                        <span>
                            <br>{{ $user->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Criou a conta em:</h5>
                        </div>
                        <span>
                            <br>{{ $user->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

