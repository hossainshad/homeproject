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
$flats_query = "SELECT * FROM flats WHERE f_id = '$f_id'";
$flats_result = mysqli_query($conn, $flats_query);
$flat = mysqli_fetch_assoc($flats_result);
$image_path = $flat['image_path'];
$p_id = $flat['p_id'];
$property_query = "SELECT * FROM properties where p_id = '$p_id'";
$property_result = mysqli_query($conn, $property_query);
$property=mysqli_fetch_assoc($property_result);
$location = $property["location_a"];
$query = "SELECT name FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];


if ($property['lift_status'] == 1) {
    $lift = "yes";
} else {
    $lift = "No";
}

$rental_query = "SELECT * FROM rentals WHERE f_id = '$f_id'";
$rental_result = mysqli_query($conn, $rental_query);


if (mysqli_num_rows($rental_result) > 0) {
  $rental = mysqli_fetch_assoc($rental_result);
  $rental_id = $rental["rental_id"];

  $payment_query = "SELECT payment_month FROM payments WHERE rental_id = '$rental_id' AND payment_month = LPAD(MONTH(CURDATE()), 2, '0')";
  $payment_result = mysqli_query($conn, $payment_query);
  $payment_row = mysqli_fetch_assoc($payment_result);

  $t_username = $rental['t_username'];
  $tenant_query = "SELECT * FROM users WHERE username = '$t_username'";
  $tenant_result = mysqli_query($conn, $tenant_query);
  $tenant = mysqli_fetch_assoc($tenant_result);
  $tenant_name = $tenant['username'];
  $tenant_f_name = $tenant['name'];
  $tenant_phone = $tenant['phone'];
  $rent_amount = $rental['rent_amount'];
  $tenant_email = $tenant['email'];
  $start_date = $rental['st_date'];

  if ($payment_row) {
      $payment_month = $payment_row['payment_month'];


      $rental_info = "<h2>Rented by:</h2>
                      <p>Name: $tenant_f_name</p>
                      <p>Username: $tenant_name</p>
                      <p>Phone: $tenant_phone</p>
                      <p>Email: $tenant_email</p>
                      <p>Rent: $rent_amount</p>
                      <p>Start Date: $start_date</p>
                      <p>Payment Status: <span style='color: green;'>Paid for this month</span></p>
                      <a href='remove_tenant.php?t_username=$t_username&f_id=$f_id&rental_id=$rental_id'><button>Remove Tenant</button></a>";
  } else {
      $rental_info = "<h2>Rented by:</h2>
                      <p>Name: $tenant_f_name</p>
                      <p>Username: $tenant_name</p>
                      <p>Phone: $tenant_phone</p>
                      <p>Email: $tenant_email</p>
                      <p>Rent: $rent_amount</p>
                      <p>Start Date: $start_date</p>
                      <p>Payment Status: <span style='color: red;'>Unpaid</span></p>
                      <a href='remove_tenant.php?t_username=$t_username&f_id=$f_id&rental_id=$rental_id'><button>Remove Tenant</button></a>";
  }

} else {
  $rental_info = "No one is renting this flat.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <link rel="stylesheet" href = "../index/index.css">
    
    
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
      <h2><?php echo "Rent: <span>" . $flat['rent_amount'] . "</span>"; ?></h2>
      <h2><?php echo "Full Address: <span>" . $property['address'] . "</span>"; ?></h2>
      <h2><?php echo "Additional Details: <span>" . $flat['additional_info'] . "</span>"; ?></h2>
         
    </div>
  </div>
    <div class="rental_info;" style="position:absolute; right:50px; top:30px">
        <div class="rental-info">
            <h2><?php echo $rental_info; ?></h2>
        </div>
    </div>
    
</body>
</html>