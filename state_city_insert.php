<?php
require_once "db.php";

/* INSERT STATE */
if(isset($_POST['save_state'])){

    $state_name = mysqli_real_escape_string($conn, $_POST['state_name']);
    $state_code = mysqli_real_escape_string($conn, $_POST['state_code']);

    $insert_state = "INSERT INTO state (state_name, state_code)
                     VALUES ('$state_name', '$state_code')";

    if(mysqli_query($conn, $insert_state)){
        echo "<script>alert('State Added Successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

/* INSERT CITY */
if(isset($_POST['save_city'])){

    $state_id  = $_POST['state_id'];
    $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);

    $insert_city = "INSERT INTO city (state_id, city_name)
                    VALUES ('$state_id', '$city_name')";

    if(mysqli_query($conn, $insert_city)){
        echo "<script>alert('City Added Successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>State & City Master</title>
</head>
<body>

<h2>Add State</h2>
<form method="POST">
    <label>State Name:</label><br>
    <input type="text" name="state_name" required><br><br>

    <label>State Code:</label><br>
    <input type="text" name="state_code"><br><br>

    <button type="submit" name="save_state">Save State</button>
</form>

<hr>

<h2>Add City</h2>
<form method="POST">
    <label>Select State:</label><br>
    <select name="state_id" required>
        <option value="">Select State</option>
        <?php
        $state_query = mysqli_query($conn, "SELECT * FROM state ORDER BY state_name ASC");
        while($row = mysqli_fetch_assoc($state_query)){
            echo "<option value='".$row['state_id']."'>".$row['state_name']."</option>";
        }
        ?>
    </select><br><br>

    <label>City Name:</label><br>
    <input type="text" name="city_name" required><br><br>

    <button type="submit" name="save_city">Save City</button>
</form>

</body>
</html>