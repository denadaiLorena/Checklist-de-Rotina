# Checklist de Rotina (Seu Checklist)

Aplicação simples de checklist/tarefas feita em PHP + PostgreSQL, com interface em HTML/CSS/JS. As ações (criar/editar/deletar/marcar como concluída) são feitas via requisições `POST` (AJAX) para `index.php`, que retorna JSON.

## Funcionalidades

- Criar tarefa
- Editar tarefa
- Deletar tarefa
- Marcar/desmarcar como concluída
- Lista ordenada por `id` (mais recentes primeiro)

## Tecnologias

- **Backend:** PHP (sem framework)
- **Banco:** PostgreSQL (via PDO)
- **Frontend:** HTML + CSS + JavaScript
- **AJAX:** `fetch` (e jQuery apenas para alguns handlers)
- **CDN:** Font Awesome e jQuery

## Requisitos

- **PHP 7.4+** (recomendado PHP 8.x)
- Extensões do PHP: **PDO** e **pdo_pgsql**
- **PostgreSQL** (local ou Supabase)

## Configuração do banco

O projeto espera uma tabela `tasks` no PostgreSQL.

1) Ajuste as credenciais de conexão em [backend/database/connection.php](backend/database/connection.php).

- Dica: para uso em produção, evite deixar credenciais fixas no arquivo. O ideal é ler de variáveis de ambiente e não versionar segredos.

2) Crie as tabelas:

```bash
psql "postgresql://USUARIO:SENHA@HOST:PORTA/NOME_DO_BANCO" -f backend/database/create_tables.sql
```

3) (Opcional) Popular com exemplos:

```bash
psql "postgresql://USUARIO:SENHA@HOST:PORTA/NOME_DO_BANCO" -f backend/database/population.sql
```

### Observação sobre o SQL

O arquivo [backend/database/create_tables.sql](backend/database/create_tables.sql) contém também uma tabela `usuario`. Se você for usá-la, revise o script conforme necessário (por exemplo, garantindo que a sintaxe esteja compatível com o seu PostgreSQL).

## Como executar (local)

### Opção A) Servidor embutido do PHP

No diretório raiz do projeto (onde está `index.php`), execute:

```bash
php -S localhost:8000
```

Abra no navegador:

- `http://localhost:8000/index.php`

Importante: rode o servidor na **raiz do projeto**, porque alguns assets são referenciados com caminho absoluto (ex.: `/frontend/js/...`).

### Opção B) Apache/Nginx

Configure o **DocumentRoot** apontando para a pasta do projeto (onde está `index.php`). Não há regras de rewrite obrigatórias.

## Como funciona (rotas/ações AJAX)

Todas as ações são `POST` para `index.php` com um campo `acao`.

- `acao=criar_ajax` + `description`
  - Resposta: `{ ok: true, task_html: "..." }`
- `acao=editar_ajax` + `id` + `description`
  - Resposta: `{ ok: true, task: { id, titulo } }`
- `acao=deletar_ajax` + `id`
  - Resposta: `{ ok: true, task: { id } }`
- `acao=marcarFeita_ajax` + `id` + `completo` (0/1)
  - Resposta: `{ ok: true, task: { id, completo } }`

A tela principal é renderizada em [frontend/tela_prin.php](frontend/tela_prin.php) e cada item de tarefa usa o template [frontend/task_item.php](frontend/task_item.php).

## Estrutura de pastas

- [index.php](index.php): front controller (recebe POSTs e inclui a tela)
- [backend/database](backend/database): conexão e scripts SQL
- [backend/src](backend/src): controller e repositório
- [frontend](frontend): tela principal, template de item e assets (CSS/JS/img)

## Troubleshooting

- **Erro de conexão com banco:** verifique host/porta/usuário/senha em [backend/database/connection.php](backend/database/connection.php) e se o `sslmode=require` faz sentido no seu ambiente.
- **`could not find driver`/PDO:** habilite a extensão `pdo_pgsql` no `php.ini`.
- **Tarefas não inserem e o banco não é PostgreSQL:** o repositório usa `INSERT ... RETURNING id` (compatível com PostgreSQL). Para MySQL/MariaDB seria necessário adaptar.
- **CSS/imagens não carregam:** rode a aplicação na raiz do servidor (para que `/frontend/...` aponte corretamente).
