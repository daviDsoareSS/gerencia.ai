<?php
    include_once '../vendor/autoload.php';

    $content = $_POST['contentTask'];
    $idTask = $_POST['id'];

    // var_dump($idTask);
    // die();

    update('tasks', [
        'content' => $content,
    ], ['id', $idTask]);