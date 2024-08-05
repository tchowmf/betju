@extends('templates.blank')
@section('title', "Bet Juuu - Administração")

@section('contents')

<div class="container">
    
    @if(session('success'))
    <div class="alert alert-success sm-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger sm-2">{{ session('error') }}</div>
    @endif

    <h1>Administração</h1>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="{{ route('dashboard', ['view' => 'events']) }}">Gerenciar Eventos</a>
        <a class="navbar-brand" href="{{ route('dashboard', ['view' => 'users']) }}">Gerenciar Contas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Criar Novo
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('events.create') }}">Nova Aposta</a>
                        <a class="dropdown-item" href="1">Nova Conta</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    @if(request()->get('view') == 'events')
        <h2>Eventos de Aposta</h2>
        <table id="eventsTable" class="table table-responsive-lg">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Jogador 1</th>
                    <th>Jogador 2</th>
                    <th>Status</th>
                    <th>Vencedor</th>
                    <th>Criado em</th>
                    <th>Válida até</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->player1 }}</td>
                    <td>{{ $event->player2 }}</td>
                    <td>{{ $event->status }}</td>
                    <td>{{ $event->winner }}</td>
                    <td>{{ $event->created_at ? $event->created_at->format('d/m/Y H:i') : 'Data não informada' }}</td>
                    <td>{{ $event->time_limit ? \Carbon\Carbon::parse($event->time_limit)->format('d/m/Y H:i') : 'Data não informada' }}</td>
                    <td style="display: flex;">
                        <a href="{{ route('events.resolve', $event->id) }}" class="btn btn-success btn-circle">
                            <i class="fa fa-check"></i>
                        </a>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-info btn-circle">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-circle" onclick="return confirm('Tem certeza que deseja excluir este evento?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(request()->get('view') == 'users')
        <h2>Usuários</h2>
        <table id="usersTable" class="table table-responsive-lg">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Role</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Data não informada' }}</td>
                    <td style="display: flex;">
                        <a href="{{ route('transaction.index', $user->id) }}" class="btn btn-success btn-circle">
                            <i class="fa fa-dollar-sign"></i>
                        </a>
                        <a href="{{ route('manager.edit', $user->id) }}" class="btn btn-info btn-circle">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('manager.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-circle" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    new DataTable('#eventsTable', {
        "pageLength": 15,
        "order": []
    });

    new DataTable('#usersTable', {
        "pageLength": 15,
        "order": []
    });
</script>

@endsection
