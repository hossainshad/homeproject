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
$location = $_GET['location'];
$query = "SELECT name FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$image_path = $_GET['image_path'];

$flats_query = "SELECT * FROM flats WHERE f_id = '$f_id'";
$flats_result = mysqli_query($conn, $flats_query);
$flat = mysqli_fetch_assoc($flats_result);
$rent_amount= $flat["rent_amount"];
$p_id = $flat['p_id'];
$property_query = "SELECT * FROM properties where p_id = '$p_id'";
$property_result = mysqli_query($conn, $property_query);
$property=mysqli_fetch_assoc($property_result);

$o_username = $property["o_username"];

$users_q = "SELECT * FROM users WHERE username = '$o_username'";
$users_result =mysqli_query($conn, $users_q);
$users = mysqli_fetch_assoc($users_result);

$owner_name = $users["name"];
$owner_email = $users["email"];
$owner_phone = $users["phone"];

$owner_info = "<h2>Owner Information:</h2>
                  <p>Name: $owner_name</p>
                  <p>Username: $o_username</p>
                  <p>Phone: $owner_phone</p>
                  <p>Email: $owner_email</p>";


if ($property['lift_status'] == 1) {
    $lift = "yes";
} else {
    $lift = "No";
}
$check_query = "SELECT * FROM rent_requests WHERE f_id = '$f_id' AND t_username = '$username'";
$check_result = mysqli_query($conn, $check_query);
$renting_check_query = "SELECT * FROM rentals WHERE t_username = '$username' AND status = 'active'";
$renting_check_result = mysqli_query($conn, $renting_check_query);

if (mysqli_num_rows($check_result) > 0) {
  $error_message = "You have already sent a request for this flat.";
} elseif (mysqli_num_rows($renting_check_result) > 0) {
  $error_message = "You are already renting a flat.";
} else {
  $error_message = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel= "stylesheet" href = "../index/index.css">
    <style>
      .rental-info {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: left;
        margin-left: 20px;
        border-width: 4px;
        border-color: black;
        }

        .rental-info h2 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        }

        .rental-info p {
        font-size: 16px;
        margin-bottom: 5px;
        }
    </style>
    
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
    <div style= "position: absolute; top:30%;left: 3%">

      <a href="../flats/rent_req_list.php" class="button" style=" font-size: 18px;">
        See Rent Requests
      </a>
    </div>
  </div>
    
  <div class ='f_details'>
    <div>
      <img class= "main_image" src="<?php echo $image_path; ?>" alt="">
    </div>
    <h1><?php echo $flat['sqft'] . ' SQFT flat in ' . $location; ?></h1>
    <div class="details">
      <h2><?php echo "Beds: <span>" . $flat['beds'] . "</span>"; ?></h2>
      <h2><?php echo "Baths: <span>" . $flat['baths'] . "</span>"; ?></h2>
      <h2><?php echo "Floor: <span>" . $flat['floor'] . "</span>"; ?></h2>
      <h2><?php echo "Area(SQFT): <span>" . $flat['sqft'] . "</span>"; ?></h2>
      <h2><?php echo "Lift: <span>" . $lift . "</span>"; ?></h2>
      <h2><?php echo "Full Address: <span>" . $property['address'] . "</span>"; ?></h2>
      <h2><?php echo "Rent(BDT): <span>" . $rent_amount . "</span>"; ?></h2>
      <h2><?php echo "Additional Details: <span>" . $flat['additional_info'] . "</span>"; ?></h2>
      <?php if (!empty($error_message)) { ?>
            <h4 style="color: red;"><?php echo $error_message; ?></h4>
        <?php } else { ?>
            <a href="../flats/rr_form.php?f_id=<?php echo $flat['f_id']; ?>&o_username=<?php echo $property['o_username']; ?>" class="btn" style="position: absolute; top:50%; left:70%">Request Rent</a>
        <?php } ?>
         
    </div>
  </div>
  <div class="rental_info;" style="position:absolute; left:900px; top:30px">
        <div class="rental-info">
            <h2><?php echo $owner_info; ?></h2>
        </div>
    </div>
    
</body>
</html>