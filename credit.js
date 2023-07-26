"use strict";
const cc_info = document.getElementById("card-info");
const per_info = document.getElementById("personal-info");
const cc_n = document.getElementById("cc-num-in");
const card_logo = document.getElementById("card-logo");

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
 * Check that the expiration date is after current date
 *  and entered month is valid
 */
function checkExpiration() {
  const exp_yr = document.getElementsByName("cc-exp-YY");
  const exp_m = document.getElementsByName("cc-exp-MM");
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
  let phone = document.getElementsByName("cc-phone");
  if (phone === null) {
    return false;
  }
  phone = phone[0].value;
  const number = phone.match(/[0-9]{10}/);
  if (number === null) {
    return false;
  }
  console.log(number);
  return number[0];
}

/**
 * Validate credit card info form and submit if valid
 */
function validateCCInfo() {
  const phone = parsePhone();
  if (!phone) {
    return;
  }

  const valid_date = checkExpiration();
  if (!valid_date) {
    console.log("invalid cc date");
    return;
  }
  let address = document.getElementsByName("cc-addr");
  address = parseAddr(address);
}

cc_n.addEventListener("input", setCCLogo);
