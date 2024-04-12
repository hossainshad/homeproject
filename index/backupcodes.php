<?php
if($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
} else {
    $name = "User not found";
}
?>