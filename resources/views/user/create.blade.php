<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro</title>
    @vite('resources/scss/app.scss')
</head>
<body class="register-page bg-body-secondary">
@vite('resources/js/app.js')

<div class="register-box">
    <div class="register-logo">
        <b>Rede Patas</b>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="register-box-msg">Preencha os campos para se cadastrar</p>

            {{-- Erros de validação --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                {{-- Nome — preservado após falha --}}
                <label class="visually-hidden" for="name">Nome</label>
                <div class="input-group mb-3">
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nome"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    />
                    <div class="input-group-text">
                        <span class="bi bi-person"></span>
                    </div>
                </div>

                {{-- E-mail — preservado após falha --}}
                <label class="visually-hidden" for="email">Email</label>
                <div class="input-group mb-3">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                    />
                    <div class="input-group-text">
                        <span class="bi bi-envelope"></span>
                    </div>
                </div>

                {{-- Senha — nunca repopulada --}}
                <label class="visually-hidden" for="password">Senha</label>
                <div class="input-group mb-3">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Senha (mín. 8 caracteres)"
                        required
                    />
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                </div>

                <div class="row" style="display: flex; justify-content: center;">
                    <div class="col-6">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3 text-center">
                Já tem uma conta?
                <a href="{{ route('login') }}">Entrar</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
