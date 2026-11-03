const authToken = () => localStorage.getItem('token_usuario');

async function apiRequest(url, options = {}) {
    const headers = {
        Accept: 'application/json',
        ...(options.body ? { 'Content-Type': 'application/json' } : {}),
        ...(authToken() ? { Authorization: `Bearer ${authToken()}` } : {}),
        ...options.headers,
    };

    const response = await fetch(url, { ...options, headers });
    const data = response.status === 204 ? null : await response.json();

    if (!response.ok) {
        const validationMessage = data?.errors
            ? Object.values(data.errors).flat()[0]
            : null;
        throw new Error(validationMessage || data?.mensagem || data?.message || 'Não foi possível concluir a operação.');
    }

    return data;
}

function showStatus(element, message, isSuccess = false) {
    if (!element) return;
    element.textContent = message;
    element.classList.toggle('success', isSuccess);
}

const signupForm = document.querySelector('#signup-form');

if (signupForm) {
    signupForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!signupForm.reportValidity()) return;

        const status = document.querySelector('#signup-status');
        const button = signupForm.querySelector('button[type="submit"]');
        const senha = signupForm.elements.senha.value;
        const senhaConfirmacao = signupForm.elements.senha_confirmation.value;

        if (senha !== senhaConfirmacao) {
            showStatus(status, 'As senhas não conferem.');
            signupForm.elements.senha_confirmation.focus();
            return;
        }

        button.disabled = true;
        showStatus(status, 'Criando sua conta...');

        try {
            await apiRequest('/api/cadastro_usuario', {
                method: 'POST',
                body: JSON.stringify({
                    nome: signupForm.elements.nome.value.trim(),
                    email: signupForm.elements.email.value.trim(),
                    senha,
                    senha_confirmation: senhaConfirmacao,
                    telefone: signupForm.elements.telefone.value.trim(),
                    tipo_usuario: signupForm.elements.tipo_usuario.value,
                }),
            });

            window.location.assign('/login?cadastro=ok');
        } catch (error) {
            showStatus(status, error.message);
            button.disabled = false;
        }
    });
}

const loginForm = document.querySelector('#login-form');

if (loginForm) {
    const query = new URLSearchParams(window.location.search);
    if (query.get('cadastro') === 'ok') {
        showStatus(document.querySelector('#login-status'), 'Conta criada! Entre com seu e-mail e senha.', true);
    }

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!loginForm.reportValidity()) return;

        const status = document.querySelector('#login-status');
        const button = loginForm.querySelector('button[type="submit"]');
        button.disabled = true;
        showStatus(status, 'Entrando...');

        try {
            const data = await apiRequest('/api/login', {
                method: 'POST',
                body: JSON.stringify({
                    email: loginForm.elements.email.value.trim(),
                    senha: loginForm.elements.senha.value,
                    lembrar: loginForm.elements.lembrar.checked,
                }),
            });

            localStorage.setItem('token_usuario', data.token);
            localStorage.setItem('nome_usuario', data.usuario.nome);
            localStorage.setItem('tipo_usuario', data.usuario.tipo_usuario);
            window.location.assign('/');
        } catch (error) {
            showStatus(status, error.message);
            button.disabled = false;
        }
    });
}

document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        const input = document.getElementById(toggle.dataset.passwordToggle);
        const showingPassword = input.type === 'password';
        input.type = showingPassword ? 'text' : 'password';
        toggle.setAttribute('aria-label', showingPassword ? 'Ocultar senha' : 'Mostrar senha');
    });
});

const binGrid = document.querySelector('#bin-grid');

