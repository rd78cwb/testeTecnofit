# Tecnofit - Ranking API

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-8892BF.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/database-MySQL%208-4479A1.svg?style=flat-square)](https://www.mysql.com/)


> API RESTful em PHP puro para consulta do ranking de recordes pessoais por movimento, considerando empates de posição e regras de negócio conforme desafio técnico Tecnofit.

---

## 💡 Sobre o Projeto

API RESTful para ranking de movimentos, no qual cada usuário pode ter múltiplos recordes. O sistema retorna a lista de usuários ordenada por recorde pessoal e trata empates corretamente, mostrando posição, valor do recorde e data.

### 🚀 Tecnologias Utilizadas

- **PHP 8.2+** (puro, sem frameworks)
- **Composer** (gerenciamento de dependências)
- **MySQL 8**
- **PDO** (acesso seguro ao banco)
- **Docker & Docker Compose** (opcional, recomendado para setup rápido)

### 📝 Decisões Técnicas

- **Empate no ranking:** Usuários com o mesmo recorde compartilham a mesma posição (ex: dois primeiros lugares empatados, o próximo é o terceiro).
- **Consulta de movimento:** O endpoint aceita nome **ou** id do movimento.
- **Organização:** Rotas (fast-route), servicos, modelos.

---

## 🏁 Começando

### 📂 Estrutura de Diretórios

```
/src        # Lógica da aplicação (classes, repositórios etc.)
/public     # Ponto de entrada (index.php)
/mysql      # Scripts SQL
```

### ✅ Pré-requisitos

- [Git](https://git-scm.com/)
- [PHP (v8.1+)](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [Docker + Docker Compose](https://www.docker.com/)

### 📦 Instalação

1.  Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    cd seu-repositorio
    ```

2.  Instale as dependências:
    ```bash
    composer install
    ```

### ⚙️ Configuração do Ambiente

1.  O Banco de dados será criado conforme a migration.sql (sql\migration.sql)

---

### 🐳 Usando Docker

O projeto oferece um `docker-compose.yml` para facilitar:

1. Suba os serviços:
    ```bash
    docker-compose up --build
    ```

2. O PHP será servido em `http://localhost:8000` e o MySQL estará disponível na porta 3306.

3. As variáveis de ambiente para conexão estão em `.env` e já compatíveis com os serviços do compose.

> Certifique-se de ajustar `DB_HOST` para o nome do serviço do banco no compose (ex: `db`).

---

### 🕹️ Testando com Postman

1. Importe `postman_collection.json` (raiz do projeto) no Postman.
2. Coleção "Ranking API" estará disponível.
3. Variável `baseUrl` já configurada para `http://localhost:8000`.

---

