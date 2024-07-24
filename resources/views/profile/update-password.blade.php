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
                    <img src="{{ asset('img/undraw_profile.svg') }}" class="rounded-circle" widht="150">
                    <div class="mt-3">
                        <h3>{{ $user->username }}</h3>

                        <!-- Divider -->
                        <hr class="sidebar-divider">

                        <a class="nav-link" href="{{ route('profile.index') }}" style="color: black; text-decoration: none;">
                            Conta
                        </a>

                        <a class="nav-link" href="{{ route('profile.userBets')}}" style="color: black; text-decoration: none;">
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

        <div class="col-md-8 mt-1">
            <div class="card mb-3 content">
                <h2 class="m-3 pt-3">Logado como: {{ $user->username }}</h2>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form">
                        @include('profile.partials.update-password-form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
