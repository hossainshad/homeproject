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
$o_username = $_GET['o_username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Request Form</title>
    <link rel="stylesheet" href="../index/index.css">
    <style>

    body {
        background-color: #222222; 
        color: Black;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    
    .form-container {
        background-color: white; 
        padding: 20px;
        margin: 0 auto;
        max-width: 500px;
        border-radius: 8px; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    }

    
    form {
        margin: 0;
        padding: 20px;
    }

    
    label {
        display: block;
        margin-bottom: 10px;
        margin-top: 20px;
        color: #222222; 
    }


    input[type=date],
    textarea,
    input[type=submit] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #222222;
        box-sizing: border-box;
    }

    /* Styling for the submit button */
    input[type=submit] {
        background-color: #222222;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type=submit]:hover {
        background-color: #333333;
    }

    /* Adjust the first label to have less margin-top */
    form label:first-of-type {
        margin-top: 0;
    }

    </style>
</head>
<body>
    <div class="form-container">
        <h1>Rent Request Form</h1>
        <form action="send_rent_request.php" method="POST">
            <input type="hidden" name="f_id" value="<?php echo $f_id; ?>">
            <input type="hidden" name="o_username" value="<?php echo $o_username; ?>">
            
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
            
            
            <label for="message">Message:</label>
            <textarea name="message" id="message"></textarea>
            
            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>