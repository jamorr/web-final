// Function to add an error message to the DOM for a given input element
function add_error(element, msg) {
    // Create a new <div> element for the error message
    let errordiv = document.createElement("div");
    // Add the "error" class to the <div> to style it appropriately
    errordiv.classList.add("error");
    // Set the innerHTML of the <div> to the error message provided
    errordiv.innerHTML = msg;
    // Insert the error <div> before the specified input element in the DOM
    element.insertAdjacentElement("beforebegin", errordiv);
}

// Function to validate the form inputs
function validate(){
    // Log a message to indicate that the validation function is called
    console.log("Validation function called.");

    // Clear existing errors (remove all elements with class "error" from the DOM)
    let error = 0;
    let errors = Array.from(document.getElementsByClassName("error"));
    errors.forEach(errorElement => {
        errorElement.remove();
    });

    // Get references to the email and password input elements
    var email = document.getElementById("email");
    var pass = document.getElementById("pass");
    
    // Create an array containing the input elements for easier iteration
    const fields = [email, pass];

    // Loop through each input element and check for validation errors
    fields.forEach(input => {
        // Check if the input's value length is less than 3 characters
        if (input.value.length < 3) {
            // If the input's value length is less than 3, add an error message
            add_error(input, "Field must contain at least three characters!");
            // Set the error variable to 1 to indicate the presence of errors
            error = 1;
        }
    });

    // Check if any errors were found during validation
    if (error) {
        // Return false to prevent the form submission
        return false;
    }

    return;

}
