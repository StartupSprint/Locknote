<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "localnotedb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the encryption key from the POST request
$data = json_decode(file_get_contents("php://input"));

if (isset($data->encryptionKey)) {
    $encryptionKey = mysqli_real_escape_string($conn, $data->encryptionKey);

    // Check if the encryption key exists in the database
    $checkKeySql = "SELECT * FROM keylist WHERE `key` = '$encryptionKey'";
    $keyResult = $conn->query($checkKeySql);

    if ($keyResult->num_rows === 0) {
        // The encryption key does not exist, insert a new row
        $insertSql = "INSERT INTO keylist (`key`, note) VALUES ('$encryptionKey', '')";

        if ($conn->query($insertSql) === TRUE) {
            $response = array('message' => 'Key saved successfully');
            echo json_encode($response);
        } else {
            $response = array('message' => 'Error saving key');
            echo json_encode($response);
        }
    } else {
        $response = array('message' => 'Key already exists');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Encryption key not provided');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
