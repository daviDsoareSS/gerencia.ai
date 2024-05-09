<?php 
    include_once '../vendor/autoload.php';

    $oldId = $_POST['old_id'];
    $newId = $_POST['new_id'];

    $teste = update('tasks', [
        'ordem' => $newId
    ], ['ordem', $oldId]);
