@extends('templates.blank')
@section('title', "Bet Juuu - Transação")

@section('contents')

@if(session('success'))
  <div class="alert alert-success sm-2">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger sm-2">{{ session('error') }}</div>
@endif

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1>Transação</h1>
                    <h4>para {{ $users->username }}</h4>
                    <h7>saldo: R${{ $users->credits }}</h7>

                    <form action="{{ route('transaction', $users->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <br><label for="transaction_type">Selecione o tipo</label>
                            <select name="transaction_type" id="transaction_type" class="form-control" required>
                                <option value="deposit">Deposito</option>
                                <option value="withdraw">Retirada</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transaction_value">Valor</label>
                            <input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="transaction_value" 
                            id="transaction_value" class="form-control" required>
                        </div>

                        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-success">Realizar Transferência</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection