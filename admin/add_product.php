<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_POST) {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);
    
    if (!empty($name) && !empty($category) && !empty($price)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, category, price, description, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $category, $price, $description, $image_url]);
            header('Location: dashboard.php');
            exit;
        } catch(PDOException $e) {
            $error = "Error adding product.";
        }
    }
}

header('Location: dashboard.php');
exit;
?>