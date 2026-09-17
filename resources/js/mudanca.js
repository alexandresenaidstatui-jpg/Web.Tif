import './bootstrap';

const form = document.querySelector('#mudanca-form');
const submitButton = document.querySelector('#mudanca-submit');
const status = document.querySelector('#mudanca-status');
const tipoLogin = localStorage.getItem('tipo_login');
const token = tipoLogin === 'funcionario'
    ? localStorage.getItem('token_funcionario')
    : localStorage.getItem('token_usuario');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    submitButton.disabled = true;
    status.textContent = 'salvando...';

    try {
        const response = await fetch('/api/mudancas', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                ...(token ? { Authorization: `Bearer ${token}` } : {}),
            },
            body: JSON.stringify({
                origem: form.origem.value.trim(),
                destino: form.destino.value.trim(),
                material: form.material.value,
                justificativa: form.justificativa.value.trim(),
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Não foi possível salvar a mensagem.');
        }

        status.textContent = 'mudança salva!';
        window.location.href = '/mudancas-realizadas';
    } catch (error) {
        status.textContent = error.message;
    } finally {
        submitButton.disabled = false;
    }
});
