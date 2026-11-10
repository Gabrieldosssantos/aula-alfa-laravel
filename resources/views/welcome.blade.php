<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Início — Rede Patas</title>
    @vite('resources/scss/app.scss')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
@vite('resources/js/app.js')

<div class="app-wrapper">

    @include('parts.header')

    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Início</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            Bem-vindo, {{ Auth::user()->name }}!
                        </h5>
                        <p class="card-text">
                            Você está autenticado no sistema.
                        </p>

                        @php $profile = Auth::user()->profile; @endphp

                        @if($profile && $profile->type === 'admin')
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                <i class="bi bi-people-fill me-1"></i> Acessar painel administrativo
                            </a>
                        @else
                            <p class="text-muted">
                                Sua conta é do tipo <strong>usuário comum</strong>.
                                Você não tem acesso à área administrativa.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
</body>
</html>
