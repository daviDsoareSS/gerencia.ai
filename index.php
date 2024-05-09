<?php
    session_start();
    include_once 'vendor/autoload.php';

    $last_id_from_tasks = raw("SELECT MAX(id) as id FROM tasks");

    // Redirecionar para a URL atual com parâmetros adicionais
    function redirectCurrentPageWithParams($params) {
        // Verificar se já ocorreu um redirecionamento
        if (!headers_sent() && !isset($_SESSION['redirected'])) {
            $_SESSION['redirected'] = true;

            // Construir a URL com parâmetros adicionais
            $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $query_string = http_build_query($params);
            $redirect_url = $current_url . '?' . $query_string;

            // Redirecionar o navegador
            header("Location: $redirect_url");
            exit();
        }
    }
    
    $params = array(
        'project' => $last_id_from_tasks,
    );

    redirectCurrentPageWithParams($params['project']);

    if(!isset($_GET['project'])){
        $_GET['project'] = 1;
    }
    $get_project = $_GET['project'];

    $tasks = raw("SELECT * FROM tasks WHERE id_project = {$get_project} ORDER BY ordem DESC");
    $projectSelected = raw("SELECT * FROM projects WHERE id = {$get_project}");

    $conclusion_date;
    foreach($projectSelected as $project){
        $conclusion_date = $project->conclusion_date;
    }

    $projects = raw("SELECT * FROM projects");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/modal.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/splide.min.css') ?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>
