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
$name = $row['name'];

$sql = "SELECT * FROM properties WHERE o_username = '$username'";
$result = $conn->query($sql);
$sql_u = "SELECT t_flag, tenant_f_id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql_u);
$row = mysqli_fetch_assoc($result);
$t_flag = $row['t_flag'];
$tenant_f_id = $row['tenant_f_id'];

if (is_null($tenant_f_id)) {
    $tenant_message = "You are not a tenant yet.";
    $owner_info = "";
    $payment_status = "";
    $show_payment_div = false;
} else {
    $rentals_q = "SELECT * FROM rentals WHERE f_id = '$tenant_f_id'";
    $rentals_result = mysqli_query($conn, $rentals_q);
    $rentals = mysqli_fetch_assoc($rentals_result);
    $rental_id = $rentals['rental_id'];
    $payment_query = "SELECT payment_month FROM payments WHERE rental_id = '$rental_id' AND payment_month = LPAD(MONTH(CURDATE()), 2, '0')";
    $payment_result = mysqli_query($conn, $payment_query);
    $payment_row = mysqli_fetch_assoc($payment_result);
    if ($payment_row) {
        $payment_month = $payment_row['payment_month'];
        $payment_status = "<p>Payment status: <span style='color: green;'>Paid for this month</span></p>";
    } else {
        $payment_status = "<p>Payment status: <span style='color: red;'>Unpaid for this month</span></p>";
    }

    $sql = "SELECT f.*, p.address
            FROM flats f
            JOIN properties p ON f.p_id = p.p_id
            WHERE f.f_id = '$tenant_f_id'";

    $sql_result = mysqli_query($conn, $sql);
    $flat = mysqli_fetch_assoc($sql_result);
    $p_id = $flat["p_id"];
    $image_path = $flat["image_path"];
    
    $rent_amount = $flat["rent_amount"];

    $property_query = "SELECT * FROM properties where p_id = '$p_id'";
    $property_result = mysqli_query($conn, $property_query);
    $property = mysqli_fetch_assoc($property_result);
    $o_username = $property["o_username"];
    $location = $property["location_a"];

    $owner_q = "SELECT * FROM users where username = '$o_username'";
    $owner_result = mysqli_query($conn, $owner_q);
    $owner = mysqli_fetch_assoc($owner_result);
    $owner_name = $owner["name"];
    $owner_email = $owner["email"];
    $owner_phone = $owner["phone"];

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

    $show_payment_div = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
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
        <div style= "position: absolute; top:25%;left: 3%">
            <a href="ongoing_maint_req.php" style="color:white;">
                <h4>Pending Maintenance Requests</h4>
            </a>
        </div>
        
  </div>
    <?php if (is_null($tenant_f_id)) { ?>
        <h1 style="position:relative;left : 500px"><?php echo $tenant_message; ?></h1>
    <?php } else { ?>
        <div class='f_details'>
            <div>
                <img class="main_image" src="<?php echo $image_path; ?>" alt="">
            </div>
            <h1><?php echo $flat['sqft'] . ' SQFT flat in ' . $location; ?></h1>
            <div class="details">
                <h2><?php echo "Beds: <span>" . $flat['beds'] . "</span>"; ?></h2>
                <h2><?php echo "Baths: <span>" . $flat['baths'] . "</span>"; ?></h2>
                <h2><?php echo "Floor: <span>" . $flat['floor'] . "</span>"; ?></h2>
                <h2><?php echo "Area(SQFT): <span>" . $flat['sqft'] . "</span>"; ?></h2>
                <h2><?php echo "Lift: <span>" . $lift . "</span>"; ?></h2>
                <h2><?php echo "Full Address: <span>" . $flat['address'] . "</span>"; ?></h2>
                <h2><?php echo "Rent(BDT): <span>" . $rent_amount . "</span>"; ?></h2>
                <h2><?php echo "Additional Details: <span>" . $flat['additional_info'] . "</span>"; ?></h2>
            </div>
        </div>
        <div class="rental_info" style="position:absolute; left:900px; top:300px">
            <div class="rental-info">
                <h2>Maintenance Request</h2>
                <form action="submit_maintenance_req.php" method="post">
                    <input type="hidden" name="tenant_f_id" value="<?php echo $tenant_f_id; ?>">
                    <input type="hidden" name="o_username" value="<?php echo $o_username; ?>">
                    <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
                    <textarea name="maintenance_message" rows="3" cols="25" placeholder="Describe your issue..."></textarea><br>
                    <button type="submit" class="btn">Request Maintenance</button>
                </form>
            </div>
        </div>

    <?php } ?>
    <div class="rental_info;" style="position:absolute; left:900px; top:30px">
        <div class="rental-info">
            <h2><?php echo $owner_info; ?></h2>
        </div>
    </div>
    <?php if ($show_payment_div) { ?>
        <div class="rental_info;" style="position:absolute; left:900px; top:500px">
            <div class="rental-info">
                <h2>Payment</h2>
                <h2> <?php echo $payment_status; ?> </h2>

                <a href="payment_box.php"><button class= "btn">Make payment</button></a>

            </div>
        </div>
    <?php } ?>
</body>
</html>