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
$query = "DELETE FROM rent_requests WHERE f_id = '$f_id' AND t_username = '$t_username'";
$result = mysqli_query($conn, $query);

header("Location: ./rent_req_list.php");
?>