<body>

    <?php 
        include('includes/header.php');
    ?>

    <div class="modal task-add" style="display: none;">
        <div class="modal-content">
            <div class="header">
                <h3>Criar tarefa</h3>
                <p>Escreva o nome da tarefa</p>
            </div>
            <div class="body">
                <div class="wrapper-inputs">
                    <div class="group-input">
                        <label for="name-task">Título da tarefa</label>
                        <input id="name-task" type="text" name="name-task" placeholder="Digite o título para a tarefa...">
                    </div>
                </div>
                <div class="wrapper-tasks">
                    <div class="task-create" contenteditable="true"></div>
                    <div class="wrapper-colours">
                        <p>Selecione uma cor: </p>
                        <div class="group">
                            <span id="blue"></span>
                            <span id="yellow"></span>
                            <span id="red"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <a href="">Cancelar</a>
                <button class="btn-submit-form" id="ajax-2">Criar</button>
            </div>

            <div class="closeModal">
                <span>×</span>
            </div>
        </div>
        <div class="overlay"></div>
    </div>

    <?= modalAddTask() ?>
    <?= modalAddProject() ?>

    <main>
        <div class="content">
            <div class="title-section">
                <h1>Projetos</h1>
                <span></span>
            </div>
            <div class="header">
                <div class="splide">
                    <div class="splide__track">
                        <ul class="list-projects splide__list">
                            <?php foreach($projects as $item):?>
                                <a href="?project=<?= $item->id ?>" class="splide__slide">
                                    <li class="<?= $item->id == $get_project ? 'active' : '' ?>"><?= $item->name ?></li>
                                </a>                                    
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
                <div class="container-btn-project">
                    <h3 class="edit" id="btn-edit-project"><span>+</span> Editar</h3>
                    <h3 id="btn-add-project"><span>+</span> Adicionar</h3>
                </div>
            </div>
        </div>
    </main>
    <section>
        <div class="content">
            <div class="title-section skeleton">
                <h1>Tarefas</h1>
                <?= isset($conclusion_date) ? '<span>| Previsão de entrega '. formatDate($conclusion_date) . '</span>': '' ?>
                <br>
                <?= isset($conclusion_date) ? '<span>Restam'. daysMissing($conclusion_date). 'dias </span>' : '' ?>
            </div>
            <div class="wrapper-content">
                <div class="overlay edit-task" style="display: none;"></div>

                <div class="task add-task skeleton" id="btn-add-task">
                    <p>+</p>
                    <h2>Adicionar tarefa</h2>
                </div>

                <?php foreach($tasks as $item): ?>                    
                    <div class="item skeleton" 
                        draggable="true" 
                        data-background_color="<?= $item->background_color ?>" 
                        list-pos="<?= $item->id ?>"
                        title="Clique para editar">
                        <div class="task" contenteditable="true">
                            <input type="hidden" name="id" value="<?= $item->id ?>">
                            <?= $item->content ?>
                        </div>
                        <div class="change-colours">
                            <div class="group-input">
                                <input type="checkbox" name="id" id="" value="<?= $item->id ?>">
                            </div>

                            <div class="group-colours">
                                <span data-color="<?= $item->background_color == 'red' ? 'active' : 'red' ?>" id="<?= $item->id ?>"></span>
                                <span data-color="<?= $item->background_color == 'yellow' ? 'active' : 'yellow' ?>" id="<?= $item->id ?>"></span>
                                <span data-color="<?= $item->background_color == 'blue' ? 'active' : 'blue' ?>" id="<?= $item->id ?>"></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

    </section>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?= asset('js/main.js') ?>"></script>
    <script src="<?= asset('js/modal.js') ?>"></script>
    <script src="<?= asset('js/splide.min.js') ?>"></script>

    <script>
        var splide = new Splide( '.splide', {
            perPage: 5,
            perMove: 1,
            pagination: false,
        });

        splide.mount();
    </script>
    <script>
        let buttonsSubmitForm = document.querySelectorAll('.btn-submit-form')

        buttonsSubmitForm.forEach((item) =>{
            item.addEventListener('click', function(){
                switch (item.id) {
                    case 'ajax-1':
                        addProject()
                    break;

                    case 'ajax-2':      
                        addTask()
                    break;
                    
                    case 'ajax-3':      
                        console.log('ajax 3')
                    break;

                    case 'ajax-4':      
                        console.log('ajax 4')
                    break;

                    default:
                    break;
                }
            })
        })

    </script>

    <script>
        let allTasks = document.querySelectorAll('.wrapper-content .item .task')
        let contentTasks = document.querySelectorAll('.wrapper-content .item .task');
        const overlayTask = document.querySelector('.wrapper-content .overlay.edit-task');
        
        
        allTasks.forEach((task, index) =>{
            let contentEditable = contentTasks[index];
            let inputTask = task.querySelector('input'); 
            
            task.addEventListener('click', function(){
                task.classList.add('expanded')
                overlayTask.style.display = 'block';
                $('.change-colours').css('display', 'none');

            })
            overlayTask.addEventListener('click', function(){
                task.classList.remove('expanded');
                overlayTask.style.display = 'none';
                $('.change-colours').css('display', 'flex');

            })
            // Adiciona um ouvinte de evento de input ao contentEditable
            contentEditable.addEventListener('input', function() {
                // Captura o novo conteúdo do contentEditable
                let newContent = contentEditable.innerHTML;

                // Atualiza o valor do textarea correspondente
                contentTasks[index].value = newContent;

                // Obtém o ID da tarefa
                let idTask = inputTask.value;

                $.ajax({
                type: 'POST',
                    url: 'ajax/update-task.php',
                    data: {
                        id: idTask,
                        contentTask: newContent, 
                    },
                    success: function(res) {
                        // FAZ AQUI PRO TRECO APARECER
                        console.log(res)
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            });
        })

    </script>

    <script>
        $('.change-colours span').click(function(){
            let idTask = $(this).attr('id');
            let colorTask = $(this).attr('data-color');

            $.ajax({
                type: 'POST',
                url: 'ajax/change-color-task.php',
                data: {
                    id: idTask,
                    colorTask: colorTask,
                },
                success: function(res) {
                    // FAZ AQUI PRO TRECO APARECER
                    console.log(res)

                    location.reload();
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })
    </script>

    <script defer>        
        document.addEventListener('DOMContentLoaded', () => {
            let current_pos, drop_pos;
            
            let AllTasks = document.querySelectorAll('.wrapper-content .item');
            let contentChangeColours = document.querySelectorAll('.item .change-colours')
            

            let checkboxes = 0;
            let checkboxTask = document.querySelectorAll('.change-colours .group-input input[type="checkbox"]'); 

            checkboxTask.forEach((check, index) =>{
                const colours = contentChangeColours[index];
                check.addEventListener('change', function(){
                    if (this.checked) {
                        checkboxes++;
                        colours.classList.add('active')
                    } else {
                        checkboxes--;
                        colours.classList.remove('active')
                    }
                    if(checkboxes == 0){
                        document.querySelector('.title-section span').style.display = 'none';
                    }else{
                        document.querySelector('.title-section span').style.display = 'flex';
                        document.querySelector('.title-section span').innerHTML = `${checkboxes} itens selecionados`
                    }
                })
            })
            
            AllTasks.forEach((item) => {

                item.addEventListener('dragstart', function (){
                    current_pos = this.getAttribute('list-pos');
                });

                item.addEventListener('dragover', (e) => e.preventDefault());

                item.addEventListener('drop', function (e) {
                    e.preventDefault();
                    drop_pos = this.getAttribute('list-pos');

                    if (current_pos !== drop_pos) {
                        let currentElement = document.querySelector(`[list-pos="${current_pos}"]`);
                        let dropElement = document.querySelector(`[list-pos="${drop_pos}"]`);

                        currentElement.setAttribute('list-pos', drop_pos);
                        dropElement.setAttribute('list-pos', current_pos);

                        let parent = currentElement.parentNode;
                        let nextSibling = dropElement.nextSibling === currentElement ? dropElement : dropElement.nextSibling;
                        parent.insertBefore(currentElement, nextSibling);
                    }

                    console.log('id_antigo: ' + current_pos + '   e o id_novo:' + drop_pos)

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/order-task.php',
                        data: {
                            old_id: current_pos,
                            new_id: drop_pos,
                        },
                        success: function(res) {
                            console.log(res)

                            // location.reload();
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });
            });
        });
        
    </script>
    
</body>
</html>