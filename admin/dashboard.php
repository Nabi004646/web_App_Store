<?php
// ====================================
// ADMIN DASHBOARD
// File: admin/dashboard.php
// ====================================

session_start();

require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Require admin authentication
requireAdmin();

// Get statistics
$totalApps = getTotalApps($conn);
$totalDownloads = getTotalDownloads($conn);
$recentApps = getRecentApps($conn, 10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
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
                    <a href="dashboard.php" class="active">
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
                <h1 class="topbar-title">Dashboard</h1>
                <div class="topbar-user">
                    <span class="user-name">Welcome, <?php echo htmlspecialchars(getAdminName()); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>
            
            <div class="content">
                
                <!-- STATISTICS CARDS -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon primary">📱</div>
                        <div class="stat-value"><?php echo number_format($totalApps); ?></div>
                        <div class="stat-label">Total Apps</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon success">⬇️</div>
                        <div class="stat-value"><?php echo number_format($totalDownloads); ?></div>
                        <div class="stat-label">Total Downloads</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon warning">📦</div>
                        <div class="stat-value"><?php echo count(getCategories($conn)); ?></div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
                
                <!-- RECENT APPS TABLE -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Apps</h2>
                        <a href="add-app.php" class="btn btn-success btn-sm">Add New App</a>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentApps)): ?>
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Icon</th>
                                            <th data-sortable>App Name</th>
                                            <th>Category</th>
                                            <th>Version</th>
                                            <th data-sortable>Downloads</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentApps as $app): ?>
                                            <tr>
                                                <td>
                                                    <img 
                                                        src="../uploads/apps/<?php echo htmlspecialchars($app['app_icon']); ?>" 
                                                        alt="Icon"
                                                        class="app-icon-small"
                                                        onerror="this.src='../assets/images/default-icon.png'"
                                                    >
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($app['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        <?php echo htmlspecialchars(getCategoryName($conn, $app['category'])); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($app['version']); ?></td>
                                                <td><?php echo number_format($app['downloads']); ?></td>
                                                <td><?php echo timeAgo($app['created_at']); ?></td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="edit-app.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-edit">Edit</a>
                                                        <a href="delete-app.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-delete">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted">No apps yet. <a href="add-app.php">Add your first app</a></p>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
    
    <script src="assets/admin.js"></script>
</body>
</html>
<?php closeConnection($conn); ?>
