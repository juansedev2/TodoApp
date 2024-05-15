"use strict";
function validateEmail(input){
    let regex = /[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?/i;
    return regex.test(input);
}

function validatePassword(input){
    let regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    return regex.test(input);
}

function validateName(name){
    return name.length <= 20 && name.length != 0;
}

function validateLastName(last_name){
    return last_name.length <= 20 && last_name.length != 0;
}

function validatePasswords(password1, password2){
    return password1 === password2;
}

function validateInputs(email, password){
    return validateEmail(email) && validatePassword(password);
}

function addChangeEvents(){
    
    const name_input = document.getElementById("name");
    const last_name_input = document.getElementById("last-name");
    const email = document.getElementById("email");
    const password1 = document.getElementById("inputPassword");
    const password2 = document.getElementById("inputPassword2");

    name_input.addEventListener("change", (event) => {
        const text = event.target.value;
        const result = validateName(text);
        const nameHelpBlock = document.getElementById("nameHelpBlock");
        if(result){
            nameHelpBlock.innerText = ""
            nameHelpBlock.className = "";
            name_validation = true;
        }else{
            nameHelpBlock.className = "text-danger";
            nameHelpBlock.innerText = "El nombre no puede estar vacio ni superar los 20 caracteres"
            name_validation = false;
        }
    });

    last_name_input.addEventListener("change", (event) => {
        const text = event.target.value;
        const result = validateLastName(text);
        const nameHelpBlock = document.getElementById("lastnameHelpBlock");
        if(result){
            nameHelpBlock.innerText = ""
            nameHelpBlock.className = "";
            last_name_validation = true;
        }else{
            nameHelpBlock.className = "text-danger";
            nameHelpBlock.innerText = "El apellido no puede estar vacio ni superar los 20 caracteres"
            last_name_validation = false;
        }
    });

    email.addEventListener("change", (event) => {
        const text = event.target.value;
        const result = validateEmail(text);
        const nameHelpBlock = document.getElementById("EmailHelpBlock");
        if(result){
            nameHelpBlock.innerText = ""
            nameHelpBlock.className = "";
            email_validation = true;
        }else{
            nameHelpBlock.className = "text-danger";
            nameHelpBlock.innerText = "El formato de correo electrónico no es válido"
            email_validation = false;
        }
    });

    password1.addEventListener("change", (event) => {
        const text = event.target.value;
        const result = validatePassword(text);
        const nameHelpBlock = document.getElementById("passwordHelpBlock");
        if(result){
            nameHelpBlock.innerText = ""
            nameHelpBlock.className = "";
            password1_validation = true;
        }else{
            nameHelpBlock.className = "text-danger";
            nameHelpBlock.innerText = "Su contraseña debe tener entre 8 y 20 caracteres, contener letras y números, y no debe contener espacios, caracteres especiales ni emoji."
            password1_validation = false;
        }
    });

    password2.addEventListener("change", (event) => {
        const text = event.target.value;
        const result = validatePassword(text);
        const nameHelpBlock = document.getElementById("passwordHelpBlock2");
        if(result){
            nameHelpBlock.innerText = ""
            nameHelpBlock.className = "";
            password2_validation = true;
        }else{
            nameHelpBlock.className = "text-danger";
            nameHelpBlock.innerText = "Su contraseña debe tener entre 8 y 20 caracteres, contener letras y números, y no debe contener espacios, caracteres especiales ni emoji."
            password2_validation = false;
        }
    });

}

function main(){

    addChangeEvents();   

    const form = document.getElementById("register-form");

    form.addEventListener("submit", (event) => {
        // Re-validate data
        let name_input = document.getElementById("name").value;
        let last_name_input = document.getElementById("last-name").value;
        let email = document.getElementById("email").value;
        let password1 = document.getElementById("inputPassword").value;
        let password2 = document.getElementById("inputPassword2").value;

        name_input = validateName(name_input);
        last_name_input = validateLastName(last_name_input);
        email = validateEmail(email);
        let passwords = validatePasswords(password1, password2);
        password1 = validatePassword(password1);
        password2 = validatePassword(password2);
        

        if(!(name_input && last_name_input && email && passwords && password1 && password2)){
            event.preventDefault();
            alert("DATOS INCOMPLETOS");
        }else{
            const password1 = document.getElementById("inputPassword").value;
            const password2 = document.getElementById("inputPassword2").value;
            if(!validatePassword(password1, password2)){
                const nameHelpBlock1 = document.getElementById("passwordHelpBlock");
                const nameHelpBlock2 = document.getElementById("passwordHelpBlock2");
                nameHelpBlock1.className = "text-danger";
                nameHelpBlock1.innerText = "Su contraseña debe tener entre 8 y 20 caracteres, contener letras y números, y no debe contener espacios, caracteres especiales ni emoji."
                nameHelpBlock2.className = "text-danger";
                nameHelpBlock2.innerText = "Su contraseña debe tener entre 8 y 20 caracteres, contener letras y números, y no debe contener espacios, caracteres especiales ni emoji."
                event.preventDefault();
            }else{
                const nameHelpBlock1 = document.getElementById("passwordHelpBlock");
                const nameHelpBlock2 = document.getElementById("passwordHelpBlock2");
                nameHelpBlock1.className = "";
                nameHelpBlock1.innerText = ""
                nameHelpBlock2.className = "";
                nameHelpBlock2.innerText = ""
            }
        }
        
    });
}

    // Vars to final validation
    let name_validation = false;
    let last_name_validation = false;
    let email_validation = false;
    let password1_validation = false;
    let password2_validation = false;

main();



