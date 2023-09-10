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

    // Retrieve the note for the given user (encryption key)
    $sql = "SELECT note FROM keylist WHERE `key` = '$encryptionKey'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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

// Close the database connection
$conn->close();
?>
