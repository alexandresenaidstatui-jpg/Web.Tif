<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/cadastro_usuario.js'])
    <style>
        :root { --roxo: #8c4dff; --roxo-escuro: #7540e8; --preto: #09070d; --branco: #fffdf9; --texto: #17121f; --suave: #f3edff; --coral: #ff9478; }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 58px 18px 32px;
            color: var(--texto);
            background: radial-gradient(circle at 15% 15%, #21133d 0, transparent 34%), var(--preto);
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

        .container { max-width: 860px; }

        .page-kicker { margin: 0 0 8px; color: var(--coral); font-size: .72rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }

        .page-intro { max-width: 560px; margin: 0 auto 30px; color: #d6cdea; font-size: .96rem; text-align: center; }

        h3 {
            margin-bottom: 10px !important;
            color: var(--roxo);
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 700;
        }

        .bg-light {
            padding: 34px !important;
            border: 1px solid rgba(140, 77, 255, .18);
            border-radius: 18px !important;
            background: var(--branco) !important;
            box-shadow: 16px 16px 0 rgba(140, 77, 255, .18), 0 24px 55px rgba(0, 0, 0, .28);
        }

        label {
            color: var(--texto);
            margin-bottom: 7px;
            font-size: .78rem;
            letter-spacing: .02em;
            font-weight: 600;
        }

        .form-control {
            min-height: 43px;
            border: 1px solid #e4d9fa;
            border-radius: 10px;
            background: var(--suave);
            color: var(--texto);
        }

        .form-control:focus {
            border-color: var(--roxo);
            background: var(--branco);
            box-shadow: 0 0 0 .2rem rgba(140, 77, 255, .2);
        }

        .btn-primary {
            min-width: 170px;
            min-height: 46px;
            border: 0;
            border-radius: 10px;
            background: var(--roxo);
            font-weight: 700;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--roxo-escuro);
        }

        #cadastro_status { border: 0; font-size: .9rem; }

        @media (max-width: 576px) {
            body { padding-top: 42px; }
            body::before { height: 10px; }
            .bg-light { padding: 23px 18px !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">Crie seu cadastro</h3>
        <p class="page-intro">Preencha seus dados para acessar o SITE e acompanhar suas solicitações.</p>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="bg-light p-4 rounded">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="nome">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="nome" name="nome" placeholder="Digite seu nome">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Digite seu email">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="cpf">CPF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="cpf" name="cpf" placeholder="Digite seu CPF">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="senha">Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="senha" name="senha" placeholder="Digite sua senha">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="confirmar_senha">Confirmar Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="data_nascimento">Data de Nascimento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="data_nascimento" name="data_nascimento" placeholder="Digite sua data de nascimento">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-3">
                            <button type="button" class="btn btn-primary btn-lg" id="cadastro_usuario">Cadastrar</button>
                            <div id="cadastro_status" class="alert d-none mt-3 mb-0" role="status" aria-live="polite"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>