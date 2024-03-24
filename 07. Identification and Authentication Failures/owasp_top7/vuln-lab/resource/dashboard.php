<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$users = [
    'superuser' => [
        'content' => 'Bounty_Boys{Captured_The_Flag}'
    ]
];

$username = $_SESSION['username'];

if ($username == "superuser") {
    $content = isset($users[$username]['content']) ? $users[$username]['content'] : '';
} else {
    $content = "Is that all you can do ? Show me what you've got ! Try to login as superuser";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="login-form"> 
        <p><?php echo $content; ?></p>
        <form action="logout.php" method="post">
            <input type="submit" name="logout" value="Logout" class="button-logout">
        </form>
    </div>
</body>
</html>
