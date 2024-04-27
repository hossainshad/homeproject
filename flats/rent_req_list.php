<?php
session_start();
include "../database_connection.php";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../index/index.css">
    <style>
        .rr{
            padding-left: 10px;
        }
        .cardrr {
            display: inline-block;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
            width: 500px;
            margin: 20px;
            background-color: #222222;
        }
        .rr p{
            color: white;
            font-size: 20px;
        }
        .button2{
            background-color: white;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.2s;
        }
        .button2:hover{
            background-color: #45a049;
        }
        .button1{
            background-color: white;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.2s;
        }
        .button1:hover{
            background-color: red;
        }
    </style>
</head>
<body>
    <h1>Rent Requests</h1>
    <ul class="rent-requests">
        <?php
        $request_query = "SELECT rr.o_username,rr.st_date,rr.message, rr.request_id,f.f_id, rr.request_date,f.flat_num, rr.status, f.sqft, f.beds, p.p_name, f.baths, f.floor, p.location_a, u.username AS t_username
        FROM rent_requests rr
        JOIN flats f ON rr.f_id = f.f_id
        JOIN properties p ON f.p_id = p.p_id
        JOIN users u ON rr.t_username = u.username
        WHERE rr.o_username = '$username'";
        $request_result = mysqli_query($conn, $request_query);

        if ($request_result->num_rows > 0) {
            while ($request = $request_result->fetch_assoc()) {
                echo '<li>
                        <div class = "cardrr">
                            <div class= "rr">
                                <p>From: ' . $request['t_username'] . '</p>
                                <p>For Property: ' . $request['p_name'] . '</p>
                                <p>Flat ('. $request['flat_num'] .'): ' . $request['sqft'] . ' sqft, ' . $request['beds'] . ' beds, ' . $request['baths'] . ' baths, Floor ' . $request['floor'] . '</p>
                                <p>Location: ' . $request['location_a'] . '</p>
                                <p>Request Date: ' . $request['request_date'] . '</p>
                                <p>From: ('. $request['st_date'] . '</p>
                                <p>Message: ' . $request['message'] . '</p>
                                <p>Status: ' . $request['status'] . '</p>
                                <div style= "display: inline-block; position: relative; left:260px; bottom: 30px">
                                    <a class="button2" href="r_accept.php?f_id=' . $request['f_id'] . '&t_username=' . $request['t_username'] . '&st_date=' . $request['st_date'] . '&message=' . $request['message'] . '&o_username=' . $request['o_username'] .'">Accept</a>
                                    <a class="button1" href="r_reject.php?f_id=' . $request['f_id'] . '&t_username=' . $request['t_username'] . '">Reject</a>
                                </div>
                            </div>
                        </div>
                      </li>';
        }
        } else {
            echo '<li>No rent requests found.</li>';
        }
        ?>
    </ul>
    
</body>
</html>