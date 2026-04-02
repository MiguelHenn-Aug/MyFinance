<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container">

<a class="navbar-brand" href="#">
<i class="bi bi-currency-dollar"></i> MyFinance
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav me-auto">

<li class="nav-item">
    @if(session()->has('user_id'))
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-light' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Análise
        </a>
    @else
        <a class="nav-link disabled text-muted" href="#" style="pointer-events: none; filter: blur(0.5px);">
            <i class="bi bi-speedometer2"></i> Análise
        </a>
    @endif
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('contato') ? 'active text-white' : 'text-light' }}" href="{{ route('contato') }}">
        <i class="bi bi-envelope"></i> Contato
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('analise') ? 'active text-white' : 'text-light' }}" href="{{ route('analise') }}">
        <i class="bi bi-book"></i> Como Usar
    </a>
</li>

</ul>

<div class="d-flex align-items-center gap-2">
    @if(session()->has('user_id'))
        <span class="text-white me-2">{{ session('user_name') }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-light text-primary">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-light border-white text-white fw-semibold px-4">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </a>
    @endif
</div>

</div>
</div>
</nav>