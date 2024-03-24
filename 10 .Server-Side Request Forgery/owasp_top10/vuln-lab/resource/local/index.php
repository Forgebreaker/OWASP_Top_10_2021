<?php
$allowed_ip = '127.0.0.1';
$user_ip = $_SERVER['REMOTE_ADDR'];

if ($user_ip !== $allowed_ip) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file.');
}

$db = new SQLite3('0f1dc3a4a495befc4fd568aa151b6c8b.db');
$alert = "";

if (isset($_GET['id']) and isset($_GET['otp'])) {
    $time = date("Y-m-d H:i:s");
    $id = $_GET['id'];
    $otp = $_GET['otp'];

    $stmt = $db->prepare("SELECT * FROM data WHERE id = :id AND otp = :otp;");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $stmt->bindValue(':otp', $otp, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result && $row = $result->fetchArray()) {
        if ((strtotime($time) - strtotime($row['opt_generated_time'])) > 300) {
            $alert = "<pre>OTP is expired</pre>";
        } else {
            if ($row['id'] === 'CVE-170144') {
                $alert .= "<pre>Login successful</pre>";
                $alert .= "<pre>Bounty_Boys{Captured_The_Flag}</pre>";
            } else {
                $alert = "<pre>Login successful</pre>";
            }
        }
    } else {
        $alert = "<pre>Wrong OTP or device ID not exist</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="center-container">
        <div class="login-form">
            <h2>Login Form</h2> <!--Remember to remove device CVE-170144 out of the system ! It is vulnerable-->
            <form action="index.php" method="GET">
            <div class="input-group">
                    <input type="text" id="info" name="id" placeholder="Enter Your Device ID" required>
                </div>
                <div class="input-group">
                    <input type="text" id="info" name="otp" placeholder="Enter The 4-Digit OTP" required>
                </div>
                <input type="submit" value="Login">
            </form>
            <div class="text-center"><br>
                <a href="/generator.php">Create new OTP</a>
                <p><?php echo $alert ?></p>
            </div>
        </div>
    </div>
</body>
</html>