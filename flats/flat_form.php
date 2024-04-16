<?php
session_start();
include "../database_connection.php";
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
} else {
    echo "Error: Property ID (p_id) not found in the URL.";
    exit(); 
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $flat_num = $_POST['flat_num'];
        $beds = $_POST['beds'];
        $baths = $_POST['baths'];
        $sqft = $_POST['sqft'];
        $floor = $_POST['floor'];
        $additional_info = $_POST['additional_info'];
        $sql = "INSERT INTO flats (p_id, flat_num, beds, baths, sqft,floor, additional_info) VALUES ('$p_id', '$flat_num', '$beds', '$baths', '$sqft','$floor','$additional_info')";
    

        if ($conn->query($sql) === TRUE) {
            $flat_id = $conn->insert_id; // Get the inserted flat's ID
            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads//' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
                // Update the flat's image path
                $sql_update_image = "UPDATE flats SET image_path = '$image_path' WHERE f_id = $flat_id";
                $conn->query($sql_update_image);
            }
            if (isset($_FILES['additional_images']) && is_array($_FILES['additional_images']['tmp_name'])) {
                foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
                    $filename = $_FILES['additional_images']['name'][$key];
                    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads//' . basename($filename);
                    move_uploaded_file($tmp_name, $image_path);
            
                    $sql_insert_image = "INSERT INTO flat_images (f_id, a_image_path) VALUES ($flat_id, '$image_path')";
                    $conn->query($sql_insert_image);
                }
            }

            $sql_update = "UPDATE properties SET total_flats = total_flats + 1 WHERE p_id = '$p_id'";
            if ($conn->query($sql_update) === TRUE) {

                header("Location: http://homify.local/flats/flats.php?p_id=$p_id");
            } else {
                echo "Error updating user data: " . $conn->error;
            }
            
        } else {
            echo "Error inserting flat: " . $conn->error;
        }
    }
} else {
  header("Location: http://homify.local/login/login.php");
      exit();
  }
?>

