# 🚀 beTalent Multi-Gateways API

Este projeto é uma API robusta desenvolvida em **Laravel 10** para gestão de transações financeiras com suporte a múltiplos gateways de pagamento. O sistema conta com redundância automática, gestão completa de produtos e clientes, além de um sistema de controle de acesso (RBAC).

## 🛠️ Tecnologias Utilizadas

* **Framework:** Laravel 10
* **Autenticação:** Laravel Sanctum
* **Banco de Dados:** MySQL
* **Documentação:** Swagger & Postman Collection
* **Ambiente:** Docker

---

## 📥 Instalação e Configuração

### Opção 1: Instalação Local (Sem Docker)

1. **Clonar o repositório:**
```bash
git clone https://github.com/luiis-fernandoo/beTalent-multi-gateways.git
cd beTalent-multi-gateways

```

2. **Instalar dependências e configurar:**
```bash
composer install
cp .env.example .env
php artisan key:generate

```

3. **Banco de Dados:**
* Configure suas credenciais no `.env`.
* Execute as migrações e alimente o banco:


```bash
php artisan migrate
php artisan db:seed --class=RolesSeeder
php artisan db:seed --class=UsersSeeder
php artisan db:seed --class=GatewaysSeeder
php artisan db:seed --class=ProductsSeeder

```

### Opção 2: Instalação via Docker

1. **Subir os containers:**
```bash
docker-compose up -d

```


2. **Configuração Inicial:**
```bash
docker exec -it betalent-app composer install
docker exec -it betalent-app php artisan key:generate
docker exec -it betalent-app php artisan migrate

```


3. **Alimentar o Banco:**
```bash
docker exec -it betalent-app php artisan db:seed --class=RolesSeeder
docker exec -it betalent-app php artisan db:seed --class=UsersSeeder
docker exec -it betalent-app php artisan db:seed --class=GatewaysSeeder
docker exec -it betalent-app php artisan db:seed --class=ProductsSeeder

```



---

## 🔐 Autenticação e Headers

A API utiliza tokens de acesso via Sanctum. A sessão expira a cada **30 minutos**.

1. **Login:** `POST /api/login` (User: `admin@betalent.com` | Pass: `1234`).
2. **Headers Obrigatórios:**
* `x-token-access`: [Token retornado no login]
* `x-user-id`: `1` (ou o ID do usuário logado)

---

## ⚙️ Funcionalidades Principal

### 💳 Gestão de Transações (CRUD Completo)

Diferente de um simples histórico, o sistema possui um motor completo de transações:

* **Criação de Compra:** Realiza a tentativa de pagamento. O sistema tentará o primeiro gateway; em caso de falha, acionará o segundo automaticamente.
* **Visualização e Listagem:** Consulta detalhada de cada transação gerada.
* **Estorno (Chargeback):** Possibilidade de reverter uma transação aprovada diretamente pela API, comunicando-se com o gateway de origem.

### 📦 Outros Cruds

* **Usuários:** Gestão completa de operadores do sistema.
* **Produtos:** Cadastro de itens com suporte a `name` e `amount` (em centavos).

---

## 🔌 Configuração de Gateways (.env)

Para o funcionamento correto das integrações, é imprescindível configurar as URLs e as chaves de autenticação no seu arquivo `.env`.

> [!NOTE]
> Consulte o arquivo `.env.example` para identificar os campos necessários para cada gateway configurado (URLs, Tokens e Credenciais de autenticação). Garanta que os mocks ou APIs dos gateways estejam acessíveis.

---

## 📂 Documentação Externa

* **Swagger:** `http://localhost:8000/api/documentation`
* **Postman Collection:** [Download da pasta de Requests (Google Drive)](https://drive.google.com/drive/folders/1IrsG76qYQPBks09uSZVWyt7mEfQzOQ5B?usp=sharing)
