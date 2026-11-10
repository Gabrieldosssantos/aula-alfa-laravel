<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/scss/app.scss')
</head>
<body class="login-page bg-body-secondary">
@vite('resources/js/app.js')

<div class="login-box">
    <div class="login-logo">
        <b>Rede Patas</b>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Entre com seu email e senha</p>

            {{-- Mensagem de sucesso (ex.: cadastro realizado) --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Erros de validação / credenciais inválidas --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

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
                        autofocus
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
                        placeholder="Senha"
                        required
                    />
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                </div>

                <div class="row" style="display: flex; justify-content: center;">
                    <div class="col-6">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3 text-center">
                Ainda não tem uma conta?
                <a href="{{ route('register') }}">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
