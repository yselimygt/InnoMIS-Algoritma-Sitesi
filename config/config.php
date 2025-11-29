<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'innomis_algo');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application Configuration
define('APP_URL', 'http://localhost/InnoMIS-Algoritma-Sitesi/public_html');
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
