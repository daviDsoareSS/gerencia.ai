<?php 

function connect() {
    $pdo = new \PDO('mysql:host=localhost;dbname=todo-list;charset=utf8', 'root', '');
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

    return $pdo;
}

// var_dump("$_SERVER[REQUEST_URI]");
// die();
