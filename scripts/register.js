// Function to add an error message
function add_error(element, msg) {
    let errordiv = document.createElement("div");
    errordiv.classList.add("error");
    errordiv.innerHTML = msg;
    element.insertAdjacentElement("beforebegin", errordiv);
}
const form = document.getElementById("form");
// Main Validation Function
function validate() {
    let error = 0; // Variable to track if there are any errors

    // Removes all existing error messages from the DOM
    let errors = Array.from(document.getElementsByClassName("error"));
    errors.forEach(errorElement => {
        errorElement.remove();
    });

    // Grabs information and stores it in local variables
    var firstname = document.getElementById("firstname");
    var lastname = document.getElementById("lastname");
    var email = document.getElementById("email");
    var pass = document.getElementById("pass");
    var pass2 = document.getElementById("pass2");

    // Creates an array with all input fields
    const fields = [firstname, lastname, email, pass, pass2];

    // Checks each item in the array to make sure it meets character requirement.
    for (let i = 0; i < fields.length; i++) {
        if (fields[i].value.length < 3) {
            // If the length is less than three, it creates an error message.
            add_error(fields[i], "Field must contain at least 3 characters");
            error = 1; // Set the error flag to indicate there's an error.
        }
    }

    // Checks if passwords are the same using the confirmpass() function.
    if (confirmpass() == false) {
        error = 1; // Set the error flag to indicate there's an error.
    }

    // Checks names with a regular expression (Regex)
    const nameRegex = /^[A-Z][a-z]*$/;

    // Validates the first name using the regex
    if (!nameRegex.test(firstname.value)) {
        add_error(firstname, "Invalid name format");
        error = 1; // Set the error flag to indicate there's an error.
    }

    // Validates the last name using the regex
    if (!nameRegex.test(lastname.value)) {
        add_error(lastname, "Invalid name format");
        error = 1; // Set the error flag to indicate there's an error.
    }

    // Check if there are any errors
    if (error) {
        return false; // Validation failed, prevent form submission.
    }

    //If everything's good, start submission using fetch
    const url = "./register-submit.php";
    let formdata  = new FormData(form);
    fetch(url,{
        method:"POST",

    }

    )
}

// Function to confirm if passwords match
function confirmpass() {
    let pass = document.getElementById("pass").value;
    let pass2 = document.getElementById("pass2").value; 
    let pass_error = document.getElementById("pass-error");

    if (pass == pass2) {
        // If passwords match, clear the error message.
        pass_error.innerHTML = "";
        return true; // Return true to indicate passwords match.
    } else {
        // If passwords don't match, display an error message.
        pass_error.innerHTML = "Passwords do not match";
        return false; // Return false to indicate passwords don't match.
    }
}
