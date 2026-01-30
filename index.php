<?php
// ====================================
// HOME PAGE
// File: index.php
// ====================================

// Include database connection
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get data
$categories = getCategories($conn);
$featuredApps = getFeaturedApps($conn, 6);
$recentApps = getRecentApps($conn, 8);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Play Store - Download Apps</title>
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
    
    <!-- HERO SECTION -->
    <div class="container">
        <div class="hero">
            <h1>Welcome to Web Play Store</h1>
            <p>Discover and download amazing web applications</p>
        </div>
        
        <!-- CATEGORIES SECTION -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Categories</h2>
            </div>
            
            <div class="categories-grid">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="category-card" data-category-id="<?php echo $category['id']; ?>">
                            <div class="category-icon">📱</div>
                            <div class="category-name"><?php echo htmlspecialchars($category['category_name']); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No categories available</p>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- FEATURED APPS SECTION -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Featured Apps</h2>
            </div>
            
            <div class="apps-grid">
                <?php if (!empty($featuredApps)): ?>
                    <?php foreach ($featuredApps as $app): ?>
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
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📱</div>
                        <h3 class="empty-state-title">No Apps Yet</h3>
                        <p class="empty-state-text">Check back later for amazing apps!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- RECENT APPS SECTION -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Recently Added</h2>
            </div>
            
            <div class="apps-grid">
                <?php if (!empty($recentApps)): ?>
                    <?php foreach ($recentApps as $app): ?>
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
                <?php endif; ?>
            </div>
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
