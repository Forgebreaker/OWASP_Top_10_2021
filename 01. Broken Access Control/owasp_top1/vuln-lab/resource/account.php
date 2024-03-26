<?php
$db = new SQLite3('database.db');

function account($db, $accountNumber) {
    $connect = $db->prepare('SELECT * FROM users WHERE account_number = :accountNumber');
    $connect->bindValue(':accountNumber', $accountNumber, SQLITE3_INTEGER);
    $result = $connect->execute();

    return $result->fetchArray();
}

$accountDetails = null;
if (isset($_GET['account_number'])) {
    $accountNumber = $_GET['account_number'];
    $accountDetails = account($db, $accountNumber);
}
include 'account.html';
?>


