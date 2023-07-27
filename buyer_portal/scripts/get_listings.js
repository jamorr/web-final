class Listing extends HTMLDivElement {
	constructor() {
		super();
		this.classList.add("listing-card");
	}
	addData(data) {
		this.classList = "listing";
		
		// Add the main image.
		const main_image = new Image();
		main_image.src = `images/${data.id}/main.webp`;
		this.appendChild(main_image);
		
		// Add the price.
		const price = document.createElement("div");
		price.classList.add("price");
		price.textContent = "$" + parseInt(data.price).toLocaleString();
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
		if (data.floor_area != "0") {
			const floor = document.createElement("strong");
			floor.textContent = parseInt(data.floor_area).toLocaleString();
			details.appendChild(floor);
			details.append(" sqft\u00A0\u00A0\u00A0");
		}
		if (data.lot_area != "0") {
			const lot = document.createElement("strong");
			lot.textContent = parseInt(data.lot_area).toLocaleString();
			details.appendChild(lot);
			details.append(" sqft lot");
		}
		this.appendChild(details);
		
		// Add the address.
		const address = document.createElement("div");
		address.innerHTML = data.street_address + "<br>" + data.city + ", ";
		address.innerHTML += data.state_abbrev + " " + data.zip;
		this.appendChild(address);
	}
}

// Load two more rows of listing cards.
function load_listings() {
	const xhr = new XMLHttpRequest();
	// Send GET request to PHP file with current offset.
	xhr.open("GET", `listings_data.php?offset=${offset}&limit=${limit}`);
	xhr.onload = function () {
		// Check the server response.
		if (xhr.status === 200) {
			// Parse the listings data.
			const listings_data = JSON.parse(xhr.responseText);
			if (listings_data.length > 0) {
				// Create a new card for each listing.
				listings_data.forEach((listing) => {
					const card = document.createElement('div', { is: "listing-card" });
					card.addData(listing);
					card_container.appendChild(card);
				});
			offset += listings_data.length;
			}
		}
	};
	xhr.send();
}

// Check if the bottom of the page has been reached.
function check_scroll() {
	if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
		load_listings();
	}
}

// Set a variable for the listing card container.
const card_container = document.getElementById("listing_cards");

// Define a custom element "listing-card" from the Listing class.
customElements.define("listing-card", Listing, { extends: "div" });

let offset = 0; // Start at the 0th listing.
const limit = 3; // Set the number of listings to get.

// Add a listener for scroll event.
window.addEventListener('scroll', check_scroll);

// Initially load listings (3 rows or 3).
load_listings();
load_listings();
load_listings();
