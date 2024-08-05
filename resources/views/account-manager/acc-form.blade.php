@extends('templates.blank')
@section('title', "Bet Juuu - Editar Conta")

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
                    <h1>Editar Conta</h1>
                    <form action="{{ route('manager.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="username">Username da conta:</label>
                            <input type="text" name="username" id="username" class="form-control" 
                            value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha da conta:</label>
                            <input type="text" name="password" id="password" class="form-control" 
                            value="">
                        </div>
                        <div class="form-group">
                            <label for="credits">JuuuCoins:</label>
                            <input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="credits" 
                            id="credits" class="form-control" value="{{ $user->credits }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Cargo:</label>
                            <select name="role_id" id="role_id" class="form-control">
                                <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Apostador</option>
                            </select>
                        </div>
                        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Conta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
