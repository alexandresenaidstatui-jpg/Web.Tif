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
        :root {
            --roxo: #8c4dff;
            --roxo-escuro: #7540e8;
            --preto: #000000;
            --branco: #ffffff;
            --texto: #17121f;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 34px 18px 24px;
            color: var(--texto);
            background: var(--preto);
            font-family: Arial, Helvetica, sans-serif;
        }

        body::before {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 34px;
            background: var(--roxo);
            content: '';
        }

        .login-card {
            width: min(100%, 520px);
            margin: 72px auto 0;
            padding: 34px;
            border-radius: 9px;
            background: var(--branco);
            box-shadow: 18px 18px 0 rgba(140, 77, 255, .35);
        }

        .login-title {
            margin: 0 0 8px;
            color: var(--roxo);
            font-size: 1.7rem;
            font-weight: 700;
        }

        .login-subtitle {
            margin: 0 0 28px;
            color: #5d536b;
            font-size: .95rem;
        }

        .form-label { font-weight: 600; }

        .form-control {
            border: 2px solid transparent;
            border-radius: 7px;
            background: #f5efff;
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
            border-radius: 7px;
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
            .login-card { margin-top: 54px; padding: 24px 20px; }
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
        <br>
        <a class="back-link" href="{{ route('welcome') }}">&#8592; Voltar para boas-vindas</a>

    </main>
  
        

</body>

</html>
