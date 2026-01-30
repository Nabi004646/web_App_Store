# 🚀 Web Play Store
### A Modern PHP + MySQL Web App Marketplace

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-yellow)
![Responsive](https://img.shields.io/badge/Design-Responsive-green)
![License](https://img.shields.io/badge/License-MIT-lightgrey)

A modern, fully responsive Web Play Store platform where users can browse, search, and install web apps — built using HTML, CSS, JavaScript, PHP, and MySQL (MySQLi).

Designed with:
✨ Beautiful UI  
🎨 Smooth animations  
🔐 Secure authentication  
🛠 Admin dashboard  
👤 User dashboard  
📦 Install tracking system  
📬 Newsletter subscription  

---

# 📸 Screenshots

## 🏠 Home Page
![Home Screenshot](assets/screenshots/screen1.png)

## 📊 Dashboard
![Dashboard Screenshot](assets/screenshots/screen2.png)

Replace these two images with your own screenshots:

assets/screenshots/screen1.png  
assets/screenshots/screen2.png  

---

# ✨ Features

### 👥 User Features
- Register / Login / Logout
- Personal dashboard
- Install apps
- Install history tracking
- Profile management
- Change password

### 🛍 Store Features
- App listing
- Categories filtering
- Search system
- App details page
- Download counter
- Responsive app cards
- Smooth animations

### 🛠 Admin Panel
- Secure admin login
- Add / Edit / Delete apps
- Upload icons and files
- Manage users
- Manage categories
- Manage blogs
- View statistics
- View subscribers

### 📰 Extra Pages
- Blog
- About
- Privacy Policy
- Contact
- Newsletter subscription

### 🎨 UI/UX
- Mobile-first responsive design
- Modern cards layout
- Hover animations
- Sticky navbar
- Sidebar dashboard
- Dark/Light theme toggle
- Clean typography

---

# 🧰 Tech Stack

Frontend:
- HTML5
- CSS3
- Vanilla JavaScript

Backend:
- PHP (procedural)
- MySQL
- MySQLi

Server:
- Apache (XAMPP / LAMP compatible)

---

# 📁 Project Structure

web-playstore/
│
├── admin/
├── user/
├── blog/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── screenshots/
├── includes/
├── uploads/
├── index.php
├── login.php
├── register.php
├── app-details.php
├── dashboard.php
└── database.sql

---

# ⚙ Installation Guide

Step 1 – Clone project
git clone https://github.com/yourusername/web-playstore.git

OR copy manually into:
htdocs/ (XAMPP)
var/www/html (Linux)

Step 2 – Setup database
Open: http://localhost/phpmyadmin
Create database: web_playstore
Import: database.sql

Step 3 – Configure DB connection
Edit includes/db.php and update credentials:

$host = "localhost";
$user = "root";
$pass = "";
$db   = "web_playstore";

Step 4 – Run
http://localhost/web-playstore/
Admin → /admin/login.php

---

# 🔐 Security

- password_hash()
- password_verify()
- Sessions authentication
- SQL injection prevention
- File upload validation
- Protected admin routes

---

# 📬 Newsletter

Users can subscribe via email.  
Stored inside the subscriptions table.

---

# 🚀 Future Improvements

- Payments integration
- PWA support
- Ratings & reviews
- Comments system
- REST API
- Multi-language
- SaaS version

---

# 👨‍💻 Author

Nabin Kunwar (Nabi)  
Full Stack Developer | Web Designer | Freelancer

GitHub: your-link  
Portfolio: your-link  

---

# 📄 License

MIT License — free to use and modify.

⭐ If you like this project, give it a star!
