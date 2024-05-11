//! First, we need to know if the session storage is empty or no
"use strict";
/**
 * This function is the main of the app, int the script calling the necessary functions
*/
function main(){
    addEventListeners(); // Upload the form to create tasks
    // If the session is not empty, then get the tasks saved and load it again in the view, other case then show a message that is empty
    if(!validateSession() || returnTaskList().length == 0){
        let appContainer = document.getElementById("container-todo");
        appContainer.appendChild(showEmptyView());
    }else{
        console.log("volviendo a cargar contenido...");
        addTasksView();
        reloadEventsDeleteButtons();
    }
}
/**
 * This function validate if the sessionStore is empty
 * @returns bool: true if the sessionStore is empty, false if not
*/
function validateSession(){
    if(sessionStorage.length != 0){
        return true;
    }else{
        return false;
    }
}
/**
 * This function init the array to save the task (each task shoul be an objetct, so createList create the base array) since the sessionStorage
*/
function createTaskList(){
    sessionStorage.setItem("task-list", JSON.stringify([]));
    createIdTaskCounter();
}
/**
 * This function add a new task in the sessionStorage
 * @param task should be the task object to add it in the array and save it in sessionStorage
*/
function addTask(task){
    let task_list = returnTaskList();
    task_list.push(task);
    sessionStorage.setItem("task-list", JSON.stringify(task_list)); // sessionStorage only hand strings
}
/**
 * This function returns the array of the tasks
 * @returns array: Return the array saved in the sessionStorage with his current data
*/
function returnTaskList(){
    return JSON.parse(sessionStorage.getItem("task-list")); // To return the "[]" how an real array
}
/**
 * This function delete ALL of the sessionStorage data (the array and the counter and any other data)
*/
function deleteTaskList(){
    sessionStorage.removeItem("task-list");
    sessionStorage.removeItem("task-id-counter");
    sessionStorage.clear();
}
/**
 * This function init the task id counter to assign it to each task created
*/
function createIdTaskCounter(){
    sessionStorage.setItem("task-id-counter", 0);
}
/**
 * This function get the current id avalible according the task list to each task created and return the id to be assigned
 * @returns int: return the id number
*/
function assginIdTask(){
    let id = sessionStorage.getItem("task-id-counter");
    Number(id);
    id++;
    sessionStorage.setItem("task-id-counter", id);
    return id;
}
/**
 * This function init and create the container that shows the message if the data of the tasks is empty, also return int
 * @returns object: return the container object HTML
*/
function showEmptyView(){
    let container = document.createElement("div");
    container.id = "text-message-div";
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
/**
 * This function validate the inputs of the tasks to will be created, validate that each input if not be empty and max length
 * @param {string} title is the tittle of the task
 * @param {string} description is the description of the task
 * @returns bool: return true if the inputs passed the validations, if not, return false
*/
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
/**
 * This function add the event listener to the form creation of the task and validate the data to create each task
*/
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

            if(!validateSession()){ // For the first time to create the first task
                createTaskList();
            }

            const task = {
                id : assginIdTask(),
                title_task, 
                description_task
            }
            addTask(task); // Add to the array of tasks
            // Update the view and the last task created to have the correspondin events how the other before him
            addLastTask();

        }
    });
}
/**
 * This function add the last task of the view with his necessary data and add his event listener to will be eliminated
*/
function addLastTask(){
    const div_tasks = document.getElementById("container-todo");
    if(document.getElementById("text-message-div")){
        document.getElementById("text-message-div").remove();
    }
    const tasks = returnTaskList();
    const task = tasks[tasks.length -1];
    const content = document.createRange().createContextualFragment(`
        <div class="col-sm mb-3 mt-3" id="task-${task.id}">
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
    
    if(div_tasks.childNodes.length == 0){ // This will be the first taks in will be created, then create the row father to the card
        let row = document.createElement("div");
        row.className = "row";
        row.appendChild(content);
        div_tasks.appendChild(row);
        updateLastTaskEvent(`${task.id}`);
        reloadEventsDeleteButtons();
        return;
    }
    // According the last div (row), calculate if his nodes have 3 cards(tasks) and create other father if it's necessary
    let last_div = div_tasks.childNodes[div_tasks.childNodes.length - 1];

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

    updateLastTaskEvent(`${task.id}`);

}
/**
 * This function search the las task and update the event click to can use the confirm-delete-button
 * @param {int} task_id is the id to search the last task and update his events
 */
function updateLastTaskEvent(task_id){
    const button = document.getElementById(task_id);
    /**
     * !This is very important
     * !For each primary button of the cards, this buttons should have the click event for make the delete function
    */
    button.addEventListener("click", (event) => {
        /**
        * ! First, get the confirm-delete-button of the modal, so for each click in the buttons of the card, then assign the
        * ! id of the button to the value of the button of the modal, then that button have the value to make the delet action of each task
        * ! because this occurs for each click in each button of the cards that open the modal and the reference of the button of the modal it does
        */
        let confirm_delete_button = document.getElementById("confirm-delete-button"); // !GET THE REFERENCE, NOT ONLY DOCUMENT
        confirm_delete_button.value = event.target.id; // ! The value of the button modal have to be the current id of the button of the task
        document.getElementById("modal-alert-delete-task").innerHTML = "¿Deseas eliminar la tarea: " + event.target.id + "?";    
    });
    
}
/**
 * This function load the tasks cards and his containers on the view and calculates that should be assigned only 3 cars for one row
*/
function addTasksView(){
    const tasks = returnTaskList();
    let div_tasks = document.getElementById("container-todo");

    if(div_tasks.innerHTML == ""){

        let counter_task_on_row = 0;
        let row = document.createElement("div");
        row.className = "row";

        tasks.forEach(task => {
            let content = document.createRange().createContextualFragment(`
            <div class="col-sm mb-3 mt-3" id="task-${task.id}">
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
    }
}
/**
 * This function reload the clicks events for each button fo the cards/tasks containers and the confirm-delet-button of the modal, where
 * each button of the cards have the id of the taks to will be eliminated and the confirm-delete-button should have contain that value in his value property.
 * This functions shoul be when the script inits for the first time
*/
function reloadEventsDeleteButtons(){
    // It's necessary reload the event click to delete buttons
    console.log("volviendo a cargar los eventos...");
    const delete_task_buttons = document.querySelectorAll("button.delete-task-button");
    let confirm_delete_button = document.getElementById("confirm-delete-button"); // GET THE REFERENCE, NOT ONLY DOCUMENT
            confirm_delete_button.addEventListener("click", () => {
                deleteEspecificTask(confirm_delete_button.value);
                const modalContainer = document.getElementById("staticBackdrop");
                const modal = bootstrap.Modal.getInstance(modalContainer)
                modal.hide();
        });
    delete_task_buttons.forEach(button => {
        button.addEventListener("click", (event) => {
            confirm_delete_button.value = event.target.id;
            document.getElementById("modal-alert-delete-task").innerHTML = "¿Deseas eliminar la tarea: " + event.target.id + "?";
        });
    });
}
/**
 * This function delete the task on the array tasks fo the sessionStorage and delete the container object of the document HTML
 * @param {int|string} id is the id of the only task the be eliminated
 */
function deleteEspecificTask(id){
    const tasks = returnTaskList();
    console.log("Se me pidió borrar la tarea: " + id);
    for(let i = 0; i < tasks.length; i++){
        if(tasks[i].id == id){
            tasks.splice(i, 1);
            break;
        }
    }
    updateTasks(tasks);
    // ONLY DELETE THE TASK CONTAINER referenced
    if(document.getElementById(`task-${id}`)){
        document.getElementById(`task-${id}`).remove();
    }
}
/**
 * This function update the tasks in the sessionStorage
 * @param {Array} tasks is the current array to will be stored
*/
function updateTasks(tasks){
    sessionStorage.removeItem("task-list");
    sessionStorage.setItem("task-list", JSON.stringify(tasks));
}

// Init the app
main();