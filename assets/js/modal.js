let tasksVinculed = [];

function handleCheckboxChange(event) {
    const checkbox = event.target;
    const id = checkbox.id;

    if (checkbox.checked) {
        tasksVinculed.push(id);
        console.log(tasksVinculed);
    } 
    else {
    const index = tasksVinculed.indexOf(id);
        if (index !== -1) {
            tasksVinculed.splice(index, 1);
        }
    }
}

// Adiciona um event listener a todos os checkboxes
const checkboxes = document.querySelectorAll('.wrapper-tasks ul li input[type="checkbox"]');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', handleCheckboxChange);
});

function addProject(){
    let nameProject = document.querySelector('input#name-project').value
    let startDateProject = document.querySelector('input#start-date').value
    let conclusionDateProject = document.querySelector('input#conclusion-date').value
    
    $.ajax({
        type: 'POST',
        url: 'ajax/add-project.php',
        data: {
            name: nameProject,
            start_date: startDateProject,
            conclusion_date: conclusionDateProject,
            tasks: tasksVinculed
        },
        success: function(res) {
            console.log(res)
            location.reload(); 
        },
        error: function(error) {
            console.log(error)
        }
    })
}

let url = new URL(window.location.href);
let params = new URLSearchParams(url.search);
let project = params.get('project') ? params.get('project') : 1;
let task;
let contentask = document.querySelector('.wrapper-tasks .task-create')
let colorsTask = document.querySelectorAll('.wrapper-colours .group span')
let colorSelected = 'yellow';

contentask.addEventListener('input', function(){
    task = contentask.innerHTML;
})

colorsTask.forEach(color => {
    color.addEventListener('click', function(){
        colorsTask.forEach(item => {
            item.classList.remove('active');
        });
        color.classList.add('active')
        contentask.id = color.id
        colorSelected = contentask.id
    })
})

function addTask(){
    let nameTask = document.querySelector('input#name-task').value
    $.ajax({
        type: 'POST',
        url: 'ajax/add-task.php',
        data: {
            name: nameTask,
            task: task,
            project: project,
            background_color: colorSelected
        },
        success: function(res) {
            console.log(res)
            location.reload(); 
        },
        error: function(error) {
            console.log(error)
        }
    })
}