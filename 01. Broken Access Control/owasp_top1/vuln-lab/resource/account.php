<?php
$db = new SQLite3('database.db');

function getAccountDetails($db, $accountNumber) {
    $stmt = $db->prepare('SELECT * FROM users WHERE account_number = :accountNumber');
    $stmt->bindValue(':accountNumber', $accountNumber, SQLITE3_INTEGER);
    $result = $stmt->execute();

    return $result->fetchArray();
}

$accountDetails = null;
if (isset($_GET['account_number'])) {
    $accountNumber = $_GET['account_number'];
    $accountDetails = getAccountDetails($db, $accountNumber);
}
include 'account.html';
?>


