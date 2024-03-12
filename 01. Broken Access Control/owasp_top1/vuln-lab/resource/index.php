<?php
session_start();
$db = new SQLite3('database.db');
$loginError = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = SQLite3::escapeString($_POST['username']);

    $password = SQLite3::escapeString($_POST['password']);

    $query = "SELECT account_number FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->query($query);
    $user = $result->fetchArray();

    if ($user) {
        $_SESSION['user_id'] = $user['account_number'];
        header("Location: account.php?account_number=" . $user['account_number']);
        exit;
    } else {
        $loginError = "Invalid username or password.";
    }
}
include 'index.html';
?>


