<?php
session_start();
$db = new SQLite3('database.db');
$loginError = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $raw_password = $_POST['password'];

    $password = md5($raw_password);

    $stmt = $db->prepare('SELECT account_number, password FROM users WHERE username = :username');
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    
    $result = $stmt->execute();
    $user = $result->fetchArray();
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['account_number'];
        header("Location: account.php?account_number=" . $user['account_number']);
        exit;
    } else {
        $loginError = "Invalid username or password.";
    }
}
include 'index.html';
?>


