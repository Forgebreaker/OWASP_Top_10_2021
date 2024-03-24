<?php
session_start();
$db = new SQLite3('database.db');
$loginError = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];

    $password = $_POST['password'];

    $query = "SELECT account_number FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->query($query);
    $user = $result->fetchArray();

    if ($user) {
        $_SESSION['user_id'] = $user['account_number'];
        file_put_contents('./logs.txt', "[Successful login] Username: $username || Password: $password, Time: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: account.php?account_number=" . $user['account_number']);
        exit;
    } else {
        file_put_contents('./logs.txt', "[Login Failed] Username: $username || Password: $password, Time: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        $loginError = "Invalid username or password.";
    }
}
include 'index.html';
?>


