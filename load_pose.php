<?php
$conn = new mysqli("localhost", "root", "", "ziyaddb");
$id = $_GET["id"];

$res = $conn->query("SELECT * FROM pose WHERE id=$id LIMIT 1");
$data = $res->fetch_assoc();

echo json_encode($data);
$conn->close();
