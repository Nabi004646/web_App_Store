<?php
// ====================================
// ADMIN LOGIN PAGE
// File: admin/login.php
// ====================================

session_start();

// Include database and auth
require_once '../includes/db.php';
require_once '../includes/auth.php';

// If already logged in, redirect to dashboard
if (isLoggedIn() && isAdmin()) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        if (loginUser($conn, $email, $password)) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Web Play Store</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
    
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <div class="login-logo-icon">W</div>
                <h1>Admin Login</h1>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="admin@example.com"
                        required
                        autocomplete="email"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                </div>
                
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </form>
            
            <p style="margin-top: 20px; text-align: center; color: var(--gray); font-size: 14px;">
                Default: admin@webplaystore.com / admin123
            </p>
        </div>
    </div>
    
</body>
</html>
<?php closeConnection($conn); ?>
