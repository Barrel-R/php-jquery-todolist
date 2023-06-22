$(document).ready(function() {
    fetchTodoList();
  
    // Adicionar tarefa
    $('#todo-form').submit(function(event) {
        event.preventDefault();
        
        let title = $('#titleInput').val();
        let description = $('#descriptionInput').val();

        addTodoItem(title, description);
    });

    // Editar tarefa
    $(document).on('click', '#editBtn', function() {
        let todoId = $(this).data('todo-id');
        let data = {}

        const title = $('#title-' + todoId).val()
        const description = $('#desc-' + todoId).val()
        const isChecked = $('#checkbox-' + todoId).prop('checked')
        
        if (title.length > 0) {
            data['title'] = title
        }

        if (description.length > 0) {
            data['description'] = description
        }

        if (isChecked) {
            data['finished'] = true
        }

        data['mode'] = 'update' // para atualizar tenho que usar POST, entao
                                // para detectar o edit passo uma flag

        editTodoItem(todoId, data)
    })
  
    // Deletar tarefa
    $(document).on('click', '#deleteBtn', function() {
        let todoId = $(this).data('todo-id');
        deleteTodoItem(todoId);
    });
});
  
function fetchTodoList() {
    $('#todo-list').fadeOut(150, function() {
        $.ajax({
            url: 'controllers/api/TodoApiHandler.php',
            method: 'GET',
            success: function(response) {
                let todos = JSON.parse(response);
                let todoList = $('#todo-list');
                todoList.empty();
                
                renderTodoCard(todos);
                
                todoList.fadeIn(150);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching to-do list:', error);
            }
        });
    });
}
  
function addTodoItem(title, description) {
    $.ajax({
        url: 'controllers/api/TodoApiHandler.php',
        method: "POST",
        data: {
            title: title,
            description: description
        },
        success: function(response) {
            console.log(response);
            fetchTodoList();
            $('#titleInput').val('');
            $('#descriptionInput').val('');
        },
        error: function(xhr, status, error) {
            console.error('Error adding to-do item:', error);
        }
    });
}

function editTodoItem(todoId, data) {
    $.ajax({
        url: 'controllers/api/TodoApiHandler.php?id=' + todoId,
        method: 'POST',
        data: data,
        success: function(response) {
            fetchTodoList();
        },
        error: function(xhr, status, error) {
            console.error('Error editing to-do item:', error);
        }
    })
}
  
function deleteTodoItem(todoId) {
    $.ajax({
        url: 'controllers/api/TodoApiHandler.php?id=' + todoId,
        method: 'DELETE',
        success: function(response) {
            fetchTodoList();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting to-do item:', error);
        }
    });
}

function renderTodoCard(todos) {
    let todoList = $('#todo-list');
    todoList.empty();

    for (let i = 0; i < todos.length; i++) {
        let todo = todos[i];
        
        let card = $('<div>').addClass('todo-card');
        let cardHeader = $('<h3>').text('Tarefa ' + todo.id) 

        let titleLabel = $('<label>').text('Título:');
        let titleInput = $('<input>').attr('type', 'text').addClass('todo-title-input').attr('id', 'title-' + todo.id).val(todo.title);
        
        let descriptionLabel = $('<label>').text('Descrição:');
        let descriptionInput = $('<input>').attr('type', 'text').addClass('todo-description-input').attr('id', 'desc-' + todo.id).val(todo.description);

        let checkBoxContainer = $('<div>').addClass('checkbox-container')
        let checkBoxLabel = $('<label>').text('Concluído:').attr('for', 'markFinishedBox');
        let checkbox = $('<input>').attr('type', 'checkbox').addClass('checkbox').attr('id', 'checkbox-' + todo.id);

        let buttonContainer = $('<div>').addClass('button-container')
        let editButton = $('<button>').text('Editar').addClass('edit-button').attr('id', 'editBtn').data('todo-id', todo.id);
        let deleteButton = $('<button>').text('Deletar').addClass('delete-button').attr('id', 'deleteBtn').data('todo-id', todo.id);
        
        if (todo.completed_at != null) {
            checkbox.prop('checked', true);
            card.css('background-color', 'rgb(21, 115, 71')
            card.css('color', 'white')
        }

        buttonContainer.append(editButton, deleteButton)
        checkBoxContainer.append(checkBoxLabel, checkbox)
        card.append(cardHeader, titleLabel, titleInput, descriptionLabel, descriptionInput, checkBoxContainer, buttonContainer);
        todoList.append(card);
    }
}