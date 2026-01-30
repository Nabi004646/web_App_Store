<?php
// ====================================
// SEARCH PAGE
// File: search.php
// ====================================

require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get search query
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Search apps
$apps = array();
if (!empty($search_query)) {
    $apps = searchApps($conn, $search_query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search: <?php echo htmlspecialchars($search_query); ?> - Web Play Store</title>
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
                        value="<?php echo htmlspecialchars($search_query); ?>"
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
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">
                    <?php if (!empty($search_query)): ?>
                        Search results for "<?php echo htmlspecialchars($search_query); ?>"
                    <?php else: ?>
                        Search Apps
                    <?php endif; ?>
                </h2>
                <?php if (!empty($apps)): ?>
                    <span class="view-all"><?php echo count($apps); ?> result(s) found</span>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($apps)): ?>
                <div class="apps-grid">
                    <?php foreach ($apps as $app): ?>
                        <div class="app-card" data-app-id="<?php echo $app['id']; ?>">
                            <div class="app-header">
                                <img 
                                    src="uploads/apps/<?php echo htmlspecialchars($app['app_icon']); ?>" 
                                    alt="<?php echo htmlspecialchars($app['name']); ?>"
                                    class="app-icon"
                                    onerror="this.src='assets/images/default-icon.png'"
                                >
                                <div class="app-info">
                                    <h3 class="app-name"><?php echo htmlspecialchars($app['name']); ?></h3>
                                    <div class="app-category">
                                        <?php echo htmlspecialchars(getCategoryName($conn, $app['category'])); ?>
                                    </div>
                                    <div class="app-rating">
                                        ⭐ ⭐ ⭐ ⭐ ⭐
                                    </div>
                                </div>
                            </div>
                            
                            <p class="app-description">
                                <?php echo htmlspecialchars($app['description']); ?>
                            </p>
                            
                            <div class="app-footer">
                                <div class="app-meta">
                                    <span>📦 <?php echo htmlspecialchars($app['size']); ?></span>
                                    <span>⬇️ <?php echo number_format($app['downloads']); ?></span>
                                </div>
                                <button 
                                    class="install-btn" 
                                    data-app-id="<?php echo $app['id']; ?>"
                                    data-app-name="<?php echo htmlspecialchars($app['name']); ?>"
                                >
                                    Install
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🔍</div>
                    <h3 class="empty-state-title">
                        <?php if (empty($search_query)): ?>
                            Enter a search term
                        <?php else: ?>
                            No results found
                        <?php endif; ?>
                    </h3>
                    <p class="empty-state-text">
                        <?php if (empty($search_query)): ?>
                            Type something in the search box above
                        <?php else: ?>
                            Try different keywords or browse categories
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </section>
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
