<?php
require "../common_database.php";
// Get the offset and the number of rows to query.
$offset = $_GET['offset'];
$limit = $_GET['limit'];
$element_ids = [
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

// Store the search query and additional search conditions if any.
$query = $_GET['query'];
// Create a database query.
$sql = "SELECT * FROM Listings " .

// Include the search query if any.
"WHERE (street_address LIKE '%{$query}%'
OR city LIKE '%{$query}%'
OR state_abbrev LIKE '%{$query}%' 
OR zip LIKE '%{$query}%') ";

$column_names = ["price", "bedrooms", "bathrooms", "floor_area", "lot_area"];

// add filters 
for ($i=0; $i < count($element_ids); $i++) { 
    $key = $element_ids[$i];
    $symbol = ($i % 2 === 0)?">=":"<=";
    $col_name = (int) $i / 2;
    if (isset($_GET[$key])) { 
        $sql.= "AND $column_names[$col_name] $symbol '$_GET[$key]' ";
    }
}
// include offset and limit
$sql .= "LIMIT {$offset}, {$limit}";

echo readFromTable($sql, []);
?>
