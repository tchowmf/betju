@extends('TemplateUser.index')
@section('title', 'Conta - Kart Timer')

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
                        <h3>{{ $userInfo->firstname }} {{ $userInfo->lastname }}</h3>

                        <!-- Divider -->
                        <hr class="sidebar-divider">

                        <a class="nav-link" href="/profile" style="color: black; text-decoration: none;">
                            Conta
                        </a>

                        <a class="nav-link" href="/profile/support" style="color: black; text-decoration: none;">
                            Suporte
                        </a>

                        <a class="nav-link" href="/profile/update-password" style="color: black; text-decoration: none;">
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
                <h2 class="m-3 pt-3">Logado como: {{ $userInfo->firstname}}</h2>
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
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Nome completo:</h5>
                        </div>
                        <span id="fullName">
                            <!-- Exibição do nome completo -->
                            <br><span>{{ $userInfo->firstname }} {{ $userInfo->lastname }} <a href="#" onclick="toggleForm('nameForm')" id="editIconName"><img src="{{ asset('img/edit.gif') }}" alt="Edit Value"></a></span>
                        </span>

                        <!-- Formulário de edição para nome -->
                        <form action="{{ route('update-name', ['user' => $userInfo->id]) }}" method="post" style="display: none;" id="nameForm">
                            @CSRF
                            <input type="text" class="form-control" value="{{ $userInfo->firstname }}" name="firstname">
                            <input type="text" class="form-control" value="{{ $userInfo->lastname }}" name="lastname">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>E-mail:</h5>
                        </div>
                        <span id="userEmail">
                            <!-- Exibição do e-mail -->
                            <br>{{ $userInfo->email }} <a href="#" onclick="toggleForm('emailForm')" id="editIconEmail"><img src="{{ asset('img/edit.gif') }}" alt="Edit Value"></a></span>
                        </span>

                        <!-- Formulário de edição para e-mail -->
                        <form action="{{ route('update-email', ['user' => $userInfo->id]) }}" method="post" style="display: none;" id="emailForm">
                            @CSRF
                            <input type="email" class="form-control" value="{{ $userInfo->email }}" name="email">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>E-mail confirmado:</h5>
                        </div>
                        <span>
                            <br>@if (auth()->user()->email_verified_at != null)
                                    Confirmado ✅
                                @else
                                    <form action="{{ route('sendVerificationEmail', ['user' => auth()->user()->id]) }}" method="post">
                                        @CSRF
                                        <button type="submit" class="btn btn-light">Enviar Email de Confirmação</button>
                                    </form>
                                @endif
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Data de nascimento:</h5>
                        </div>
                        <span id="dateOfBirth">
                            @php
                                $formattedBirthDate = (auth()->user()->birth_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', auth()->user()->birth_date)->format('d/m/Y') : '--/--/----';
                            @endphp

                            <!-- Exibição da data de nascimento -->
                            <br><span>{{ $formattedBirthDate }} <a href="#" onclick="toggleFormdate()" id="editIcon"><img src="{{ asset('img/edit.gif') }}" alt="Edit Value"></a></span>
                        </span>

                        <!-- Formulário de edição (inicialmente oculto) -->
                        <form action="{{ route('update-birth-date', ['user' => auth()->user()->id]) }}" method="post" style="display: none;" id="birth_date">
                            @CSRF
                            <br><input type="date" class="form-control" value="{{ auth()->user()->birth_date }}" name="birth_date">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-3 content">
                <h2 class="m-3 pt-3">Estatísticas</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Participou de corridas:</h5>
                        </div>
                        <span>
                            <br>5
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Última atividade:</h5>
                        </div>
                        <span>
                            <br>{{$userInfo->updated_at->format('d/m/Y H:i:s')}}
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <br><h5>Criou a conta em:</h5>
                        </div>
                        <span>
                            <br>{{$userInfo->created_at->format('d/m/Y H:i:s')}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('scripts')
<script>
    function toggleFormdate() {
        var form = document.getElementById('birth_date');
        var dateOfBirth = document.getElementById('dateOfBirth');
        var editIcon = document.getElementById('editIcon');

        if (form.style.display === 'none') {
            form.style.display = 'inline-block';
            dateOfBirth.style.display = 'none';
        } else {
            form.style.display = 'none';
            dateOfBirth.style.display = 'inline';
        }
    }
</script>

<script>
    function toggleForm(formId) {
    var form = document.getElementById(formId);
    var fullName = document.getElementById('fullName');
    var userEmail = document.getElementById('userEmail');

    if (form.style.display === 'none') {
        form.style.display = 'inline-block';

        if (formId === 'nameForm') {
            fullName.style.display = 'none';
        } else if (formId === 'emailForm') {
            userEmail.style.display = 'none';
        }
    } else {
        form.style.display = 'none';

        if (formId === 'nameForm') {
            fullName.style.display = 'inline';
        } else if (formId === 'emailForm') {
            userEmail.style.display = 'inline';
        }
    }
}
</script>
@endsection

