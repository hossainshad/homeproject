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

$sql_u = "SELECT t_flag, tenant_f_id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql_u);
$row = mysqli_fetch_assoc($result);
$t_flag = $row['t_flag'];
$tenant_f_id = $row['tenant_f_id'];
$sql_r = "SELECT * FROM rentals WHERE t_username = '$username'";
$result_r = mysqli_query($conn, $sql_r);
$rentals= mysqli_fetch_assoc($result_r);
$rent_amount= $rentals["rent_amount"];
$rental_id = $rentals["rental_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href= "index.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4; /* light gray background */
            font-family: Arial, sans-serif; /* Setting a default font */
        }

        .payment-box {
            width: 350px; /* Fixed width */
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* subtle shadow */
            background-color: white; /* white background */
            border-radius: 8px; /* rounded corners */
            text-align: center; /* Center-align text */
        }

        .payment-box form {
            display: flex;
            flex-direction: column; 
        }

        .payment-box input[type="date"],
        .payment-box input[type="submit"] {
            padding: 10px;
            margin-top: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }

        .payment-box input[type="submit"] {
            background-color: #222222; 
            color: white; 
            cursor: pointer; 
        }

        .payment-box input[type="submit"]:hover {
            background-color: #45a049;
        }

        .payment-box label {
            text-align: left; 
            margin-bottom: 5px; 
        }
    </style>

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
    <div class="payment-box">
        <h2>Payments</h2>
        <h3>Amount(BDT): <?php echo $rent_amount?>/=</h3>
        <form method="post" action="make_payment.php">
            <label>Select Month and Year:</label>
            <select name="payment_month" required>
                <option value="">Select Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select name="payment_year">
                <option value="2024">2024</option>
            </select>
            <input type="hidden" name="rent_amount" value="<?php echo $rent_amount; ?>">
            <input type="hidden" name="rental_id" value="<?php echo $rental_id; ?>">
            <input type="submit" name="make_payment" value="Make Payment">
        </form>
    </div>
</body>
</html>