<?php
session_start();
include "../database_connection.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $payment_month = $_POST['payment_month'];
    $rent_amount = $_POST['rent_amount'];
    $rental_id = $_POST['rental_id'];
    $payment_year = $_POST['payment_year'];

    $current_date = date('Y-m-d');


    $check_payment_query = "SELECT COUNT(*) AS payment_exists FROM payments WHERE rental_id = '$rental_id' AND payment_month = '$payment_month'";
    $check_payment_result = mysqli_query($conn, $check_payment_query);
    $check_payment_row = mysqli_fetch_assoc($check_payment_result);
    $payment_exists = $check_payment_row['payment_exists'];

    if ($payment_exists > 0) {
        echo '<h1>You have already paid for this month.</h1>';
        exit();
    } else {
        $insert_payment_query = "INSERT INTO payments (rental_id, amount, payment_month,payment_year,paid_date) VALUES ('$rental_id', '$rent_amount', '$payment_month','$payment_year',$current_date)";
        mysqli_query($conn, $insert_payment_query);

        header("Location: t_dash.php?success=payment_made");
        exit();
    }
} else {
    header("Location: tenant_dashboard.php?error=invalid_request");
    exit();
}
?>