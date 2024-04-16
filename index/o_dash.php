<?php
session_start();
include "../database_connection.php";
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  header("Location: http://homify.locals/login/login.php");
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
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
  </div>
  <a href="../property_enlist/pe_form.php" style="text-decoration: none;">
    <div class="add_property">
      <h3>+ New Property</h3>
    </div>
  </a>
  <div class="main-content">
    <ul class="property-list">
      <h1>Your Properties</h1>
      <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="../flats/flats.php?p_id=' . $row['p_id'] . '" style="text-decoration: none; font-size: larger;">
                <div class="list_i">' . 
                     $row['p_name'] . " - " . 
                     $row['location_a'] . '</div>
                     </a></li>';
            }
        } else {
            echo '<li>No properties found</li>';
        }
      ?>
    </ul>
  </div>
</body>

</html>