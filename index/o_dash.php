<?php
session_start();
include "../database_connection.php";
$username = $_SESSION['username'];
$query = "SELECT name FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <div class="side-bar">
    <h2 style="color: white; padding:30px; "><?php echo $name?></h2>
  </div>
  <a href="../property_enlist/pe_form.php">
    <div class="add_property">
      <h3 style="color: white;">
        +New Property
      </h3>
    </div>
  </a>
</body>

</html>