//! First, we need to know if the session storage is empty or no
"use strict";
function main(){
    addEventListeners();
    if(!validateSession()){
        let appContainer = document.getElementById("container-todo");
        appContainer.appendChild(showEmptyView());
        createTaskList();
    }else{
        addTasksView();
    }
}

function validateSession(){
    return sessionStorage.length != 0;
}

function createTaskList(){
    sessionStorage.setItem("task-list", JSON.stringify([]));
    createIdTaskCounter();
}

function addTask(task){
    let task_list = returnTaskList();
    task_list.push(task);
    sessionStorage.setItem("task-list", JSON.stringify(task_list)); // sessionStorage only hand strings
}

function returnTaskList(){
    return JSON.parse(sessionStorage.getItem("task-list")); // To return the "[]" how an real array
}

function deleteTaskList(){
    sessionStorage.removeItem("task-list");
    sessionStorage.removeItem("task-id-counter");
    sessionStorage.clear();
}

function createIdTaskCounter(){
    sessionStorage.setItem("task-id-counter", 0);
}

function assginIdTask(){
    let id = sessionStorage.getItem("task-id-counter");
    Number(id);
    id++;
    sessionStorage.setItem("task-id-counter", id);
    return id;
}

function showEmptyView(){
    let container = document.createElement("div.text-center");
    container.className = "text-center";
    let title1 = document.createElement("h1");
    title1.className = "mb-5 mt-5";
    title1.innerText = "No hay tareas creadas";
    let title2 = document.createElement("h1");
    title2.className = "mb-5 mt-5";
    title2.innerText = "Empieza a crearlas con el botón inferior";
    container.appendChild(title1);
    container.appendChild(title2);
    return container;
}

function addEventListeners(){
    // Buton of the form
    let create_task_button = document.getElementById("create-task-button");
    
    create_task_button.addEventListener("click", (event) => {
        
        const title_task = document.getElementById("title-task").value
        const description_task = document.getElementById("description-task").value
        const validation = valideInputs(title_task, description_task);
        
        if(validation){
            
            // Save the task and close the modal
            const modalContainer = document.getElementById("exampleModal");
            const modal = bootstrap.Modal.getInstance(modalContainer)
            modal.hide();

            if(!validateSession()){
                createTaskList();
            }

            const task = {
                id : assginIdTask(),
                title_task, 
                description_task
            }
            addTask(task);
            // Update the view
            addLastTask();

        }
    });
}

function addLastTask(){
    const div_tasks = document.getElementById("container-todo");
    let last_div = div_tasks.childNodes[div_tasks.childNodes.length - 1];
    const tasks = returnTaskList();
    const task = tasks[tasks.length -1];
    const content = document.createRange().createContextualFragment(`
        <div class="col-sm mb-3 mt-3">
            <div class="card">
                <div class="card-header">
                    Tarea # ${task.id}
                </div>
                <div class="card-body">
                    <h2 class="card-title">${task.title_task}</h2>
                    <p class="card-text">${task.description_task}</p>
                    <button type="button" class="btn btn-danger delete-task-button" id="${task.id}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar</button>
                </div>
            </div>
        </div>
    `);

    if(last_div.childNodes.length < 9){
        /** 
         * Why 9? because each of the nodes (html element) of a row, actually add 3 (text, html element, text)
         * so each element count how one, so actually for each 3 elements, that 3 is really one, so is equivalent, 3 = 1, 6 = 2 and 9 = 3,
         * the number of the right is the number of the complete node task (by 3 elments described before), so for each 3, really is one div complete
        */
        last_div.appendChild(content);
    }else{
        let row = document.createElement("div");
        row.className = "row";
        row.appendChild(content);
        div_tasks.appendChild(row);
    }
    reloadEventsDeleteButtons();
}

function addTasksView(){
    const tasks = returnTaskList();
    let div_tasks = document.getElementById("container-todo");

    if(div_tasks.innerHTML == ""){

        let counter_task_on_row = 0;
        let row = document.createElement("div");
        row.className = "row";

        tasks.forEach(task => {
            let content = document.createRange().createContextualFragment(`
            <div class="col-sm mb-3 mt-3">
                <div class="card">
                    <div class="card-header">
                        Tarea # ${task.id}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">${task.title_task}</h2>
                        <p class="card-text">${task.description_task}</p>
                        <button type="button" class="btn btn-danger delete-task-button" id="${task.id}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar</button>
                    </div>
                </div>
            </div>
            `); 
            row.appendChild(content);
            counter_task_on_row++;

            if(counter_task_on_row == 3){
                div_tasks.appendChild(row);
                row = document.createElement("div");
                row.className = "row";
                counter_task_on_row = 0;
            }
        });

        div_tasks.appendChild(row);
        reloadEventsDeleteButtons();
        return;
    }

}

function valideInputs(title, description){
    
    let help_text = document.getElementById("help-text");

    if(title.length != 0  && description.length != 0){
        if(title.length > 20){
            help_text.innerText = "Titulo demasiado largo, debe ser máximo 20 caracteres"
            return false;
        }
        if(description.length > 200){
            help_text.innerText = "Descripción demasiada larga, debe ser máximo 200 caracteres"
            return false;
        }
        help_text.innerText = ""
        return true;
    }

    help_text.innerText = "El título y/o la descripción no pueden estar vacios"

    return false;
}

function reloadEventsDeleteButtons(){
    // It's necessary reload the event click to delete buttons
    const delete_task_buttons = document.querySelectorAll("button.delete-task-button");
    delete_task_buttons.forEach(button => {
        button.addEventListener("click", (event) => {
            document.getElementById("modal-alert-delete-task").innerHTML = "¿Deseas eliminar la tarea: " + button.id + "?";
            document.getElementById("confirm-delete-button").addEventListener("click", () => {
                const modalContainer = document.getElementById("staticBackdrop");
                const modal = bootstrap.Modal.getInstance(modalContainer)
                modal.hide();
                deleteEspecificTask(button.id);
            });
        });
    });
}

function deleteEspecificTask(id){
    const tasks = returnTaskList();
    for(let i = 0; i < tasks.length; i++){
        if(tasks[i].id == id){
            console.log("Encontrado...");
            tasks.splice(i, 1);
            break;
        }
    }
    updateTasks(tasks);
    resetDivTaskContent();
}

function updateTasks(tasks){
    sessionStorage.removeItem("task-list");
    sessionStorage.setItem("task-list", JSON.stringify(tasks));
}


function resetDivTaskContent(){
    let div_tasks = document.getElementById("container-todo");
    div_tasks.innerHTML = "";
    addTasksView();
}

// Init the script of the app
main();