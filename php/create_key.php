<?php
require_once('usedb.php');

$data = json_decode(file_get_contents("php://input"));
$encryptionKey = $data->encryptionKey;

$sql = "INSERT INTO keys (encryption_key) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $encryptionKey);

$response = array();

if ($stmt->execute()) {
    $response["success"] = true;
} else {
    $response["success"] = false;
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
