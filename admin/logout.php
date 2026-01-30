<?php
// ====================================
// LOGOUT PAGE
// File: admin/logout.php
// ====================================

session_start();

require_once '../includes/auth.php';

// Logout user
logoutUser();
?>
