class Listing extends HTMLDivElement {
  constructor() {
    super();
    this.classList.add("listing");
  }
  addData(data) {
    // Link the card to the listing page.
    this.addEventListener("click", function () {
      window.location.href = `listing.php?id=${data.id}`;
    });

    // Add the main image.
    const main_image = new Image();
    main_image.src = `assets/${data.id}/main.webp`;
    this.appendChild(main_image);

    // Add the price.
    const price = document.createElement("div");
    price.classList.add("price");
    price.textContent = `$${parseInt(data.price).toLocaleString()}`;
    this.appendChild(price);

    // Add the listing details.
    const details = document.createElement("div");
    const bed = document.createElement("strong");
    bed.textContent = data.bedrooms;
    details.appendChild(bed);
    details.append(" bed\u00A0\u00A0\u00A0");
    const bath = document.createElement("strong");
    bath.textContent = data.bathrooms;
    details.appendChild(bath);
    details.append(" bath\u00A0\u00A0\u00A0");

    // Only add floor/lot area if it is not zero.
    if (data.floor_area !== "0") {
      const floor = document.createElement("strong");
      floor.textContent = parseInt(data.floor_area).toLocaleString();
      details.appendChild(floor);
      details.append(" sqft\u00A0\u00A0\u00A0");
    }
    if (data.lot_area !== "0") {
      const lot = document.createElement("strong");
      // Convert to acres if >= 10000 sqft.
      if (data.lot_area >= 10000) {
        lot.textContent = (parseInt(data.lot_area) / 43560).toLocaleString();
        details.appendChild(lot);
        details.append(" acre lot");
      } else {
        lot.textContent = parseInt(data.floor_area).toLocaleString();
        details.appendChild(lot);
        details.append(" sqft lot");
      }
    }
    this.appendChild(details);

    // Add the address.
    const address = document.createElement("div");
    address.innerHTML = `${data.street_address}<br>${data.city}, `;
    address.innerHTML += `${data.state_abbrev} ${data.zip}`;
    this.appendChild(address);
  }
}

// Load two more rows of listing cards.
function load_listings() {
  // Stop if all rows have already been loaded.
  if (offset >= 30) return;

  // Store the current offset, then move it forward by one row.
  const current_offset = offset;
  offset += limit;

  // Send GET request to PHP file with current offset.
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `read_listings.php?offset=${current_offset}&limit=${limit}${search_terms}`
  );
  xhr.onload = function () {
    // Check the server response.
    if (xhr.status === 200) {
      // Parse the listings data.
      const listings_data = JSON.parse(xhr.responseText);
      if (listings_data.length > 0) {
        // Create a new card for each listing.
        listings_data.forEach((listing) => {
          const card = document.createElement("div", { is: "listing-card" });
          card.addData(listing);
          card_container.appendChild(card);
        });
      }
    }
  };
  xhr.send();
}

// Check if the bottom of the page has been reached.
function check_scroll() {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight)
    load_listings();
}

// Clear the existing listing cards and
function search() {
  search_terms = "";
  if (query.value !== "") search_terms += `&query=${query.value}`;
  if (min_price.value !== "") search_terms += `&min_price=${min_price.value}`;
  if (max_price.value !== "") search_terms += `&max_price=${max_price.value}`;
  if (min_bed.value !== "") search_terms += `&min_bed=${min_bed.value}`;
  if (max_bed.value !== "") search_terms += `&max_bed=${max_bed.value}`;
  if (min_bath.value !== "") search_terms += `&min_bath=${min_bath.value}`;
  if (max_bath.value !== "") search_terms += `&max_bath=${max_bath.value}`;
  if (min_floor_area.value !== "")
    search_terms += `&min_floor_area=${min_floor_area.value}`;
  if (max_floor_area.value !== "")
    search_terms += `&max_floor_area=${max_floor_area.value}`;
  if (min_lot_area.value !== "")
    search_terms += `&min_lot_area=${min_lot_area.value}`;
  if (max_lot_area.value !== "")
    search_terms += `&max_lot_area=${max_lot_area.value}`;
  card_container.innerHTML = "";
  offset = 0;

  // Initially load 3 rows of listing cards.
  load_listings();
  load_listings();
  load_listings();
}

// Set variables for the listing card container and search form elements.
const card_container = document.getElementById("listing_cards");
const query = document.getElementById("query");
const min_price = document.getElementById("min_price");
const max_price = document.getElementById("max_price");
const min_bed = document.getElementById("min_bed");
const max_bed = document.getElementById("max_bed");
const min_bath = document.getElementById("min_bath");
const max_bath = document.getElementById("max_bath");
const min_floor_area = document.getElementById("min_floor_area");
const max_floor_area = document.getElementById("max_floor_area");
const min_lot_area = document.getElementById("min_lot_area");
const max_lot_area = document.getElementById("max_lot_area");

const search_button = document.getElementById("search");
search_button.addEventListener("click", function () {
  search();
});

// Define a custom element "listing-card" from the Listing class.
customElements.define("listing-card", Listing, { extends: "div" });

let offset = 0; // Set the row offset.
const limit = 3; // Set the number of rows to get.
let search_terms = ""; // Optional suffix for GET request URL.

// Add a listener for scroll event.
window.addEventListener("scroll", check_scroll);

// Initially load 3 rows of listing cards.
load_listings();
load_listings();
load_listings();
