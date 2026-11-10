{{--
    Partial: cabeçalho AdminLTE com menu do usuário e botão Sair.
    Incluído via @include('parts.header') nas views do painel.
--}}
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">

        {{-- Marca / logo --}}
        <a href="{{ route('admin.users.index') }}" class="navbar-brand">
            <span class="brand-text fw-light">Rede Patas</span>
        </a>

        {{-- Espaçador --}}
        <ul class="navbar-nav ms-auto">

            {{-- Menu do usuário autenticado --}}
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        {{-- Logout via POST com CSRF — nunca por GET --}}
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-1"></i> Sair
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth

        </ul>
    </div>
</nav>
