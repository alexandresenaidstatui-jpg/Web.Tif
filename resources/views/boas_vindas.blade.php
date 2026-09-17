<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo | {{ config('app.name', 'TIF2') }}</title>
    <style>
        :root { --ink: #ffffff; --muted: #d8ccef; --paper: #000000; --cream: #ffffff; --roxo: #8c4dff; --roxo-escuro: #7540e8; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; color: var(--ink); background: var(--paper); font-family: Georgia, 'Times New Roman', serif; }
        body::before { position: fixed; top: 0; right: 0; left: 0; z-index: 2; height: 34px; background: var(--roxo); content: ''; }
        .page { min-height: 100vh; overflow: hidden; padding-top: 34px; background: var(--paper); }
        nav, main, footer { width: min(1120px, calc(100% - 48px)); margin: 0 auto; }
        nav { display: flex; align-items: center; justify-content: space-between; padding: 28px 0; font-family: Arial, sans-serif; }
        .brand { color: var(--roxo); font-size: 1.15rem; font-weight: 700; letter-spacing: .08em; text-decoration: none; text-transform: uppercase; }
        .nav-link { color: var(--ink); font-size: .9rem; text-decoration: none; }
        .nav-link span { color: var(--roxo); }
        main { display: grid; grid-template-columns: 1.05fr .95fr; align-items: center; gap: 7vw; min-height: calc(100vh - 145px); padding: 48px 0 86px; }
        .eyebrow { margin: 0 0 20px; color: var(--roxo); font: 700 .75rem/1 Arial, sans-serif; letter-spacing: .2em; text-transform: uppercase; }
        h1 { max-width: 640px; margin: 0; font-size: clamp(3.5rem, 8vw, 7.2rem); font-weight: 400; letter-spacing: -.05em; line-height: .9; }
        .intro { max-width: 470px; margin: 30px 0 34px; color: var(--muted); font: 1.1rem/1.65 Arial, sans-serif; }
        .actions { display: flex; flex-wrap: wrap; gap: 14px; }
        .button { display: inline-block; padding: 15px 23px; border: 1px solid var(--roxo); color: var(--cream); background: var(--roxo); font: 700 .9rem Arial, sans-serif; text-decoration: none; transition: transform .2s ease, background .2s ease; }
        .button:hover { transform: translateY(-3px); background: var(--roxo-escuro); }
        .button.secondary { color: var(--roxo); background: transparent; }
        .button.secondary:hover { color: var(--cream); }
        .feature { position: relative; min-height: 390px; padding: 42px; border: 0; border-radius: 9px; color: #17121f; background: var(--cream); box-shadow: 18px 18px 0 rgba(140, 77, 255, .35); }
        .feature:before { position: absolute; top: -22px; right: 28px; width: 70px; height: 70px; border-radius: 50%; background: var(--roxo); content: ''; }
        .feature-number { display: block; margin-bottom: 65px; color: var(--roxo); font: 700 3rem/1 Arial, sans-serif; }
        .feature h2 { max-width: 330px; margin: 0 0 18px; font-size: 2rem; font-weight: 400; }
        .feature p { max-width: 340px; margin: 0; color: #5d536b; font: 1rem/1.6 Arial, sans-serif; }
        footer { padding-bottom: 24px; color: var(--muted); font: .75rem Arial, sans-serif; }
        @media (max-width: 760px) {
            nav, main, footer { width: min(100% - 36px, 560px); }
            .page { padding-top: 28px; }
            body::before { height: 28px; }
            main { display: block; padding-top: 70px; }
            h1 { font-size: clamp(3.4rem, 18vw, 6rem); }
            .feature { min-height: 320px; margin-top: 74px; padding: 30px; }
            .feature-number { margin-bottom: 45px; }
        }
    </style>
</head>
<body>
    <div class="page">
        <nav aria-label="Navegação principal">
            <a class="brand" href="{{ route('welcome') }}">TIF2</a>
            <a class="nav-link" href="{{ route('cadastro.usuario') }}">Criar cadastro <span aria-hidden="true">&#8594;</span></a>
        </nav>
        <main>
            <section>
                <p class="eyebrow">Um novo começo</p>
                <h1>Seja muito bem-vindo.</h1>
                <p class="intro">Crie seu cadastro para fazer parte da nossa plataforma. É rápido, simples e seus dados ficam organizados em um só lugar.</p>
                <div class="actions">
                    <a class="button" href="{{ route('cadastro.usuario') }}">cadastro aluno <span aria-hidden="true">&#8594;</span></a>
                    <a class="button secondary" href="{{ route('cadastro.funcionario') }}">cadastro funcionario</a>
                </div>
            </section>
            <aside class="feature" id="sobre">
                <span class="feature-number">01</span>
                <h2>Seu primeiro passo começa aqui.</h2>
                <p>Preencha seus dados no cadastro e nós cuidamos de registrar tudo com segurança para você continuar.</p>
            </aside>
        </main>
        <footer>&copy; {{ date('Y') }} TIF2. Feito para começar bem.</footer>
    </div>
</body>
</html>
