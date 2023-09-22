<?php
$serverName = "sql211.infinityfree.com";
$databaseName = "if0_35085005_locknote";
$username = "if0_35085005";
$password = "z93UAb75vWW";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // This message indicates a successful connection
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
