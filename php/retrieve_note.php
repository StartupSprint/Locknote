<?php
$serverName = "tcp:sqldatabaselocknote.database.windows.net,1433";
$databaseName = "locknotedb";
$username = "devkiraa";
$password = "Kiraa@M1670529";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the encryption key from the POST request
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->encryptionKey)) {
        $encryptionKey = $data->encryptionKey;

        // Prepare and execute a query to retrieve the note for the given user (encryption key)
        $sql = "SELECT note FROM keylist WHERE [key] = :encryptionKey";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':encryptionKey', $encryptionKey, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $note = $row['note'];

            echo json_encode(array('note' => $note)); // Send the note as JSON response
        } else {
            $response = array('note' => ''); // Return an empty note if the key doesn't exist
            echo json_encode($response);
        }
    } else {
        $response = array('note' => ''); // Return an empty note if no encryption key is provided
        echo json_encode($response);
    }
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
