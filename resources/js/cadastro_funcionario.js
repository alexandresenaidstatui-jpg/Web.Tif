import Swal from 'sweetalert2'

$(document).ready(function() {
    $('#cadastro_usuario').click(function(event) {
        event.preventDefault();

        const nome = $('#nome').val().trim();
        const email = $('#email').val().trim();
        const senha = $('#senha').val();
        const confirmarSenha = $('#confirmar_senha').val();
        const registro = $('#cpf').val().trim();
        const materias = $('#materias').val().trim();
        const dataNascimento = $('#data_nascimento').val().trim();

        if (!nome || !email || !senha || !confirmarSenha || !registro || !dataNascimento) {
            Swal.fire('Atenção', 'Preencha todos os campos obrigatórios.', 'warning');
            return;
        }

        if (senha !== confirmarSenha) {
            Swal.fire('Atenção', 'As senhas não conferem.', 'warning');
            return;
        }

        if (senha.length < 8) {
            Swal.fire('Atenção', 'A senha deve ter no mínimo 8 caracteres.', 'warning');
            return;
        }

        $('#cadastro_usuario').prop('disabled', true);
        $('#cadastro_status').removeClass('d-none alert-danger').addClass('alert-info').text('Salvando funcionário...');

        $.ajax({
            url: '/api/cadastro-funcionario',
            type: 'POST',
            data: {
                nome,
                email,
                senha,
                cpf: registro,
                materias,
                data_nascimento: dataNascimento,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.erro === 'n') {
                    $('#cadastro_status').removeClass('alert-info').addClass('alert-success').text('Funcionário salvo com sucesso!');
                    Swal.fire('Sucesso', response.mensagem, 'success').then(() => {
                        window.location.href = '/login-funcionario';
                    });
                    return;
                }

                showError(response.mensagem || 'Não foi possível salvar o funcionário.');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                const mensagem = xhr.responseJSON?.message || Object.values(errors).flat().join(' ') || 'Não foi possível salvar o funcionário.';
                showError(mensagem);
            },
            complete: function() {
                $('#cadastro_usuario').prop('disabled', false);
            },
        });
    });

    function showError(mensagem) {
        $('#cadastro_status').removeClass('alert-info').addClass('alert-danger').text(mensagem);
        Swal.fire('Erro', mensagem, 'error');
    }
});
