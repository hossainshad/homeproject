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
    <link rel="stylesheet" href="index.css">
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
    <h1>Maintenance Requests</h1>
    <ul class="maintenance-requests">
        <?php
        $request_query = "SELECT
                            m.m_id,
                            m.o_username,
                            m.t_username,
                            m.status,
                            m.maintenance_desc,
                            m.f_id,
                            f.flat_num,
                            f.sqft,
                            f.beds,
                            f.baths,
                            f.floor,
                            p.p_name,
                            p.location_a,
                            u.username AS tenant_name
                        FROM
                            maintenance m
                        JOIN
                            flats f ON m.f_id = f.f_id
                        JOIN
                            properties p ON f.p_id = p.p_id
                        JOIN
                            users u ON m.t_username = u.username
                        WHERE
                            m.o_username = '$username'";
        $request_result = mysqli_query($conn, $request_query);

        if ($request_result->num_rows > 0) {
            while ($request = $request_result->fetch_assoc()) {
                echo '<li>
                        <div class="cardrr">
                            <div class="rr">
                                <p>From: ' . $request['tenant_name'] . '</p>
                                <p>For Property: ' . $request['p_name'] . '</p>
                                <p>Flat (' . $request['flat_num'] . '): ' . $request['sqft'] . ' sqft, ' . $request['beds'] . ' beds, ' . $request['baths'] . ' baths, Floor ' . $request['floor'] . '</p>
                                <p>Location: ' . $request['location_a'] . '</p>
                                <p>Maintenance Description: ' . $request['maintenance_desc'] . '</p>
                                <p>Status: ' . $request['status'] . '</p>
                
                            </div>
                        </div>
                    </li>';
            }
        } else {
            echo '<li>No maintenance requests found.</li>';
        }
        ?>
    </ul>
</body>