if (binGrid) {
    if (!authToken()) {
        window.location.replace('/login');
    } else {
        const profileName = document.querySelector('#profile-name');
        profileName.textContent = `Olá, ${localStorage.getItem('nome_usuario') || 'usuário'}`;

        const setApiError = (error) => {
            if (error.message.includes('Autenticação') || error.message.includes('Token inválido')) {
                localStorage.removeItem('token_usuario');
                localStorage.removeItem('nome_usuario');
                localStorage.removeItem('tipo_usuario');
                window.location.replace('/login');
                return;
            }
            showStatus(document.querySelector('#dashboard-status'), error.message);
        };

        const renderBin = (bin) => {
            const card = document.createElement('article');
            card.className = 'bin-card';
            card.style.setProperty('--bin-color', bin.cor);

            const header = document.createElement('div');
            header.className = 'bin-card-header';
            const symbol = document.createElement('span');
            symbol.className = 'bin-symbol';
            symbol.textContent = '♻';
            const name = document.createElement('span');
            name.className = 'bin-name';
            name.textContent = bin.nome;
            header.append(symbol, name);

            const content = document.createElement('div');
            content.className = 'bin-card-body';
            const state = document.createElement('div');
            state.className = `bin-state${bin.aberta ? '' : ' is-closed'}`;
            const stateDot = document.createElement('i');
            stateDot.className = 'state-dot';
            const stateLabel = document.createElement('span');
            stateLabel.textContent = `Status: ${bin.aberta ? 'Aberta' : 'Fechada'}`;
            state.append(stateDot, stateLabel);

            const illustration = document.createElement('div');
            illustration.className = 'bin-illustration';
            illustration.innerHTML = '<svg viewBox="0 0 38 46" fill="none" aria-hidden="true"><path d="M10 12h18l-1.6 30H11.6L10 12Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M7 8h24M14 8V4h10v4m-9 10v17m8-17v17" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>';

            const actions = document.createElement('div');
            actions.className = 'bin-actions';
            const primary = document.createElement('button');
            primary.className = 'bin-action primary';
            primary.type = 'button';
            primary.textContent = bin.aberta ? 'Fechar' : 'Abrir';
            primary.addEventListener('click', () => updateBin(bin, !bin.aberta));

            const secondary = document.createElement('button');
            secondary.className = 'bin-action secondary';
            secondary.type = 'button';
            secondary.textContent = bin.aberta ? 'Abrir' : 'Fechar';
            secondary.addEventListener('click', () => updateBin(bin, bin.aberta));

            actions.append(primary, secondary);
            content.append(state, illustration, actions);
            card.append(header, content);
            return card;
        };

        const renderActivities = (activities) => {
            const list = document.querySelector('#activity-list');
            list.replaceChildren();

            if (!activities.length) {
                const empty = document.createElement('li');
                empty.className = 'empty-activity';
                empty.textContent = 'Nenhuma ação registrada.';
                list.append(empty);
                return;
            }

            activities.forEach((activity) => {
                const item = document.createElement('li');
                const time = document.createElement('span');
                time.className = 'activity-time';
                time.textContent = new Date(activity.atualizada_em).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

                const dot = document.createElement('i');
                dot.className = `activity-dot${activity.aberta ? '' : ' is-closed'}`;

                const description = document.createElement('span');
                description.className = 'activity-text';
                description.textContent = `${activity.nome} ${activity.aberta ? 'aberta' : 'fechada'} por ${activity.usuario}`;

                item.append(time, dot, description);
                list.append(item);
            });
        };

        const loadDashboard = async () => {
            const data = await apiRequest('/api/lixeiras');
            binGrid.replaceChildren(...data.lixeiras.map(renderBin));

            const abertas = data.lixeiras.filter((bin) => bin.aberta).length;
            document.querySelector('#open-count').textContent = abertas;
            document.querySelector('#closed-count').textContent = data.lixeiras.length - abertas;
            document.querySelector('#total-count').textContent = data.lixeiras.length;

            data.lixeiras.forEach((bin) => {
                const count = document.querySelector(`#count-${bin.tipo}`);
                if (count) count.textContent = bin.aberta ? 'Aberta' : 'Fechada';
            });

            renderActivities(data.acoes_recentes);
            document.querySelector('#updated-at').textContent = `Atualizado às ${new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}`;
        };

        async function updateBin(bin, aberta) {
            const status = document.querySelector('#dashboard-status');
            document.querySelectorAll('.bin-action').forEach((button) => { button.disabled = true; });
            showStatus(status, `Atualizando lixeira de ${bin.nome}...`);

            try {
                await apiRequest(`/api/lixeiras/${encodeURIComponent(bin.tipo)}`, {
                    method: 'PATCH',
                    body: JSON.stringify({ aberta }),
                });
                await loadDashboard();
                showStatus(status, `Lixeira de ${bin.nome} ${aberta ? 'aberta' : 'fechada'} com sucesso.`, true);
            } catch (error) {
                document.querySelectorAll('.bin-action').forEach((button) => { button.disabled = false; });
                setApiError(error);
            }
        }

        document.querySelector('#logout-button').addEventListener('click', async () => {
            const button = document.querySelector('#logout-button');
            button.disabled = true;

            try {
                await apiRequest('/api/logout', { method: 'POST' });
                localStorage.removeItem('token_usuario');
                localStorage.removeItem('nome_usuario');
                localStorage.removeItem('tipo_usuario');
                window.location.assign('/login');
            } catch (error) {
                button.disabled = false;
                setApiError(error);
            }
        });

        loadDashboard().catch(setApiError);
    }
}
