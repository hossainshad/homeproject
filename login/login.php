<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../database_connection.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username' AND
    pass='$password'";
    
    $result = $conn->query($sql);

    if ($result->num_rows >0){
      $_SESSION['username'] = $username;
      header("Location: ../index/index.php");
      exit();
    }
    else {
      echo "<h1 style='color: white; position: absolute;top:10%;right:35%'>Invalid Username or Password</h1>";
    }


}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
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
</head>

<body>
  <div class="container">
    <form action="login.php" method="POST">
      <h2>Homify</h2>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
      </div>
      <div class="form-group">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
</body>