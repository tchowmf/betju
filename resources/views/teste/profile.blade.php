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

                        <a class="nav-link" href="#" style="color: black; text-decoration: none;">
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

    </div>
</body>
@endsection

