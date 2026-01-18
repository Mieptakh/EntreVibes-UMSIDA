<?php
// =========================
// PURE ROUTING - NO DATABASE
// =========================
session_start();

// BASE_PATH tetap perlu untuk include file
define('BASE_PATH', __DIR__);

// BASE_URL otomatis - FIXED VERSION
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);

// Pastikan ada slash di akhir
$baseUrl = $protocol . '://' . $host . $scriptPath;
if (substr($baseUrl, -1) !== '/') {
    $baseUrl .= '/';
}
define('BASE_URL', $baseUrl);

// =========================
// HELPER FUNCTIONS
// =========================
function redirect($path) {
    $url = BASE_URL . ltrim($path, '/');
    header('Location: ' . $url);
    exit;
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function renderErrorPage($code, $title, $message) {
    http_response_code($code);
    echo "<div style='font-family:sans-serif; text-align:center; padding:50px;'>
            <h1>{$code}</h1><h2>{$title}</h2><p>{$message}</p>
            <a href='".BASE_URL."'>Back to Home</a>
          </div>";
    exit;
}

// =========================
// ROUTES CONFIG
// =========================
$defaultPage = 'home';

// SEMUA PAGE PUBLIK - tambahin links di sini
$publicPages = [
    'home'         => 'home.php',
    'pendaftaran'  => 'pendaftaran.php',
    'gallery'      => 'gallery.php',
    'about'        => 'about.php',
    'timeline'     => 'timeline.php',
    'competitions' => 'competitions.php',
    'partnership'  => 'partnership.php',
    'faq'          => 'faq.php',
    'links'        => 'links.php',  // INI NIH YG DITAMBAHIN
    'contact'      => 'contact.php',
];

$adminPages = [
    'admin'               => ['file' => 'admin/index.php', 'auth' => true],
    'admin/dashboard'     => ['file' => 'admin/dashboard.php', 'auth' => true],
    'admin/faq'           => ['file' => 'admin/faq.php', 'auth' => true],
    'admin/gallery'       => ['file' => 'admin/gallery.php', 'auth' => true],
    'admin/competitions'  => ['file' => 'admin/competitions.php', 'auth' => true],
    'admin/partners'      => ['file' => 'admin/partners.php', 'auth' => true],
    'admin/registrations' => ['file' => 'admin/registrations.php', 'auth' => true],
    'admin/stats'         => ['file' => 'admin/stats.php', 'auth' => true],
    'admin/timeline'      => ['file' => 'admin/timeline.php', 'auth' => true],
    'admin/users'         => ['file' => 'admin/users.php', 'auth' => true],
    'admin/settings'      => ['file' => 'admin/settings.php', 'auth' => true],
    'admin/login'         => ['file' => 'admin/login.php', 'auth' => false],
    'admin/logout'        => ['file' => 'admin/logout.php', 'auth' => true],
];

// =========================
// ROUTE PARSING
// =========================
$route = $_GET['route'] ?? $defaultPage;
$route = trim($route, '/');
$route = $route === '' ? $defaultPage : $route;

// =========================
// DEBUG MODE
// =========================
$debug = false; // Set true untuk debugging
if ($debug) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    echo "<!-- DEBUG: Route = '$route' -->\n";
    echo "<!-- DEBUG: BASE_URL = '" . BASE_URL . "' -->\n";
    echo "<!-- DEBUG: BASE_PATH = '" . BASE_PATH . "' -->\n";
}

// =========================
// PURE ROUTER LOGIC
// =========================
try {
    // 1. ADMIN ROUTES
    if (str_starts_with($route, 'admin')) {
        if (!isset($adminPages[$route])) {
            renderErrorPage(404, 'Admin Not Found', 'Halaman admin tidak ditemukan.');
        }

        $page = $adminPages[$route];
        
        // Authentication check
        if ($page['auth'] && !isAdmin()) {
            redirect('admin/login');
        }
        
        // Prevent login page access if already logged in
        if ($route === 'admin/login' && isAdmin()) {
            redirect('admin/dashboard');
        }

        $file = BASE_PATH . '/' . $page['file'];
        if (file_exists($file)) {
            if ($debug) echo "<!-- DEBUG: Loading admin file: $file -->\n";
            require $file;
            exit;
        }
    }

    // 2. PUBLIC ROUTES - INI YG PENTING BANGET
    if (isset($publicPages[$route])) {
        $file = BASE_PATH . '/' . $publicPages[$route];
        if ($debug) echo "<!-- DEBUG: Public route detected: $route -> $file -->\n";
        
        if (file_exists($file)) {
            if ($debug) echo "<!-- DEBUG: Loading public file: $file -->\n";
            require $file;
            exit;
        } else {
            if ($debug) echo "<!-- DEBUG: File not found: $file -->\n";
            renderErrorPage(404, 'File Not Found', "Halaman '$route' tidak ditemukan.");
        }
    }

    // 3. DIRECT PHP FILE ACCESS (with security)
    $directFile = BASE_PATH . '/' . $route . '.php';
    if ($debug) echo "<!-- DEBUG: Checking direct file: $directFile -->\n";
    
    if (file_exists($directFile) && is_file($directFile)) {
        // Security: block access to sensitive directories
        $forbiddenPaths = ['admin/', 'database/', 'config/', 'includes/', 'inc/', 'lib/'];
        $normalizedRoute = str_replace('\\', '/', $route) . '/';
        
        $blocked = false;
        foreach ($forbiddenPaths as $badPath) {
            if (strpos($normalizedRoute, $badPath) === 0 || 
                strpos('/' . $normalizedRoute, '/' . $badPath) !== false) {
                $blocked = true;
                break;
            }
        }
        
        if ($blocked) {
            renderErrorPage(403, 'Forbidden', 'Akses ditolak.');
        }
        
        if ($debug) echo "<!-- DEBUG: Loading direct file: $directFile -->\n";
        require $directFile;
        exit;
    }

    // 4. 404 - NOT FOUND
    if ($debug) echo "<!-- DEBUG: No route matched, showing 404 -->\n";
    renderErrorPage(404, 'Not Found', 'Halaman tidak ditemukan.');

} catch (Throwable $e) {
    // Error logging untuk debugging
    if ($debug || ini_get('display_errors')) {
        echo "<pre style='background:#f00;color:#fff;padding:20px;'>";
        echo "ROUTER ERROR:\n";
        echo "Message: " . htmlspecialchars($e->getMessage()) . "\n";
        echo "File: " . htmlspecialchars($e->getFile()) . "\n";
        echo "Line: " . htmlspecialchars($e->getLine()) . "\n";
        echo "Route: " . htmlspecialchars($route) . "\n";
        echo "Trace:\n" . htmlspecialchars($e->getTraceAsString());
        echo "</pre>";
    } else {
        renderErrorPage(500, 'Server Error', 'Terjadi kesalahan pada sistem.');
    }
}