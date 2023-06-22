<?php

class TodoService
{
    private $pdo;
 
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
 
    public function getAllTodos() {
        try {
            $pdo = $this->pdo;

            $sql = "SELECT * FROM todo_list";
            $stmt = $pdo->query($sql);
            $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $todos;
        } catch (PDOException $e) {
            die("Error retrieving todos: ". $e->getMessage());
        } finally {
            $pdo = null;
        }
    }
 
    public function createTodo($title, $description) {
        try {
            $pdo = $this->pdo;

            $sql = "INSERT INTO todo_list (title, description) VALUES (:title, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error creating todo: " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }

    public function updateTodo($todoId, $data) {
        try {
            $pdo = $this->pdo;
            $sql = "UPDATE todo_list SET ";
            $params = [];

            if (isset($data['title'])) {
                $sql .= "title = :title, ";
                $params[':title'] = $data['title'];
            }
    
            if (isset($data['description'])) {
                $sql .= "description = :description, ";
                $params[':description'] = $data['description'];
            }

            if (isset($data['finished']) && $data['finished'] === true) {
                $sql .= "completed_at = CURRENT_TIMESTAMP";
            } else {
                $sql .= "completed_at = NULL";
            }
    
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = :id";
            $params[':id'] = $todoId;
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            die("Error updating todo: " . $e->getMessage());
        } finally {
            $pdo = null;
        }
    }

    public function deleteTodo($todoId) {
        try {
            $pdo = $this->pdo;

            $sql = "DELETE FROM todo_list WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $todoId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Error deleting todo: " . $e->getMessage());
        } finally {
            $pdo = null;
        }
    }
}