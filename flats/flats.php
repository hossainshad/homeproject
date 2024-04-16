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
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    $sql = "SELECT * FROM flats WHERE p_id = '$p_id'";
    $result1 = $conn->query($sql);
} else {
    echo "Property ID not Found.";
}
$query = "SELECT * FROM properties WHERE p_id = '$p_id'";
$result = mysqli_query($conn, $query);
$properties = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../index/index.css">
</head>
<body>
  <div class="side-bar">
    <h2 style="padding:30px; color: white"><?php echo $name; ?></h2>
    <div style= "position: absolute; top:80%;left: 10%">
      <a href="../index/index.php" style="color:white;">
        <h4>Return to Homepage</h4>
      </a>
    </div>
    <div style= "position: absolute; top:90%;left: 3%">
      <a href="../logout.php" class="button" style="color:red">
        Logout
      </a>
    </div>
  </div>
  <a href="./flats_form.php?p_id=<?php echo $p_id; ?>" style="text-decoration: none;">
    <div class="add_property">
      <h3>+ Add Flat</h3>
    </div>
  </a>
  <div class="main-content">
    <ul class="property-list">
        <h1>Flats at <?php echo $properties['p_name'] . '(' . $properties['location_a'].')'; ?></h1>
        <?php
        if ($result1->num_rows > 0) {
            echo "<h2>Flats in Property</h2>";
            echo "<ul>";
            while ($row = $result1->fetch_assoc()) {
                $status = $row['status'] == 0 ? "Vacant" : "Occupied";
                echo '<li><a href="flat_details.php?f_id=' . $row['f_id'] . '" style="text-decoration: none; font-size: larger;">
                <div class="list_i">' . 
                    $row['flat_num']  . ' : ' . $row['status'] .'</div></a></li>';
            }
            echo "</ul>";
        } else {
            echo "<h3>No flats found for this property.</h3>";
        }
        ?>
    </ul>
  </div>
</body>

</html>