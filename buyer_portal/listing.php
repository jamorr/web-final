<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/style.css">
		<title>Listing Details</title>
		<script src="scripts/lightbox.js"></script>
		<?php require_once 'read_listing_details.php';?>
	</head>
	<body>
		
		<!-- Modal image gallery -->
		<div id="gallery" class="modal">
			<span class="close" onclick="close_gallery()">&times;</span>
			<div class="modal-content">
				<div class="mySlides">
					<div class="numbertext">1 / 4</div>
					<img src="assets/<?= $listing["id"] ?>/1.webp" style="width:100%">
				</div>
				<!-- Next/previous controls -->
				<a class="prev" onclick="change_image(-1)">&#10094;</a>
				<a class="next" onclick="change_image(1)">&#10095;</a>
			</div>
		</div>
		
		
		<!-- Listing details -->
		<div id="listing_details">
			<img src="assets/<?= $listing["id"] ?>/main.webp" onclick="open_gallery()">
		</div>
		<div>
			<?= file_get_contents("assets/descriptions/" . $listing["id"] . ".txt") ?>
		</div>
	</body>
</html>

<!-- Array
(
    [id] => 29
    [street_address] => 4665 Riverview Rd
    [city] => Atlanta
    [state_abbrev] => GA
    [zip] => 30327
    [price] => 46800000
    [bedrooms] => 7
    [bathrooms] => 8.5
    [floor_area] => 0
    [lot_area] => 808038
    [year_built] => 1995
    [date_listed] => 2023-02-05
) -->
