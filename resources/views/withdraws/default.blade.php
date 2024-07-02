@extends('templates.blank')
@section('title', "Bet Juuu - Sacar")

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
                    <h1>RETIRAR (PIX)</h1>
                    <div class="form-group">
                        <label for="player1">Valor de saque:</label>
                        <input type="text" name="value" id="value" class="form-control" value="Enviar solicitação para algum ADM" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection