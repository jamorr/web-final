const user_email = document.getElementById("user_identifier").innerText;

// Get the wish list cookie as an array of listing ids.
function get_wishlist() {
  const cookie_obj = document.cookie.split("; ").reduce((prev, current) => {
    const [name, ...value] = current.split("=");
    prev[name] = value.join("=");
    return prev;
  }, {});
  const cookie_str = JSON.stringify(cookie_obj);
  console.log(cookie_obj);

  return JSON.parse(decodeURI(cookie_obj[user_email]));
}

// Add or remove the listing id to the wish list cookie.
function set_wishlist(raw_id) {
  const id = parseInt(raw_id);
  const wish_list = get_wishlist();
  console.log(wish_list);
  if (wish_list.includes(id)) wish_list.splice(wish_list.indexOf(id), 1);
  else wish_list.push(id);
  const encoded_list = encodeURIComponent(JSON.stringify(wish_list));
  const date = new Date();
  date.setTime(date.getTime() + 1000000);
  const expires = `; expires=${date.toUTCString()}`;
  document.cookie = `${user_email}=${encoded_list}${expires}; path=/`;
}

// Change the appearance of the wish list button on the listing page.
function set_button() {
  const button = document.getElementById("lc_wish_list");
  if (button.classList.contains("active")) {
    button.classList.remove("active");
    button.innerHTML = "<img src='assets/star.png'><br>Add to wish list";
  } else {
    button.classList.add("active");
    button.innerHTML = "<img src='assets/star.png'><br>Remove from wish list";
  }
}

// Initially set the appearance of the wish list button on the listing page.
function initialize_button(raw_id) {
  const id = parseInt(raw_id);
  const wish_list = get_wishlist();
  if (wish_list.includes(id)) set_button();
}

// Change the appearance of the wish list button on the listing card.
function set_card_button(button) {
  if (button.classList.contains("wl_active")) {
    button.classList.remove("wl_active");
  } else {
    button.classList.add("wl_active");
  }
}

// Initially set the appearance of the wish list button on the listing cards.
function initialize_card_button(raw_id) {
  const id = parseInt(raw_id);
  const wish_list = get_wishlist();
  if (wish_list.includes(id)) return true;
  else return false;
}
