<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'innomis_algo');
define('DB_USER', 'root');
define('DB_PASS', '');

/*
define('DB_HOST', 'localhost'); // Burası genelde localhost kalır, değiştirmeyin.
define('DB_NAME', 'innomis_algo'); // Hostinger'daki tam veritabanı adı
define('DB_USER', 'admin');  // Hostinger'daki kullanıcı adı
define('DB_PASS', '123456');          // Oluştururken girdiğiniz şifre
*/

// Application Configuration
define('APP_URL', 'http://localhost/InnoMIS-Algoritma-Sitesi/public_html');

/*web sitesinde kullanılacak url
define('APP_URL', 'websitesi domaini');*/
define('APP_NAME', 'InnoMIS Algoritma Platformu');

// Sandbox Configuration
// Modes: 'docker' (önerilen), 'local' (mevcut basit exec), 'judge0' (harici servis)
define('SANDBOX_MODE', 'local');
define('JUDGE0_URL', ''); // Örn: https://judge0.yourdomain.com
define('JUDGE0_API_KEY', '');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Europe/Istanbul');

// CSRF Enforcement
// Set to false to disable global CSRF checks (not recommended)
define('ENFORCE_CSRF', true);
// Array of path prefixes to exempt from CSRF checking (e.g. API endpoints)
define('CSRF_EXEMPT_PREFIXES', ['/api/']);
