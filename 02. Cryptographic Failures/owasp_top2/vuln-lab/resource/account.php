<?php
session_start();
$db = new SQLite3('database.db');

function getAccountDetails($db, $accountNumber) {
    $stmt = $db->prepare('SELECT * FROM users WHERE account_number = :accountNumber');
    $stmt->bindValue(':accountNumber', $accountNumber, SQLITE3_INTEGER);
    $result = $stmt->execute();

    return $result->fetchArray();
}

$accountDetails = null;

$userAccountNumber = $_SESSION['user_id'];

if (isset($_GET['account_number'])) {
    $accountNumber = $_GET['account_number'];
    
    if ($accountNumber == $userAccountNumber) {
        $accountDetails = getAccountDetails($db, $accountNumber);
    } else {
        header("Location: account.php?account_number=" . $userAccountNumber);
    }

} else {
    header("Location: account.php?account_number=" . $userAccountNumber);
    exit;
}
include 'account.html';
?>

