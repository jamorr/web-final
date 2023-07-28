<!DOCTYPE html>
<html lang="en">
	<head>
	<?php
	// Checking if the account is authorized.
	session_start();
	if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
		header("Location: ../index.html");
	}
	?>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <style>
      .accordion-button {
        text-align: left;
        color: #fff !important;
        background-color: #616161 !important;
        display: block;
        user-select: none;
        width: 100%;
        border: none;
        padding: 8px 16px;
        overflow: hidden;
        --webkit-appearance: button;
        text-decoration: none;
        cursor: pointer;
        text-transform: none;
        white-space: nowrap;
        margin-top: 20px;
        border-style: none;
      }
      .accordion-button:hover {
        color: #000 !important;
        background-color: #ccc !important;
      }
      .adv-search {
        padding: 1rem;
        color: #000 !important;
        border: 1px solid #ccc !important;
      }
      .adv-search label,
      input {
        margin-top: 20px;
        margin-bottom: 20px;
      }
      .adv-search label {
        display: inline-block;
        min-width: 10rem;
        text-align: right;
      }
    </style>
    <title>nestXchange • Dashboard</title>
  </head>
  <body>
	<header class="main-header">
		<h1>nestXchange</h1>
		<a href="../account_page/account.html">Account settings</a>
	</header>
    <h1>Buyer Dashboard</h1>

    <!-- Search elements -->
    <div id="search_container">
      <label for="query">Search:</label>
      <input type="text" id="query" />
      <button id="search">Search</button>

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
    <script>
      function showDropdown() {
        const drop = document.getElementById("dropdown");
        if (drop.style.display === "block") {
          drop.style.display = "none";
        } else {
          drop.style.display = "block";
        }
      }
    </script>
	
	<footer>&copy; 2023 nestXchange</footer>
  </body>
</html>