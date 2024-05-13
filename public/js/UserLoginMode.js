"use strict";
/**
 * This function is the main of the app, int the script calling the necessary functions
*/
function main(){
    addEventsDeleteTasksButtons();
}

/**
 * This function add the click events to the delete buttons of the cards of the task
*/
function addEventsDeleteTasksButtons(){
    let delete_task_buttons = document.querySelectorAll("button.delete-task-button");
    delete_task_buttons.forEach( button => {
        button.addEventListener("click", (event) => {
            // Get the confirm-delete-button to assign the value
            console.log(event.target.value);
            let id_task_input_button = document.getElementById("id_task_input_button");
            id_task_input_button.value = event.target.value;
        });
    });
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
// Init the app
main();