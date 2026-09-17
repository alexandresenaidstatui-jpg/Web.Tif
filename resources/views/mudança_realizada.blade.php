<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudanças realizadas | {{ config('app.name', 'TIF2') }}</title>
    <style>
        :root { --purple: #8c4dff; --purple-dark: #7540e8; --ink: #17121f; --paper: #fffdf9; --soft: #f3edff; --muted: #6f647d; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: radial-gradient(circle at 85% 18%, #2a1948 0, transparent 32%), #09070d; font-family: 'Trebuchet MS', Arial, sans-serif; }
        body::before { display: block; height: 10px; background: var(--purple); content: ''; }
        .page { width: min(1120px, calc(100% - 36px)); margin: 0 auto; padding: 34px 0 48px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 30px; }
        .home-link { color: #fff; font-size: .9rem; text-decoration: none; }
        .home-link:hover { color: #d9c9ff; }
        h1 { margin: 0; color: var(--purple); font-size: clamp(1.8rem, 4vw, 2.8rem); }
        .subtitle { margin: 8px 0 0; color: #d6cdea; font-size: .95rem; }
        .status { margin: 0 0 18px; padding: 12px 16px; border-radius: 9px; color: #176b45; background: #e5f6ed; font-size: .9rem; font-weight: 700; }
        .table-card { overflow: hidden; border: 1px solid rgba(140, 77, 255, .18); border-radius: 18px; background: var(--paper); box-shadow: 16px 16px 0 rgba(140, 77, 255, .2), 0 24px 55px rgba(0, 0, 0, .28); }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 17px 20px; border-bottom: 1px solid #e9e0f5; text-align: left; vertical-align: top; }
        th { color: var(--purple-dark); background: var(--soft); font-size: .74rem; letter-spacing: .08em; text-transform: uppercase; }
        td { font-size: .9rem; line-height: 1.45; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #fcf9ff; }
        .empty { padding: 46px 24px; color: var(--muted); text-align: center; }
        .empty strong { display: block; margin-bottom: 8px; color: var(--ink); font-size: 1.05rem; }
        .new-button { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 0 16px; border-radius: 9px; color: #fff; background: var(--purple); font-size: .82rem; font-weight: 700; text-decoration: none; }
        .new-button:hover { background: var(--purple-dark); }
        .actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .edit-button, .delete-button { display: inline-flex; align-items: center; justify-content: center; min-height: 34px; padding: 0 11px; border: 0; border-radius: 7px; font: inherit; font-size: .78rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .edit-button { color: var(--purple-dark); background: #eadfff; }
        .edit-button:hover { background: #dccbff; }
        .delete-button { color: #a22b36; background: #ffe4e6; }
        .delete-button:hover { background: #ffcdd2; }
        @media (max-width: 600px) { .topbar { align-items: flex-start; flex-direction: column; } .new-button { width: 100%; } .page { padding-top: 24px; } }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div>
                <a class="home-link" href="{{ route('welcome') }}">Voltar para o início</a>
                <h1>Mudanças realizadas</h1>
                <p class="subtitle">Confira todas as solicitações registradas no sistema.</p>
            </div>
        </header>

        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif

        <section class="table-card" aria-labelledby="titulo-tabela">
            <h2 id="titulo-tabela" hidden>Lista de mudanças</h2>
            @if ($mudancas->isEmpty())
                <div class="empty">
                    <strong>Nenhuma mudança registrada</strong>
                    As solicitações salvas aparecerão aqui.
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Onde veio</th>
                                <th>Pra onde vai</th>
                                <th>Alterado por</th>
                                <th>Material</th>
                                <th>Justificativa</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mudancas as $mudanca)
                                <tr>
                                    <td>{{ $mudanca->origem }}</td>
                                    <td>{{ $mudanca->destino }}</td>
                                    <td>{{ $mudanca->responsavel_tipo === 'funcionario' ? 'Funcionário' : ($mudanca->responsavel_tipo === 'aluno' ? 'Aluno' : 'Não identificado') }}</td>
                                    <td>{{ $mudanca->material }}</td>
                                    <td>{{ $mudanca->justificativa }}</td>
                                    <td>{{ $mudanca->created_at?->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="edit-button" href="{{ route('mudancas.editar', $mudanca) }}">Editar</a>
                                            <form method="POST" action="{{ route('mudancas.excluir', $mudanca) }}" onsubmit="return confirm('Deseja excluir esta mudança?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete-button" type="submit">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>
</body>
</html>
