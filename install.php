<?php
// ====================================
// INSTALL/DOWNLOAD PAGE
// File: install.php
// ====================================

require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get app ID from URL
$app_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get app details
$app = getAppById($conn, $app_id);

// If app not found, redirect to home
if (!$app) {
    header("Location: index.php");
    exit();
}

// Increment download count
incrementDownload($conn, $app_id);

// Get file path
$file_path = 'uploads/apps/' . $app['app_file'];

// Check if file exists
if (file_exists($file_path)) {
    // Set headers for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($app['app_file']) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    
    // Clear output buffer
    ob_clean();
    flush();
    
    // Read file and send to output
    readfile($file_path);
    exit();
} else {
    // File not found
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - Web Play Store</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header class="header">
            <div class="header-container">
                <a href="index.php" class="logo">
                    <div class="logo-icon">W</div>
                    <span>Web Play Store</span>
                </a>
            </div>
        </header>
        
        <div class="container">
            <div class="empty-state">
                <div class="empty-state-icon">❌</div>
                <h3 class="empty-state-title">File Not Found</h3>
                <p class="empty-state-text">The app file could not be found. Please contact support.</p>
                <div style="margin-top: 24px;">
                    <a href="index.php" class="download-btn">Go Home</a>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="footer-content">
                <p>&copy; 2025 Web Play Store. All rights reserved.</p>
            </div>
        </footer>
    </body>
    </html>
    <?php
}

closeConnection($conn);
?>
