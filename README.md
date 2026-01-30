# 🌐 Web Play Store

A complete full-stack web application for managing and distributing web apps — similar to the Google Play Store. Built with PHP, MySQL, HTML5, CSS3, and Vanilla JavaScript.  
Responsive, lightweight, and easy to deploy.

---

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)]() [![PHP](https://img.shields.io/badge/PHP-7%2B-8892BF)]() [![MySQL](https://img.shields.io/badge/MySQL-5.6%2B-00758F)]()

## 🚀 Highlights
- Clean, modern UI with responsive design (mobile & desktop)
- Full admin dashboard for app and user management
- Secure authentication and basic security measures
- File uploads for app icons and packages with validation
- Real-time download tracking

---

## 📋 Table of Contents
- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Project Structure](#-project-structure)
- [Usage](#-usage)
- [Security Features](#-security-features)
- [Customization](#-customization)
- [Database Tables](#-database-tables)
- [Troubleshooting](#-troubleshooting)
- [Updating](#-updating)
- [License & Support](#-license--support)
- [Coming Soon](#-coming-soon)

---

## ✨ Features

### 👥 User Features
- Browse apps by category
- Search functionality
- View app details (description, version, size, downloads)
- Download / install apps
- Responsive design for mobile & desktop
- Clean, modern UI

### 🛠️ Admin Features
- Secure admin login system
- Dashboard with statistics
- Add new apps with file uploads
- Edit existing apps
- Delete apps
- Manage users
- Real-time download tracking

---

## 📋 Requirements
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache Web Server (XAMPP / LAMP / WAMP)
- Modern web browser

---

## 🔧 Installation

### Step 1 — Extract Files
Extract the `web-playstore` folder to your web server directory:
- XAMPP: `C:/xampp/htdocs/`
- WAMP: `C:/wamp/www/`
- LAMP: `/var/www/html/`

### Step 2 — Create Database
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click **New** to create a database
3. Name it: `web_playstore`
4. Click **Import**
5. Choose `database.sql` from the project
6. Click **Go** to import

OR run the SQL directly:
- Open `database.sql`
- Copy all SQL code
- Paste into phpMyAdmin SQL tab and execute

### Step 3 — Configure Database Connection
Edit `includes/db.php` if needed (default settings work for XAMPP):

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'web_playstore');
```

### Step 4 — Set Permissions
Make sure the `uploads/apps/` folder is writable:
- Windows: Right-click folder → Properties → Security → Allow "Write"
- Linux: `chmod 755 uploads/apps/`

### Step 5 — Access the Application
- Frontend (User Side): `http://localhost/web-playstore/`
- Admin Panel: `http://localhost/web-playstore/admin/login.php`

**Default Admin Credentials**
- Email: `admin@webplaystore.com`  
- Password: `admin123`

---

## 📁 Project Structure

```
web-playstore/
├── admin/
│   ├── assets/
│   │   ├── admin.css
│   │   └── admin.js
│   ├── login.php
│   ├── dashboard.php
│   ├── add-app.php
│   ├── edit-app.php
│   ├── delete-app.php
│   ├── manage-users.php
│   └── logout.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
├── includes/
│   ├── db.php
│   ├── auth.php
│   └── functions.php
├── uploads/
│   └── apps/
├── index.php
├── app-details.php
├── search.php
├── category.php
├── install.php
└── database.sql
```

---

## 🎯 Usage

### Adding New Apps (Admin)
1. Login to admin panel
2. Click "Add New App" in sidebar
3. Fill in app details:
   - App Name
   - Version
   - Category
   - Description
   - Upload App Icon (JPG, PNG, GIF - Max 5MB)
   - Upload App File (ZIP, RAR, APK, EXE, DMG - Max 100MB)
4. Click **Add App**

### Editing Apps (Admin)
1. Go to Dashboard
2. Find the app in the list
3. Click **Edit**
4. Make changes
5. Optionally upload new icon/file
6. Click **Update App**

### Deleting Apps (Admin)
1. Go to Dashboard
2. Find the app
3. Click **Delete**
4. Confirm deletion

### Downloading Apps (User)
1. Browse or search for apps
2. Click an app to view details
3. Click **Download & Install**
4. File will download automatically

---

## 🔒 Security Features
- Password hashing (bcrypt)
- SQL injection prevention (mysqli_real_escape_string)
- Session-based authentication
- Admin route protection
- File upload validation
- Size limits on uploads
- CSRF protection ready

> Note: Always enforce HTTPS in production and review PHP settings for secure file handling.

---

## 🎨 Customization

### Changing Colors
Edit `assets/css/style.css` and modify CSS variables:

```css
:root {
    --primary-color: #1a73e8;
    --secondary-color: #34a853;
    /* etc. */
}
```

### Adding Categories
1. Login to phpMyAdmin
2. Go to `categories` table
3. Click **Insert**
4. Add new category name

### Changing Logo
- Frontend: modify `.logo` in `index.php`
- Admin: modify `.sidebar-logo` in admin pages

---

## 📊 Database Tables
1. `users` — Store admin/user accounts  
2. `categories` — App categories  
3. `apps` — All app information  
4. `downloads` — Download tracking with IP addresses

---

## 🐛 Troubleshooting

### Database Connection Error
- Check credentials in `includes/db.php`
- Ensure MySQL service is running
- Verify database name is correct

### File Upload Error
- Ensure `uploads/apps/` exists and is writable
- Check `php.ini` upload limits:
  - `upload_max_filesize = 100M`
  - `post_max_size = 100M`

### Admin Login Not Working
- Verify database import
- Check `users` table for admin account
- Clear browser cache and cookies

### Images Not Displaying
- Check file paths
- Ensure images are in `uploads/apps/`
- Verify file permissions

---

## 🔄 Updating
1. Backup your database
2. Backup `uploads/` folder
3. Replace old files with new ones
4. Keep `includes/db.php` settings
5. Keep `uploads/` folder

---

## 📝 License
This project is free to use for personal and commercial purposes.

---

## 👨‍💻 Developer Notes
- Built with vanilla PHP (no frameworks)
- Uses MySQLi (not PDO)
- Fully responsive design
- Production-ready code with clear comments and structure

---

## 🆘 Support
If you need help:
1. Read this README
2. Review code comments
3. Check browser console for JS errors
4. Check Apache / PHP error logs

---

## ✨ Features Coming Soon
- App ratings and reviews
- Advanced search filters
- App screenshots gallery
- User registration
- Download history
- Email notifications

---

**Developed by NABIN with CLAUDE BRO— Web Play Store Project**
