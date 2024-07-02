@extends('templates.blank')
@section('title', "Bet Juuu - Depositar")

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
                    <h1>DEPOSITAR (PIX)</h1>
                    <div class="form-group">
                        <label for="title">E-mail para deposito:</label>
                        <input type="text" name="pix" id="pix" class="form-control" value="betjuuu@gmail.com" readonly>
                    </div>
                    <div class="form-group">
                        <label for="player1">Valor de Deposito:</label>
                        <input type="text" name="value" id="value" class="form-control" value="Valor do PIX realizado" readonly>
                    </div>
                    <span>Enviar comprovante para algum ADM</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection