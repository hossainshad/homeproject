<?php
// Assuming database connection is established in 'database_connection.php'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "database_connection.php";

    $username = $_POST['username'];
    $password = $_POST['pass']; // Consider hashing the password before storing
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if username exists
    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        echo "<h1>Username already taken. Please choose a different username.</h1>";
    } else {
        // Check if email exists
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($result->num_rows > 0) {
            echo "<h1>Email already taken. Please choose a different email.</h1>";
        } else {
            // Insert the new user
            $sql = "INSERT INTO users (username, pass, name, email, phone, address) VALUES ('$username', '$password', '$name', '$email', '$phone', '$address')";
            if ($conn->query($sql) === TRUE) {
                header("Location: http://localhost/homeproject/regdone.html");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration Form</title>
  <link rel="stylesheet" href="./style.css" />
</head>

<body>
  <form class="formContainer" action="register.php" method="POST">
    <div class="formInput">
      <span>Select a username: </span>
      <input type="text" name="username" required />
    </div>
    <div class="formInput">
      <span>Create a Password: </span>
      <input type="password" name="pass" required />
    </div>
    <div class="formInput">
      <span>Full Name: </span>
      <input type="text" name="name" required />
    </div>
    <div class="formInput">
      <span>Address: </span>
      <input type="text" name="address" required />
    </div>
    <div class="formInput">
      <span>Email: </span>
      <input type="email" name="email" required />
    </div>
    <div class="formInput">
      <span>Phone: </span>
      <input type="tel" name="phone" required />
    </div>
    <input type="submit" value="Register" />
  </form>
</body>

</html>