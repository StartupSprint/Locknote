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

    // Get the note text and encryption key from the POST request
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->noteText) && isset($data->encryptionKey)) {
        $noteText = $data->noteText;
        $encryptionKey = $data->encryptionKey;

        // Save the note for the given user (encryption key)
        $updateSql = "UPDATE keylist SET note = ? WHERE [key] = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->execute([$noteText, $encryptionKey]);

        echo json_encode(['message' => 'Note saved successfully']);
    } else {
        echo json_encode(['message' => 'Note text or encryption key not provided']);
    }
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
