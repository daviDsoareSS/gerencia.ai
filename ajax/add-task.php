<?php 
    include_once '../vendor/autoload.php';

    $idProject = $_POST['project'];
    $nameTask = $_POST['name'];
    $contentTask = $_POST['task'];
    $backgroundColorTask = $_POST['background_color'];

    $task = create('tasks', [
        'name' => $nameTask,
        'content' => $contentTask,
        'id_project' => $idProject,
        'background_color' => $backgroundColorTask, 
    ]);

    update('tasks', [
        'ordem' => $task->id,
    ], ['id', $task->id]);
