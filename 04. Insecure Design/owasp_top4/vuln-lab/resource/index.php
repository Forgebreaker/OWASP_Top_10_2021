<?php
$redis = new Redis();
$redis->connect('redis', 6379);
$redis->auth('hungthinhtran_bountyboys');

$max_calls_limit  = 5;
$time_period      = 60;
$total_user_calls = 0;

$client_ip = $_SERVER['REMOTE_ADDR'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $client_ip = $_SERVER['HTTP_CLIENT_IP'];
} else {
    $client_ip = $_SERVER['REMOTE_ADDR']; 
}

if (!$redis->exists($client_ip)) {
    $redis->set($client_ip, 1);
    $redis->expire($client_ip, $time_period);
    $total_user_calls = 1;
} else {
    $redis->incr($client_ip);
    $total_user_calls = $redis->get($client_ip);
    if ($total_user_calls > $max_calls_limit) {
        exit();
    }
}

$db = new SQLite3('0f1dc3a4a495befc4fd568aa151b6c8b.db');
$alert = "";

if (isset($_POST['id']) and isset($_POST['otp'])) {
    $time = date("Y-m-d H:i:s");
    $id = $_POST['id'];
    $otp = $_POST['otp'];

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="center-container">
        <div class="login-form">
            <h2>Login Form</h2>
            <form action="index.php" method="post">
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