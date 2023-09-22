<?php
$serverName = "sql211.infinityfree.com";
$databaseName = "if0_35085005_locknote";
$username = "if0_35085005";
$password = "z93UAb75vWW";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the encryption key from the POST request
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->encryptionKey)) {
        $encryptionKey = $data->encryptionKey;

        // Prepare and execute a query to create a new row for the key in the database
        $sql = "INSERT INTO keylist ([key], note) VALUES (:encryptionKey, '')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':encryptionKey', $encryptionKey, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            $response = array('success' => false);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}
?>
