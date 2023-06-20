<?php

require_once './Connection.php';

try {
    $connection = new Connection();
    $pdo = $connection->connect();

    $sql = "
    SELECT COUNT(*)
    FROM information_schema.tables
    WHERE table_schema = :dbName
    AND table_name = 'todo_list';
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dbName', $dbName, PDO::PARAM_STR);
    $stmt->execute();

    $tableExists = ($stmt->fetchColumn() > 0);

    if ($tableExists) {
        echo "To-do list table already exists!";
    } else {
        $createTableSql = "
        CREATE TABLE todo_list (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
        ";

        $pdo->exec($createTableSql);

        echo "To-do lists table created successfully!";
    }

    $pdo = null;
    $connection = null;
} catch(PDOException $e) {
    die("Error creating to-do list table: " . $e->getMessage());
}