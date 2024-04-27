<?php

session_start();
include "../database_connection.php";
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  header("Location: http://homify.local/login/login.php");
  exit();
}

if (isset($_GET['m_id'])) {
    $m_id = $_GET['m_id'];

    $delete_query = "DELETE FROM maintenance WHERE m_id = $m_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        header("Location: ongoing_maint_req.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>