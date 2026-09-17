<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar mudança | {{ config('app.name', 'TIF2') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/js/mudanca.js'])
    <style>
        :root { --purple: #8c4dff; --purple-dark: #7540e8; --ink: #17121f; --paper: #fffdf9; --soft: #f3edff; --coral: #ff9478; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: radial-gradient(circle at 85% 18%, #2a1948 0, transparent 32%), #09070d; font-family: 'Quicksand', sans-serif; }
        body::before { display: block; height: 10px; background: var(--purple); content: ''; }
        .screen { display: grid; place-items: center; min-height: calc(100vh - 10px); padding: 32px 18px; }
        .change-card { width: min(100%, 420px); padding: 30px 36px 32px; border: 1px solid rgba(140, 77, 255, .18); border-radius: 18px; background: var(--paper); box-shadow: 16px 16px 0 rgba(140, 77, 255, .2), 0 24px 55px rgba(0, 0, 0, .28); }
        .home-link { display: grid; place-items: center; width: 32px; height: 32px; margin: 0 0 16px; color: var(--purple); text-decoration: none; }
        .home-link svg { width: 24px; height: 24px; }
        h1 { margin: 0 0 34px; color: var(--purple); font-size: 25px; font-weight: 700; }
        .field { display: block; margin-bottom: 17px; }
        .field-label { display: block; margin: 0 0 9px 1px; font-size: 12px; font-weight: 700; }
        .material-select, .reason-input { width: 100%; border: 1px solid #e4d9fa; border-radius: 10px; outline: 0; background: var(--soft); color: var(--ink); font: inherit; font-size: 13px; font-weight: 600; }
        .material-select { height: 44px; padding: 0 12px; cursor: pointer; }
        .material-select option { color: var(--ink); background: #fff; }
        .reason-input { min-height: 126px; padding: 12px; resize: vertical; }
        .location-input { min-height: 44px; height: 44px; resize: none; }
        .reason-input::placeholder { color: #8b7da4; }
        .material-select:focus, .reason-input:focus, .next-button:focus-visible { box-shadow: 0 0 0 3px rgba(140, 77, 255, .3); }
        .next-button { display: flex; align-items: center; justify-content: center; width: 100%; height: 46px; margin: 24px auto 0; padding: 0; border: 0; border-radius: 10px; color: #fff; background: var(--purple); cursor: pointer; }
        .next-button:hover { background: var(--purple-dark); }
        .next-button:disabled { cursor: wait; opacity: .65; }
        .next-button svg { width: 14px; height: 14px; margin-left: 6px; fill: currentColor; }
        .status { min-height: 17px; margin: 12px 0 -8px; color: var(--purple-dark); font-size: 11px; font-weight: 700; text-align: center; }
        @media (max-width: 480px) { .screen { padding: 24px 14px; } .change-card { padding: 26px 22px 28px; } }
    </style>
</head>
<body>
    <main class="screen">
        <form class="change-card" id="mudanca-form">
            <a class="home-link" href="{{ route('welcome') }}" aria-label="Voltar para o início">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z"/>
                    <path d="M15 6h3V3h-3v3Z"/>
                </svg>
            </a>
            <h1>Quem é você</h1>

            <label class="field" for="origem">
                <span class="field-label">onde veio</span>
                <input class="reason-input location-input" id="origem" name="origem" maxlength="255" required placeholder="Informe de onde veio">
            </label>

            <label class="field" for="destino">
                <span class="field-label">pra onde vai</span>
                <input class="reason-input location-input" id="destino" name="destino" maxlength="255" required placeholder="Informe para onde vai">
            </label>

            <label class="field" for="material">
                <span class="field-label">escolha um bem material</span>
                <select class="material-select" id="material" name="material" required>
                    <option value="" selected disabled>Selecione</option>
                    <option value="Notebook">Notebook</option>
                    <option value="Celular">Celular</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Outro">Outro</option>
                </select>
            </label>

            <label class="field" for="justificativa">
                <span class="field-label">justifique o porque da mudança</span>
                <textarea class="reason-input" id="justificativa" name="justificativa" maxlength="2000" required placeholder="Escreva sua justificativa"></textarea>
            </label>

            <button class="next-button" id="mudanca-submit" type="submit" aria-label="Salvar mensagem">
                <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M10.7 5.1 2.2.3A.8.8 0 0 0 1 1v10a.8.8 0 0 0 1.2.7l8.5-4.8a1 1 0 0 0 0-1.8Z"/></svg>
            </button>
            <p class="status" id="mudanca-status" role="status" aria-live="polite"></p>
        </form>
    </main>
</body>
</html>
