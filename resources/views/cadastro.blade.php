<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087b56">
    <title>Cadastro | Lixeira Inteligente</title>
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
            <a class="active" href="{{ route('cadastro') }}">Cadastro</a>
            <a href="{{ route('login') }}">Login</a>
        </nav>
        <span class="eco-note"><span aria-hidden="true">✦</span> Juntos por um futuro mais limpo</span>
    </header>

    <main class="auth-layout signup-layout">
        <section class="eco-panel signup-panel">
            <a class="brand brand-panel" href="{{ route('login') }}">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M9 10h14l-1.2 17H10.2L9 10Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                        <path d="M7 7h18M13 7V4h6v3m-6 7v9m6-9v9" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span>Lixeira <strong>Inteligente</strong></span>
            </a>
            <div class="panel-copy">
                <p class="eyebrow">Pequenas atitudes, grande impacto</p>
                <h1>Tecnologia que cuida do nosso planeta.</h1>
                <p>Separe, recicle e acompanhe. Um futuro mais sustentável começa com você.</p>
            </div>
            <div class="recycling-art" aria-hidden="true">
                <div class="sun"></div>
                <div class="leaf leaf-one"></div>
                <div class="leaf leaf-two"></div>
                <div class="recycle-symbol">↻</div>
                <div class="mini-bins">
                    <span class="mini-bin bin-green"><i>♻</i></span>
                    <span class="mini-bin bin-yellow"><i>♻</i></span>
                    <span class="mini-bin bin-red"><i>♻</i></span>
                    <span class="mini-bin bin-blue"><i>♻</i></span>
                </div>
            </div>
            <div class="panel-values">
                <span><i class="value-icon green">♻</i> Sustentabilidade</span>
                <span><i class="value-icon yellow">✦</i> Cidade mais limpa</span>
                <span><i class="value-icon blue">◎</i> Futuro consciente</span>
            </div>
            <div class="color-wave" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
        </section>

        <section class="form-side">
            <div class="form-card signup-card">
                <div class="card-heading">
                    <p class="eyebrow">Faça parte da mudança</p>
                    <h2>Crie sua conta</h2>
                    <p>Preencha seus dados para acessar o sistema.</p>
                </div>
                <form id="signup-form" novalidate>
                    <label class="input-group" for="nome">
                        <span>Nome completo</span>
                        <span class="input-wrap"><span class="input-icon" aria-hidden="true">♙</span><input id="nome" name="nome" type="text" autocomplete="name" placeholder="Como podemos te chamar?" maxlength="255" required></span>
                    </label>
                    <label class="input-group" for="email">
                        <span>E-mail</span>
                        <span class="input-wrap"><span class="input-icon" aria-hidden="true">✉</span><input id="email" name="email" type="email" autocomplete="email" placeholder="seu@email.com" maxlength="255" required></span>
                    </label>
                    <div class="field-pair">
                        <label class="input-group" for="senha">
                            <span>Senha</span>
                            <span class="input-wrap"><span class="input-icon" aria-hidden="true">♙</span><input id="senha" name="senha" type="password" autocomplete="new-password" placeholder="Mínimo de 8 caracteres" minlength="8" required></span>
                        </label>
                        <label class="input-group" for="senha-confirmacao">
                            <span>Confirmar senha</span>
                            <span class="input-wrap"><span class="input-icon" aria-hidden="true">♙</span><input id="senha-confirmacao" name="senha_confirmation" type="password" autocomplete="new-password" placeholder="Digite novamente" minlength="8" required></span>
                        </label>
                    </div>
                    <div class="field-pair">
                        <label class="input-group" for="telefone">
                            <span>Telefone</span>
                            <span class="input-wrap"><span class="input-icon" aria-hidden="true">☎</span><input id="telefone" name="telefone" type="tel" autocomplete="tel" placeholder="(00) 00000-0000" maxlength="30" required></span>
                        </label>
                        <label class="input-group" for="tipo-usuario">
                            <span>Tipo de usuário</span>
                            <span class="input-wrap"><span class="input-icon" aria-hidden="true">♙</span>
                                <select id="tipo-usuario" name="tipo_usuario" required>
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="morador">Morador</option>
                                    <option value="operador">Operador</option>
                                </select>
                            </span>
                        </label>
                    </div>
                    <button class="button button-primary submit-button" type="submit">Criar conta <span aria-hidden="true">→</span></button>
                    <p class="form-status" id="signup-status" role="status" aria-live="polite"></p>
                </form>
                <p class="form-footer">Já tem uma conta? <a href="{{ route('login') }}">Faça login</a></p>
            </div>
        </section>
    </main>
</body>
</html>
