<?php
session_start();
include "../database_connection.php";
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
} else {
    echo "Error: Property ID (p_id) not found in the URL.";
    exit(); 
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
  header("Location: http://homify.local/login/login.php");
      exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration Form</title>
  <link rel="stylesheet" href="./style.css" />
  <style>
  body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
    background-color: black;
  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }

  form {
    width: 400px;
    padding: 20px;
    border: 1px solid gray;
    border-radius: 5px;
    border-width: 3px;
    background-color: white;
    padding-right: 40px;
  }

  h2 {
    text-align: center;
  }

  .form-group {
    margin-bottom: 15px;
  }

  label {
    display: block;
    font-weight: bold;
  }

  input[type='text'],
  select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #282828;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
  }

  
  button:hover {
    background-color: #8AC44B;
  }
  </style>
</head>

<body>
  <div class="container">
    <form action="flat_form.php?p_id=<?php echo $p_id; ?>" enctype="multipart/form-data" method="POST">
      <h2>Insert Flat Details</h2>
      <div class="form-group">
        <label for="flat_num">Flat Number:</label>
        <input type="text" id="flat_num" name="flat_num" required />
      </div>
      <div class="form-group">
        <label for="beds">Number of Beds:</label>
        <input type="text" id="beds" pattern="[1-9]*" maxlength="4" name="beds" required />
      </div>
      <div class="form-group">
        <label for="baths">Number of baths:</label>
        <input type="text" id="baths" pattern="[1-9]*" maxlength="4" name="baths" required />
      </div>
      <div class="form-group">
        <label for="sqft">Flat total area(SquareFeet):</label>
        <input type="text" id="sqft" pattern="[0-9]*" maxlength="9" name="sqft" required />
      </div>
      <div class="form-group">
        <label for="rent_amount">Rent (per month):</label>
        <input type="text" id="rent_amount" pattern="[0-9]*" maxlength="9" name="rent_amount" required />
      </div>
      <div class="form-group">
        <label for="floor">Floor Number:</label>
        <input type="text" id="floor" pattern="[1-9]*" maxlength="9" name="floor" required />
      </div>
      <div class="form-group">
        <label for="additional_info">Additional info (Dining,Drawing, kitchen,etc)</label>
        <input type="text" id="additional_info" name="additional_info" required />
      </div>
      <div style="padding-bottom:10px">
        <h4>Primary Image:</h4>
        <input type="file" name="image" required>
        
      </div>
      <div class="form-group">
        <button type="submit">Add this property</button>
      </div>
    </form>
  </div>
</body>

</html>