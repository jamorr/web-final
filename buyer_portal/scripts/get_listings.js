class Listing extends HTMLDivElement {
  constructor() {
    super();
    this.classList.add("listing");
  }
  addData(data) {
    // Add the main image.
    const main_image = new Image();
    main_image.src = `assets/${data.id}/main.webp`;
    this.appendChild(main_image);

	// Add the wish list button.
	const wl_button = document.createElement("div");
	wl_button.classList.add("wl_button");
	wl_button.addEventListener("click", function () {
		// Add the listing to the wish list here.
		alert("test");
	});
	const wl_icon = new Image();
	wl_icon.src = "assets/star.png"
	wl_button.appendChild(wl_icon);
	this.appendChild(wl_button);
	
	// Link the card to the listing page.
	if (document.querySelector('#elementSelector:hover')) {
		alert('I like it when you touch me!');
	}
    this.addEventListener("click", function (e) {
		if(e.target != wl_button) {}
			window.location.href = `listing.php?id=${data.id}`;
    });

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
  const url = new URL(
    "~agrizzle3/WP/PW/3/buyer_portal/read_listings.php",
    window.location.origin
  );
  url.searchParams.append("offset", current_offset);
  url.searchParams.append("limit", limit);
  if (search_filters) {
    Object.keys(search_filters).forEach((key) => {
      url.searchParams.append(key, search_filters[key]);
    });
  }
  // Send GET request with the constructed URL.
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((listings_data) => {
      if (listings_data.length > 0) {
        // Create a new card for each listing.
        listings_data.forEach((listing) => {
          const card = document.createElement("div", { is: "listing-card" });
          card.addData(listing);
          card_container.appendChild(card);
        });
      }
    })
    .catch((error) => {
      // Handle errors that occurred during fetch
      console.error("Fetch error:", error);
    });
}

// Check if the bottom of the page has been reached.
function check_scroll() {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight)
    load_listings();
}

// Clear the existing listing cards and
function search() {
  search_filters = {};
  element_ids.forEach((element) => {
    const doc = document.getElementById(element);
    if (doc.value !== "") search_filters[element] = doc.value;
  });
  card_container.innerHTML = "";
  offset = 0;

  // Initially load 3 rows of listing cards.
  load_listings();
  load_listings();
  load_listings();
}

// Set variables for the listing card container and search form elements.
const card_container = document.getElementById("listing_cards");
const element_ids = [
  "query",
  "min_price",
  "max_price",
  "min_bed",
  "max_bed",
  "min_bath",
  "max_bath",
  "min_floor_area",
  "max_floor_area",
  "min_lot_area",
  "max_lot_area",
];
let search_filters = {};

const search_button = document.getElementById("search");
search_button.addEventListener("click", function () {
  search();
});

// Define a custom element "listing-card" from the Listing class.
customElements.define("listing-card", Listing, { extends: "div" });

let offset = 0; // Set the row offset.
const limit = 3; // Set the number of rows to get.

// Add a listener for scroll event.
window.addEventListener("scroll", check_scroll);

// Initially load 3 rows of listing cards.
load_listings();
load_listings();
load_listings();