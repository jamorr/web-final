let slides = [];
var slide_index;

// Add "slides" to the modal image gallery.
function get_images(id) {
	const gallery_content = document.getElementById("gallery_content");
	let i;
	for (i = 1; i <= 11; i++) {
		let image_name;
		if (i == 1) image_name = "main";
		else image_name = (i - 1);
		const slide = document.createElement("div");
		slide.classList.add("slide");
		const image_number = document.createElement("div");
		image_number.textContent = `${i} / 11`;
		const image = document.createElement("img");
		image.src = `assets/${id}/${image_name}.webp`;
		slide.appendChild(image_number);
		slide.appendChild(image);
		gallery_content.appendChild(slide);
		slides.push(slide);
	}
}

// Open the modal image gallery.
function open_gallery() {
	slide_index = 0;
	show_slide();
	document.getElementById("gallery").style.display = "block";
}

// Close the modal image gallery.
function close_gallery() {
	document.getElementById("gallery").style.display = "none";
}

// Go to the next/previous image.
function change_image(n) {
	show_slide(slide_index += n);
}

function show_slide() {
	// Loop back around if index > or < length
	if (slide_index > 10) slide_index = 0;
	if (slide_index < 0) slide_index = 10;
	
	// Set all image other than the ith to display = none.
	let i;
	for (i = 0; i < 11; i++) slides[i].style.display = "none";
	slides[slide_index].style.display = "block";
}

document.getElementById("gallery").onclick = function(e) {
	if(e.target == document.getElementById("gallery"))
		close_gallery();
}
