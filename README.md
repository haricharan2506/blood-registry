# Blood Registry (PHP + MySQL + HTML/CSS/JS)

A clean, modern blood donor & request registry built for XAMPP (PHP 8+, MySQL).  
Includes: donor signup, search by blood group & city, request blood, and an admin dashboard to manage donors/requests. Uses PDO with prepared statements.

## Quick Setup (XAMPP)
1. Copy the `blood-registry` folder to `C:\xampp\htdocs\blood-registry` (Windows) or `/Applications/XAMPP/htdocs/blood-registry` (macOS).
2. Start **Apache** and **MySQL** from XAMPP Control Panel.
3. Open **phpMyAdmin** → create database `blood_registry` (utf8mb4).
4. Import `sql/schema.sql` into that database.
5. Open `config/db.php` and confirm DB credentials (default: user `root`, empty password on Windows).
6. Visit: `http://localhost/blood-registry/public/`

**Admin Login:**  
- Email: `admin@example.com`  
- Password: `admin123`

> Change the default admin password after first login in the dashboard.

## Project structure
```
blood-registry/
  assets/
    css/styles.css
    js/app.js
  config/db.php
  partials/header.php
  partials/navbar.php
  partials/footer.php
  public/
    index.php
    register.php
    thanks.php
    search.php
    request-blood.php
    login.php
    logout.php
    dashboard.php
    donors.php
    requests.php
    add-donor.php
    edit-donor.php
    delete-donor.php
    approve-request.php
  sql/schema.sql
  README.md
```

## Notes
- Uses lightweight CSS transitions & animations (fade-in, glass cards, hover, page transitions).
- Client-side validation in `assets/js/app.js` and server-side validation in PHP.
- Basic session auth for admin pages.  
- This is a starter project—secure further for production (CSRF, stricter validation, HTTPS, rate limits).
