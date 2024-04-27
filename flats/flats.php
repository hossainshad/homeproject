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

  $sql = "DELETE FROM flats WHERE f_id = '$f_id'";
  if ($conn->query($sql) === TRUE) {
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
  <style>
    .rent-summary {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #f2f2f2;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .rent-summary h2 {
      margin-top: 0;
    }

    .rent-summary p {
      margin: 10px 0;
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
  <a href="./flats_form.php?p_id=<?php echo $p_id; ?>" style="text-decoration: none;">
    <div class="add_property">
      <h3>+ Add Flat</h3>
    </div>
  </a>
  <div class="rent-summary">
    <h2>Rent Summary</h2>
    <?php
    $total_rent_query = "SELECT SUM(rent_amount) AS total_rent FROM flats WHERE p_id = '$p_id' AND status = 'Occupied'";
    $total_rent_result = mysqli_query($conn, $total_rent_query);
    $total_rent_row = mysqli_fetch_assoc($total_rent_result);
    $total_rent_amount = $total_rent_row['total_rent'];
    
    $collected_rent_query = "SELECT SUM(f.rent_amount) AS collected_rent FROM flats f LEFT JOIN rentals r ON f.f_id = r.f_id
                         LEFT JOIN payments p ON r.rental_id = p.rental_id AND p.payment_month = LPAD(MONTH(CURDATE()), 2, '0')
                         WHERE f.p_id = '$p_id' AND p.payment_id IS NOT NULL";
                         
    $collected_rent_result = mysqli_query($conn, $collected_rent_query);
    $collected_rent_row = mysqli_fetch_assoc($collected_rent_result);
    $collected_rent_amount = $collected_rent_row['collected_rent'];
    $due_rent_amount = $total_rent_amount - $collected_rent_amount;
    
    
    echo "<p>Total Rent Amount: TK " . number_format($total_rent_amount, 2) . "</p>";
    echo "<p>Collected Rent Amount: TK " . number_format($collected_rent_amount, 2) . "</p>";
    echo "<p>Due Rent Amount: TK " . number_format($due_rent_amount, 2) . "</p>";
    ?>
  </div>
  <div class="main-content">
    <ul class="property-list">
        <h1>Flats at <?php echo $properties['p_name'] . '(' . $properties['location_a'].')'; ?></h1>
        <?php
        if ($result1->num_rows > 0) {
            echo "<h2>Flats in Property</h2>";
            echo "<ul>";
            while ($row = $result1->fetch_assoc()) {
                $f_id = $row['f_id'];
                $status = $row['status'] == 0 ? "Vacant" : "Occupied";
                $rental_query = "SELECT * FROM rentals WHERE f_id = '$f_id'";
                $rental_result = mysqli_query($conn, $rental_query);
                $rental = mysqli_fetch_assoc($rental_result);
                if ($rental){
                  $rental_id = $rental["rental_id"];
                  $payment_query = "SELECT payment_month FROM payments WHERE rental_id = '$rental_id' AND payment_month = LPAD(MONTH(CURDATE()), 2, '0')";
                  $payment_result = mysqli_query($conn, $payment_query);
                  $payment_row = mysqli_fetch_assoc($payment_result);
                  if ($payment_row) {
                    $payment_status = "Paid";
                  } else {
                    $payment_status = "Unpaid";
                  }

                } else {
                    $payment_status = "";
                }

                echo '<li style="display: flex; align-items: center;">
                        <a href="flat_dashboard.php?f_id=' . $row['f_id'] . '" style="text-decoration: none; font-size: larger;">
                            <div class="list_i">' . $row['flat_num'] . ' : ' . $row['status'] . '</div>
                        </a>
                        <span style="margin-left: 10px;">' . $payment_status . '</span>
                        <a href="delete_flat.php?f_id=' . $row['f_id'] . '&p_id=' . $p_id . '" onclick="return confirm(\'Are you sure you want to delete this flat?\');" style="color: red; text-decoration: none; font-weight: bold; margin-left: 10px;">Delete</a>
                    </li>';
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