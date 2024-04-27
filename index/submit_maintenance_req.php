<?php
session_start();
include "../database_connection.php";

if (isset($_SESSION['username'])) {
    $tenant_username = $_SESSION['username'];
    $message = $_POST['maintenance_message'];
    $f_id = $_POST['tenant_f_id'];
    $p_id = $_POST['p_id'];
    $o_username = $_POST['o_username'];
    $maintenance_desc = $_POST['maintenance_message'];


}
$query = "INSERT INTO maintenance (o_username, t_username, status, maintenance_desc, f_id) VALUES ('$o_username', '$tenant_username','Pending', '$maintenance_desc', '$f_id')";
$result = mysqli_query($conn, $query);
header("Location: http://homify.local/index/t_dash.php");

?>