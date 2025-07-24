<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "ziyaddb");
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

$res = $conn->query("SELECT id, servo1, servo2, servo3, servo4, servo5, servo6 FROM pose");
$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
?>