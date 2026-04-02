@include('templates.header')
@include('templates.navbar')

<main class="container mt-5">
    @hasSection('no_outer_card')
        @yield('conteudo')
    @else
        <div class="card shadow">
            <div class="card-body">
                @yield('conteudo')
            </div>
        </div>
    @endif
</main>

@include('templates.footer')