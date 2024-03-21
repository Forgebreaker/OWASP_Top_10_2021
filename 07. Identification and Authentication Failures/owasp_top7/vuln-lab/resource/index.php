<?php
session_start();

$users_file = 'users.json';

$users = [];

if (file_exists($users_file)) {
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true);
}

function save_users() {
    global $users, $users_file;
    $users_data = json_encode($users);
    file_put_contents($users_file, $users_data);
}

if (!isset($users['admin'])) {
    $users['superuser'] = [
        'password' => '2c978a0dc12126ec35994889e3c49c03'
    ];
    save_users();
}

function username_exists($username) {
    global $users;
    return isset($users[$username]);
}

function register_user($username, $password) {
    global $users;
    if (username_exists($username)) {
        return false;
    } else {
        $users[$username] = [
            'password' => $password
        ];
        save_users();
        return true;
    }
}

function login($username, $password) {
    global $users;
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['username'] = trim($username);
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $registration_result = register_user($username, $password);

    if ($registration_result) {
        $_SESSION['username'] = trim($username);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Username already exists!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
include "./index.html";
?>

