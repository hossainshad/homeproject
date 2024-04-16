<?php
session_start();
include "database_connection.php";

// Assuming the username is stored in the session
$o_username = $_SESSION['username'];

// Query to get all properties of the logged-in user
$sql = "SELECT * FROM properties WHERE o_username = '$o_username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Properties</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .property-list {
            list-style-type: none;
            padding: 0;
        }
        .property-list li {
            padding: 10px;
            margin: 5px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
        }
        .property-list li a {
            text-decoration: none;
            color: black;
            display: block;
        }
        .property-list li a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Your Properties</h1>
    <ul class="property-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="property_details.php?p_id=' . $row['p_id'] . '">' . 
                     htmlspecialchars($row['p_name']) . " - " . 
                     htmlspecialchars($row['location_a']) . '</a></li>';
            }
        } else {
            echo '<li>No properties found</li>';
        }
        ?>
    </ul>
</body>
</html>