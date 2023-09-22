<?php
require_once('usedb.php');

$data = json_decode(file_get_contents("php://input"));
$encryptionKey = $data->encryptionKey;
$noteText = $data->noteText;

$sql = "INSERT INTO notes (encryption_key, note_text) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $encryptionKey, $noteText);

$response = array();

if ($stmt->execute()) {
    $response["message"] = "Note saved successfully!";
} else {
    $response["message"] = "Error saving note.";
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
