<?php
// ====================================
// DELETE APP PAGE
// File: admin/delete-app.php
// ====================================

session_start();

require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Require admin authentication
requireAdmin();

// Get app ID
$app_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get app data
$app = getAppById($conn, $app_id);

// If app not found, redirect
if (!$app) {
    header("Location: dashboard.php");
    exit();
}

// Handle confirmation
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Delete files
    deleteFile('../uploads/apps/' . $app['app_icon']);
    deleteFile('../uploads/apps/' . $app['app_file']);
    
    // Delete from database
    $query = "DELETE FROM apps WHERE id = $app_id";
    
    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        $error = 'Failed to delete app: ' . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete App - Admin Panel</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
    
    <div class="admin-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="logo-icon">W</div>
                    <span>Admin Panel</span>
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="add-app.php">
                        <span class="icon">➕</span>
                        <span>Add New App</span>
                    </a>
                </li>
                <li>
                    <a href="manage-users.php">
                        <span class="icon">👥</span>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="../index.php" target="_blank">
                        <span class="icon">🌐</span>
                        <span>View Site</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="topbar">
                <h1 class="topbar-title">Delete App</h1>
                <div class="topbar-user">
                    <span class="user-name">Welcome, <?php echo htmlspecialchars(getAdminName()); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>
            
            <div class="content">
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Confirm Deletion</h2>
                    </div>
                    <div class="card-body">
                        <div style="text-align: center; padding: 40px 20px;">
                            <div style="font-size: 64px; margin-bottom: 24px;">⚠️</div>
                            <h2 style="margin-bottom: 16px;">Are you sure?</h2>
                            <p style="color: var(--gray); margin-bottom: 32px;">
                                You are about to delete the app <strong>"<?php echo htmlspecialchars($app['name']); ?>"</strong>. 
                                This action cannot be undone.
                            </p>
                            
                            <div style="display: flex; gap: 12px; justify-content: center;">
                                <a href="delete-app.php?id=<?php echo $app_id; ?>&confirm=yes" class="btn btn-danger">
                                    Yes, Delete It
                                </a>
                                <a href="dashboard.php" class="btn btn-primary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
    
    <script src="assets/admin.js"></script>
</body>
</html>
<?php closeConnection($conn); ?>
