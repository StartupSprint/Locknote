<?php
require_once('usedb.php');

$data = json_decode(file_get_contents("php://input"));
$encryptionKey = $data->encryptionKey;

$sql = "SELECT note_text FROM notes WHERE encryption_key = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $encryptionKey);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$noteText = $row['note_text'];

$response = array("note" => $noteText);
echo json_encode($response);

$stmt->close();
$conn->close();
?>
