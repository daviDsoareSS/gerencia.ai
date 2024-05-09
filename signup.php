<?php
    session_start();
    include_once 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="<?= asset('css/signup.css')?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>
<body>
    <main>
        <div class="content">
            <div class="wrapper-form">
                <div class="progress-container">
                </div>
                <form action="">
                    <div class="wrapper-inputs">
                        <div class="group-input colu2">
                            <div class="col">
                                <label for="">Nome</label>
                                <input type="text">
                            </div>
                            <div class="col">
                                <label for="">Sobrenome</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="group-input">
                            <label for="">Qual seu interesse com o <i>Gerencia aí</i></label>
                            <select name="" id="">
                                <option selected disabled>Selecione um interesse</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>