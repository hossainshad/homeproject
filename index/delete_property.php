<?php
session_start();
include "../database_connection.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: http://homify.local/login/login.php");
    exit();
}

if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    $delete_flats_query = "DELETE FROM flats WHERE p_id = '$p_id'";
    $sql2 = "UPDATE users SET p_enlisted = p_enlisted - 1 WHERE username = '$username'";
    if ($conn->query($delete_flats_query) === TRUE) {
            $delete_property_query = "DELETE FROM properties WHERE p_id = '$p_id'";
            if ($conn->query($delete_property_query) === TRUE && $conn->query($sql2) === TRUE) {
                echo "Property deleted successfully.";
            } else {
                echo "Error deleting property: " . $conn->error;
            }
    } else {
        echo "Error deleting flats: " . $conn->error;
    }

    $redirect_url = "Location: o_dash.php";
    header($redirect_url);
    exit();
} else {
    echo "No property ID provided.";
}
?>