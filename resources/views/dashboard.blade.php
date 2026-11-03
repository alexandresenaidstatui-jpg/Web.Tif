<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087b56">
    <title>Painel | Lixeira Inteligente</title>
    @vite(['resources/css/eco.css', 'resources/js/eco.js'])
</head>
<body class="dashboard-page">
    <header class="dashboard-header">
        <a class="brand" href="{{ route('dashboard') }}" aria-label="Lixeira Inteligente">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M9 10h14l-1.2 17H10.2L9 10Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                    <path d="M7 7h18M13 7V4h6v3m-6 7v9m6-9v9" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    <path d="M16 1.8v2M4.6 4.6 6 6m20-1.4L24.6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <span>Lixeira <strong>Inteligente</strong></span>
        </a>
        <nav class="top-nav dashboard-nav" aria-label="Navegação principal">
            <a class="active" href="{{ route('dashboard') }}">Início</a>
            <a href="{{ route('cadastro') }}">Cadastro</a>
            <a href="{{ route('login') }}">Login</a>
        </nav>
        <button class="profile-button" id="logout-button" type="button">
            <span class="avatar" aria-hidden="true">♙</span>
            <span id="profile-name">Olá!</span>
            <span class="profile-chevron" aria-hidden="true">⌄</span>
        </button>
    </header>

    <main class="dashboard-shell">
        <aside class="sidebar">
            <nav class="side-nav" aria-label="Menu do painel">
                <a class="selected" href="{{ route('dashboard') }}"><span aria-hidden="true">⌂</span> Início</a>
                <a href="#coletores"><span aria-hidden="true">♻</span> Abrir / Fechar</a>
                <a href="#resumo"><span aria-hidden="true">▤</span> Relatórios</a>
                <a href="#configuracoes"><span aria-hidden="true">⚙</span> Configurações</a>
            </nav>
            <div class="sidebar-message">
                <span aria-hidden="true">♻</span>
                <p>Tecnologia que cuida do nosso planeta.</p>
            </div>
        </aside>

        <section class="dashboard-content">
            <div class="dashboard-title">
                <div>
                    <p class="eyebrow">Painel de controle</p>
                    <h1><span class="title-leaf" aria-hidden="true">♻</span> Abrir e Fechar</h1>
                    <p>Gerencie o funcionamento das lixeiras inteligentes.</p>
                </div>
                <span class="live-status"><i></i> Sistema ativo</span>
            </div>

            <p class="dashboard-status" id="dashboard-status" role="status" aria-live="polite"></p>
            <div class="dashboard-columns">
                <section class="collector-area" id="coletores" aria-labelledby="collector-heading">
                    <div class="section-heading">
                        <div>
                            <h2 id="collector-heading">Coletores</h2>
                            <p>Toque para alterar o estado de cada lixeira.</p>
                        </div>
                        <span class="updated-label" id="updated-at"></span>
                    </div>
                    <div class="bin-grid" id="bin-grid" aria-live="polite">
                        <div class="loading-card">Carregando lixeiras...</div>
                    </div>
                </section>

                <aside class="dashboard-aside">
                    <section class="info-card" id="resumo">
                        <div class="info-heading"><span aria-hidden="true">◉</span><h2>Resumo do sistema</h2></div>
                        <div class="summary-list">
                            <div><i class="summary-dot dot-green"></i><span>Em operação</span><strong id="open-count">—</strong></div>
                            <div><i class="summary-dot dot-gray"></i><span>Fechadas</span><strong id="closed-count">—</strong></div>
                            <div><i class="summary-dot dot-blue"></i><span>Total de lixeiras</span><strong id="total-count">—</strong></div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="material-summary">
                            <span><i class="summary-dot dot-green"></i> Orgânico <strong id="count-organico">—</strong></span>
                            <span><i class="summary-dot dot-yellow"></i> Metal <strong id="count-metal">—</strong></span>
                            <span><i class="summary-dot dot-red"></i> Plástico <strong id="count-plastico">—</strong></span>
                            <span><i class="summary-dot dot-blue"></i> Papel <strong id="count-papel">—</strong></span>
                        </div>
                    </section>
                    <section class="info-card activity-card">
                        <div class="info-heading"><span aria-hidden="true">◷</span><h2>Últimas ações</h2></div>
                        <ul class="activity-list" id="activity-list">
                            <li class="empty-activity">Nenhuma ação registrada.</li>
                        </ul>
                    </section>
                    <p class="dashboard-aside-note" id="configuracoes">Separar corretamente é cuidar do futuro.</p>
                </aside>
            </div>
        </section>
    </main>
    <footer class="dashboard-footer"><span>© {{ date('Y') }} Lixeira Inteligente</span><span class="footer-colors" aria-hidden="true"><i></i><i></i><i></i><i></i></span></footer>
</body>
</html>
