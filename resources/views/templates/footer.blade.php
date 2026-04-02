<!-- FOOTER -->

<footer class="footer text-light mt-5">

<div class="container py-5">

<div class="row">

<div class="col-md-4">

<h5>
<i class="bi bi-currency-dollar"></i>
MyFinance
</h5>

<p class="text-secondary">

</p>

</div>

<div class="col-md-4">

<h5>
<i class="bi bi-link-45deg"></i>
Links
</h5>

<ul class="list-unstyled">

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('analise') ? 'active text-white' : 'text-light' }}" href="{{ route('analise') }}">
        <i class="bi bi-book"></i> Como Usar
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('contato') ? 'active text-white' : 'text-light' }}" href="{{ route('contato') }}">
        <i class="bi bi-envelope"></i> Contato
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('login') ? 'active text-white' : 'text-light' }}" href="{{ route('login') }}">
        <i class="bi bi-box-arrow-in-right me-1"></i> Conecte-se
    </a>
</li>
@if(session()->has('user_id'))
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-light' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Análise
        </a>
    @else
        <a class="nav-link disabled text-muted" href="#" style="pointer-events: none; filter: blur(0.5px);">
            <i class="bi bi-speedometer2"></i> Análise
        </a>
@endif

</ul>

</div>

<div class="col-md-4">

<h5>
<i class="bi bi-share"></i>
Redes
</h5>

<div class="social-icons">

<a href="#" class="text-secondary"><i class="bi bi-github"></i></a>
<a href="#" class="text-secondary"><i class="bi bi-linkedin"></i></a>
<a href="#" class="text-secondary"><i class="bi bi-instagram"></i></a>
<a href="#" class="text-secondary"><i class="bi bi-twitter-x"></i></a>

</div>

</div>

</div>

<hr class="border-secondary mt-4">

<div class="text-center text-secondary">

<i class="bi bi-c-circle"></i>
2026 - MyFinance | Todos os direitos reservados

</div>

</div>

</footer>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>