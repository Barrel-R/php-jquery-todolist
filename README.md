# XNEO_crud

## Setup do Projeto:

Atualize as configurações do banco de dados em src/database/Connection.php:

Exemplo:
```
    private $host = 'localhost';
    private $dbName = 'xneo_crud';
    private $username = 'root';
    private $password = '';
```

Execute a migration da tabela no terminal:

```
cd src/database
php create_todo_table.php
```

Navegue para o diretório 'src' e utilize este comando:

```
php -S localhost:8000
```

Navegue para a url localhost:8000 no seu navegador para acessar o projeto!