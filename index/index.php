<?php
session_start();
include "../database_connection.php";
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: http://homify.local/login/login.php");
    exit();
}
$query = "SELECT name FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$fullName = $row['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
  <style>

  </style>
</head>

<body>
  <div class="welcome-message">
    <h2 style="color: white; margin-right: 250px;">Welcome back, <?php echo $username; ?>!</h2>
    <h1 style="color: white; ">HOMIFY</h1>
    <div style="margin-top: 30px; margin-left: 200px">
      <a href="../index/o_dash.php" style="margin-right:20px;" class="button">
        Ownership Dashboard
      </a>
      <a href="../property_enlist/pe_form.php" class="button">
        Tenantship Dashboard
      </a>
    </div>
    <div style= "position: absolute; top:90%;left: 3%">
      <a href="../logout.php" class="button" style="color:red">
        Logout
      </a>
    </div>
  </div>
</body>

</html>