function get_wishlist () {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; wishlist=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
}

console.log(JSON.parse(get_wishlist()));

function set_wishlist(id) {
	
}