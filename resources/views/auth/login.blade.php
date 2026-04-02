@extends('templates.main_template')

@section('no_outer_card', true)

@section('conteudo')
<style>
    .auth-page {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-card {
        max-width: 540px;
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 30px 55px rgba(0, 0, 0, 0.12);
    }
    .auth-card .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        color: #fff;
        border: none;
    }
    .auth-card .form-control {
        border-radius: .75rem;
    }
    .auth-card .btn-primary {
        border-radius: .85rem;
        padding: .9rem 1.6rem;
    }
    .auth-card .btn-outline-secondary {
        border-radius: .85rem;
        padding: .9rem 1.6rem;
    }
</style>

<div class="auth-page">
    <div class="card auth-card">
        <div class="card-header text-center py-4">
            <h3 class="mb-1">Acesse sua conta</h3>
            <p class="mb-0 text-white-75">Digite seu email e senha para entrar no painel.</p>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="********" required>
                    </div>
                </div>
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-primary fw-bold">Entrar</button>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('register') }}" class="text-primary fw-semibold">Criar uma conta</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
