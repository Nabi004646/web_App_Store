<?php
// ====================================
// AUTHENTICATION FUNCTIONS
// File: includes/auth.php
// ====================================

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
}

// Require admin authentication
function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        header("Location: login.php");
        exit();
    }
}

// Login user
function loginUser($conn, $email, $password) {
    // Sanitize email
    $email = mysqli_real_escape_string($conn, $email);
    
    // Query to find user
    $query = "SELECT id, name, email, password, role FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_role'] = $user['role'];
            
            return true;
        }
    }
    
    return false;
}

// Logout user
function logoutUser() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy session
    session_destroy();
    
    // Redirect to login
    header("Location: login.php");
    exit();
}

// Get current admin name
function getAdminName() {
    return isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
}
?>
