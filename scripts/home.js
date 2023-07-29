const slider1 = document.getElementById("slide-1");
const slider2 = document.getElementById("slide-2");
const slider3 = document.getElementById("slide-3");
const slider4 = document.getElementById("slide-4");
const slider5 = document.getElementById("slide-5");

let sliders = [slider1, slider2, slider3, slider4, slider5];
const url = "./top5.php";
//Grabs 5 listings from the database.
fetch(url, {
  headers: {
    "Content-Type": "application/json",
  },
})
  .then((response) => response.json())
  .then((data) => {
    for (let i = 0; i < data.length; i++) {
      fillSlider(data[i]);
    }
  });

//Listing info must be object
function fillSlider(data) {
  let sliderElement = document.getElementById("slide-" + data.id);
  // Add the main image.
  let img = document.createElement("img");
  img.src =
    "https://codd.cs.gsu.edu/~agrizzle3/WP/PW/3/buyer_portal/assets/" +
    data.id +
    "/main.webp";
  img.width = "200px";
  img.id = "home_list_img";
  img.classList.add("home_list_image");

  console.log(img.src);
  sliderElement.appendChild(img);
  let subelement = document.createElement("div");
  subelement.classList.add("text-container");
  // let text = document.createElement("p");
  // // text.innerHTML = <strong>Address: </strong> + listing_info.street_address;
  // sliderElement.appendChild(text);

  // Add the price.
  const price = document.createElement("div");
  price.classList.add("price");
  price.textContent = `$${parseInt(data.price).toLocaleString()}`;
  subelement.appendChild(price);

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
  subelement.appendChild(details);

  // Add the address.
  const address = document.createElement("div");
  address.innerHTML = `${data.street_address}<br>${data.city}, `;
  address.innerHTML += `${data.state_abbrev} ${data.zip}`;
  subelement.appendChild(address);
  sliderElement.appendChild(subelement);
}
