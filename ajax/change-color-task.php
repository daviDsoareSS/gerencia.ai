<?php 
    include_once '../vendor/autoload.php';

    $idTask = $_POST['id'];
    $colorTask = $_POST['colorTask'];

    update('tasks', [
        'background_color' => $colorTask,
    ], ['id', $idTask]);    
