<?php
// Checking if the account is authorized.
session_start();
if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header("Location: ../index.html");
}
require_once 'read_listing_details.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles/style.css">
        <title>nestXchange • <?php echo $listing["street_address"] ?></title>
    </head>
    <body>
        
        <!-- Header -->
        <header class="main-header">
            <h1>nestXchange</h1>
            <a href="../account_page/account.">Account settings</a> •
            <a href="">Wish list</a>
            <div id="user_identifier">
              <?php
                echo $_SESSION['email'] 
                ?>
            </div>
        </header>
        
        <script src="scripts/wishlist.js"></script>
        <!-- Main listing image and details -->
        <div id="listing_details">
            <img src="assets/<?php echo $listing["id"] ?>/main.webp" onclick="open_gallery()">
            <div id="ld_text">
                <div id="ld_price">$<?php echo number_format($listing["price"]) ?></div>
                <div><span><?php echo $listing["bedrooms"] ?></span> bed</div>
                <div><span><?php echo $listing["bathrooms"] ?></span> bath</div>
                <?php if ($listing["floor_area"] != 0) {
                    echo "<div><span>" . number_format($listing["floor_area"]) .
                        "</span> sqft</div>\n";
                } ?>
                <?php if ($listing["lot_area"] > 10000) {
                    echo "<div><span>" . number_format(($listing["lot_area"] / 43560), 2) .
                        "</span> acre lot</div>\n";
                } elseif ($listing["lot_area"] != 0) {
                    echo "<div><span>" . number_format($listing["lot_area"]) .
                    "</span> sqft lot</div>\n";
                } ?>
                <div id="ld_address">
                    <?php echo $listing["street_address"] ?><br>
                    <?php echo $listing["city"] ?>, <?php echo $listing["state_abbrev"] ?> <?php echo $listing["zip"] ?> 
                </div>
            </div>
            <div id="back_button" onclick="history.back()">
                &larr; Back to dashboard
            </div>
        </div>
        
        <!-- Additional details and wish list button -->
        <div id="lc_desc_title"><h2>Listing overview</h2></div>
        <div id="listing_content">
            <div id="lc_desc">
                <div id="lc_desc_fade"></div>
                <div id="lc_desc_text">
                    <br><?php echo file_get_contents("assets/descriptions/" . $listing["id"] . ".txt") ?> 
                    <br><br>
                </div>
            </div>
            <div id="lc_facts">
                <img src="assets/home.png"><br>
                Built in <?php echo $listing["year_built"] ?><br>
                <img src="assets/calendar.png"><br>
                Listed for <?php echo
                round((time() - strtotime($listing["date_listed"])) / 86400); ?> days
            </div>
            <div id="lc_wish_list" onclick="set_wishlist(<?php echo $listing['id'] ?>); set_button()";>
                <img src="assets/star.png"><br>
                Add to wish list
            </div>
            <script>initialize_button(<?php echo $listing["id"] ?>)</script>
        </div>
        
        <!-- Modal image gallery -->
        <div id="gallery">
            <span id="close" onclick="close_gallery()">&times;</span>
            <div id="gallery_content">
                <a id="prev" onclick="change_image(-1)">&#10094;</a>
                <a id="next" onclick="change_image(1)">&#10095;</a>
            </div>
        </div>
        <script src="scripts/lightbox.js"></script>
        <script>get_images(<?php echo $listing["id"] ?>)</script>
        
        <footer>&copy; 2023 nestXchange</footer>
    </body>
</html>
