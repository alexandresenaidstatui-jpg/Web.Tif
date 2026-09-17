<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login de funcionário</title>
    <style>
        :root { --roxo: #8c4dff; --roxo-escuro: #7540e8; --preto: #09070d; --branco: #fffdf9; --texto: #17121f; --suave: #f3edff; --coral: #ff9478; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: 58px 18px 24px; color: var(--texto); background: radial-gradient(circle at 82% 18%, #2a1948 0, transparent 32%), var(--preto); font-family: 'Trebuchet MS', Arial, sans-serif; }
        body::before { position: fixed; top: 0; right: 0; left: 0; height: 10px; background: var(--roxo); content: ''; }
        .login-page { width: min(100%, 480px); margin: 0 auto; }
        .page-kicker { margin: 0 0 8px; color: var(--coral); font-size: .72rem; font-weight: 700; letter-spacing: .18em; text-align: center; text-transform: uppercase; }
        .page-title { margin: 0 0 10px; color: var(--roxo); font-size: clamp(1.8rem, 5vw, 2.5rem); font-weight: 700; text-align: center; }
        .page-intro { margin: 0 0 30px; color: #d6cdea; font-size: .95rem; text-align: center; }
        .login-card { padding: 34px; border: 1px solid rgba(140, 77, 255, .18); border-radius: 18px; background: var(--branco); box-shadow: 16px 16px 0 rgba(140, 77, 255, .2), 0 24px 55px rgba(0, 0, 0, .28); }
        .field { margin-bottom: 20px; }
        label { display: block; margin-bottom: 7px; color: var(--texto); font-size: .78rem; font-weight: 600; letter-spacing: .02em; }
        .form-control { width: 100%; min-height: 46px; padding: 10px 12px; border: 1px solid #e4d9fa; border-radius: 10px; outline: 0; background: var(--suave); color: var(--texto); font: inherit; }
        .form-control:focus { border-color: var(--roxo); background: var(--branco); box-shadow: 0 0 0 .2rem rgba(140, 77, 255, .2); }
        .btn-primary { width: 100%; min-height: 46px; border: 0; border-radius: 10px; color: var(--branco); background: var(--roxo); font: inherit; font-weight: 700; cursor: pointer; }
        .btn-primary:hover, .btn-primary:focus { background: var(--roxo-escuro); }
        .btn-primary:disabled { cursor: wait; opacity: .7; }
        .status { min-height: 22px; margin: 15px 0 0; font-size: .9rem; text-align: center; }
        .status.error { color: #b42318; }
        .status.success { color: #18794e; }
        .back-link { display: block; margin-top: 22px; color: var(--roxo); font-size: .9rem; text-align: center; text-decoration: none; }
        .back-link:hover { color: var(--roxo-escuro); }
        @media (max-width: 576px) { body { padding-top: 42px; } .login-card { padding: 24px 18px; } }
    </style>
</head>
<body>
    <main class="login-page">
        <p class="page-kicker">Área exclusiva</p>
        <h1 class="page-title">Login de funcionário</h1>
        <p class="page-intro">Entre com seus dados profissionais para continuar.</p>

        <form class="login-card" id="login-funcionario-form">
            <div class="field">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" autocomplete="email" required>
            </div>
            <div class="field">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" id="senha" name="senha" autocomplete="current-password" required>
            </div>
            <div class="field">
                <label for="materia">Matéria</label>
                <input class="form-control" type="text" id="materia" name="materia" list="materias-escolares" placeholder="Selecione ou digite sua matéria" autocomplete="off" required>
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
                    <option value="Tecnologia"></option>
                </datalist>
            </div>
            <button class="btn-primary" id="entrar-funcionario" type="submit">Entrar</button>
            <p class="status" id="login-status" role="status" aria-live="polite"></p>
        </form>

        <a class="back-link" href="{{ route('welcome') }}">Voltar para boas-vindas</a>
    </main>

    <script>
        document.querySelector('#login-funcionario-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const button = document.querySelector('#entrar-funcionario');
            const status = document.querySelector('#login-status');
            const email = document.querySelector('#email').value.trim();
            const senha = document.querySelector('#senha').value;
            const materia = document.querySelector('#materia').value.trim();

            button.disabled = true;
            status.className = 'status';
            status.textContent = 'Entrando...';

            try {
                const response = await fetch('/api/login-funcionario', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, senha, materia }),
                });
                const data = await response.json();

                if (!response.ok || data.erro !== 'n') {
                    throw new Error(data.mensagem || 'Não foi possível realizar o login.');
                }

                localStorage.removeItem('token_usuario');
                localStorage.setItem('tipo_login', 'funcionario');
                localStorage.setItem('token_funcionario', data.token);
                status.className = 'status success';
                status.textContent = 'Login realizado com sucesso.';
                window.location.href = @json(route('mudanca'));
            } catch (error) {
                status.className = 'status error';
                status.textContent = error.message;
                button.disabled = false;
            }
        });
    </script>
</body>
</html>
