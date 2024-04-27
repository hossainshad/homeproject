<?php
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
$name = $row['name'];

$sql = "SELECT * FROM properties WHERE o_username = '$username'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <div class="side-bar">
    <h2 style="padding:30px; color: white"><?php echo $name; ?></h2>
    <div style= "position: absolute; top:80%;left: 10%">
      <a href="./index.php" style="color:white;">
        <h4>Return to Homepage</h4>
      </a>
    </div>
    <div style= "position: absolute; top:90%;left: 3%">
      <a href="../logout.php" class="button" style="color:red">
        Logout
      </a>
    </div>
    <div style= "position: absolute; top:30%;left: 3%">

      <a href="../flats/rent_req_list.php" class="button" style=" font-size: 18px;">
        See Rent Requests
      </a>
    </div>
  </div>
</body>
</html>
