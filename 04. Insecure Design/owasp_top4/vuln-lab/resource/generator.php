<?php
$db = new SQLite3('0f1dc3a4a495befc4fd568aa151b6c8b.db');

$info = "";

function generateOTP($digits = 4) {
    $otp = '';
    for ($i = 0; $i < $digits; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $time = date("Y-m-d H:i:s");
    $stmt = $db->prepare("SELECT * FROM data WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray();

    if ($row) {
        if ((strtotime($time) - strtotime($row['opt_generated_time'])) > 300 || $row['otp'] === NULL) {
            $otp = generateOTP();
            $stmt = $db->prepare("UPDATE data SET otp = :otp, opt_generated_time = :time WHERE id = :id");
            $stmt->bindValue(':otp', $otp, SQLITE3_TEXT);
            $stmt->bindValue(':time', $time, SQLITE3_TEXT);
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            try {
                $stmt->execute();
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
            <form action="#" method="post">
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
