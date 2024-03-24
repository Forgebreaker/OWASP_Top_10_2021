<?php
$allowed_ip = '127.0.0.1';
$user_ip = $_SERVER['REMOTE_ADDR'];

if ($user_ip !== $allowed_ip) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file.');
}

$db = new SQLite3('0f1dc3a4a495befc4fd568aa151b6c8b.db');

$info = "";

function generateOTP($digits = 4) {
    $otp = '';
    for ($i = 0; $i < $digits; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $time = date("Y-m-d H:i:s");
    $connect = $db->prepare("SELECT * FROM data WHERE id = :id");
    $connect->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $connect->execute();
    $row = $result->fetchArray();

    if ($row) {
        if ((strtotime($time) - strtotime($row['opt_generated_time'])) > 300 || $row['otp'] === NULL) {
            $otp = generateOTP();
            $connect = $db->prepare("UPDATE data SET otp = :otp, opt_generated_time = :time WHERE id = :id");
            $connect->bindValue(':otp', $otp, SQLITE3_TEXT);
            $connect->bindValue(':time', $time, SQLITE3_TEXT);
            $connect->bindValue(':id', $id, SQLITE3_TEXT);
            try {
                $connect->execute();
                $info .= "<pre>WE SENT OTP TO YOUR DEVICE</pre>";
                $info .= "<a href='/index.php'>Login</a>";
            } catch (Exception $e) {
                $info .= "<pre>Error: " . $e->getMessage() . "</pre>";
            }
        } else {
            $info .= "<pre>OTP is not expired</pre>";
            $info .= "<a href='/index.php'>Login</a>";
        }
    } else {
        $info .= "<pre>ID is not registered</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Generator</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="center-container">
        <div class="login-form">
            <form action="#" method="GET">
                <h1>Authentication</h1>
                <div class="input-group">
                    <input type="id" class="form-control" name="id" placeholder="Enter Your Device ID" required>
                </div>
                <input type="submit" class="btn" value="Submit">
            </form>
            <div class="text-center">
                <?php echo $info ?>
            </div>
        </div>
    </div>
</body>
</html>
