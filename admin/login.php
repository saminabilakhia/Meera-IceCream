<?php
session_start();
require_once '../includes/db_connect.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();
            
            if ($admin && $password === $admin['password']) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } catch(PDOException $e) {
            $error = "Database error. Please try again.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Meera Icecreams</title>
    <link rel="icon" type="image/jpeg" href="../assets/img/icons/WhatsApp Image 2025-10-13 at 3.10.32 AM.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #F8BBD0, #B3E5FC);">
    <div class="login-form">
        <h2 style="text-align: center; margin-bottom: 30px; color: #6B4226;"><img src="../assets/img/icons/WhatsApp Image 2025-10-13 at 3.10.32 AM.jpeg" alt="Meera Icecreams" style="height: 40px; margin-right: 10px; border-radius: 5px; vertical-align: middle;"> Admin Login</h2>
        
        <?php if (isset($error)): ?>
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #666;">
            <p>Default Login: admin / admin123</p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="../index.html" style="color: #6B4226; text-decoration: none;">← Back to Website</a>
        </div>
    </div>
</body>
</html>