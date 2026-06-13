# SchedMVC — Sistema de Agendamentos

Sistema de agendamentos em **PHP 8.2 + MySQL 8** com arquitetura **MVC** e padrões de projeto **Singleton** e **Factory**, containerizado com **Docker**.

---

## Requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## Como rodar

### 1. Clone ou entre na pasta do projeto

```bash
cd sistema-de-agendamentos-mvc
```

### 2. Suba os containers

```bash
docker compose up --build
```

> Na primeira execução o Docker irá baixar as imagens do PHP e do MySQL — pode levar alguns minutos.  
> Nas próximas vezes basta `docker compose up`.

### 3. Aguarde a mensagem de pronto

Quando o terminal exibir a linha abaixo, o sistema está no ar:

```
app-1  | ✓ Usuário de teste criado: teste@teste.com / teste123
app-1  | Iniciando Apache...
```

### 4. Acesse no navegador

```
http://localhost:8080
```

---

## Usuário de teste

Criado automaticamente na primeira inicialização:

| Campo  | Valor              |
|--------|--------------------|
| E-mail | `teste@teste.com`  |
| Senha  | `teste123`         |

---

## Como usar o sistema

### Login / Cadastro
- A tela de login abre ao acessar `http://localhost:8080`
- Entre com o usuário de teste ou clique em **"Cadastre-se"** para criar uma conta nova
- A senha é armazenada com **bcrypt**

### Dashboard
- Após o login você vê o painel com estatísticas e a lista de todos os seus agendamentos

### Criar agendamento
- Clique em **"+ Novo Agendamento"**
- Escolha o tipo:
  - **Padrão** — título, descrição, data e hora
  - **Urgente** — exige nível de prioridade (Alta ou Altíssima)
  - **Profissional** — exige nome do cliente/paciente

### Editar
- Na tabela do dashboard, clique em **"Editar"** na linha desejada

### Excluir
- Clique em **"Excluir"** — uma confirmação é exibida antes de deletar

### Sair
- Clique em **"Sair"** no menu lateral

---

## Comandos úteis

```bash
# Rodar em background (sem travar o terminal)
docker compose up --build -d

# Ver logs em tempo real
docker compose logs -f app

# Parar os containers
docker compose down

# Parar e apagar o banco (reset completo)
docker compose down -v
```

---

## Estrutura do projeto

```
.
├── docker-compose.yml
├── Dockerfile
├── apache.conf
├── entrypoint.sh
├── public/
│   ├── index.php        # Front Controller (entrada única)
│   └── .htaccess
├── app/
│   ├── Core/            # Router, Database (Singleton), Session, Controller base
│   ├── Controllers/     # AuthController, AppointmentController
│   ├── Models/          # User, Appointment (abstrato), subclasses, Factory, Repository
│   └── Views/           # auth/ e appointments/ em PHP puro
└── database/
    ├── init.sql         # Criação das tabelas no MySQL
    └── seed.php         # Insere o usuário de teste com bcrypt
```

---

## Padrões de projeto aplicados

| Padrão        | Onde                                                                                      |
|---------------|-------------------------------------------------------------------------------------------|
| **MVC**       | Models em `app/Models/`, Views em `app/Views/`, Controllers em `app/Controllers/`        |
| **Singleton** | `app/Core/Database.php` — garante uma única conexão PDO com o MySQL                      |
| **Factory**   | `app/Models/AppointmentFactory.php` — instancia o tipo correto de agendamento com validação polimórfica |
