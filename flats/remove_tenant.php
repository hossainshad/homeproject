<?php
session_start();
include "../database_connection.php";

if (isset($_GET['t_username']) && isset($_GET['f_id']) && isset($_GET['rental_id'])) {
    $t_username = $_GET['t_username'];
    $f_id = $_GET['f_id'];
    $rental_id = $_GET['rental_id'];
    $delete_payments_query = "DELETE FROM payments WHERE rental_id = '$rental_id'";
    mysqli_query($conn, $delete_payments_query);
    $delete_rental_query = "DELETE FROM rentals WHERE rental_id = '$rental_id'";
    mysqli_query($conn, $delete_rental_query);

    $update_user_query = "UPDATE users SET t_flag = 0, tenant_f_id = NULL WHERE username = '$t_username'";
    mysqli_query($conn, $update_user_query);
    $update_flat_query = "UPDATE flats SET status = 'Vacant' WHERE f_id = '$f_id'";
    mysqli_query($conn, $update_flat_query);
    header("Location: flat_dashboard.php?f_id=$f_id");
    exit();
} else {
    header("Location: flat_dashboard.php?f_id=$f_id");
    exit();
}
?>