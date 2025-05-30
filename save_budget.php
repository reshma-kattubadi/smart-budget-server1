<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$amount = $_POST['amount'];
$month = $_POST['month'];

// Check if budget exists for user & month
$stmt = $conn->prepare("SELECT id FROM budgets WHERE username = ? AND month = ?");
$stmt->bind_param("ss", $username, $month);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update budget
    $stmt->close();
    $stmt = $conn->prepare("UPDATE budgets SET amount = ? WHERE username = ? AND month = ?");
    $stmt->bind_param("dss", $amount, $username, $month);
    $stmt->execute();
} else {
    // Insert budget
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO budgets (user_id, amount, username, month) VALUES (?, ?, ?, ?)");
    $user_id = $_SESSION['user_id']; // Make sure this is set on login
    $stmt->bind_param("idss", $user_id, $amount, $username, $month);
    $stmt->execute();
}

$stmt->close();

// Redirect back to dashboard
header("Location: dashboard.php");
exit();
?>
