<?php

class Todo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTodos() {
        $sql = "SELECT * FROM todo_list";
        $stmt = $pdo->query($sql);
        $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $todos;
    }

    // Esse model seria utilizado para espeficiar relationamentos,
    // e obter dados do banco.
}
