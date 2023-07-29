<?php
// Checking if the account is authorized.
session_start();
if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header("Location: ../index.html");
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="styles/style.css" />
		<title>nestXchange • Dashboard</title>
	</head>
	<body>
		<!-- Header -->
		<header class="main-header">
			<h1>nestXchange</h1>
			<a href="../account_page/account.php">Account settings</a> •
			<a href="../sign_out.php">Sign out</a> •
			<a href="javascript:search(true)">Wish list</a>
      <div id="user_identifier">
      <?php
       echo $_SESSION['email'] ?>
      </div>
		</header>
    <script src="scripts/wishlist.js"></script>
		
		<!-- Search elements -->
		<div id="search_container">
			<input type="text" id="query" />
			<button id="search">Search</button>
			<button id="clear_search">Clear</button>
			<button type="button" class="accordion-button" onclick="showDropdown();">
				Advanced Filters
			</button>
			<div class="adv-search" style="display: none" id="dropdown">
				<label for="min_price">Price:</label>
				<input type="text" id="min_price" placeholder="min" />
				<input type="text" id="max_price" placeholder="max" /><br />
				<label for="min_bed">Beds:</label>
				<input type="text" id="min_bed" placeholder="min" />
				<input type="text" id="max_bed" placeholder="max" /><br />
				<label for="min_bath">Baths:</label>
				<input type="text" id="min_bath" placeholder="min" />
				<input type="text" id="max_bath" placeholder="max" /><br />
				<label for="min_floor_area">Floor Area (sqft):</label>
				<input type="text" id="min_floor_area" placeholder="min" />
				<input type="text" id="max_floor_area" placeholder="max" /><br />
				<label for="min_lot_area">Lot Area (sqft):</label>
				<input type="text" id="min_lot_area" placeholder="min" />
				<input type="text" id="max_lot_area" placeholder="max" /><br />
			</div>
		</div>
		
		<!-- Listing cards -->
		<div id="listing_cards"></div>
		<script src="scripts/get_listings.js"></script>
		
		<!-- Script for drop-down advanced search -->
		<script>
		function showDropdown() {
			const drop = document.getElementById("dropdown");
			if (drop.style.display === "inline-block") {
			drop.style.display = "none";
			} else {
			drop.style.display = "inline-block";
			}
		}
		</script>
		
		<footer>&copy; 2023 nestXchange</footer>
	</body>
</html>