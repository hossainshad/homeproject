<?php
session_start();
include "../database_connection.php";
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  header("Location: http://homify.local/login/login.php");
  exit();
}
if (isset($_GET['f_id']) && isset($_GET['p_id'])) {
  $f_id = $_GET['f_id'];
  $p_id = $_GET['p_id'];

  $sql1 = "DELETE FROM flats WHERE f_id = '$f_id'";
  $sql2 = "UPDATE properties SET total_flats = total_flats - 1 WHERE p_id = '$p_id'";
  
  if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
      echo "Flat deleted successfully.";
  } else {
      echo "Error deleting flat: " . $conn->error;
  }


  $redirect_url = "Location: flats.php?p_id=" . $p_id;
  header($redirect_url);
  exit();
} else {
  echo "No flat ID or property ID provided.";
}
?>