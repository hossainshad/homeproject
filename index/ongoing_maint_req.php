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
    <h1>Ongoing Maintenance Requests</h1>
    <ul class="maintenance_requests">
        <?php
        $request_query = "SELECT
                            m.m_id,
                            m.o_username,
                            m.t_username,
                            m.status,
                            m.maintenance_desc,
                            m.f_id,
                            f.flat_num,
                            p.p_name,
                            p.location_a
                        FROM
                            maintenance m
                        JOIN
                            flats f ON m.f_id = f.f_id
                        JOIN
                            properties p ON f.p_id = p.p_id
                        WHERE
                            m.t_username = '$username'";
        $request_result = mysqli_query($conn, $request_query);

        if ($request_result->num_rows > 0) {
            while ($request = $request_result->fetch_assoc()) {
                echo '<li>
                        <div class="cardrr">
                            <div class="rr">
                                <p>For Property: ' . $request['p_name'] . '</p>
                                <p>Flat: ' . $request['flat_num'] . '</p>
                                <p>Location: ' . $request['location_a'] . '</p>
                                <p>Maintenance Description: ' . $request['maintenance_desc'] . '</p>
                                <p>Status: ' . $request['status'] . '</p>
                                <a  class="button2" style="position: relative; left:260px; bottom: 30px" href="resolve_request.php?m_id=' . $request['m_id'] . '">Issue Resolved</a>
                            </div>
                        </div>
                    </li>';
            }
        } else {
            echo '<li>No ongoing maintenance requests found.</li>';
        }
        ?>
    </ul>
</body>
</html>