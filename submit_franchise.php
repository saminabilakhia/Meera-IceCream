<?php
require_once 'includes/db_connect.php';

if ($_POST) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $investment = $_POST['investment'];
    $message = trim($_POST['message']);
    
    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($city) || empty($investment)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO franchise_requests (name, email, phone, city, investment, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $city, $investment, $message]);
            $success = true;
        } catch(PDOException $e) {
            $error = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - Meera Icecreams</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>🍦 Meera Icecreams</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="story.html">Our Story</a></li>
                <li><a href="flavors.html">Flavors</a></li>
                <li><a href="stores.html">Stores</a></li>
                <li><a href="franchise.html">Franchise</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="section" style="margin-top: 70px; text-align: center;">
        <?php if (isset($success)): ?>
            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <h2 style="color: #4CAF50;"><i class="fas fa-check-circle"></i> Application Submitted Successfully!</h2>
                <p style="font-size: 1.2rem; margin: 20px 0;">Thank you for your interest in joining the Meera Icecream family!</p>
                <p>We have received your franchise application and our team will review it shortly. You can expect to hear from us within 2-3 business days.</p>
                <p><strong>What's Next?</strong></p>
                <ul style="text-align: left; margin: 20px 0;">
                    <li>Our franchise team will review your application</li>
                    <li>We'll contact you for a preliminary discussion</li>
                    <li>If selected, we'll schedule a detailed meeting</li>
                    <li>Complete the franchise agreement and training process</li>
                </ul>
                <a href="index.html" class="btn" style="margin-top: 20px;">Return to Home</a>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <h2 style="color: #f44336;"><i class="fas fa-exclamation-triangle"></i> Error</h2>
                <p style="color: #f44336; font-size: 1.1rem;"><?php echo $error; ?></p>
                <a href="franchise.html" class="btn" style="margin-top: 20px;">Go Back</a>
            </div>
        <?php else: ?>
            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <h2>No Data Received</h2>
                <p>Please submit the form properly.</p>
                <a href="franchise.html" class="btn">Go to Franchise Page</a>
            </div>
        <?php endif; ?>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>🍦 Meera Icecreams</h3>
                <p>Serving happiness, one scoop at a time.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="story.html">Our Story</a></li>
                    <li><a href="flavors.html">Flavors</a></li>
                    <li><a href="franchise.html">Franchise</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>📞 +91 98765 43210</p>
                <p>📧 hello@meeraicecreams.com</p>
                <p>📍 Surat, Gujarat</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Meera Icecreams. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>