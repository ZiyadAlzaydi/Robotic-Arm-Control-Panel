<?php
$conn = new mysqli("localhost", "root", "", "ziyaddb");

$conn->query("UPDATE run SET status=0");

$data = json_decode(file_get_contents("php://input"), true);
$s = $data;

$sql = $conn->prepare("UPDATE run SET servo1=?, servo2=?, servo3=?, servo4=?, servo5=?, servo6=?, status=1");
$sql->bind_param("iiiiiii", $s['servo1'], $s['servo2'], $s['servo3'], $s['servo4'], $s['servo5'], $s['servo6'], $one);
$one = 1;

$sql->execute();
$conn->close();
