<?php
    include_once '../vendor/autoload.php';

    $tasksVinculed = $_POST['tasks'];
    $nameProject = $_POST['name'];
    $start_date = $_POST['start_date'];
    $conclusion_date = $_POST['conclusion_date'];

    $project = create('projects', [
        'name' => $nameProject,
        'start_date' => $start_date,
        'conclusion_date' => $conclusion_date,
    ]);

    foreach($tasksVinculed as $tasks){
        update('tasks',[
            'id_project' => $project->id, 
        ],['id', $tasks]);
    }  
?>