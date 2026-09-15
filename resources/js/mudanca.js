import './bootstrap';

const form = document.querySelector('#mudanca-form');
const submitButton = document.querySelector('#mudanca-submit');
const status = document.querySelector('#mudanca-status');

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
            },
            body: JSON.stringify({
                material: form.material.value,
                justificativa: form.justificativa.value.trim(),
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Não foi possível salvar a mensagem.');
        }

        status.textContent = 'mensagem salva!';
        form.reset();
    } catch (error) {
        status.textContent = error.message;
    } finally {
        submitButton.disabled = false;
    }
});
