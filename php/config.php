<?php
$serverName = "sqlsrv:server = tcp:sqldatabaselocknote.database.windows.net,1433";
$databaseName = "locknotedb";
$username = "zaumhoclhr";
$password = "028I348KO1JW16DA$";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // This message indicates a successful connection
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
