# 🚀 Be-Talent Multi-Gateways API

Este projeto é uma API robusta desenvolvida em **Laravel 10** para gestão de transações financeiras com suporte a múltiplos gateways de pagamento. O foco principal foi a implementação da lógica de **Nível 3** do desafio, estruturando a resiliência entre gateways e o cálculo dinâmico de múltiplos produtos. Os usuários são verificados pela role, para que seja permitido o acesso a determinadas funções/rotas através de ADMIN, FINANCE, MANAGER e USER.

---

### 📢 Nota do Desenvolvedor
Este projeto foi desenvolvido integralmente durante um único final de semana. Priorizei a arquitetura do motor de pagamentos e a integração modular.
* **Nível de Entrega:** Implementação de **Nível 3** concluída (Cálculo de múltiplos produtos no back-end e integração com gateways autenticados).
* **Uso de IA:** O projeto contou com o auxílio de IA como ferramenta de aceleração de produtividade e auxílio na configuração de ambiente, porém toda a lógica de negócio e arquitetura foram estruturadas manualmente.
* **Limitações de Tempo:** Devido ao prazo restrito, os seguintes itens ficaram como próximos passos (incompletos):
    * **TDD (Testes Unitários):** Não houve tempo para implementação da cobertura de testes.
    * **Swagger:** A ferramenta está instalada, mas a documentação detalhada de cada endpoint ficou parcial.

---

### 🛠️ Tecnologias Utilizadas
* **Framework:** Laravel 10 (PHP 8.2)
* **Banco de Dados:** MySQL 8.0
* **Ambiente:** Docker (Nginx + PHP-FPM) ou Instalação Local
* **Autenticação:** Laravel Sanctum

---

### 📥 Instalação e Configuração

#### Opção 1: Via Docker (Recomendado)
O ambiente Docker foi configurado para responder na porta **3000**.

1. **Subir os containers:**
   ```bash
   cp .env.example .env
   docker compose up -d
   ```

2. **Configuração interna:**
   ```bash
   # Instalação de dependências e chaves
   docker compose exec app composer install
   docker compose exec app php artisan key:generate

   # Ajuste de permissões (Essencial para Linux/Docker)
   docker compose exec app chown -R www-data:www-data storage bootstrap/cache
   docker compose exec app chmod -R 775 storage bootstrap/cache

   # Migrações e Seeds
   docker compose exec app php artisan migrate --seed
   ```
   **Acesso:** `http://localhost:3000`

---

#### Opção 2: Instalação Local (Sem Docker)
Certifique-se de ter o PHP 8.2+ e o MySQL instalados em sua máquina.

1. **Preparar o projeto:**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Banco de Dados:**
   Configure as credenciais do seu banco no arquivo `.env` e execute:
   ```bash
   php artisan migrate --seed
   ```

3. **Iniciar o servidor:**
   ```bash
   php artisan serve --port=3000
   ```
   **Acesso:** `http://localhost:3000`

---

### 🔐 Autenticação e Credenciais

A API utiliza tokens via **Sanctum**. 
1. **Login:** `POST /api/login`
2. **Credenciais Padrão:** `admin@betalent.com` | Senha: `1234`
3. **Uso:** O token retornado deve ser enviado no Header `Authorization: Bearer {seu_token}`.

---

### 💳 Diferenciais de Nível 3 Implementados

* **Cálculo de Carrinho no Back-end:** A API recebe apenas os IDs e quantidades dos produtos. O valor final é calculado no servidor consultando o banco de dados, garantindo a integridade dos valores.
* **Resiliência Multi-Gateway (Fallback):** Sistema configurado para tentar o pagamento no Gateway principal; em caso de falha técnica (erro 500 ou timeout), o segundo gateway é acionado automaticamente.
* **Arquitetura Modular:** Facilidade para plugar novos gateways de pagamento seguindo padrões de interface.
* **RBAC Completo:** A estrutura de Roles (Admin, Manager, etc.) Usuários autenticados passam por uma verificação de permissões para que cada user tenha apenas acesso ao que lhe é permitido através do seu role.

---

### 📂 Documentação e Testes
* **Postman:** Recomenda-se o uso da **Postman Collection** disponível na raiz do projeto para testar os fluxos de login, produtos e transações.
* **Logs:** Para monitorar as tentativas de pagamento e possíveis erros, verifique `storage/logs/laravel.log` ou use `docker compose logs app`.
