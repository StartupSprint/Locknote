<?php
// Azure SQL Database connection details
$serverName = "tcp:sqldatabaselocknote.database.windows.net,1433";
$databaseName = "locknotedb";
$username = "devkiraa";
$password = "Kiraa@M1670529";

try {
    // Establish a connection to Azure SQL Database
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the encryption key from the POST request
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->encryptionKey)) {
        $encryptionKey = $data->encryptionKey;

        // Check if the encryption key exists in the database
        $checkKeySql = "SELECT * FROM keylist WHERE [key] = ?";
        $stmt = $conn->prepare($checkKeySql);
        $stmt->execute([$encryptionKey]);

        if ($stmt->rowCount() === 0) {
            // The encryption key does not exist, insert a new row
            $insertSql = "INSERT INTO keylist ([key], note) VALUES (?, '')";
            $stmt = $conn->prepare($insertSql);
            $stmt->execute([$encryptionKey]);

            echo json_encode(['message' => 'Key saved successfully']);
        } else {
            echo json_encode(['message' => 'Key already exists']);
        }
    } else {
        echo json_encode(['message' => 'Encryption key not provided']);
    }
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
