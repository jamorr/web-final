// Open the modal image gallery.
function open_gallery() {
	image_index = 1;
	show_image(image_index);
	document.getElementById("gallery").style.display = "block";
}

// Close the modal image gallery.
function close_gallery() {
	document.getElementById("gallery").style.display = "none";
}

// Go to the next/previous image.
function change_image(n) {
	show_image(image_index += n);
}

function show_image(n) {
	// Initialize variable i.
	var i;
	
	// Get slide elements as an array.
	var image = document.getElementsByClassName("myimage");
	
	// Loop back around if index > or < length
	if (n > image.length) {image_index = 1};
	if (n < 1) {image_index = image.length}
	
	// Set all image other than the ith to display = none.
	for (i = 0; i < image.length; i++) {
		image[i].style.display = "none";
	}
	image[image_index-1].style.display = "block";
}

function get_id(id) {
	listing_id = id;
}

var image_index = 1;
var listing_id;

// Maybe use this code to detect click outside of image/div
// document.getElementById('outer-container').onclick = function(e) {
// 	if(e.target != document.getElementById('content-area')) {
// 		console.log('You clicked outside');
// 	} else {
// 		console.log('You clicked inside');
// 	}
// }