# PHP & Jquery To-do List (CRUD)

## Project Setup:

Update the database configuration at src/database/Connection.php:

Example:
```
    private $host = 'localhost';
    private $dbName = 'your_db_name';
    private $username = 'your_username';
    private $password = '123456';
```

Execute the migration file in the terminal:

```
cd src/database
php create_todo_table.php
```

Navigate to the 'src' directory and use this command:

```
php -S localhost:8000
```

Navigate to the browser with the url: localhost:8000 to access the project!
