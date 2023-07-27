

function add_error(element,msg){
    let errordiv = document.createElement("div");
    errordiv.classList.add("error");
    errordiv.innerHTML = msg;
    element.insertAdjacentElement("beforebegin", errordiv);
}
//Main Function
function validate(){
    let error = 0;
//Removes all error messages
    let errors = Array.from(document.getElementsByClassName("error"));
    errors.forEach(errorElement => {
        errorElement.remove();
    });

//Grabs information and stores in local variables
var firstname = document.getElementById("firstname");
var lastname = document.getElementById("lastname");
var email = document.getElementById("email");
var pass = document.getElementById("pass");
var pass2 = document.getElementById("pass2");
//Creates an array with all info
const fields = [firstname,lastname,email,pass,pass2];
//Checks each item in array to make sure not empty.
for(let i = 0;i<fields.length;i++){
    /* If length is less than three, it creates a div with the 'error' class
    and adds an error message. It then adds it before the checked input field. */

    if(fields[i].value.length < 3){
        add_error(fields[i],"Field must contain at least 3 characters");
        error = 1;
    }
}
//Checks if passwords are the same
if(confirmpass() == false){
error = 1;
}
//Checks names with regex
const nameRegex = /^[A-Z][a-z]*$/;
//First name
if (!nameRegex.test(firstname.value)) {
    add_error(firstname,"Invalid name format")
}
//Last name
if (!nameRegex.test(lastname.value)) {
    add_error(lastname,"Invalid name format")

}

//Check if errors
if(error){
    return false;
}
}


function confirmpass(){
    let pass = document.getElementById("pass").value;
    let pass2 = document.getElementById("pass2").value; 
    let pass_error = document.getElementById("pass-error");

    if(pass == pass2){
        pass_error.innerHTML = "";
    }
    else{
        pass_error.innerHTML = "Passwords do not match";
        return false;
    }
}

