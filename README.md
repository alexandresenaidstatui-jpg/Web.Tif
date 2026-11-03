# Lixeira Inteligente

Aplicação web para acompanhar e controlar lixeiras inteligentes. Inclui cadastro e login de usuários, painel de status e API para atualizar as lixeiras.

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e npm
- Banco de dados compatível com Laravel, configurado no `.env` (por exemplo, MySQL)

## Instalação

Na raiz do projeto, instale as dependências:

```bash
composer install
npm install
```

Crie o arquivo de ambiente a partir do exemplo, caso ainda não exista:

```bash
cp .env.example .env
```

No Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Configure no `.env` a conexão do banco (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`). Em seguida, gere a chave da aplicação e execute as migrações:

```bash
php artisan key:generate
php artisan migrate
```

As migrações criam as colunas de telefone e tipo de usuário e inicializam quatro lixeiras: orgânico, metal, plástico e papel. Se já houver usuários cadastrados, os campos antigos de CPF e data de nascimento tornam-se opcionais.

## Executar

Compile os arquivos do frontend:

```bash
npm run build
```

Inicie o servidor local:

```bash
php artisan serve
```

A aplicação fica disponível normalmente em `http://127.0.0.1:8000`.

Para acessá-la de outro dispositivo na mesma rede, inicie o servidor aceitando conexões de rede:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Use o IPv4 do computador anfitrião no outro dispositivo, por exemplo `http://192.168.1.25:8000`. O firewall do sistema pode precisar permitir conexões na porta escolhida. `0.0.0.0` é o endereço de escuta do servidor, não o endereço a ser usado no navegador ou no Postman.

## Telas

- `/cadastro` — cria uma conta com nome, e-mail, senha, telefone e tipo de usuário.
- `/login` — autentica uma conta existente.
- `/` — painel autenticado para abrir e fechar lixeiras, conferir o resumo e ver as últimas alterações.

## API

As rotas abaixo usam o prefixo `/api`. No Postman, configure `Accept: application/json`. Para requisições com corpo JSON, configure também `Content-Type: application/json` e selecione **Body → raw → JSON**.

### Criar conta

`POST /api/cadastro_usuario`

```json
{
  "nome": "Maria da Silva",
  "email": "maria@example.com",
  "senha": "senha12345",
  "senha_confirmation": "senha12345",
  "telefone": "(11) 99999-1234",
  "tipo_usuario": "morador"
}
```

`tipo_usuario` aceita `morador` ou `operador`. O e-mail precisa ser único e a senha deve ter pelo menos oito caracteres; `senha_confirmation` deve corresponder a `senha`.

Resposta de sucesso (`200`):

```json
{
  "erro": "n",
  "mensagem": "Cadastro realizado com sucesso.",
  "data": {
    "erro": "n"
  }
}
```

### Entrar

`POST /api/login`

```json
{
  "email": "maria@example.com",
  "senha": "senha12345",
  "lembrar": false
}
```

`lembrar` é opcional. Se omitido ou `false`, o token vale dois dias; se `true`, vale trinta dias. A resposta de sucesso contém o token Bearer:

```json
{
  "erro": "n",
  "mensagem": "Login realizado com sucesso.",
  "token": "TOKEN_RETORNADO_PELA_API",
  "usuario": {
    "nome": "Maria da Silva",
    "tipo_usuario": "morador"
  },
  "data": {
    "erro": "n"
  }
}
```

### Consultar lixeiras

`GET /api/lixeiras`

Requer autenticação. No Postman, em **Authorization**, escolha **Bearer Token** e cole o token retornado pelo login. A resposta inclui o estado atual das lixeiras e até cinco ações recentes.

### Abrir ou fechar uma lixeira

`PATCH /api/lixeiras/{tipo}`

Requer o token Bearer e um corpo JSON com o novo estado. Os tipos disponíveis são `organico`, `metal`, `plastico` e `papel`.

Exemplo para abrir a lixeira de metal:

```http
PATCH /api/lixeiras/metal
```

```json
{
  "aberta": true
}
```

Para fechar, envie `"aberta": false`.

### Sair

`POST /api/logout`

Requer o token Bearer. Invalida o token atual e retorna `204 No Content`.

> Trate tokens como credenciais: não os publique nem os compartilhe. A resposta `"erro": "n"` significa que a operação foi concluída sem erro; `"erro": "s"` indica uma falha.

## Testes

Execute a suíte automatizada com:

```bash
php artisan test
```

## Tecnologias

- Laravel 12 e PHP
- Blade e JavaScript
- Vite
- Banco de dados suportado pelo Laravel
