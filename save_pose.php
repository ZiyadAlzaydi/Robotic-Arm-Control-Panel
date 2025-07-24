<?php
$conn = new mysqli("localhost", "root", "", "ziyaddb");

$data = json_decode(file_get_contents("php://input"), true);
$s = $data["servos"];

$sql = $conn->prepare("INSERT INTO pose (servo1,servo2,servo3,servo4,servo5,servo6) VALUES (?,?,?,?,?,?)");
$sql->bind_param("iiiiii", $s[0], $s[1], $s[2], $s[3], $s[4], $s[5]);

if ($sql->execute()) {
  echo "Pose saved!";
} else {
  echo "Error saving pose.";
}
$conn->close();
