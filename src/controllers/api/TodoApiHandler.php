<?php

require_once 'TodoApi.php';

$api = new TodoApi();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo $api->index();
        break;
    case 'POST':
        if (isset($_POST['mode']) && $_POST['mode'] === 'update') {
            echo $api->update();
        } else {
            echo $api->create();
        }
        break;
    case 'PUT':
        echo $api->update();
        break;
    case 'PATCH':
        echo $api->update();
        break;
    case 'DELETE':
        echo $api->destroy();
        break;
    default:
        $api->index();
        break;
}
