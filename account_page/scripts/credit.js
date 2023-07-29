"use strict";
const cc_info = document.getElementById("card-info");
const per_info = document.getElementById("personal-info");
const cc_n = document.getElementById("cc-num-in");
const card_logo = document.getElementById("card-logo");
const form = document.getElementById("cc-info-form");
const same_check = document.getElementById("same");
const billing = document.getElementById("cc-billing");
const address = document.getElementById("address");
/**
 * Get the credit card company based on first 2 digits of IIN
 * @param {number} ident - Identifying digits of IIN
 */
function parseIIN(ident) {
  if (ident === 34 || ident === 37) {
    return "amex";
  } else if (ident >= 40 && ident < 50) {
    return "visa";
  } else if (ident >= 50 && ident < 56) {
    return "master";
  } else {
    return false;
  }
}
/**
 * toggle the billing address input box
 */
function toggleBilling() {
  if (billing.disabled) {
    billing.disabled = false;
    billing.add;
  } else {
    billing.disabled = true;
  }
}

/**
 * set the credit card logo image
 */
function setCCLogo(e) {
  const ident = parseInt(e.target.value.slice(0, 2));
  const parsed = parseIIN(ident);
  let image;
  if (parsed === false) {
    image = "";
  } else {
    image = `url(./assets/${parsed}.png)`;
  }
  card_logo.style.backgroundImage = image;
}
/**
 * Check that the expiration date is after current date
 *  and entered month is valid
 */
function checkExpiration() {
  const exp_yr = document.getElementsByName("cc_exp_YY");
  const exp_m = document.getElementsByName("cc_exp_MM");
  if (exp_yr === null || exp_m === null) {
    return;
  }
  const today = new Date();
  const year = parseInt(today.getFullYear().toString().slice(2, 4));
  const month = today.getMonth();
  const exp_m_int = parseInt(exp_m[0].value);
  const exp_y_int = parseInt(exp_yr[0].value);
  // check month is valid
  if (exp_m_int > 12 || exp_m_int < 1) {
    return false;
  }
  // check that date is after current date
  if (exp_y_int > year) {
    return true;
  } else if (exp_y_int === year && exp_m_int >= month) {
    return true;
  }
  return false;
}

/**
 * Parse the phone number input
 */
function parsePhone() {
  let phone = document.getElementsByName("cc_phone");
  if (phone === null) {
    return false;
  }
  phone = phone[0].value;
  const number = phone.match(/^[0-9]{10}$/);
  if (number === null) {
    return false;
  }
  return number[0];
}

/**
 * Validate credit card info form and submit if valid
 */
function validateCCInfo() {
  //TODO:replace console.log() with some highlighting of invalid fields
  const phone = parsePhone();
  if (!phone) {
    return;
  }

  const valid_date = checkExpiration();
  if (!valid_date) {
    console.log("invalid cc date");
    return false;
  }

  // check main address
  let address = document.getElementsByName("cc_addr")[0];
  if (address === null) {
    console.log("no elements with cc-addr name");
    return false;
  }
  address = address.value.match(/^[0-9a-zA-Z.\-\s]+$/);
  if (address === null) {
    console.log("Invalid address string");
    return false;
  }
  // check billing address
  if (billing.disabled === true) {
    billing.value = address;
  }
  const bill_addr = billing.value.match(/^[0-9a-zA-Z.\-\s]+$/);
  if (bill_addr === null) {
    return false;
  }

  let name = document.getElementsByName("cc_name")[0];
  if (name === null) {
    console.log("no elements with cc-name name");
    return false;
  }
  name = name.value.match(/^[a-zA-Z\s.\-,']+$/);

  if (name === null) {
    console.log("invalid name string");
    return false;
  }
  return true;
}

function showCreditModal() {
  const modal = document.getElementById("popup");
  modal.style.display = "block";
}

function hideCreditModal() {
  const modal = document.getElementById("popup");
  modal.style.display = "none";
}

cc_n.addEventListener("input", setCCLogo);
same_check.addEventListener("change", (_) => {
  toggleBilling();
});
form.addEventListener("submit", (e) => {
  e.preventDefault();
  if (validateCCInfo()) {
    // form.submit();
    // const form = e.target;
    const formData = new FormData(form); // Create a FormData object to store form data
    formData.set("cc_billing_addr", billing.value);
    const url = "./card-submit.php";

    // Using fetch API
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
          });
        }
        return response.text();
      })
      .then((data) => {
        // Handle the successful response from the server if needed
        console.log("Server response:", data);
      })
      .catch((error) => {
        // Handle any other errors that may occur during the fetch request
        console.error("Fetch error:", error);
      });
  }
});
