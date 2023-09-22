<?php
require_once('usedb.php');

$data = json_decode(file_get_contents("php://input"));
$encryptionKey = $data->encryptionKey;

$sql = "SELECT COUNT(*) AS count FROM keys WHERE encryption_key = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $encryptionKey);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

$response = array("exists" => ($count > 0));
echo json_encode($response);

$stmt->close();
$conn->close();
?>
