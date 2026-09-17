<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro de funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/cadastro_funcionario.js'])
    <style>
        :root { --roxo: #8c4dff; --roxo-escuro: #7540e8; --preto: #09070d; --branco: #fffdf9; --texto: #17121f; --suave: #f3edff; --coral: #ff9478; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: 58px 18px 32px; color: var(--texto); background: radial-gradient(circle at 15% 15%, #21133d 0, transparent 34%), var(--preto); font-family: 'Trebuchet MS', Arial, sans-serif; }
        body::before { position: fixed; top: 0; right: 0; left: 0; height: 10px; background: var(--roxo); content: ''; }
        .cadastro-page { max-width: 860px; margin: 0 auto; }
        .page-kicker { margin: 0 0 8px; color: var(--coral); font-size: .72rem; font-weight: 700; letter-spacing: .18em; text-align: center; text-transform: uppercase; }
        .page-intro { max-width: 560px; margin: 0 auto 30px; color: #d6cdea; font-size: .96rem; text-align: center; }
        .page-title { margin: 0 0 10px; color: var(--roxo); font-size: clamp(1.6rem, 4vw, 2.2rem); font-weight: 700; text-align: center; }
        .cadastro-card { max-width: 700px; margin: 0 auto; padding: 34px; border: 1px solid rgba(140, 77, 255, .18); border-radius: 18px; background: var(--branco); box-shadow: 16px 16px 0 rgba(140, 77, 255, .18), 0 24px 55px rgba(0, 0, 0, .28); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 24px; }
        .field { min-width: 0; margin-bottom: 18px; }
        .field.full { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 7px; color: var(--texto); font-size: .78rem; font-weight: 600; letter-spacing: .02em; }
        .form-control { min-height: 43px; border: 1px solid #e4d9fa; border-radius: 10px; background: var(--suave); color: var(--texto); }
        .form-control:focus { border-color: var(--roxo); background: var(--branco); box-shadow: 0 0 0 .2rem rgba(140, 77, 255, .2); }
        .action-area { margin-top: 8px; text-align: center; }
        .btn-primary { min-width: 170px; min-height: 46px; border: 0; border-radius: 10px; background: var(--roxo); font-weight: 700; }
        .btn-primary:hover, .btn-primary:focus { background: var(--roxo-escuro); }
        #cadastro_status { border: 0; font-size: .9rem; }
        @media (max-width: 576px) { body { padding-top: 42px; } .cadastro-card { padding: 23px 18px; } .form-grid { display: block; } }
    </style>
</head>
<body>
    <main class="cadastro-page">
        
        <h1 class="page-title" id="titulo-cadastro">Cadastro de funcionário</h1>
        <p class="page-intro">Informe seus dados profissionais para acessar a plataforma.</p>
        <section class="cadastro-card" aria-labelledby="titulo-cadastro">
            <div class="form-grid">
                <div class="field full">
                    <label for="nome">Nome do funcionário <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" autocomplete="name" required>
                </div>
                <div class="field">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="senha">Senha <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Mínimo de 8 caracteres" autocomplete="new-password" required>
                </div>
                <div class="field">
                    <label for="cpf">Registro de funcionário <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Informe seu registro" autocomplete="off" required>
                </div>
                <div class="field">
                    <label for="materias">Matéria principal</label>
                    <input type="text" class="form-control" id="materias" name="materias" list="materias-escolares" placeholder="Selecione ou digite uma matéria" autocomplete="off">
                    <datalist id="materias-escolares">
                        <option value="Língua Portuguesa"></option>
                        <option value="Matemática"></option>
                        <option value="História"></option>
                        <option value="Geografia"></option>
                        <option value="Ciências"></option>
                        <option value="Biologia"></option>
                        <option value="Física"></option>
                        <option value="Química"></option>
                        <option value="Inglês"></option>
                        <option value="Espanhol"></option>
                        <option value="Filosofia"></option>
                        <option value="Sociologia"></option>
                        <option value="Artes"></option>
                        <option value="Educação Física"></option>
                        <option value="Ensino Religioso"></option>
                        <option value="Tecnologia"></option>
                    </datalist>
                </div>
                <div class="field">
                    <label for="confirmar_senha">Confirmar senha <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Repita sua senha" autocomplete="new-password" required>
                </div>
                <div class="field">
                    <label for="data_nascimento">Data de nascimento <span class="text-danger">*</span></label>
                    <input type="date" class="form-control date-field" id="data_nascimento" name="data_nascimento" required>
                </div>
            </div>
            <div class="action-area">
                <button type="button" class="btn btn-primary" id="cadastro_usuario" aria-label="Cadastrar funcionário">Cadastrar</button>
                <div id="cadastro_status" class="alert d-none" role="status" aria-live="polite"></div>
            </div>
        </section>
    </main>
</body>
</html>