<?php

function modalAddProject(){
    $Alltasks = raw("SELECT * FROM tasks ORDER BY ordem");    
    echo '
        <div class="modal project-add" style="display: none; ">
            <div class="modal-content">
                <div class="header">
                    <h3>Adicionar projeto</h3>
                    <p>Crie projetos e vincule-os a ele</p>
                </div>
                <div class="body">
                    <div class="wrapper-inputs">
                        <div class="group-input">
                            <label for="name-project">Nome do projeto</label>
                            <input id="name-project" type="text" name="name-project">
                        </div>
                        <div class="group-input">
                            <label for="start-date">Data de início</label>
                            <input id="start-date" type="date" name="start-date">
                        </div>
                        <div class="group-input">
                            <label for="conclusion-date">Data prevista de conclusão</label>
                            <input id="conclusion-date" type="date" name="conclusion-date">
                        </div>
                    </div>
                    <div class="wrapper-tasks">
                        <h4>Vincule as tarefas criadas</h4>
                        <ul>';
                            foreach($Alltasks as $item){
                                echo '
                                <li>
                                    <input type="checkbox" id="'. $item->id. '">
                                    '. $item->name.'
                                </li>';
                            }
                            echo'
                        </ul>
                    </div>
                </div>
                <div class="footer">
                    <a href="">Cancelar</a>
                    <button class="btn-submit-form" id="ajax-1">Adicionar</button>
                </div>

                <div class="closeModal">
                    <span>×</span>
                </div>
            </div>
            <div class="overlay"></div>
        </div>
    ';
}

function modalAddTask(){
    echo '
        <div class="modal task-add" style="display: none;">
            <div class="modal-content">
                <div class="header"></div>
                <div class="body">
                    <?= Allprojects ?>
                </div>
                <div class="footer"></div>

                <div class="closeModal">
                    <span>×</span>
                </div>
            </div>
            <div class="overlay"></div>
        </div>
    ';
}