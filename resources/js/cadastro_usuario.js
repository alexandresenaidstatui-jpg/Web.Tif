import Swal from 'sweetalert2'

$(document).ready(function() {
    $("#cadastro_usuario").click(function(e) {
        e.preventDefault();
        
        // Validação básica no frontend
        const nome = $("#nome").val().trim();
        const email = $("#email").val().trim();
        const senha = $("#senha").val();
        const confirmarSenha = $("#confirmar_senha").val();
        const cpf = $("#cpf").val().trim();
        const dataNascimento = $("#data_nascimento").val().trim();

        if (!nome || !email || !senha || !cpf || !dataNascimento) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Por favor, preencha todos os campos!'
            });
            return;
        }

        if (senha !== confirmarSenha) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'As senhas não conferem!'
            });
            return;
        }

        if (senha.length < 8) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'A senha deve ter no mínimo 8 caracteres!'
            });
            return;
        }

        // Alerta de confirmação
        Swal.fire({
            title: 'Confirmar Cadastro',
            text: `Você tem certeza que deseja cadastrar com o email: ${email}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, cadastrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Desabilita o botão enquanto envia
                $("#cadastro_usuario").prop('disabled', true).text('Processando...');
                $("#cadastro_status")
                    .removeClass('d-none alert-success alert-danger')
                    .addClass('alert-info')
                    .text('Salvando seus dados...');

                $.ajax({
                    url: "/api/cadastro_usuario",
                    type: "POST",
                    data: {
                        nome: nome,
                        email: email,
                        senha: senha,
                        data_nascimento: dataNascimento,
                        cpf: cpf,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.data && response.data.erro === "n") {
                            $("#cadastro_status")
                                .removeClass('alert-info')
                                .addClass('alert-success')
                                .text('Dados salvos com sucesso!');

                            Swal.fire({
                                icon: 'success',
                                title: 'Parabéns!',
                                text: 'Cadastro realizado com sucesso!',
                                confirmButtonText: 'OK',
                                didClose: function() {
                                    // Limpa o formulário
                                    $("#nome").val('');
                                    $("#email").val('');
                                    $("#senha").val('');
                                    $("#confirmar_senha").val('');
                                    $("#cpf").val('');
                                    $("#data_nascimento").val('');
                                    // Redireciona para login
                                    setTimeout(function() {
                                        window.location.href = '/';
                                    }, 800);
                                }
                            });
                        } else {
                            $("#cadastro_status")
                                .removeClass('alert-info')
                                .addClass('alert-danger')
                                .text(response.mensagem || 'Não foi possível salvar os dados.');

                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.mensagem || 'Erro ao cadastrar usuário'
                            });
                        }
                    },
                    error: function(xhr) {
                        let mensagem = 'Erro ao conectar com o servidor';
                        if (xhr.responseJSON) {
                            mensagem = xhr.responseJSON.message || Object.values(xhr.responseJSON.errors || {}).flat().join(' ') || mensagem;
                        }
                        $("#cadastro_status")
                            .removeClass('alert-info')
                            .addClass('alert-danger')
                            .text(mensagem);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: mensagem
                        });
                    },
                    complete: function() {
                        // Reabilita o botão
                        $("#cadastro_usuario").prop('disabled', false).text('Cadastrar');
                    }
                });
            }
        });
    });
});
