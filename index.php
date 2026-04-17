<?php
session_start();

require_once 'db.php'; 

$message = "";

// अगर already login है तो redirect
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: firm_select.php");
    exit();
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        // IMPORTANT: password_verify
        if (password_verify($password, $row['password'])) {

            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['username'];

            header("Location: firm_select.php");
            exit;

        } else {
            $message = "Wrong Password";
        }

    } else {
        $message = "User Not Found";
    }
}

// Prevent cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Booking Entry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/layout.css">
</head>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #ffffff;
}

.header {
    text-align: center;
    color: #ff6b6b;
    font-size: 22px;
    padding: 15px;
    font-weight: bold;
}

.container {
    display: flex;
    height: calc(100vh - 60px);
}

/* LEFT PANEL */
.left-panel {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.reminder-box {
    border: 3px solid #000;
    padding: 30px;
    width: 320px;
}

.reminder-box h2 {
    color: green;
    text-align: center;
    margin-bottom: 20px;
}

.reminder {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.reminder span {
    font-size: 18px;
    color: red;
    margin-right: 10px;
}

.reminder p {
    color: green;
    font-weight: bold;
}

/* RIGHT PANEL */
.right-panel {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    background: #3f7fb3;
    width: 320px;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
}

.logo {
    background: #fff;
    padding: 15px;
    border-radius: 50%;
    margin-bottom: 10px;
}

.logo img {
    width: 100px;
}

.welcome {
    background: red;
    color: #fff;
    padding: 5px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 15px;
}

input {
    width: 90%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 20px;
    border: none;
}

button {
    width: 90%;
    padding: 10px;
    background: #f6b343;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    cursor: pointer;
}

.message {
    margin-top: 10px;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="header">Transport Software Training Video</div>

<div class="container">

    <!-- LEFT -->
    <!-- <div class="left-panel">
        <div class="reminder-box">
            <h2>REMINDERS</h2>

            <div class="reminder">
                <span>✔</span><p>POD REMINDER</p>
            </div>
            <div class="reminder">
                <span>✔</span><p>E WAY BILL EXPIRY REMINDER</p>
            </div>
            <div class="reminder">
                <span>✔</span><p>E WAY BILL EXTENSION</p>
            </div>
            <div class="reminder">
                <span>✔</span><p>PARTY GST VERIFICATION</p>
            </div>
        </div>
    </div> -->

    <!-- RIGHT -->
    <div class="right-panel">
        <div class="login-box">

            <div class="logo">
                <!-- Replace logo.png with your logo -->
                <img src="logo.png" alt="Transport Lite">
            </div>

            <div class="welcome">Welcome to Transport Lite</div>

            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>

           <div class="message"><?= $message ?? '' ?></div>
        </div>
    </div>

</div>

</body>
</html>
