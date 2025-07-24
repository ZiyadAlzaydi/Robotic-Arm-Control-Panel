<?php
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "ziyaddb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['id'])) {
    echo "Missing ID.";
    exit;
}

$id = intval($_POST['id']);

// First verify the ID exists
$check = $conn->prepare("SELECT id FROM pose WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    echo "Error: Pose with ID $id does not exist in database!";
    exit;
}

// Now delete the record
$stmt = $conn->prepare("DELETE FROM pose WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Pose deleted successfully.";
    } else {
        echo "Error: No rows were deleted (ID exists but delete failed).";
    }
} else {
    echo "Error: " . $conn->error;
}

$check->close();
$stmt->close();
$conn->close();
?>