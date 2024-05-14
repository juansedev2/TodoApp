"use strict";
function validateEmail(input){
    let regex = /[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?/i;
    return regex.test(input);
}

function validatePassword(input){
    let regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    return regex.test(input);
}

function validateInputs(email, password){
    return validateEmail(email) && validatePassword(password);
}

function main(){
    const form = document.getElementById("login-form");
    form.addEventListener("submit", (event) => {
        const email = document.getElementById("exampleInputEmail1").value;
        const password = document.getElementById("exampleInputPassword1").value;
        const result = validateInputs(email, password);
        if(!result){
            event.preventDefault();
        }
    });
}

main();
