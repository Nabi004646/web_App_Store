<?php
// ====================================
// EDIT APP PAGE
// File: admin/edit-app.php
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

// Get categories
$categories = getCategories($conn);

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = sanitize($conn, $_POST['name']);
    $description = sanitize($conn, $_POST['description']);
    $category = (int)$_POST['category'];
    $version = sanitize($conn, $_POST['version']);
    
    // Validate inputs
    if (empty($name) || empty($description) || empty($category) || empty($version)) {
        $error = 'All fields are required';
    } else {
        // Handle icon upload (optional)
        $icon_filename = $app['app_icon'];
        if (isset($_FILES['app_icon']) && $_FILES['app_icon']['error'] === UPLOAD_ERR_OK) {
            $icon_validation = validateImage($_FILES['app_icon']);
            
            if ($icon_validation === true) {
                // Delete old icon
                deleteFile('../uploads/apps/' . $app['app_icon']);
                
                // Upload new icon
                $icon_filename = uploadFile($_FILES['app_icon'], '../uploads/apps/');
                
                if (!$icon_filename) {
                    $error = 'Failed to upload icon';
                    $icon_filename = $app['app_icon'];
                }
            } else {
                $error = $icon_validation;
            }
        }
        
        // Handle app file upload (optional)
        $app_filename = $app['app_file'];
        $file_size = $app['size'];
        
        if (empty($error) && isset($_FILES['app_file']) && $_FILES['app_file']['error'] === UPLOAD_ERR_OK) {
            $app_validation = validateAppFile($_FILES['app_file']);
            
            if ($app_validation === true) {
                // Delete old file
                deleteFile('../uploads/apps/' . $app['app_file']);
                
                // Upload new file
                $app_filename = uploadFile($_FILES['app_file'], '../uploads/apps/');
                
                if (!$app_filename) {
                    $error = 'Failed to upload app file';
                    $app_filename = $app['app_file'];
                } else {
                    // Update file size
                    $file_size = formatFileSize($_FILES['app_file']['size']);
                }
            } else {
                $error = $app_validation;
            }
        }
        
        // Update in database
        if (empty($error)) {
            $query = "UPDATE apps SET 
                      name = '$name', 
                      description = '$description', 
                      category = $category, 
                      version = '$version', 
                      app_icon = '$icon_filename', 
                      app_file = '$app_filename', 
                      size = '$file_size'
                      WHERE id = $app_id";
            
            if (mysqli_query($conn, $query)) {
                $success = 'App updated successfully!';
                
                // Reload app data
                $app = getAppById($conn, $app_id);
            } else {
                $error = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit App - Admin Panel</title>
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
                <h1 class="topbar-title">Edit App</h1>
                <div class="topbar-user">
                    <span class="user-name">Welcome, <?php echo htmlspecialchars(getAdminName()); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>
            
            <div class="content">
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit: <?php echo htmlspecialchars($app['name']); ?></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name" class="form-label">App Name *</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        class="form-input" 
                                        placeholder="Enter app name"
                                        required
                                        value="<?php echo htmlspecialchars($app['name']); ?>"
                                    >
                                </div>
                                
                                <div class="form-group">
                                    <label for="version" class="form-label">Version *</label>
                                    <input 
                                        type="text" 
                                        id="version" 
                                        name="version" 
                                        class="form-input" 
                                        placeholder="e.g., 1.0.0"
                                        required
                                        value="<?php echo htmlspecialchars($app['version']); ?>"
                                    >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="category" class="form-label">Category *</label>
                                <select id="category" name="category" class="form-input" required>
                                    <option value="">Select a category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo ($app['category'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="form-label">Description *</label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    class="form-input" 
                                    placeholder="Describe the app..."
                                    required
                                ><?php echo htmlspecialchars($app['description']); ?></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="app_icon" class="form-label">App Icon (Leave empty to keep current)</label>
                                    <input 
                                        type="file" 
                                        id="app_icon" 
                                        name="app_icon" 
                                        class="form-input file-input" 
                                        accept="image/jpeg,image/jpg,image/png,image/gif"
                                    >
                                    <p class="text-muted" style="margin-top: 8px; font-size: 13px;">
                                        Current: <?php echo htmlspecialchars($app['app_icon']); ?>
                                    </p>
                                </div>
                                
                                <div class="form-group">
                                    <label for="app_file" class="form-label">App File (Leave empty to keep current)</label>
                                    <input 
                                        type="file" 
                                        id="app_file" 
                                        name="app_file" 
                                        class="form-input file-input" 
                                        accept=".zip,.rar,.apk,.exe,.dmg"
                                    >
                                    <p class="text-muted" style="margin-top: 8px; font-size: 13px;">
                                        Current: <?php echo htmlspecialchars($app['app_file']); ?> (<?php echo htmlspecialchars($app['size']); ?>)
                                    </p>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 24px;">
                                <button type="submit" class="btn btn-primary">Update App</button>
                                <a href="dashboard.php" class="btn btn-danger" style="margin-left: 12px;">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
    
    <script src="assets/admin.js"></script>
</body>
</html>
<?php closeConnection($conn); ?>
