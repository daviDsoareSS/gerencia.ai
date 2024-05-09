// MODAL

let allModal = document.querySelectorAll('.modal')

allModal.forEach(modal =>{
    const overlay = modal.querySelector('.overlay')
    const closeModal = modal.querySelector('.closeModal')
    
    overlay.addEventListener('click', () =>{
        modal.classList.remove('active')
    })
    closeModal.addEventListener('click', () =>{
        modal.classList.remove('active')
    })
})

const triggerAddProject = document.querySelector('#btn-add-project')
const triggerAddTask = document.querySelector('#btn-add-task')

triggerAddProject.addEventListener('click', function(){
    document.querySelector('.modal.project-add').classList.add('active')
})

triggerAddTask.addEventListener('click', function(){
    document.querySelector('.modal.task-add').classList.add('active')
})

const allSkeleton = document.querySelectorAll('.skeleton')

window.addEventListener('load', function(){
    allSkeleton.forEach(item=>{
        setInterval(function(){
            item.classList.remove('skeleton')
        }, 200)
    })
})