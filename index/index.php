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
if (isset($_GET['search'])) {
  $location = isset($_GET['location_a']) ? $_GET['location_a'] : '';
  $minRent = isset($_GET['min_rent']) ? $_GET['min_rent'] : '';
  $maxRent = isset($_GET['max_rent']) ? $_GET['max_rent'] : '';
  $minSqft = isset($_GET['min_sqft']) ? $_GET['min_sqft'] : '';
  $maxSqft = isset($_GET['max_sqft']) ? $_GET['max_sqft'] : '';

  
  $flats_query = "SELECT f.*, p.location_a FROM flats f 
                  INNER JOIN properties p ON f.p_id = p.p_id 
                  WHERE p.o_username <> '$username' AND f.status = 'Vacant'";

  if (!empty($location)) {
      $flats_query .= " AND p.location_a = '$location'";
  }
  
  if (!empty($minRent)) {
      $flats_query .= " AND f.rent_amount >= $minRent";
  }

  if (!empty($maxRent)) {
      $flats_query .= " AND f.rent_amount <= $maxRent";
  }

  if (!empty($minSqft)) {
      $flats_query .= " AND f.sqft >= $minSqft";
  }

  if (!empty($maxSqft)) {
      $flats_query .= " AND f.sqft <= $maxSqft";
  }
} else {
  
  $flats_query = "SELECT f.*, p.location_a FROM flats f 
                  INNER JOIN properties p ON f.p_id = p.p_id 
                  WHERE p.o_username <> '$username' AND f.status = 'Vacant'";
}

$flats_result = mysqli_query($conn, $flats_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
  <style>
    .search-bar {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    
    .search-bar form {
        display: flex;
        align-items: center;
    }

    .search-bar label {
        font-weight: bold;
        margin-right: 10px;
    }

    .search-bar select,
    .search-bar input[type="number"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .search-bar input[type="submit"] {
        background-color: #222222;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-bar input[type="submit"]:hover {
        background-color: #45a049;
    }

    
    @media (max-width: 768px) {
        .search-bar form {
            flex-wrap: wrap;
        }

        .search-bar label,
        .search-bar select,
        .search-bar input[type="number"],
        .search-bar input[type="submit"] {
            margin-bottom: 10px;
        }
    }

  </style>
</head>

<body>
  <div class="welcome-message">
    <h2 style="color: white; margin-right: 250px;">Welcome back, <?php echo $username; ?>!</h2>
    <h1 style="color: white; ">HOMIFY</h1>
    <div style="margin-top: 30px; margin-left: 200px">
      <a href="../index/o_dash.php" style="margin-right:20px;" class="button">
        Owners Dashboard
      </a>
      <a href="t_dash.php" class="button">
        Tenant Dashboard
      </a>
    </div>
    <div style= "position: relative; top:13px;left: 1%">
      <a href="../logout.php" class="button" style="color:red">
        Logout
      </a>
    </div>
  </div>
  <div class="search-bar">
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="location_a">Location:</label>
        <select id="location_a" name="location_a">
            <option value="">All</option>
            <option value="Dhanmondi">Dhanmondi</option>
            <option value="Gulshan">Gulshan</option>
            <option value="Banani">Banani</option>
            <option value="Mirpur">Mirpur</option>
            <option value="Uttara">Uttara</option>
        </select>

        <label for="min_rent">Min Rent:</label>
        <input type="number" id="min_rent" name="min_rent" min="0">

        <label for="max_rent">Max Rent:</label>
        <input type="number" id="max_rent" name="max_rent" min="0">

        <label for="min_sqft">Min Sqft:</label>
        <input type="number" id="min_sqft" name="min_sqft" min="0">

        <label for="max_sqft">Max Sqft:</label>
        <input type="number" id="max_sqft" name="max_sqft" min="0">

        <input type="submit" name="search" value="Search">
    </form>
  </div>
  <main style= "padding-left:70px;">
      <?php while ($flat = mysqli_fetch_assoc($flats_result)) : 
        $property_query = "SELECT location_a FROM properties WHERE p_id = '" . $flat['p_id'] . "'";
        $property_result = mysqli_query($conn, $property_query);
        $property_data = mysqli_fetch_assoc($property_result);
        $location = $property_data['location_a'];?>
        <div class="card">
          <?php if (!empty($flat['image_path'])): ?>
            <img src="<?php echo $flat['image_path']; ?>" alt="Flat Image">
          <?php else: ?>
            <img src="placeholder.jpg" alt="Flat Image">
          <?php endif; ?>
          <div class="card-content">
            <h3><?php echo $flat['sqft'] . ' SQFT flat in ' . $location; ?></h3>
            <h4><?php echo "Rent (BDT): " . $flat['rent_amount'] . "/month"; ?></h4>
            <h4><?php echo "Beds: " . $flat['beds'] . "  Baths: " . $flat['baths']; ?></h4>
            <a href="../flats/flat_details.php?f_id=<?php echo $flat['f_id']; ?>&image_path=<?php echo $flat['image_path']; ?>&location=<?php echo $location; ?>" class="btn">View Details</a>
          </div>
        </div>
        <?php endwhile; ?>
  </main>
</body>

</html>