@extends('templates.blank')
@section('title', "Bet Juuuuu - Apostas Abertas")

@section('contents')
<!-- Page Heading -->
<div class="d-flex justify-content-between mb-3">
    <h2 class="h3 mb-0 text-gray-800">APOSTAS ABERTAS</h2>
</div>

@if(!empty($success))
  <div class="alert alert-danger sm-2"> {{ $success }}</div>
@endif

@if(!empty($error))
  <div class="alert alert-danger sm-2"> {{ $error }}</div>
@endif

<div id="content" class="d-flex flex-wrap">
    @foreach ($events as $event)
    <div class="col-lg-2">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCard{{$event->id}}" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCard{{$event->id}}">
                <h6 class="m-0 font-weight-bold text-primary">{{$event->title}}</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCard{{$event->id}}" style="">
                <div class="card-body">
                    Vencedor do jogo<br><br>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto" style="width: 100px;">
                            <div class="mb-0 mr-3 font-weight-bold text-gray-800">{{$event->player1}}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">x</div>
                    <br>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto" style="width: 100px;">
                            <div class="mb-0 mr-3 font-weight-bold text-gray-800">{{$event->player2}}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <br><a href="#" class="btn btn-info btn-sm">
                        <span class="text">Ver Aposta</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



@endsection