<?php
session_start();
include 'db.php';  // Your database connection file

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get form data safely
$category = $_POST['category'] ?? '';
$amount = $_POST['amount'] ?? 0;
$expense_date = $_POST['expense_date'] ?? '';

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Prepare SQL statement to insert expense
$stmt = $conn->prepare("INSERT INTO expenses (user_id, category, amount, expense_date, username) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isdss", $user_id, $category, $amount, $expense_date, $username);

if ($stmt->execute()) {
    // Redirect to dashboard after successful insert
    header("Location: dashboard.php");
    exit();
} else {
    // Optional: display error message if insertion fails
    echo "Error adding expense: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
