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

                        <a class="nav-link" href="{{ route('profile.userBets', ['status' => 'ativas']) }}" style="color: black; text-decoration: none;">
                            Apostas
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

        <div class="container">
    
            @if(session('success'))
            <div class="alert alert-success sm-2">{{ session('success') }}</div>
            @endif
        
            @if(session('error'))
            <div class="alert alert-danger sm-2">{{ session('error') }}</div>
            @endif
        
            <h1>Apostas</h1>
            <a href="{{ route('profile.userBets', ['status' => 'ativas']) }}" class="btn btn-primary mb-3">Apostas Ativas</a>
            <a href="{{ route('profile.userBets', ['status' => 'concluidas']) }}" class="btn btn-primary mb-3">Apostas Concluídas</a>
            
            <table class="table table-responsive-lg">
                <thead>
                    @if($status == 'ativas')
                        <tr>
                            <th>Jogador 1</th>
                            <th>Jogador 2</th>
                            <th>Válida até</th>
                            <th>Tipo de aposta</th>
                            <th>Meu palpite</th>
                            <th>Ações</th>
                        </tr>
                    @else
                        <tr>
                            <th>Tipo de Aposta</th>
                            <th>Meu Palpite</th>
                            <th>Vencedor</th>
                            <th>Games perdedor</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach ($bets as $bet)
                        <tr>
                            @if($status == 'ativas')
                            <td>{{ $bet->event->player1 }}</td>
                            <td>{{ $bet->event->player2 }}</td>
                            <td>{{ \Carbon\Carbon::parse($bet->event->time_limit)->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($bet->event->time_limit > now() && $bet->event->status == 'ativo')
                                <form action="{{ route('profile.updateBet', $bet->id) }}" method="POST" data-player1="{{ $bet->event->player1 }}" data-player2="{{ $bet->event->player2 }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="bet_type" id="bet_type_{{ $bet->id }}" class="form-control-plaintext" onchange="updateBetValueOptions({{ $bet->id }})">
                                        <option value="winner" {{ $bet->bet_type == 'winner' ? 'selected' : '' }}>Winner</option>
                                        <option value="games" {{ $bet->bet_type == 'games' ? 'selected' : '' }}>Games</option>
                                    </select>
                            </td>
                            <td>
                                <select name="bet_value" id="bet_value_{{ $bet->id }}" class="form-control-plaintext">
                                    @if ($bet->bet_type == 'winner')
                                        <option value="{{ $bet->event->player1 }}" {{ $bet->bet_value == $bet->event->player1 ? 'selected' : '' }}>{{ $bet->event->player1 }}</option>
                                        <option value="{{ $bet->event->player2 }}" {{ $bet->bet_value == $bet->event->player2 ? 'selected' : '' }}>{{ $bet->event->player2 }}</option>
                                    @else
                                        <option value="0-4" {{ $bet->bet_value == '0-4' ? 'selected' : '' }}>0-4</option>
                                        <option value="5-8" {{ $bet->bet_value == '5-8' ? 'selected' : '' }}>5-8</option>
                                        <option value="9-12" {{ $bet->bet_value == '9-12' ? 'selected' : '' }}>9-12</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-circle">
                                    <i class="fa fa-check"></i>
                                </button>
                                </form>
                                <form action="{{ route('profile.cancelBet', $bet->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-circle">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                    {{ $bet->bet_value }}
                                @endif
                            </td>
                            @else
                            <td>{{ $bet->bet_type }}</td>
                            <td>{{ $bet->bet_value }}</td>
                            <td>{{ $bet->event->winner }}</td>
                            <td>{{ $bet->event->loser_games }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function updateBetValueOptions(betId) {
            const betType = document.getElementById(`bet_type_${betId}`).value;
            const betValueSelect = document.getElementById(`bet_value_${betId}`);
            const form = betValueSelect.closest('form');
            const player1 = form.dataset.player1;
            const player2 = form.dataset.player2;
            
            let options = '';

            if (betType === 'winner') {
                options = `
                    <option value="${player1}">${player1}</option>
                    <option value="${player2}">${player2}</option>
                `;
            } else {
                options = `
                    <option value="0-4">0-4</option>
                    <option value="5-8">5-8</option>
                    <option value="9-12">9-12</option>
                `;
            }

            betValueSelect.innerHTML = options;
        }
    </script>
</body>
@endsection
