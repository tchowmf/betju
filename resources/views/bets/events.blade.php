@extends('templates.blank')
@section('title', "Bet Juuuuu - Aposta")

@section('contents')

@if(!empty($success))
  <div class="alert alert-danger sm-2"> {{ $success }}</div>
@endif

@if(!empty($error))
  <div class="alert alert-danger sm-2"> {{ $error }}</div>
@endif

<div class="container">
    <h1>Eventos de Aposta</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Criar Nova Aposta</a>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Jogador 1</th>
                <th>Jogador 2</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->player1 }}</td>
                <td>{{ $event->player2 }}</td>
                <td>{{ $event->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-success">
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
@endsection