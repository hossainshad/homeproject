<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "database_connection.php";

    $username = $_POST['username'];
    $password = $_POST['pass']; 
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    
    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        echo "<div><h1 style='color: white; position: absolute;top:2%;right:25%'>Username already taken. Please choose a different username.</h1></div>";
    } else {
        
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($result->num_rows > 0) {
            echo "<h1 style='color: white; position: absolute;top:2%;right:25%'>Email already taken. Please choose a different email.</h1>";
        } else {

            $sql = "INSERT INTO users (username, pass, name, email, phone, address) VALUES ('$username', '$password', '$name', '$email', '$phone', '$address')";
            if ($conn->query($sql) === TRUE) {
                header("Location: http://localhost/regdone.html");
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
    width: 300px;
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
  input[type='email'],
  input[type='tel'],
  input[type='password'] {
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
  </style>
</head>

<body>
  <div class="container">
    <form action="register.php" method="POST">
      <h2>Register</h2>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="pass" required />
      </div>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{11}" required>
        <small>Format: 11-digit number</small>
      </div>
      <div class="form-group">
        <button type="submit">Register</button>
      </div>
    </form>
  </div>
</body>

</html>