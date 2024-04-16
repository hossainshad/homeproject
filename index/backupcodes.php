
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    $sql = "SELECT * FROM flats WHERE p_id = '$p_id'";
    $result = $conn->query($sql);
} else {
    echo "Property ID not Found.";
}

<h1>Flats in the <?php echo $properties['p_name'] . " - " . $properties['location_a']; ?></h1>
<h1>Flats in the <?php echo $properties['p_name'] . '-' . $properties['location_a']; ?></h1>