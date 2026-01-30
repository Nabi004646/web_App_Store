<?php
// ====================================
// APP DETAILS PAGE
// File: app-details.php
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

// Get category name
$category_name = getCategoryName($conn, $app['category']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($app['name']); ?> - Web Play Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <!-- HEADER -->
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <div class="logo-icon">W</div>
                <span>Web Play Store</span>
            </a>
            
            <div class="search-container">
                <form id="searchForm" method="GET" action="search.php">
                    <input 
                        type="text" 
                        id="searchBox" 
                        name="q" 
                        class="search-box" 
                        placeholder="Search apps..."
                        autocomplete="off"
                    >
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="admin/login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- MAIN CONTENT -->
    <div class="container">
        <div class="app-details">
            
            <!-- APP HEADER -->
            <div class="app-details-header">
                <img 
                    src="uploads/apps/<?php echo htmlspecialchars($app['app_icon']); ?>" 
                    alt="<?php echo htmlspecialchars($app['name']); ?>"
                    class="app-details-icon"
                    onerror="this.src='assets/images/default-icon.png'"
                >
                
                <div class="app-details-info">
                    <h1 class="app-details-name"><?php echo htmlspecialchars($app['name']); ?></h1>
                    <div class="app-details-category"><?php echo htmlspecialchars($category_name); ?></div>
                    
                    <div class="app-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo number_format($app['downloads']); ?></div>
                            <div class="stat-label">Downloads</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo htmlspecialchars($app['version']); ?></div>
                            <div class="stat-label">Version</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo htmlspecialchars($app['size']); ?></div>
                            <div class="stat-label">Size</div>
                        </div>
                    </div>
                    
                    <button 
                        id="downloadBtn"
                        class="download-btn" 
                        data-app-id="<?php echo $app['id']; ?>"
                        data-app-name="<?php echo htmlspecialchars($app['name']); ?>"
                    >
                        Download & Install
                    </button>
                </div>
            </div>
            
            <!-- DESCRIPTION SECTION -->
            <div class="app-details-section">
                <h2 class="section-subtitle">About this app</h2>
                <p class="app-details-description">
                    <?php echo nl2br(htmlspecialchars($app['description'])); ?>
                </p>
            </div>
            
            <!-- VERSION INFO -->
            <div class="app-details-section">
                <h2 class="section-subtitle">App Information</h2>
                <div class="version-info">
                    <div class="info-item">
                        <div class="info-label">Version</div>
                        <div class="info-value"><?php echo htmlspecialchars($app['version']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Size</div>
                        <div class="info-value"><?php echo htmlspecialchars($app['size']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Category</div>
                        <div class="info-value"><?php echo htmlspecialchars($category_name); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Last Updated</div>
                        <div class="info-value"><?php echo date('M d, Y', strtotime($app['updated_at'])); ?></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Web Play Store. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php closeConnection($conn); ?>
