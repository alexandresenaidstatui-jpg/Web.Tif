<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087b56">
    <title>Login | Lixeira Inteligente</title>
    @vite(['resources/css/eco.css', 'resources/js/eco.js'])
</head>
<body class="auth-page">
    <header class="topbar">
        <a class="brand" href="{{ route('login') }}" aria-label="Lixeira Inteligente">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M9 10h14l-1.2 17H10.2L9 10Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                    <path d="M7 7h18M13 7V4h6v3m-6 7v9m6-9v9" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    <path d="M16 1.8v2M4.6 4.6 6 6m20-1.4L24.6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <span>Lixeira <strong>Inteligente</strong></span>
        </a>
        <nav class="top-nav" aria-label="Navegação principal">
            <a href="{{ route('dashboard') }}">Início</a>
            <a href="{{ route('cadastro') }}">Cadastro</a>
            <a class="active" href="{{ route('login') }}">Login</a>
        </nav>
        <span class="eco-note"><span aria-hidden="true">✦</span> Juntos por um futuro mais limpo</span>
    </header>

    <main class="auth-layout login-layout">
        <section class="form-side">
            <div class="form-card login-card">
                <div class="card-heading">
                    <p class="eyebrow">Que bom ter você de volta</p>
                    <h1>Login</h1>
                    <p>Acesse sua conta para continuar.</p>
                </div>
                <form id="login-form" novalidate>
                    <label class="input-group" for="email">
                        <span>E-mail</span>
                        <span class="input-wrap"><span class="input-icon" aria-hidden="true">✉</span><input id="email" name="email" type="email" autocomplete="email" placeholder="seu@email.com" maxlength="255" required></span>
                    </label>
                    <label class="input-group" for="senha">
                        <span>Senha</span>
                        <span class="input-wrap"><span class="input-icon" aria-hidden="true">♙</span><input id="senha" name="senha" type="password" autocomplete="current-password" placeholder="Sua senha" minlength="8" required><button class="password-toggle" type="button" aria-label="Mostrar senha" data-password-toggle="senha">◉</button></span>
                    </label>
                    <div class="login-options">
                        <label class="remember-option"><input id="lembrar" name="lembrar" type="checkbox"><span>Lembrar de mim</span></label>
                        <span class="help-note">Esqueceu a senha? Fale com o suporte.</span>
                    </div>
                    <button class="button button-primary submit-button" type="submit"><span aria-hidden="true">↪</span> Entrar</button>
                    <p class="form-status" id="login-status" role="status" aria-live="polite"></p>
                </form>
                <p class="form-footer">Ainda não tem uma conta? <a href="{{ route('cadastro') }}">Cadastre-se</a></p>
            </div>
        </section>

        <section class="eco-panel login-panel">
            <div class="panel-copy">
                <p class="eyebrow">Lixeira Inteligente</p>
                <h2>Reciclar hoje, garantir um amanhã melhor.</h2>
                <p>Uma cidade mais limpa começa com escolhas conscientes.</p>
            </div>
            <div class="landscape-art" aria-hidden="true">
                <div class="landscape-sun"></div>
                <div class="hill hill-back"></div>
                <div class="hill hill-front"></div>
                <div class="tree tree-left"></div>
                <div class="tree tree-right"></div>
                <div class="wifi-mark"><i></i><i></i><i></i></div>
                <div class="landscape-bins">
                    <span class="mini-bin bin-green"><i>♻</i></span>
                    <span class="mini-bin bin-yellow"><i>♻</i></span>
                    <span class="mini-bin bin-red"><i>♻</i></span>
                    <span class="mini-bin bin-blue"><i>♻</i></span>
                </div>
            </div>
            <div class="login-panel-caption">Cada atitude conta para transformar o planeta.</div>
            <div class="color-wave" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
        </section>
    </main>
</body>
</html>
