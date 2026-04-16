<?php
require_once "db.php";

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST['save_unit'])){

    $unit_name  = mysqli_real_escape_string($conn, $_POST['unit_name']);
    $unit_value = mysqli_real_escape_string($conn, $_POST['unit_value']);

    if(!empty($unit_name) && !empty($unit_value)){

        // Prevent duplicate unit
        $check = mysqli_query($conn, "SELECT * FROM unit_master WHERE unit_name='$unit_name'");
        if(mysqli_num_rows($check) > 0){
            echo "<script>alert('Unit Already Exists');</script>";
        } else {

            $insert = "INSERT INTO unit_master (unit_name, unit_value)
                       VALUES ('$unit_name', '$unit_value')";

            if(mysqli_query($conn, $insert)){
                echo "<script>alert('Unit Saved Successfully');</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }

    } else {
        echo "<script>alert('All Fields Required');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Unit Creation</title>

<style>
body{
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#1f2d3d;
}

.container{
    width:600px;
    margin:60px auto;
    background:#f2f2f2;
    padding:25px;
    border-radius:6px;
}

.title{
    text-align:center;
    background:red;
    color:#fff;
    padding:5px 15px;
    display:inline-block;
    border-radius:15px;
    margin:0 auto 20px auto;
}

.form-group{
    margin-bottom:20px;
}

label{
    background:#1d4ed8;
    color:#fff;
    padding:3px 10px;
    border-radius:10px;
    font-size:13px;
}

input{
    width:100%;
    padding:8px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:4px;
}

.button-area{
    background:#e5e5e5;
    padding:20px;
    text-align:center;
    border-radius:4px;
}

button{
    padding:8px 25px;
    background:#16a34a;
    color:#fff;
    border:none;
    border-radius:4px;
    cursor:pointer;
}

button:hover{
    background:#138a3c;
}
</style>

</head>
<body>

<div class="container">

    <div style="text-align:center;">
        <span class="title">Unit Creation</span>
    </div>

    <form method="POST">

        <div class="form-group">
            <label>Unit</label>
            <input type="text" name="unit_name" placeholder="Enter Unit Name" required>
        </div>

        <div class="form-group">
            <label>Unit Val</label>
            <input type="number" step="0.01" name="unit_value" placeholder="Enter Unit Value" required>
        </div>

        <div class="button-area">
            <button type="submit" name="save_unit">Save</button>
        </div>

    </form>

</div>

</body>
</html>