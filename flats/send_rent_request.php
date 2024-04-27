<?php
session_start();
include "../database_connection.php";

if (isset($_SESSION['username'])) {
    $tenant_username = $_SESSION['username'];
    $f_id = $_POST['f_id'];
    $owner_username = $_POST['o_username'];
    $start_date = $_POST['start_date'];
    $message = $_POST['message'];

    $check_query = "SELECT * FROM rent_requests WHERE f_id = '$f_id' AND t_username = '$tenant_username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<h1>You have already sent a request for this flat.</h1>";
    } else {
        $query = "INSERT INTO rent_requests (f_id, t_username, o_username, st_date, message) VALUES ('$f_id', '$tenant_username', '$owner_username', '$start_date', '$message')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            
            header("Location: http://homify.local/index/index.php");
            exit();
        } else {
            echo "Error sending rent request: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: http://homify.local/login/login.php");
    exit();
}
?>