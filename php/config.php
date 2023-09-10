<?php
$serverName = "sqldatabaselocknote.database.windows.net";
$databaseName = "locknotedb";
$username = "devkiraa";
$password = "Kiraa@M1670529";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // This message indicates a successful connection
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
