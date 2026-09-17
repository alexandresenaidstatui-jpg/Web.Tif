<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar mudança | {{ config('app.name', 'TIF2') }}</title>
    <style>
        :root { --purple: #8c4dff; --purple-dark: #7540e8; --ink: #17121f; --paper: #fffdf9; --soft: #f3edff; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: radial-gradient(circle at 85% 18%, #2a1948 0, transparent 32%), #09070d; font-family: 'Trebuchet MS', Arial, sans-serif; }
        body::before { display: block; height: 10px; background: var(--purple); content: ''; }
        .page { width: min(100% - 36px, 560px); margin: 0 auto; padding: 42px 0; }
        .back-link { color: #fff; font-size: .9rem; text-decoration: none; }
        h1 { margin: 24px 0 26px; color: var(--purple); font-size: clamp(1.8rem, 5vw, 2.6rem); }
        .edit-card { padding: 30px 34px; border: 1px solid rgba(140, 77, 255, .18); border-radius: 18px; background: var(--paper); box-shadow: 16px 16px 0 rgba(140, 77, 255, .2), 0 24px 55px rgba(0, 0, 0, .28); }
        .field { display: block; margin-bottom: 18px; }
        .field-label { display: block; margin-bottom: 7px; font-size: .8rem; font-weight: 700; }
        input, select, textarea { width: 100%; border: 1px solid #e4d9fa; border-radius: 10px; outline: 0; background: var(--soft); color: var(--ink); font: inherit; padding: 11px 12px; }
        input, select { min-height: 44px; }
        textarea { min-height: 130px; resize: vertical; }
        input:focus, select:focus, textarea:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(140, 77, 255, .2); }
        .save-button { width: 100%; min-height: 46px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); font: inherit; font-weight: 700; cursor: pointer; }
        .save-button:hover { background: var(--purple-dark); }
        .cancel-link { display: block; margin-top: 18px; color: var(--purple-dark); text-align: center; text-decoration: none; }
        @media (max-width: 480px) { .page { padding-top: 28px; } .edit-card { padding: 24px 20px; } }
    </style>
</head>
<body>
    <main class="page">
        <a class="back-link" href="{{ route('mudancas.realizadas') }}">Voltar para mudanças</a>
        <h1>Editar mudança</h1>
        <form class="edit-card" method="POST" action="{{ route('mudancas.atualizar', $mudanca) }}">
            @csrf
            @method('PUT')

            <label class="field">
                <span class="field-label">Onde veio</span>
                <input type="text" name="origem" value="{{ old('origem', $mudanca->origem) }}" maxlength="255" required>
            </label>

            <label class="field">
                <span class="field-label">Pra onde vai</span>
                <input type="text" name="destino" value="{{ old('destino', $mudanca->destino) }}" maxlength="255" required>
            </label>

            <label class="field">
                <span class="field-label">Material</span>
                <select name="material" required>
                    @foreach (['Notebook', 'Celular', 'Tablet', 'Outro'] as $material)
                        <option value="{{ $material }}" @selected(old('material', $mudanca->material) === $material)>{{ $material }}</option>
                    @endforeach
                </select>
            </label>

            <label class="field">
                <span class="field-label">Justificativa</span>
                <textarea name="justificativa" maxlength="2000" required>{{ old('justificativa', $mudanca->justificativa) }}</textarea>
            </label>

            <button class="save-button" type="submit">Salvar alterações</button>
            <a class="cancel-link" href="{{ route('mudancas.realizadas') }}">Cancelar</a>
        </form>
    </main>
</body>
</html>
