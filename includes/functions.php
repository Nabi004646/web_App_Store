<?php
// ====================================
// HELPER FUNCTIONS
// File: includes/functions.php
// ====================================

// Sanitize input
function sanitize($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Get all categories
function getCategories($conn) {
    $query = "SELECT * FROM categories ORDER BY category_name ASC";
    $result = mysqli_query($conn, $query);
    $categories = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

// Get category name by ID
function getCategoryName($conn, $category_id) {
    $category_id = (int)$category_id;
    $query = "SELECT category_name FROM categories WHERE id = $category_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['category_name'];
    }
    
    return 'Unknown';
}

// Get total apps count
function getTotalApps($conn) {
    $query = "SELECT COUNT(*) as total FROM apps";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    
    return 0;
}

// Get total downloads count
function getTotalDownloads($conn) {
    $query = "SELECT SUM(downloads) as total FROM apps";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }
    
    return 0;
}

// Get recent apps
function getRecentApps($conn, $limit = 10) {
    $limit = (int)$limit;
    $query = "SELECT * FROM apps ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);
    $apps = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $apps[] = $row;
        }
    }
    
    return $apps;
}

// Get featured apps (most downloaded)
function getFeaturedApps($conn, $limit = 6) {
    $limit = (int)$limit;
    $query = "SELECT * FROM apps ORDER BY downloads DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);
    $apps = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $apps[] = $row;
        }
    }
    
    return $apps;
}

// Get app by ID
function getAppById($conn, $app_id) {
    $app_id = (int)$app_id;
    $query = "SELECT * FROM apps WHERE id = $app_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Search apps
function searchApps($conn, $search_term) {
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $query = "SELECT * FROM apps WHERE name LIKE '%$search_term%' OR description LIKE '%$search_term%' ORDER BY downloads DESC";
    $result = mysqli_query($conn, $query);
    $apps = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $apps[] = $row;
        }
    }
    
    return $apps;
}

// Get apps by category
function getAppsByCategory($conn, $category_id) {
    $category_id = (int)$category_id;
    $query = "SELECT * FROM apps WHERE category = $category_id ORDER BY downloads DESC";
    $result = mysqli_query($conn, $query);
    $apps = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $apps[] = $row;
        }
    }
    
    return $apps;
}

// Increment download count
function incrementDownload($conn, $app_id) {
    $app_id = (int)$app_id;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_ip = mysqli_real_escape_string($conn, $user_ip);
    
    // Update downloads count in apps table
    $query1 = "UPDATE apps SET downloads = downloads + 1 WHERE id = $app_id";
    mysqli_query($conn, $query1);
    
    // Insert download record
    $query2 = "INSERT INTO downloads (app_id, user_ip) VALUES ($app_id, '$user_ip')";
    mysqli_query($conn, $query2);
}

// Format file size
function formatFileSize($size_string) {
    // If already formatted (contains MB, KB, etc.), return as is
    if (preg_match('/[KMGT]B/i', $size_string)) {
        return $size_string;
    }
    
    // Otherwise, assume bytes and convert
    $bytes = (int)$size_string;
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Validate image upload
function validateImage($file) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 5 * 1024 * 1024; // 5MB
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return "Invalid image format. Allowed: JPG, JPEG, PNG, GIF";
    }
    
    if ($file['size'] > $max_size) {
        return "Image size must be less than 5MB";
    }
    
    return true;
}

// Validate app file upload
function validateAppFile($file) {
    $allowed_extensions = array('zip', 'rar', 'apk', 'exe', 'dmg');
    $max_size = 100 * 1024 * 1024; // 100MB
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return "Invalid file format. Allowed: ZIP, RAR, APK, EXE, DMG";
    }
    
    if ($file['size'] > $max_size) {
        return "File size must be less than 100MB";
    }
    
    return true;
}

// Upload file
function uploadFile($file, $upload_dir) {
    $file_name = basename($file['name']);
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    
    // Generate unique filename
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_path = $upload_dir . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $new_filename;
    }
    
    return false;
}

// Delete file
function deleteFile($file_path) {
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

// Time ago function
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $time_difference = time() - $time;
    
    if ($time_difference < 1) {
        return 'just now';
    }
    
    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    
    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;
        
        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}
?>
