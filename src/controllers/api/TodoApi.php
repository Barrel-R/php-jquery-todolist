<?php

require_once '../../database/Connection.php';
require_once '../../services/TodoService.php';

class TodoApi
{
    public $pdo;
    public $service;

    public function __construct()
    {
        $this->pdo = (new Connection())->connect();
        $this->service = new TodoService($this->pdo);
    }

    public function index() {
        $todos = $this->service->getAllTodos();
        return json_encode($todos);
    }

    public function create() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $this->service->createTodo($title, $description);

        return 'created';
    }

    public function update() {
        if (isset($_GET['id'])) {

            $todoId = $_GET['id'];
            $data = [];
            
            if (isset($_POST['title'])) $data['title'] = $_POST['title']; 
            if (isset($_POST['description'])) $data['description'] = $_POST['description'];
            if (isset($_POST['finished'])) $data['finished'] = true;
            
            $this->service->updateTodo($todoId, $data);
            return 'updated';
        }
    }

    public function destroy() {
        $todoId = $_GET['id'];

        return $this->service->deleteTodo($todoId);
    }
}