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

// Get the note text and encryption key from the POST request
$data = json_decode(file_get_contents("php://input"));

if (isset($data->noteText) && isset($data->encryptionKey)) {
    $noteText = mysqli_real_escape_string($conn, $data->noteText);
    $encryptionKey = mysqli_real_escape_string($conn, $data->encryptionKey);

    // Save the note for the given user (encryption key)
    $sql = "UPDATE keylist SET note = '$noteText' WHERE `key` = '$encryptionKey'";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Note saved successfully');
        echo json_encode($response);
    } else {
        $response = array('message' => 'Error saving note');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Note text or encryption key not provided');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
