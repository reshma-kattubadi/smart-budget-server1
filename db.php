<?php
$conn = new mysqli("localhost", "root", "", "budget_planner");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
