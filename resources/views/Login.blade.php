<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --roxo: #8c4dff; --roxo-escuro: #7540e8; --preto: #09070d; --branco: #fffdf9; --texto: #17121f; --suave: #f3edff; --coral: #ff9478; }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 58px 18px 24px;
            color: var(--texto);
            background: radial-gradient(circle at 82% 18%, #2a1948 0, transparent 32%), var(--preto);
            font-family: 'Trebuchet MS', Arial, sans-serif;
        }

        body::before {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 10px;
            background: var(--roxo);
            content: '';
        }

        .login-card {
            width: min(100%, 480px);
            margin: 48px auto 0;
            padding: 42px;
            border: 1px solid rgba(140, 77, 255, .18);
            border-radius: 18px;
            background: var(--branco);
            box-shadow: 16px 16px 0 rgba(140, 77, 255, .2), 0 24px 55px rgba(0, 0, 0, .28);
        }

        .login-title {
            margin: 0 0 10px;
            color: var(--roxo);
            font-size: clamp(2rem, 5vw, 2.6rem);
            font-weight: 700;
        }

        .login-subtitle {
            margin: 0 0 32px;
            color: #5d536b;
            font-size: .95rem;
        }

        .form-label { font-weight: 600; }

        .form-control {
            min-height: 46px;
            border: 1px solid #e4d9fa;
            border-radius: 10px;
            background: var(--suave);
        }

        .form-control:focus {
            border-color: var(--roxo);
            background: var(--branco);
            box-shadow: 0 0 0 .2rem rgba(140, 77, 255, .2);
        }

        .form-text { color: #766b83; }

        .form-check-input:checked {
            border-color: var(--roxo);
            background-color: var(--roxo);
        }

        .btn-primary {
            border: 0;
            min-height: 46px;
            border-radius: 10px;
            background: var(--roxo);
            font-weight: 700;
        }

        .btn-primary:hover,
        .btn-primary:focus { background: var(--roxo-escuro); }

        .back-link {
            display: inline-block;
            margin-top: 22px;
            color: var(--roxo);
            font-size: .9rem;
            text-decoration: none;
        }

        .back-link:hover { color: var(--roxo-escuro); }

        @media (max-width: 576px) {
            body { padding-top: 28px; }
            body::before { height: 28px; }
            .login-card { margin-top: 34px; padding: 28px 22px; }
        }
    </style>
</head>

<body>

    <main class="login-card">
        <h1 class="login-title">Login</h1>
        <p class="login-subtitle">Entre para continuar no TIF.</p>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Bem Vindo ao TIF.</div>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="lembrar">
            <label class="form-check-label" for="lembrar">Lembrar</label>
        </div>
        <button type="button" id="entrar" class="btn btn-primary">Entrar</button>
        <p id="login-status" class="mt-3 mb-0" role="status" aria-live="polite"></p>
        <br>
        <a class="back-link" href="{{ route('welcome') }}">&#8592; Voltar para boas-vindas</a>

    </main>
  
            <script>
                const entrar = document.querySelector('#entrar');
                const status = document.querySelector('#login-status');

                entrar.addEventListener('click', async () => {
                    const email = document.querySelector('#email').value.trim();
                    const senha = document.querySelector('#senha').value;

                    if (!email || !senha) {
                        status.textContent = 'Informe seu email e sua senha.';
                        status.className = 'mt-3 mb-0 text-danger';
                        return;
                    }

                    entrar.disabled = true;
                    status.textContent = 'Entrando...';
                    status.className = 'mt-3 mb-0 text-secondary';

                    try {
                        const response = await fetch('/api/login', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ email, senha }),
                        });
                        const data = await response.json();

                        if (data.erro !== 'n') {
                            throw new Error(data.mensagem || 'Email ou senha inválidos.');
                        }

                        window.location.href = @json(route('mudanca'));
                    } catch (error) {
                        status.textContent = error.message;
                        status.className = 'mt-3 mb-0 text-danger';
                        entrar.disabled = false;
                    }
                });
            </script>
</body>

</html>
