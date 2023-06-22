<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <link rel="stylesheet" href="./resources/css/styles.css">
</head>
<body>
    <div class="container-center">
        <h1>To-Do List</h1>
        
        <form id="todo-form" method="post" action="">
            <input id="titleInput" type="text" name="title" placeholder="Título" required>
            <input id="descriptionInput" type="text" name="description" placeholder="Descrição">
            <br>
            <div class="create-todo-btn-wrapper">
                <button type="submit" name="addTodo">Adicionar</button>
            </div>
        </form>

        <ul id="todo-list">
            <div id="todoContainer" class="todo-container"></div>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="./resources/js/main.js"></script>
</body>
</html>
