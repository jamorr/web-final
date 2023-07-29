// Function to add an error message to the DOM for a given input element
function add_error(element, msg) {
  // Create a new <div> element for the error message
  const errordiv = document.createElement("div");
  // Add the "error" class to the <div> to style it appropriately
  errordiv.classList.add("error");
  // Set the innerHTML of the <div> to the error message provided
  errordiv.innerHTML = msg;
  // Insert the error <div> before the specified input element in the DOM
  element.insertAdjacentElement("beforebegin", errordiv);
}

// Function to validate the form inputs
function validatelogin() {
  // Log a message to indicate that the validation function is called
  console.log("Validation function called.");

  // Clear existing errors (remove all elements with class "error" from the DOM)
  let error = 0;
  const errors = Array.from(document.getElementsByClassName("error"));
  errors.forEach((errorElement) => {
    errorElement.remove();
  });

  // Get references to the email and password input elements
  const l_email = document.getElementById("l_email");
  const l_pass = document.getElementById("l_pass");

  // Create an array containing the input elements for easier iteration
  const fields = [l_email, l_pass];

  // Loop through each input element and check for validation errors
  fields.forEach((input) => {
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

  return true;
}

const l_email = document.getElementById("l_email");
const loginform = document.getElementById("login-form");
loginform.addEventListener("submit", (e) => {
  e.preventDefault();
  if (!validatelogin()) {
    return;
  }
  const formData = new FormData(loginform);
  const url = "login-auth.php";
  fetch(url, {
    method: "POST",
    body: formData,
  })
  .then((response) => {
    if (!response.ok) {
      // If the response status code indicates an error (e.g., 500), handle the error
      return response.json().then((data) => {
        console.error("Error:", data.error);
        // You can log the error or display it to the user as needed
        // For example, show an error message to the user:
        // showErrorToUser(data.error);
        return Promise.reject(data.error); // Return a rejected Promise to trigger the catch block
      });
    }
    return response.text();
  })
  .then((data) => {
    if(data == "Success"){
      window.location.href = './buyer_portal/buyer_dash.html';
    }
      console.log("Server response:", data);
      // data = JSON.parse(data);
    // Handle the successful response from the server if needed
    if(!data["success"]){
      add_error(l_email,String(data["error"]));
    }
    else{
      showTab("login");

    }
  })
});
