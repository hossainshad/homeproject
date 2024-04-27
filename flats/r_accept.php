<?php
session_start();
include "../database_connection.php";
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  header("Location: http://homify.local/login/login.php");
  exit();
}

$f_id = $_GET['f_id'];
$t_username = $_GET['t_username'];
$o_username = $_GET['o_username'];
$start_date = $_GET['st_date'];
$message = $_GET['message'];


$query = "UPDATE flats SET status= 'Occupied' WHERE f_id = '$f_id'";
$result = mysqli_query($conn, $query);

$query_users = "UPDATE users SET tenant_f_id= '$f_id', t_flag= 1 WHERE username = '$t_username'";
$result_users = mysqli_query($conn, $query_users);
$query = "DELETE FROM rent_requests WHERE f_id = '$f_id'";
$result = mysqli_query($conn, $query);

$rent_amount_query = "SELECT rent_amount FROM flats WHERE f_id = '$f_id'";
$rent_amount_result = mysqli_query($conn, $rent_amount_query);
$rent_amount_row = mysqli_fetch_assoc($rent_amount_result);
$rent_amount = $rent_amount_row['rent_amount'];


$rental_query = "INSERT INTO rentals (f_id, t_username, st_date, rent_amount, status)
                 VALUES ('$f_id', '$t_username', '$start_date', '$rent_amount', 'active')";
$rental_result = mysqli_query($conn, $rental_query);
$rental_query1 = "DELETE FROM rent_requests WHERE t_username= '$t_username'";
$rental_result1 = mysqli_query($conn, $rental_query1);


$rental_id_q = "SELECT rental_id FROM rentals WHERE f_id = '$f_id' AND t_username = '$t_username' ORDER BY rental_id DESC LIMIT 1";
$rental_id_result = mysqli_query($conn, $rental_id_q);
$rental_id_row = mysqli_fetch_assoc($rental_id_result);
$rental_id = $rental_id_row['rental_id'];




if ($rental_result1) {
  echo "<h1>User: $t_username is now one of your tenants</h1>";
} else {
  echo "Error: " . mysqli_error($conn);
}
?>
