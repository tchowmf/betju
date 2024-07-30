@extends('templates.blank')
@section('title', "Bet Juuu - Apostas Cadastradas")

@section('contents')

<div class="container">
    
    @if(session('success'))
    <div class="alert alert-success sm-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger sm-2">{{ session('error') }}</div>
    @endif

    <h1>Eventos de Aposta</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Criar Nova Aposta</a>
    <table id="dataTable" class="table table-responsive-lg">
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
                    <a href="{{ route('events.resolve', $event->id) }}" class="btn btn-success">
                        <i class="fa fa-check"></i>
                    </a>

                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-info">
                        <i class="fa fa-edit"></i>
                    </a>

                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este evento?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    new DataTable('#dataTable', {
        pageLength: 15
    });('#dataTable');
</script>

@endsection