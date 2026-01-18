<?php
// =======================
// KONEKSI DATABASE
// =======================
try {
    $db = new PDO('sqlite:' . __DIR__ . '/database/competitions.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Koneksi gagal: " . $e->getMessage());
}

// =======================
// FETCH DATA
// =======================
function fetchAllFromTable(PDO $db, string $table) {
    try {
        $stmt = $db->prepare("SELECT * FROM $table ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Jika tabel tidak ada atau error lain
        return [];
    }
}

$faq_items      = fetchAllFromTable($db, 'faq');
$partners       = fetchAllFromTable($db, 'partners');
$kompetisis     = fetchAllFromTable($db, 'kompetisi');
$timeline_items = fetchAllFromTable($db, 'timeline');
$stats_items    = fetchAllFromTable($db, 'stats');
$galeri_items   = fetchAllFromTable($db, 'galeri');

// =======================
// FORM SUBMISSION
// =======================
$formStatus = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $school   = trim($_POST['school'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $note     = trim($_POST['note'] ?? '');

    if ($name && $email && $category) {
        try {
            $stmt = $db->prepare("INSERT INTO pendaftaran (name, school, email, phone, category, note) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $school, $email, $phone, $category, $note]);
            $formStatus = "✅ Pendaftaran berhasil terkirim!";
        } catch (PDOException $e) {
            $formStatus = "❌ Gagal menyimpan data: " . $e->getMessage();
        }
    } else {
        $formStatus = "⚠️ Harap isi semua field wajib!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UMSIDA EntreVibes Vol. 1 — Kompetisi Pelajar & Mahasiswa Seluruh Indonesia</title>
  <meta name="description" content="Ikuti UMSIDA EntreVibes Vol. 1, kompetisi bergengsi untuk generasi muda Seluruh Indonesia. Daftar sekarang dan tunjukkan kreativitas, inovasi, dan prestasi terbaikmu!">
  <meta name="keywords" content="UMSIDA EntreVibes Vol. 1, lomba pelajar Seluruh Indonesia, kompetisi mahasiswa, lomba kreativitas, inovasi pelajar, ajang prestasi Sumsel, kompetisi 2025, youth competition, pendaftaran kompetisi,  Indonesia,">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Favicon -->
  <link rel="icon" href="images/logo_default.png" type="image/x-icon">
  <link rel="shortcut icon" href="images/logo_default.png" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="180x180" href="images/logo_default.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/logo_default.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/logo_default.png">

  <!-- Canonical URL -->
  <link rel="canonical" href="https://www.sumselyouthcomp.mhteams.my.id" />

  <!-- Open Graph / Social Sharing -->
  <meta property="og:title" content="UMSIDA EntreVibes Vol. 1 — Kompetisi Pelajar & Mahasiswa Seluruh Indonesia">
  <meta property="og:description" content="Daftar sekarang di UMSIDA EntreVibes Vol. 1! Kompetisi bergengsi untuk generasi muda Seluruh Indonesia, tingkatkan kreativitas, inovasi, dan prestasi.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.sumselyouthcomp.mhteams.my.id>
  <meta property="og:image" content="images/ Seluruh Indonesia (1).png">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="UMSIDA EntreVibes Vol. 1">
  <meta name="twitter:description" content="Kompetisi bergengsi untuk generasi muda Seluruh Indonesia. Daftar sekarang!">
  <meta name="twitter:image" content="images/ Seluruh Indonesia (1).png">

  <style>
/* =========================================================================
   Fonts - Montserrat (CDN Only)
   ========================================================================= */

/* Import Montserrat dari Google Fonts CDN */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');

/* Definisi font-family untuk seluruh website */
:root {
  --font-montserrat: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
}

/* Terapkan Montserrat ke body */
body {
  font-family: var(--font-montserrat);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

    /* Load Inter as fallback from Google Fonts (if available) */
    /* If not available, system fonts are used */
:root {
  /* Font Family - Montserrat */
  font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
  
  /* Color Palette Baru */
  --primary: #62237e;      /* Ungu utama */
  --primary-dark: #5c1f7f; /* Ungu lebih gelap */
  --light: #fdfcfd;        /* Putih lembut */
  --accent: #efa609;       /* Emas/Orange */
  
  /* Derived Colors untuk konsistensi */
  --bg: var(--light);              /* Background utama */
  --text: #2a1a35;                 /* Teks utama (lebih gelap untuk kontras) */
  --muted: #6d5a7a;                /* Teks sekunder */
  --accent1: var(--primary);       /* Warna aksen 1 = primary */
  --accent2: var(--accent);        /* Warna aksen 2 = accent gold */
  
  /* Glass & Card Effects */
  --glass: rgba(253, 252, 253, 0.85);    /* Efek glass dengan warna light */
  --card: rgba(255, 255, 255, 0.92);     /* Card background */
  --shadow: rgba(98, 35, 126, 0.15);     /* Shadow dengan warna primary */
  --radius: 16px;                        /* Border radius */
  --max: 1400px;                         /* Max width container */
  --glass-border: rgba(98, 35, 126, 0.12); /* Border glass effect */
  
  /* Gradients untuk berbagai penggunaan */
  --gradient-primary: linear-gradient(135deg, var(--primary), var(--primary-dark));
  --gradient-accent: linear-gradient(135deg, var(--accent), #ffb347);
  --gradient-mix: linear-gradient(135deg, var(--primary), var(--accent));
  
  /* States */
  --hover-primary: #7a2b9c;        /* Hover state untuk primary */
  --hover-accent: #ffb93e;         /* Hover state untuk accent */
  
  /* Golden Ratio Scale */
  --gr-1: 1rem;
  --gr-1-618: 1.618rem;
  --gr-2-618: 2.618rem;
  --gr-4-236: 4.236rem;
  --gr-6-854: 6.854rem;
}

/* Dark Mode Colors - dengan palette yang sama tapi lebih gelap */
[data-theme="dark"] {
  --primary: #b580d6;               /* Ungu lebih terang untuk dark mode */
  --primary-dark: #9a6bb8;          /* Ungu gelap untuk dark mode */
  --light: #1a1420;                 /* Background gelap */
  --accent: #ffc156;                /* Emas lebih terang */
  
  --bg: var(--light);
  --text: #f5f0fa;                  /* Teks terang untuk dark mode */
  --muted: #b8a9c7;                 /* Muted lebih terang */
  
  --glass: rgba(26, 20, 32, 0.85);
  --card: rgba(35, 28, 42, 0.92);
  --shadow: rgba(181, 128, 214, 0.2);
  --glass-border: rgba(181, 128, 214, 0.15);
}

    /* Dark mode colors */
    [data-theme="dark"] {
      --bg: #0f0f12;
      --text: #f3efe9;
      --muted: #cfc7d6;
      --glass: rgba(20,18,24,0.6);
      --card: rgba(16,14,20,0.6);
      --shadow: rgba(0,0,0,0.5);
      --glass-border: rgba(255,255,255,0.06);
    }

    /* Base reset */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html,body { height: 100%; }
    body {
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow-x: hidden;
      transition: background 0.25s ease, color 0.25s ease;
    }

    /* Container helpers */
    .container {
      width: 100%;
      max-width: var(--max);
      margin: 0 auto;
      padding: 0 2rem;
    }

/* =========================================================================
   LOADING SCREEN - MINIMALIST DESIGN
   ========================================================================= */
.loader-wrap {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: 
        url('images/Background.png') center/cover no-repeat,
        linear-gradient(135deg, rgba(98, 35, 126, 0.92), rgba(92, 31, 127, 0.95));
    z-index: 99999;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.loader-wrap::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        to bottom,
        rgba(98, 35, 126, 0.3) 0%,
        rgba(92, 31, 127, 0.5) 50%,
        rgba(98, 35, 126, 0.3) 100%
    );
    z-index: 1;
}

.loader-wrap.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

/* =========================================================================
   MAIN LOADER CONTENT
   ========================================================================= */
.loader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 400px;
    padding: 0 2rem;
    position: relative;
    z-index: 2;
}

/* =========================================================================
   BRAND AREA - MINIMALIST
   ========================================================================= */
.brand-area {
    text-align: center;
    margin-bottom: 3rem;
}

.brand-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.logo-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.15);
    position: relative;
    overflow: hidden;
}

.logo-circle::before {
    content: '';
    position: absolute;
    inset: -1px;
    background: linear-gradient(135deg, var(--accent), var(--primary));
    border-radius: 50%;
    opacity: 0.3;
    z-index: -1;
}

.logo-circle img {
    width: 100px;
    height: 100px;
    object-fit: contain;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.2));
}

.brand-name {
    font-size: 2.8rem;
    font-weight: 800;
    color: white;
    letter-spacing: 1px;
    margin: 0.5rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.brand-subtitle {
    font-size: 1rem;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.9);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin: 0;
}

/* =========================================================================
   LOADING ANIMATION - MINIMALIST
   ========================================================================= */
.loading-animation {
    position: relative;
    margin: 2.5rem 0;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.spinner-ring {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.15);
    border-top: 2px solid var(--accent);
    animation: spin 1.5s linear infinite;
    margin-bottom: 1.5rem;
}

.loading-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 0.5rem;
}

.loading-dots span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    animation: bounce 1.4s infinite ease-in-out both;
}

.loading-dots span:nth-child(1) { 
    animation-delay: -0.32s; 
    background: var(--accent);
}
.loading-dots span:nth-child(2) { 
    animation-delay: -0.16s; 
    background: rgba(255, 255, 255, 0.8);
}
.loading-dots span:nth-child(3) { 
    animation-delay: 0s; 
    background: rgba(255, 255, 255, 0.6);
}

/* =========================================================================
   PROGRESS AREA - MINIMALIST
   ========================================================================= */
.progress-area {
    width: 100%;
    max-width: 320px;
    margin-top: 1rem;
}

.progress-track {
    width: 100%;
    height: 3px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1.5px;
    overflow: hidden;
    position: relative;
}

.progress-indicator {
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    border-radius: 1.5px;
    position: relative;
    transition: width 0.3s ease;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.8rem;
    font-size: 0.85rem;
}

.progress-info .status {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

.progress-info .percent {
    color: var(--accent);
    font-weight: 700;
    font-feature-settings: "tnum";
    font-variant-numeric: tabular-nums;
}

/* =========================================================================
   LOADER FOOTER
   ========================================================================= */
.loader-footer {
    position: absolute;
    bottom: 2rem;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 2;
}

.loader-footer p {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
    padding: 0 1rem;
    letter-spacing: 0.5px;
}

.loader-footer p::before {
    content: '•';
    margin: 0 0.5rem;
    color: var(--accent);
}

.loader-footer p::after {
    content: '•';
    margin: 0 0.5rem;
    color: var(--accent);
}

/* =========================================================================
   ANIMATIONS
   ========================================================================= */
@keyframes spin { 
    0% { transform: rotate(0deg); } 
    100% { transform: rotate(360deg); } 
}

@keyframes bounce {
    0%, 80%, 100% { 
        transform: scale(0); 
        opacity: 0.5;
    }
    40% { 
        transform: scale(1); 
        opacity: 1;
    }
}

@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(10px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

/* Fade in animation untuk semua elemen */
.brand-area {
    animation: fadeIn 0.6s ease-out 0.2s both;
}

.loading-animation {
    animation: fadeIn 0.6s ease-out 0.4s both;
}

.progress-area {
    animation: fadeIn 0.6s ease-out 0.6s both;
}

.loader-footer {
    animation: fadeIn 0.6s ease-out 0.8s both;
}

/* =========================================================================
   RESPONSIVE DESIGN
   ========================================================================= */

/* Tablet Devices */
@media (max-width: 1024px) {
    .loader-content {
        max-width: 350px;
    }
    
    .logo-circle {
        width: 90px;
        height: 90px;
    }
    
    .logo-circle img {
        width: 55px;
        height: 55px;
    }
    
    .brand-name {
        font-size: 2.4rem;
    }
    
    .brand-subtitle {
        font-size: 0.95rem;
    }
    
    .spinner-ring {
        width: 70px;
        height: 70px;
    }
}

/* Small Tablets & Large Phones */
@media (max-width: 768px) {
    .loader-content {
        padding: 0 1.5rem;
        max-width: 320px;
    }
    
    .brand-area {
        margin-bottom: 2.5rem;
    }
    
    .brand-logo {
        gap: 1.2rem;
    }
    
    .logo-circle {
        width: 80px;
        height: 80px;
    }
    
    .logo-circle img {
        width: 50px;
        height: 50px;
    }
    
    .brand-name {
        font-size: 2.2rem;
    }
    
    .brand-subtitle {
        font-size: 0.9rem;
        letter-spacing: 1.5px;
    }
    
    .loading-animation {
        margin: 2rem 0;
    }
    
    .spinner-ring {
        width: 65px;
        height: 65px;
        margin-bottom: 1.2rem;
    }
    
    .loading-dots span {
        width: 5px;
        height: 5px;
    }
    
    .progress-area {
        max-width: 280px;
    }
    
    .loader-footer {
        bottom: 1.5rem;
    }
    
    .loader-footer p {
        font-size: 0.75rem;
    }
}

/* Mobile Phones */
@media (max-width: 480px) {
    .loader-content {
        padding: 0 1rem;
        max-width: 280px;
    }
    
    .brand-area {
        margin-bottom: 2rem;
    }
    
    .logo-circle {
        width: 70px;
        height: 70px;
    }
    
    .logo-circle img {
        width: 45px;
        height: 45px;
    }
    
    .brand-name {
        font-size: 1.9rem;
        letter-spacing: 0.5px;
    }
    
    .brand-subtitle {
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
    
    .loading-animation {
        margin: 1.8rem 0;
    }
    
    .spinner-ring {
        width: 60px;
        height: 60px;
        margin-bottom: 1rem;
        border-width: 1.5px;
    }
    
    .loading-dots {
        gap: 5px;
    }
    
    .loading-dots span {
        width: 4px;
        height: 4px;
    }
    
    .progress-area {
        max-width: 240px;
        margin-top: 0.8rem;
    }
    
    .progress-info {
        font-size: 0.8rem;
        margin-top: 0.6rem;
    }
    
    .loader-footer {
        bottom: 1.2rem;
    }
    
    .loader-footer p {
        font-size: 0.7rem;
        padding: 0 0.8rem;
    }
}

/* Landscape Orientation */
@media (max-height: 600px) and (orientation: landscape) {
    .loader-content {
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        max-width: 90%;
        gap: 2rem;
        padding: 1rem;
    }
    
    .brand-area {
        margin-bottom: 0;
        text-align: left;
        flex: 1;
    }
    
    .brand-logo {
        align-items: flex-start;
        gap: 0.8rem;
    }
    
    .logo-circle {
        width: 60px;
        height: 60px;
    }
    
    .logo-circle img {
        width: 40px;
        height: 40px;
    }
    
    .brand-name {
        font-size: 1.8rem;
        margin: 0.3rem 0;
    }
    
    .brand-subtitle {
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    
    .loading-animation {
        margin: 0;
        width: auto;
    }
    
    .spinner-ring {
        width: 50px;
        height: 50px;
        margin-bottom: 0.8rem;
    }
    
    .progress-area {
        max-width: 200px;
        margin-top: 0;
    }
    
    .loader-footer {
        bottom: 0.8rem;
    }
    
    .loader-footer p {
        font-size: 0.65rem;
    }
}

/* Extra Small Devices */
@media (max-width: 320px) {
    .brand-name {
        font-size: 1.6rem;
    }
    
    .brand-subtitle {
        font-size: 0.75rem;
    }
    
    .logo-circle {
        width: 60px;
        height: 60px;
    }
    
    .logo-circle img {
        width: 40px;
        height: 40px;
    }
    
    .progress-area {
        max-width: 220px;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .logo-circle {
        backdrop-filter: blur(15px);
    }
    
    .logo-circle img {
        filter: drop-shadow(0 2px 12px rgba(0, 0, 0, 0.3));
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .spinner-ring {
        animation: none;
        border: 2px solid var(--accent);
    }
    
    .loading-dots span {
        animation: none;
        opacity: 0.7;
    }
    
    .brand-area,
    .loading-animation,
    .progress-area,
    .loader-footer {
        animation: none;
        opacity: 1;
    }
}

/* Dark mode optimizations */
@media (prefers-color-scheme: dark) {
    .logo-circle {
        background: rgba(0, 0, 0, 0.2);
        border-color: rgba(255, 255, 255, 0.1);
    }
    
    .progress-track {
        background: rgba(0, 0, 0, 0.2);
    }
}

/* Untuk browser yang tidak support backdrop-filter */
@supports not (backdrop-filter: blur(10px)) {
    .logo-circle {
        background: rgba(255, 255, 255, 0.05);
    }
}

/* Progress bar shimmer effect (optional) */
.progress-indicator::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
    );
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}

/* Hanya aktif jika user tidak prefer reduced motion */
@media (prefers-reduced-motion: no-preference) {
    .progress-indicator::after {
        display: block;
    }
}

/* =========================================================================
   GLOBAL STYLES
   ========================================================================= */
:root {
  --accent1: #9f8cff;
  --accent2: #c2b6ff;
  --text-dark: #2D2A24;
  --navbar-bg: rgba(249,247,244,0.92);
}

* {
  font-family: 'Montserrat', sans-serif;
}

/* =========================================================================
   NAVBAR - FIXED + ADVANCED ANIMATION
   ========================================================================= */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1200;
  background: linear-gradient(180deg, rgba(249,247,244,0.92), rgba(249,247,244,0.82));
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-bottom: 1px solid rgba(138,124,172,0.18);
  transition: all 0.35s ease;
  padding: 1.2rem 0;
}

.navbar.scrolled {
  padding: 0.6rem 0;
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  background: linear-gradient(180deg, rgba(249,247,244,0.97), rgba(249,247,244,0.97));
  transform: translateY(0);
}

.nav-item {
  position: relative;
}

.nav-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

/* =========================================================================
   LOGO
   ========================================================================= */
.logo {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: 1.25rem;
  letter-spacing: -0.5px;
  background: linear-gradient(135deg, #461362, #6a1b9a);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-decoration: none;
  transition: transform 0.3s ease;
  cursor: pointer;
}

.logo:hover { 
  transform: scale(1.05) rotate(-2deg); 
}

.logo img {
  height: 50px;
  width: auto;
  margin-right: 0.6rem;
  vertical-align: middle;
  filter: drop-shadow(0 6px 18px rgba(138,124,172,0.2));
  transition: transform 0.3s ease;
}

.logo:hover img { 
  transform: rotate(8deg) scale(1.1); 
}

/* =========================================================================
   NAV LINKS - DESKTOP
   ========================================================================= */
.nav-links {
  display: flex;
  gap: 0.8rem;
  align-items: center;
  font-family: 'Montserrat', sans-serif;
}

.nav-links a {
  text-decoration: none;
  color: #2D2A24;
  padding: 0.55rem 1rem;
  border-radius: 999px;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;
  position: relative;
  overflow: hidden;
  transition: all 0.25s ease;
  white-space: nowrap;
}

.nav-links a::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, var(--accent1), var(--accent2));
  opacity: 0;
  transform: scale(0.8);
  border-radius: 999px;
  transition: all 0.35s ease;
  z-index: -1;
}

.nav-links a:hover {
  color: #fff;
  transform: translateY(-3px);
}

.nav-links a:hover::before {
  opacity: 1;
  transform: scale(1);
}

/* =========================================================================
   NAV DROPDOWN - DESKTOP
   ========================================================================= */
.nav-dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: calc(100% + 6px); /* jarak dari navbar */
  left: 50%;
  transform: translateX(-50%);
  
  background: #fff;
  padding: 0.75rem 0;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  
  display: none;
  min-width: 240px;
  z-index: 1000;
  font-family: 'Montserrat', sans-serif;
}

.dropdown-menu::before {
  content: "";
  position: absolute;
  top: -8px;
  left: 50%;
  transform: translateX(-50%);
  
  width: 0;
  height: 0;
  
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 8px solid #fff;
}

.nav-dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown-menu a {
  display: block;
  padding: 0.75rem 1.5rem;
  color: #2D2A24;
  text-decoration: none;
  font-weight: 500;
  font-family: 'Montserrat', sans-serif;
  transition: all 0.2s ease;
}

.dropdown-menu a:hover {
  background: linear-gradient(135deg, rgba(159,140,255,0.1), rgba(194,182,255,0.1));
  color: #f1f1f1;
  padding-left: 2rem;
}

/* =========================================================================
   CTA SMALL BUTTON
   ========================================================================= */
.cta-small {
  padding: 0.55rem 1.2rem;
  border-radius: 999px;
  font-weight: 700;
  font-family: 'Montserrat', sans-serif;
  background: linear-gradient(135deg, #9f8cff, #c2b6ff);
  color: #fff;
  text-decoration: none;
  box-shadow: 0 8px 24px rgba(159,140,255,0.28);
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
}

.cta-small:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 14px 34px rgba(138,124,172,0.28);
}

/* =========================================================================
   HAMBURGER MENU - PERFECT SHAPE + INTERACTIVE
   ========================================================================= */
.hamburger {
  display: none;
  width: 50px;
  height: 50px;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  cursor: pointer;
  position: relative;
  background: transparent;
  border: none;
  overflow: hidden;
  z-index: 1300;

  transition: background-color 0.25s ease;
}

.hamburger:hover {
  background: rgba(138, 124, 172, 0.12);
}

/* Ripple effect */
.hamburger::after {
  content: "";
  position: absolute;
  inset: 50%;
  width: 0;
  height: 0;

  background: rgba(88, 60, 140, 0.45);
  border-radius: 50%;

  transform: translate(-50%, -50%) scale(0);
  opacity: 0;

  transition:
    transform 0.45s ease-out,
    opacity 0.45s ease-out;
}

/* Active ripple */
.hamburger:active::after {
  width: 140%;
  height: 140%;
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
}

.hamburger .bar {
  width: 28px;
  height: 3px;
  background: linear-gradient(90deg, var(--accent1), var(--accent2));
  border-radius: 3px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  transition: transform 0.4s cubic-bezier(0.77, 0, 0.175, 1),
              opacity 0.3s ease;
}

:root {
  --accent1: #6d4bbd; /* violet */
  --accent2: #3f2a73; /* deep purple */
}

.hamburger .bar:nth-child(1) { 
  top: 14px; 
}

.hamburger .bar:nth-child(2) { 
  top: 50%; 
  transform: translate(-50%, -50%); 
}

.hamburger .bar:nth-child(3) { 
  bottom: 14px; 
}

/* Active (X shape) */
.hamburger.active .bar:nth-child(1) {
  top: 50%;
  transform: translate(-50%, -50%) rotate(45deg);
  background: linear-gradient(90deg, var(--accent1), var(--accent2));
}

.hamburger.active .bar:nth-child(2) {
  opacity: 0;
  transform: translate(-50%, -50%) scaleX(0);
}

.hamburger.active .bar:nth-child(3) {
  bottom: auto;
  top: 50%;
  transform: translate(-50%, -50%) rotate(-45deg);
  background: linear-gradient(90deg, var(--accent1), var(--accent2));
}

/* =========================================================================
   MOBILE OVERLAY MENU - CIRCULAR REVEAL ANIMATION
   ========================================================================= */
.mobile-overlay {
  position: fixed;
  inset: 0;

  background-image: url("images/Background.png");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;

  backdrop-filter: blur(22px);
  -webkit-backdrop-filter: blur(22px);

  z-index: 1100;
  display: flex;
  align-items: center;
  justify-content: center;

  pointer-events: none;
  opacity: 0;
  clip-path: circle(0% at 50% 50%);
  transition: clip-path 0.8s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.4s ease;
}

.mobile-overlay.active {
  opacity: 1;
  pointer-events: auto;
  clip-path: circle(150% at 50% 50%);
}

/* =========================================================================
   MOBILE MENU WRAPPER - FADE & SLIDE IN
   ========================================================================= */
.mobile-menu {
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  transform: translateY(40px);
  opacity: 0;
  animation: menuWrapperIn 0.7s forwards cubic-bezier(0.22, 1, 0.36, 1);
  animation-delay: 0.25s;
  width: 100%;
  max-width: 400px;
  padding: 0 2rem;
  font-family: 'Montserrat', sans-serif;
}

@keyframes menuWrapperIn {
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* =========================================================================
   MOBILE MENU ITEM - BOUNCE STAGGER
   ========================================================================= */
.mobile-menu a,
.mobile-menu button {
  display: block;
  color: #fff;
  font-weight: 700;
  font-size: 1.8rem;
  text-decoration: none;
  opacity: 0;
  transform: translateY(60px) scale(0.9);
  animation: menuItemIn 0.85s forwards cubic-bezier(0.68, -0.55, 0.27, 1.55);
  background: none;
  border: none;
  font-family: 'Montserrat', sans-serif;
  cursor: pointer;
  text-align: center;
  padding: 0.75rem 0;
}

.mobile-menu a:nth-child(1) { animation-delay: 0.35s; }
.mobile-menu a:nth-child(2) { animation-delay: 0.5s; }
.mobile-menu a:nth-child(3) { animation-delay: 0.65s; }
.mobile-menu a:nth-child(4) { animation-delay: 0.8s; }
.mobile-menu a:nth-child(5) { animation-delay: 0.95s; }
.mobile-menu a:nth-child(6) { animation-delay: 1.1s; }

@keyframes menuItemIn {
  0% {
    opacity: 0;
    transform: translateY(60px) scale(0.9);
    filter: blur(6px);
  }
  70% {
    opacity: 1;
    transform: translateY(-8px) scale(1.05);
    filter: blur(0);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.mobile-menu a:hover,
.mobile-menu button:hover {
  color: #fff;
  transform: scale(1.1);
  transition: all 0.35s ease;
}

/* =========================================================================
   MOBILE DROPDOWN TOGGLE
   ========================================================================= */
.mobile-dropdown-toggle {
  background: none;
  border: none;
  width: 100%;
  text-align: center;
  font: inherit;
  font-weight: 700;
  font-size: 1.8rem;
  color: #fff;
  padding: 0.75rem 0;
  cursor: pointer;
  position: relative;
  opacity: 0;
  transform: translateY(60px) scale(0.9);
  animation: menuItemIn 0.85s forwards cubic-bezier(0.68, -0.55, 0.27, 1.55);
  animation-delay: 0.5s;
}

.mobile-dropdown-toggle::after {
  content: "▼";
  font-size: 0.8rem;
  margin-left: 0.5rem;
  transition: transform 0.3s ease;
  display: inline-block;
}

.mobile-dropdown-toggle[aria-expanded="true"]::after {
  transform: rotate(180deg);
}

/* =========================================================================
   MOBILE SUBMENU
   ========================================================================= */
.mobile-submenu {
  display: none;
  flex-direction: column;
  gap: 0.8rem;
  margin-top: 0.5rem;
  padding-left: 1rem;
}

.mobile-submenu.active {
  display: flex;
  animation: slideDown 0.4s ease forwards;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.submenu {
  display: block;
  padding: 0.6rem 0;
  font-size: 1.4rem;
  color: rgba(255,255,255,0.85);
  text-decoration: none;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;
  transition: all 0.3s ease;
}

.submenu:hover {
  color: #fff;
  padding-left: 1rem;
  transform: scale(1.05);
}

/* =========================================================================
   RESPONSIVE BEHAVIOR
   ========================================================================= */
@media (max-width: 960px) {
  .nav-links { 
    display: none; 
  }
  
  .hamburger { 
    display: flex; 
  }
  
  .logo {
    font-size: 1.1rem;
  }
  
  .logo img {
    height: 40px;
  }
}

@media (max-width: 480px) {
  .mobile-menu a,
  .mobile-menu button {
    font-size: 1.5rem;
  }
  
  .submenu {
    font-size: 1.2rem;
  }
  
  .nav-inner {
    padding: 0 1rem;
  }
}

/* =========================================================================
   HERO SECTION – FIXED & REFINED (ELEGANT + SAFE)
   ========================================================================= */

.hero-section {
  position: relative;
  min-height: calc(100vh - 96px); /* kompensasi navbar */
  padding: 8rem 1.5rem 5rem;     /* aman dari navbar */
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  isolation: isolate;

  background:
    url("images/Background.png") center / cover no-repeat;

  color: var(--light);
  font-family: 'Montserrat', system-ui, sans-serif;
}

/* Frame diperkecil agar tidak menekan konten */
.hero-section::after {
  content: '';
  position: absolute;
  inset: 2.5rem;
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  pointer-events: none;
  z-index: 1;
}

/* ================= CONTENT ================= */

.hero-container {
  position: relative;
  z-index: 2;
  max-width: 1100px;
  width: 100%;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 2.2rem;
}

/* ================= BADGE ================= */

.hero-badge {
  margin-inline: auto;
  padding: 10px 26px;
  border-radius: 999px;
  background: rgba(255,255,255,0.08);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.15);
  font-size: 0.75rem;
  letter-spacing: 2px;
  text-transform: uppercase;
}

/* ================= TITLE ================= */

.hero-title {
  font-size: clamp(3rem, 6vw, 4.8rem);
  font-weight: 800;
  line-height: 1.1;
  margin: 0;
}

.accent-text {
  background: linear-gradient(
    90deg,
    #f2c46d,
    #e6a93a
  );
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

/* ================= SUBTITLE ================= */

.hero-subtitle {
  font-size: clamp(1.2rem, 2.5vw, 1.7rem);
  font-weight: 500;
  color: rgba(255,255,255,0.85);
}

/* ================= DESCRIPTION ================= */

.hero-desc {
  max-width: 720px;
  margin-inline: auto;
  font-size: 1.05rem;
  line-height: 1.7;
  color: rgba(255,255,255,0.75);
}

/* ================= CTA BUTTONS ================= */

.hero-ctas {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

/* Base Button */
.btn {
  padding: 15px 34px;
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.25s ease;
}

/* Primary – dibuat lebih kalem */
.btn-primary {
  background: linear-gradient(
    135deg,
    #cfa24a,
    #e0b864
  );
  color: #2b1b3f;
  box-shadow: 0 8px 20px rgba(207,162,74,0.35);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 26px rgba(207,162,74,0.45);
}

/* Ghost */
.btn-ghost {
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.2);
  color: var(--light);
}

.btn-ghost:hover {
  background: rgba(255,255,255,0.14);
}

/* ================= VOLUME BADGE ================= */

.volume-badge {
  margin-top: 3rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
}

.volume-circle {
  width: 88px;
  height: 88px;
  border-radius: 50%;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
}

.volume-number {
  font-size: 2.8rem;
  font-weight: 800;
}

.volume-label {
  font-size: 0.75rem;
  letter-spacing: 2px;
  opacity: 0.75;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 768px) {
  .hero-section {
    padding: 6.5rem 1.25rem 4rem;
  }

  .hero-ctas {
    flex-direction: column;
  }

  .btn {
    width: 100%;
    max-width: 320px;
  }
}


/* =========================================================================
   TIMELINE SECTION - ELEGANT PURPLE THEME (FIXED VERSION)
   ========================================================================= */

/* Timeline Section Container */
#timeline.section {
  position: relative;
  min-height: 100vh;
  padding: 6rem 2rem;
  background: #481465;
  overflow: hidden;
}

/* Section Header Styling */
#timeline .section-header {
  text-align: center;
  margin-bottom: 4rem;
  position: relative;
  z-index: 2;
}

#timeline .section-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(255, 255, 255, 0.1);
  color: #e6d5ff;
  padding: 0.5rem 1.25rem;
  border-radius: 50px;
  font-size: 0.875rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  margin-bottom: 1.5rem;
  border: 1px solid rgba(230, 213, 255, 0.3);
  backdrop-filter: blur(10px);
}

#timeline .badge-icon {
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.1); }
}

#timeline .title {
  font-size: 2.8rem;
  font-weight: 800;
  background: linear-gradient(135deg, #ffffff 0%, #e6d5ff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 1rem;
  letter-spacing: -0.5px;
}

#timeline .subtitle {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.85);
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

/* ====================
   ERROR HANDLING STYLES
   ==================== */

/* Empty State Container */
.timeline-empty-state {
  text-align: center;
  padding: 5rem 2rem;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 24px;
  border: 2px solid rgba(163, 92, 208, 0.2);
  margin: 2rem 0;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  animation: fadeIn 0.8s ease-out;
}

.empty-state-icon {
  margin-bottom: 2rem;
}

.empty-state-icon svg {
  width: 80px;
  height: 80px;
  color: #a35cd0;
  opacity: 0.8;
}

.empty-state-title {
  font-size: 2rem;
  color: #3a1052;
  margin-bottom: 1rem;
  font-weight: 700;
}

.empty-state-message {
  color: #5a3a6e;
  max-width: 500px;
  margin: 0 auto 2.5rem;
  line-height: 1.7;
  font-size: 1.1rem;
}

.empty-state-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

/* Database Error Container */
.timeline-error {
  text-align: center;
  padding: 4rem 2rem;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 24px;
  border: 2px solid rgba(244, 67, 54, 0.2);
  margin: 2rem 0;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  animation: fadeIn 0.8s ease-out;
}

.error-icon {
  margin-bottom: 1.5rem;
}

.error-icon svg {
  width: 64px;
  height: 64px;
  color: #f44336;
  opacity: 0.9;
}

.error-title {
  font-size: 1.8rem;
  color: #d32f2f;
  margin-bottom: 1rem;
  font-weight: 700;
}

.error-message {
  color: #5a3a6e;
  max-width: 500px;
  margin: 0 auto 2.5rem;
  line-height: 1.7;
  font-size: 1.1rem;
}

/* Button Styles (Unified) */
.btn-primary, .btn-outline, .btn-error {
  padding: 0.875rem 1.75rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
  border: none;
  outline: none;
  position: relative;
  overflow: hidden;
}

.btn-primary {
  background: linear-gradient(135deg, #8a4ac7, #6c3ca3);
  color: white;
  box-shadow: 0 8px 24px rgba(138, 74, 199, 0.3);
}

.btn-primary:hover {
  background: linear-gradient(135deg, #6c3ca3, #5a2d8c);
  transform: translateY(-3px);
  box-shadow: 0 12px 32px rgba(138, 74, 199, 0.4);
}

.btn-primary:active {
  transform: translateY(-1px);
}

.btn-outline {
  background: transparent;
  color: #8a4ac7;
  border: 2px solid #8a4ac7;
  box-shadow: 0 4px 12px rgba(138, 74, 199, 0.1);
}

.btn-outline:hover {
  background: rgba(138, 74, 199, 0.08);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(138, 74, 199, 0.2);
}

.btn-error {
  background: linear-gradient(135deg, #f44336, #d32f2f);
  color: white;
  box-shadow: 0 8px 24px rgba(244, 67, 54, 0.3);
}

.btn-error:hover {
  background: linear-gradient(135deg, #d32f2f, #b71c1c);
  transform: translateY(-3px);
  box-shadow: 0 12px 32px rgba(244, 67, 54, 0.4);
}

/* Button Icon Animation */
.btn-primary svg, .btn-outline svg, .btn-error svg {
  transition: transform 0.3s ease;
}

.btn-primary:hover svg, .btn-outline:hover svg, .btn-error:hover svg {
  transform: translateX(4px);
}

/* ====================
   TIMELINE STYLES (WHEN DATA EXISTS)
   ==================== */

/* Timeline Container */
#timeline .timeline-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 3.5rem 2.5rem;
  position: relative;
  padding: 3rem 0;
  z-index: 2;
}

/* Remove vertical center line (conflicts with new design) */
#timeline .timeline-container::before {
  display: none;
}

/* Timeline Item */
#timeline .timeline-item {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  opacity: 0;
  transform: translateY(40px);
  transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
  z-index: 2;
}

#timeline .timeline-item.animate-on-scroll {
  opacity: 1;
  transform: translateY(0);
}

/* Timeline Marker */
#timeline .timeline-marker {
  position: relative;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #d4b2e6, #a35cd0);
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 
    0 12px 36px rgba(163, 92, 208, 0.4),
    0 0 0 10px rgba(255, 255, 255, 0.1),
    inset 0 2px 8px rgba(255, 255, 255, 0.3);
  transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
  z-index: 2;
}

#timeline .timeline-marker:hover {
  transform: scale(1.12) rotate(5deg);
  box-shadow: 
    0 20px 50px rgba(163, 92, 208, 0.5),
    0 0 0 12px rgba(255, 255, 255, 0.15),
    inset 0 4px 12px rgba(255, 255, 255, 0.4);
  background: linear-gradient(135deg, #e8d3f4, #b97de6);
}

#timeline .timeline-dot {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.98);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #a35cd0;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

#timeline .timeline-marker:hover .timeline-dot {
  color: #8a4ac7;
  transform: scale(1.1) rotate(-5deg);
}

/* Connector line */
#timeline .timeline-line {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  width: 3px;
  height: 50px;
  background: linear-gradient(to bottom, 
    rgba(212, 178, 230, 0.9), 
    rgba(163, 92, 208, 0.5));
  transition: height 0.5s ease;
  border-radius: 2px;
}

#timeline .timeline-item:hover .timeline-line {
  height: 70px;
}

/* Timeline Content */
#timeline .timeline-content {
  background: rgba(255, 255, 255, 0.98);
  border: 1px solid rgba(212, 178, 230, 0.25);
  border-radius: 24px;
  padding: 2rem;
  width: 100%;
  max-width: 340px;
  box-shadow: 
    0 20px 60px rgba(0, 0, 0, 0.15),
    0 8px 24px rgba(0, 0, 0, 0.08);
  transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
  position: relative;
  overflow: hidden;
}

#timeline .timeline-content::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 6px;
  background: linear-gradient(90deg, #d4b2e6, #a35cd0);
  background-size: 200% 100%;
  animation: shimmer 3s linear infinite;
}

@keyframes shimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}

#timeline .timeline-content:hover {
  transform: translateY(-12px) scale(1.02);
  box-shadow: 
    0 32px 80px rgba(0, 0, 0, 0.2),
    0 16px 40px rgba(0, 0, 0, 0.12);
  border-color: rgba(163, 92, 208, 0.4);
}

/* Date Styling */
#timeline .timeline-date {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  font-size: 0.9rem;
  color: #8a4ac7;
  margin-bottom: 1.25rem;
  padding: 0.5rem 1.25rem;
  border-radius: 50px;
  background: rgba(163, 92, 208, 0.08);
  border: 1px solid rgba(163, 92, 208, 0.15);
  transition: all 0.3s ease;
  backdrop-filter: blur(4px);
}

#timeline .timeline-date:hover {
  background: rgba(163, 92, 208, 0.12);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(163, 92, 208, 0.15);
}

#timeline .date-icon {
  flex-shrink: 0;
  color: #a35cd0;
}

/* Title Styling */
#timeline .timeline-content h3 {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 1.35rem;
  font-weight: 700;
  color: #2d0c40;
  margin-bottom: 1.25rem;
  line-height: 1.4;
  transition: color 0.3s ease;
}

#timeline .timeline-content:hover h3 {
  color: #8a4ac7;
}

#timeline .title-icon {
  flex-shrink: 0;
  color: #a35cd0;
}

/* Description Styling */
#timeline .timeline-content p {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  font-size: 1rem;
  color: #4a2a65;
  line-height: 1.7;
  margin-bottom: 1.75rem;
  text-align: left;
}

#timeline .desc-icon {
  flex-shrink: 0;
  margin-top: 0.25rem;
  color: #a35cd0;
  opacity: 0.8;
}

/* Link Styling */
#timeline .timeline-link {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  color: #8a4ac7;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.95rem;
  padding: 0.75rem 1.5rem;
  border-radius: 50px;
  background: rgba(163, 92, 208, 0.08);
  border: 1px solid rgba(163, 92, 208, 0.15);
  transition: all 0.3s ease;
}

#timeline .timeline-link:hover {
  background: rgba(163, 92, 208, 0.15);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(163, 92, 208, 0.15);
  color: #7239b0;
}

#timeline .timeline-link svg {
  transition: transform 0.3s ease;
}

#timeline .timeline-link:hover svg {
  transform: translateX(5px);
}

/* Timeline Legend */
#timeline .timeline-legend {
  display: flex;
  justify-content: center;
  gap: 2.5rem;
  margin-top: 5rem;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 24px;
  border: 1px solid rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(12px);
  max-width: 550px;
  margin-left: auto;
  margin-right: auto;
}

#timeline .legend-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: rgba(255, 255, 255, 0.95);
  font-size: 0.95rem;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.05);
  transition: all 0.3s ease;
}

#timeline .legend-item:hover {
  background: rgba(255, 255, 255, 0.1);
  transform: translateY(-2px);
}

#timeline .legend-item svg {
  flex-shrink: 0;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

/* ====================
   ANIMATIONS
   ==================== */

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-on-scroll {
  animation: fadeIn 0.8s ease forwards;
}

/* Button ripple effect */
.btn-primary::after, .btn-outline::after, .btn-error::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 5px;
  height: 5px;
  background: rgba(255, 255, 255, 0.4);
  opacity: 0;
  border-radius: 100%;
  transform: scale(1, 1) translate(-50%);
  transform-origin: 50% 50%;
}

.btn-primary:focus:not(:active)::after,
.btn-outline:focus:not(:active)::after,
.btn-error:focus:not(:active)::after {
  animation: ripple 1s ease-out;
}

@keyframes ripple {
  0% {
    transform: scale(0, 0);
    opacity: 0.5;
  }
  100% {
    transform: scale(20, 20);
    opacity: 0;
  }
}

/* ====================
   RESPONSIVE DESIGN
   ==================== */

@media (max-width: 1200px) {
  #timeline .timeline-container {
    grid-template-columns: repeat(2, 1fr);
    gap: 3rem 2rem;
  }
  
  #timeline .title {
    font-size: 2.5rem;
  }
}

@media (max-width: 768px) {
  #timeline.section {
    padding: 4rem 1rem;
  }
  
  #timeline .title {
    font-size: 2.2rem;
  }
  
  #timeline .subtitle {
    font-size: 1rem;
    padding: 0 1rem;
  }
  
  #timeline .timeline-container {
    grid-template-columns: 1fr;
    gap: 3.5rem;
    padding: 2rem 0;
  }
  
  #timeline .timeline-item {
    flex-direction: row;
    text-align: left;
    align-items: flex-start;
    gap: 2rem;
    max-width: 100%;
  }
  
  #timeline .timeline-marker {
    width: 70px;
    height: 70px;
    margin-bottom: 0;
    flex-shrink: 0;
  }
  
  #timeline .timeline-dot {
    width: 38px;
    height: 38px;
  }
  
  #timeline .timeline-line {
    position: absolute;
    top: 70px;
    left: 35px;
    width: 50px;
    height: 3px;
    background: linear-gradient(to right, 
      rgba(212, 178, 230, 0.9), 
      rgba(163, 92, 208, 0.5));
  }
  
  #timeline .timeline-item:hover .timeline-line {
    height: 3px;
    width: 60px;
  }
  
  #timeline .timeline-content {
    max-width: 100%;
    flex: 1;
    padding: 1.75rem;
  }
  
  #timeline .timeline-content h3,
  #timeline .timeline-content p {
    justify-content: flex-start;
  }
  
  #timeline .timeline-legend {
    flex-direction: column;
    gap: 1rem;
    align-items: center;
    padding: 1.5rem;
    max-width: 300px;
  }
  
  .empty-state-title,
  .error-title {
    font-size: 1.8rem;
  }
  
  .timeline-empty-state,
  .timeline-error {
    padding: 3rem 1.5rem;
    margin: 1.5rem 0;
  }
  
  .empty-state-icon svg,
  .error-icon svg {
    width: 64px;
    height: 64px;
  }
}

@media (max-width: 480px) {
  #timeline .title {
    font-size: 1.9rem;
  }
  
  #timeline .timeline-item {
    flex-direction: column;
    text-align: center;
    gap: 1.5rem;
  }
  
  #timeline .timeline-marker {
    width: 65px;
    height: 65px;
  }
  
  #timeline .timeline-dot {
    width: 35px;
    height: 35px;
  }
  
  #timeline .timeline-line {
    position: absolute;
    top: 100%;
    left: 50%;
    width: 3px;
    height: 40px;
    background: linear-gradient(to bottom, 
      rgba(212, 178, 230, 0.9), 
      rgba(163, 92, 208, 0.5));
  }
  
  #timeline .timeline-item:hover .timeline-line {
    width: 3px;
    height: 50px;
  }
  
  #timeline .timeline-content h3,
  #timeline .timeline-content p {
    justify-content: center;
    text-align: center;
  }
  
  #timeline .timeline-content h3 {
    font-size: 1.2rem;
  }
  
  #timeline .timeline-content p {
    font-size: 0.95rem;
  }
  
  .btn-primary, .btn-outline, .btn-error {
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
  }
  
  .empty-state-actions {
    flex-direction: column;
    align-items: center;
  }
  
  .empty-state-actions .btn-primary,
  .empty-state-actions .btn-outline {
    width: 100%;
    justify-content: center;
  }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
  #timeline .timeline-content {
    border: 2px solid #8a4ac7;
  }
  
  #timeline .timeline-date,
  #timeline .timeline-link {
    border: 2px solid #8a4ac7;
  }
  
  .timeline-empty-state,
  .timeline-error {
    border: 3px solid #a35cd0;
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  #timeline .timeline-content::before,
  #timeline .badge-icon,
  #timeline .timeline-marker,
  #timeline .timeline-content,
  .btn-primary, .btn-outline, .btn-error {
    animation: none;
    transition: none;
  }
  
  .animate-on-scroll {
    animation: none;
    opacity: 1;
    transform: none;
  }
}

/* =========================================================================
   SECTION KOMPETISI - ENTREVIBES UMSIDA
   ========================================================================= */

/* Section Container */
.competitions-section {
  position: relative;
  min-height: 100vh;
  padding: 5rem 2rem;
  overflow: hidden;
}

/* Background dengan texture EntreVibes */
.competitions-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #481465;
  z-index: 0;
}

/* Container untuk konten */
.competitions-container {
  position: relative;
  z-index: 1;
  max-width: 1200px;
  margin: 0 auto;
}

/* Section Header - Light Mode */
.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

/* Badge Light Mode */
.section-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1.5rem;

  background: linear-gradient(135deg,
    rgba(239, 166, 9, 0.08),
    rgba(98, 35, 126, 0.06)
  );

  border-radius: 50px;
  border: 1px solid rgba(98, 35, 126, 0.15);


  margin-bottom: 1.5rem;

  backdrop-filter: blur(6px);
}

.badge-icon {
  font-size: 1.2rem;
    color: #ffffff;
  animation: pulse 2s infinite;
}

.badge-text {
  font-size: 0.9rem;
  font-weight: 600;
  color: #ffffff;
  letter-spacing: 1px;
  text-transform: uppercase;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 900;
  color: #2a1a35;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.section-title .accent-text {
  background: linear-gradient(135deg, #b983ff, #e6d8ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.section-subtitle {
  font-size: 1.1rem;
  color: #6d5a7a;
  max-width: 700px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Filter Kategori */
.categories-filter {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 3rem;
  flex-wrap: wrap;
}

.filter-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;

  background: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(98, 35, 126, 0.15);
  border-radius: 50px;

  font-size: 0.95rem;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;

  color: #62237e;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.filter-btn:hover {
  background: rgba(98, 35, 126, 0.05);
  transform: translateY(-2px);
  box-shadow: 0 5px 20px rgba(98, 35, 126, 0.1);
}

.filter-btn.active {
  background: linear-gradient(135deg, #62237e, #5c1f7f);
  color: white;
  border-color: transparent;
  box-shadow: 0 5px 20px rgba(98, 35, 126, 0.2);
}

.filter-icon {
  font-size: 1.1rem;
}

/* Grid Kompetisi */
.competitions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 4rem;
}

/* Competition Card */
.competition-card {
  position: relative;
  height: 480px;
  perspective: 1500px;
  border-radius: 20px;
  overflow: hidden;
}

.competition-card:hover .card-front {
  transform: rotateY(180deg);
}

.competition-card:hover .card-back {
  transform: rotateY(0deg);
}

/* Card Front - Light Mode */
.card-front {
  position: absolute;
  width: 100%;
  height: 100%;

  background: #ffffff;
  border-radius: 20px;
  padding: 2rem;

  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;

  transform: rotateY(0deg);
  transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);

  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
}

/* 1. Pastikan container kartu punya perspective agar efek flip halus */
.competition-card {
    perspective: 1000px;
}


/* Sisi depan secara default menghadap user */
.card-front {
    z-index: 2;
    transform: rotateY(0deg);
}

.card-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.4rem 1rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.business-badge {
  background: linear-gradient(135deg,
      rgba(98, 35, 126, 0.1),
      rgba(98, 35, 126, 0.05));
  color: #62237e;
  border: 1px solid rgba(98, 35, 126, 0.2);
}

.creative-badge {
  background: linear-gradient(135deg,
      rgba(239, 166, 9, 0.1),
      rgba(239, 166, 9, 0.05));
  color: #b8860b;
  border: 1px solid rgba(239, 166, 9, 0.2);
}

.tech-badge {
  background: linear-gradient(135deg,
      rgba(52, 152, 219, 0.1),
      rgba(52, 152, 219, 0.05));
  color: #2980b9;
  border: 1px solid rgba(52, 152, 219, 0.2);
}

.social-badge {
  background: linear-gradient(135deg,
      rgba(46, 204, 113, 0.1),
      rgba(46, 204, 113, 0.05));
  color: #27ae60;
  border: 1px solid rgba(46, 204, 113, 0.2);
}

.card-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg,
      rgba(98, 35, 126, 0.1),
      rgba(239, 166, 9, 0.1));
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;
  font-size: 2.5rem;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.card-title {
  font-size: 1.5rem;
  font-weight: 800;
  color: #2a1a35;
  margin-bottom: 1rem;
  text-align: center;
}

.card-description {
  color: #6d5a7a;
  text-align: center;
  line-height: 1.6;
  margin-bottom: 2rem;
}

.card-details {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.detail-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #6d5a7a;
  font-size: 0.9rem;
}

.detail-icon {
  font-size: 1.1rem;
  color: #efa609;
}

/* Card Back */
.card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #62237e, #5c1f7f);
  border-radius: 20px;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  backface-visibility: hidden;
  transform: rotateY(180deg);
  transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  color: white;
}

.card-back h3 {
  font-size: 1.5rem;
  font-weight: 800;
  margin-bottom: 1rem;
  text-align: center;
}

.back-description {
  text-align: center;
  line-height: 1.6;
  opacity: 0.9;
  margin-bottom: 1.5rem;
}

.requirements {
  margin-bottom: 2rem;
  width: 100%;
}

.requirements h4 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
  opacity: 0.9;
}

.requirements ul {
  list-style: none;
  padding-left: 0;
}

.requirements li {
  font-size: 0.9rem;
  margin-bottom: 0.5rem;
  padding-left: 1.5rem;
  position: relative;
  opacity: 0.8;
}

.requirements li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: #efa609;
  font-weight: bold;
}

.card-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
}

.action-btn {
  padding: 0.75rem 1.5rem;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 600;
  text-align: center;
  text-decoration: none;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.action-btn.primary {
  background: linear-gradient(135deg, #efa609, #ffb347);
  color: white;
  border: none;
}

.action-btn.primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 20px rgba(239, 166, 9, 0.3);
}

.action-btn.secondary {
  background: rgba(255, 255, 255, 0.15);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(10px);
}

.action-btn.secondary:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .competitions-section {
    padding: 3rem 1rem;
  }

  .competitions-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .competition-card {
    height: 450px;
  }

  .categories-filter {
    gap: 0.5rem;
  }

  .filter-btn {
    padding: 0.6rem 1.2rem;
    font-size: 0.85rem;
  }

  .card-front,
  .card-back {
    padding: 1.5rem;
  }

  .card-title {
    font-size: 1.3rem;
  }
}

@media (max-width: 480px) {
  .section-title {
    font-size: 2rem;
  }

  .section-subtitle {
    font-size: 1rem;
  }

  .competition-card {
    height: 420px;
  }

  .card-icon {
    width: 70px;
    height: 70px;
    font-size: 2rem;
  }
}

/* Animation untuk card masuk */
.competition-card {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeInUp 0.6s ease forwards;
}

.competition-card:nth-child(1) { animation-delay: 0.1s; }
.competition-card:nth-child(2) { animation-delay: 0.2s; }
.competition-card:nth-child(3) { animation-delay: 0.3s; }
.competition-card:nth-child(4) { animation-delay: 0.4s; }
.competition-card:nth-child(5) { animation-delay: 0.5s; }
.competition-card:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
  .competitions-section {
    background: linear-gradient(135deg,
        rgba(26, 20, 32, 0.95) 0%,
        rgba(35, 28, 42, 0.85) 100%);
  }

  .section-badge {
    background: linear-gradient(135deg,
        rgba(239, 166, 9, 0.2),
        rgba(98, 35, 126, 0.15));
    border-color: rgba(239, 166, 9, 0.3);
  }

  .section-title {
    color: #f5f0fa;
  }

  .section-subtitle {
    color: #b8a9c7;
  }

  .filter-btn {
    background: rgba(35, 28, 42, 0.8);
    border-color: rgba(181, 128, 214, 0.2);
    color: #b580d6;
  }

  .filter-btn.active {
    background: linear-gradient(135deg, #b580d6, #9a6bb8);
    color: white;
  }

  .card-front {
    background: #ffffff;
    border-color: rgba(0, 0, 0, 0.08);
    color: #2b2b2b;
  }


.card-title {
  color: #481465;
}

.card-description,
.detail-item {
  color: rgba(72, 20, 101, 0.75);
}

  .card-back {
    background: linear-gradient(135deg, #b580d6, #9a6bb8);
  }
}

  /* =========================================================================
   GALLERY GRID - Elegant, Interactive & Responsive (Perfect 4:3 Ratio)
   ========================================================================= */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
  padding: 0 1rem;
}

.thumb {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  cursor: pointer;
  width: 100%;
  aspect-ratio: 4/3; /* Perfect 4:3 aspect ratio */
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid var(--glass-border, rgba(255,255,255,0.1));
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  transition: transform .6s cubic-bezier(0.25,0.8,0.25,1), 
              box-shadow .6s cubic-bezier(0.25,0.8,0.25,1);
  box-shadow: 0 8px 32px rgba(0,0,0,0.08);
  will-change: transform;
}

.thumb:hover {
  transform: scale(1.05) translateY(-8px);
  box-shadow: 0 24px 64px rgba(0,0,0,0.18);
}

.thumb::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    180deg, 
    transparent 0%, 
    rgba(0,0,0,0.15) 60%, 
    rgba(0,0,0,0.5) 100%
  );
  opacity: 0;
  transition: opacity .4s ease;
}

.thumb:hover::after { 
  opacity: 1; 
}

.thumb .caption {
  position: absolute;
  bottom: 16px;
  left: 16px;
  right: 16px;
  color: #fff;
  font-weight: 600;
  font-size: 1rem;
  line-height: 1.3;
  text-shadow: 0 4px 16px rgba(0,0,0,0.6);
  opacity: 0;
  transform: translateY(12px);
  transition: all .5s cubic-bezier(0.25,0.8,0.25,1);
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

.thumb:hover .caption {
  opacity: 1;
  transform: translateY(0);
}

/* =========================================================================
   LOADING ANIMATION (Enhanced shimmer effect)
   ========================================================================= */
.thumb.loading {
  background: linear-gradient(
    110deg,
    rgba(255,255,255,0.05) 8%,
    rgba(255,255,255,0.15) 18%,
    rgba(255,255,255,0.25) 33%,
    rgba(255,255,255,0.15) 45%,
    rgba(255,255,255,0.05) 55%
  );
  background-size: 300% 100%;
  animation: shimmer 2s infinite ease-in-out;
}

@keyframes shimmer {
  0% { background-position: 300% 0; }
  100% { background-position: -300% 0; }
}

/* =========================================================================
   LIGHTBOX - Elegant Modal with Perfect 4:3 Ratio
   ========================================================================= */
.lightbox {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.85);
  backdrop-filter: blur(8px);
  display: flex;
  z-index: 2000;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  opacity: 0;
  pointer-events: none;
  transition: opacity .5s ease, backdrop-filter .5s ease;
}

.lightbox.active {
  opacity: 1;
  pointer-events: auto;
}

.lightbox .box {
  position: relative;
  width: 100%;
  max-width: 720px; /* Golden ratio optimized size */
  border-radius: 20px;
  overflow: hidden;
  background: var(--card, #1a1a1a);
  border: 1px solid var(--glass-border, rgba(255,255,255,0.1));
  box-shadow: 0 24px 80px rgba(0,0,0,0.5);
  transform: scale(0.92) translateY(30px);
  opacity: 0;
  animation: lightboxIn .6s forwards cubic-bezier(0.34,1.56,0.64,1);
}

@keyframes lightboxIn {
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.lightbox .img {
  width: 100%;
  aspect-ratio: 4/3; /* Perfect 4:3 aspect ratio for modal */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  animation: imageIn 0.8s ease forwards;
  position: relative;
}

@keyframes imageIn {
  from { 
    opacity: 0; 
    transform: scale(1.1); 
    filter: blur(4px);
  }
  to { 
    opacity: 1; 
    transform: scale(1); 
    filter: blur(0);
  }
}

.lightbox .meta {
  padding: 1rem 1.5rem;
  color: var(--muted, #888);
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.9rem;
  line-height: 1.4;
  background: var(--card, #1a1a1a);
}

.lightbox .close {
  position: absolute;
  top: 16px;
  right: 16px;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(10px);
  width: 38px;
  height: 38px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  color: #fff;
  cursor: pointer;
  border: 1px solid rgba(255,255,255,0.15);
  transition: all 0.3s cubic-bezier(0.25,0.8,0.25,1);
  z-index: 10;
  font-family: monospace;
  font-weight: normal;
}

.lightbox .close:hover {
  background: rgba(255,255,255,0.15);
  transform: scale(1.1) rotate(90deg);
  border-color: rgba(255,255,255,0.2);
}

.lightbox .close:active {
  transform: scale(0.95) rotate(90deg);
}

/* =========================================================================
   RESPONSIVE DESIGN - Mobile First Approach
   ========================================================================= */

/* Large Desktop */
@media (min-width: 1200px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 0 2rem;
  }
  
  .thumb {
    border-radius: 24px;
  }
  
  .thumb .caption {
    font-size: 1.1rem;
    bottom: 20px;
    left: 20px;
    right: 20px;
  }
}

/* Desktop */
@media (max-width: 1199px) and (min-width: 992px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
  }
  
  .lightbox .box {
    max-width: 680px;
  }
}

/* Tablet */
@media (max-width: 991px) and (min-width: 768px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.2rem;
    padding: 0 1rem;
  }
  
  .thumb {
    border-radius: 16px;
  }
  
  .thumb .caption {
    font-size: 0.9rem;
    bottom: 12px;
    left: 12px;
    right: 12px;
  }
  
  .lightbox {
    padding: 1.5rem;
  }
  
  .lightbox .box {
    max-width: 560px;
    border-radius: 18px;
  }
  
  .lightbox .meta {
    padding: 1rem 1.3rem;
    font-size: 0.85rem;
  }
  
  .lightbox .close {
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    font-size: 1.2rem;
  }
}

/* Mobile Large */
@media (max-width: 767px) and (min-width: 576px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem;
    padding: 0 0.8rem;
  }
  
  .thumb {
    border-radius: 14px;
  }
  
  .thumb .caption {
    font-size: 0.85rem;
    bottom: 10px;
    left: 10px;
    right: 10px;
    font-weight: 500;
  }
  
  .lightbox {
    padding: 1rem;
  }
  
  .lightbox .box {
    max-width: 96vw;
    border-radius: 16px;
  }
  
  .lightbox .meta {
    padding: 1rem 1.2rem;
    font-size: 0.85rem;
  }
  
  .lightbox .close {
    top: 12px;
    right: 12px;
    width: 36px;
    height: 36px;
    font-size: 1.1rem;
  }
}

/* Mobile Small */
@media (max-width: 575px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.8rem;
    padding: 0 0.5rem;
  }
  
  .thumb {
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
  }
  
  .thumb:hover {
    transform: scale(1.03) translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.15);
  }
  
  .thumb .caption {
    font-size: 0.8rem;
    bottom: 8px;
    left: 8px;
    right: 8px;
    font-weight: 500;
    line-height: 1.2;
  }
  
  .lightbox {
    padding: 0.5rem;
  }
  
  .lightbox .box {
    max-width: 98vw;
    border-radius: 12px;
  }
  
  .lightbox .meta {
    padding: 0.8rem 1rem;
    font-size: 0.8rem;
  }
  
  .lightbox .close {
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    font-size: 1rem;
    background: rgba(0,0,0,0.6);
  }
}

/* Extra Small Mobile */
@media (max-width: 400px) {
  .gallery-grid {
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.6rem;
    padding: 0 0.3rem;
  }
  
  .thumb {
    border-radius: 10px;
  }
  
  .thumb .caption {
    font-size: 0.75rem;
    bottom: 6px;
    left: 6px;
    right: 6px;
  }
  
  .lightbox .close {
    top: 6px;
    right: 6px;
    width: 28px;
    height: 28px;
    font-size: 0.9rem;
  }
}

/* =========================================================================
   ACCESSIBILITY & PERFORMANCE ENHANCEMENTS
   ========================================================================= */
@media (prefers-reduced-motion: reduce) {
  .thumb,
  .thumb::after,
  .thumb .caption,
  .lightbox,
  .lightbox .box,
  .lightbox .img,
  .lightbox .close {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  .thumb {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  }
  
  .thumb:hover {
    box-shadow: 0 16px 48px rgba(0,0,0,0.2);
  }
}

    /* =========================================================================
   TESTIMONIALS SECTION - MINIMALIS, 1 SLIDE = 1 TESTIMONI, MAX LENGTH
   ========================================================================= */
.testimonials {
  position: relative;
  width: 100%;
  min-height: 65vh; /* lebih minimalis */
  padding: 3rem 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: radial-gradient(circle at top left, rgba(138,124,172,0.05), transparent 75%);
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}

/* Title + Subtitle */
.testimonials .title {
  text-align: center;
  font-size: clamp(1.8rem, 4vw, 2.4rem);
  font-weight: 800;
  margin-bottom: 0.8rem;
  background: linear-gradient(135deg, var(--accent1), var(--accent2));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.testimonials .subtitle {
  text-align: center;
  color: var(--muted);
  max-width: 600px;
  margin: 0 auto 2rem;
  font-weight: 300;
  line-height: 1.5;
}

/* --- Slider Container --- */
.test-slider {
  display: flex;
  width: 100%;
  gap: 1.5rem; /* jarak antar testimoni */
  transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
  will-change: transform;
}

/* --- Each Slide = 1 Testimoni --- */
.test-slider-wrapper {
  position: relative;
  width: 100%;
  overflow: hidden;
  display: flex;
  justify-content: center; /* pastikan slider selalu di tengah */
}

.test-slider {
  display: flex;
  gap: 2rem; /* jarak antar slide */
  transition: transform 0.7s cubic-bezier(0.22,1,0.36,1);
  padding: 0 2rem; /* padding kanan kiri agar ada jarak tetap dari tepi layar */
  will-change: transform;
}

.test-slide {
  flex: 0 0 auto; /* fleksibel tapi tidak mengecil lebih kecil dari max-width */
  width: 100%;
  max-width: 480px; /* batas maksimal testimoni */
  margin: 0 auto; /* center setiap slide */
  padding: 1.8rem 1.5rem;
  border-radius: 16px;
  background: var(--card);
  border: 1px solid var(--glass-border);
  box-shadow: 0 15px 50px rgba(0,0,0,0.06);
  transition: transform 0.45s ease, box-shadow 0.45s ease, opacity 0.45s ease;
  position: relative;
  text-align: center;
}

/* Hover interaktif */
.test-slide:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 25px 80px rgba(0,0,0,0.1);
}

/* --- Author Info --- */
.test-slide .author {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 1.2rem;
}
.test-slide .author img {
  width: 50px; height: 50px;
  border-radius: 50%;
  border: 2px solid var(--accent1);
  box-shadow: 0 6px 20px rgba(138,124,172,0.2);
}
.test-slide .author-info { text-align: left; }
.test-slide .author-info h4 { font-weight: 700; font-size: 1rem; }
.test-slide .author-info span { font-size: 0.85rem; color: var(--muted); }

/* --- Quote --- */
.test-slide p {
  font-size: 0.95rem;
  color: var(--muted);
  line-height: 1.5;
  font-style: italic;
  max-width: 400px; /* batasi panjang teks */
  margin: 0 auto;
  position: relative;
}
.test-slide p::before {
  content: "“";
  font-size: 2.2rem;
  position: absolute;
  left: -0.8rem;
  top: -0.5rem;
  color: var(--accent1);
  opacity: 0.3;
}
.test-slide p::after {
  content: "”";
  font-size: 2.2rem;
  position: absolute;
  right: -0.8rem;
  bottom: -0.5rem;
  color: var(--accent2);
  opacity: 0.3;
}

/* --- Dots Controls --- */
.test-controls {
  display: flex;
  gap: 0.8rem;
  justify-content: center;
  margin-top: 1.5rem;
}
.dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  background: rgba(0,0,0,0.15);
  cursor: pointer;
  transition: all .35s ease;
}
.dot.active {
  background: linear-gradient(135deg,var(--accent1),var(--accent2));
  transform: scale(1.2);
  box-shadow: 0 0 0 4px rgba(138,124,172,0.15),
              0 5px 15px rgba(138,124,172,0.25);
}

/* --- Prev/Next Buttons --- */
.test-nav {
  position: absolute;
  top: 50%;
  left: 0; right: 0;
  display: flex;
  justify-content: space-between;
  transform: translateY(-50%);
  pointer-events: none;
}
.test-nav button {
  pointer-events: auto;
  background: rgba(255,255,255,0.95);
  border: 1px solid var(--glass-border);
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  border-radius: 50%;
  width: 44px; height: 44px;
  display: grid; place-items: center;
  cursor: pointer;
  transition: all .35s ease;
}
.test-nav button:hover {
  background: linear-gradient(135deg,var(--accent1),var(--accent2));
  color: white;
  transform: scale(1.1);
}

/* =========================================================================
   RESPONSIVE
   ========================================================================= */
@media (max-width: 768px) {
  .test-slide {
    padding: 1.2rem 1rem;
    max-width: 90%;
  }
  .test-slide .author img {
    width: 45px; height: 45px;
  }
  .test-slide p {
    font-size: 0.9rem;
    max-width: 85%;
    line-height: 1.4;
  }
}


/* =========================================================================
   FOOTER - PREMIUM DESIGN (Fixed Colors & Layout)
   ========================================================================= */
footer {
  position: relative;
  padding: 6rem 1.5rem 3rem;

  background-image: url("images/Background.png");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;

  color: #481465;
  overflow: hidden;
  font-family: 'Montserrat', sans-serif;
  isolation: isolate;
  border-top: 1px solid #481465;

}


/* =========================================================================
   SPONSOR SECTION - Premium Glass Effect
   ========================================================================= */
.sponsor-section {
  position: relative;
  z-index: 10;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.05) 0%,
    rgba(255, 255, 255, 0.02) 100%
  );
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 24px;
  padding: 3rem 2rem;
  margin: 0 auto 5rem;
  max-width: 1100px;
  box-shadow: 
    0 20px 40px rgba(0, 0, 0, 0.3),
    0 1px 0 rgba(255, 255, 255, 0.05) inset,
    0 8px 32px rgba(98, 35, 126, 0.2);
  animation: slideUpFade 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
  transform: translateY(30px);
  opacity: 0;
}

.sponsor-content {
  text-align: center;
  position: relative;
}

.sponsor-content h4 {
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.6);
  text-transform: uppercase;
  letter-spacing: 3px;
  margin-bottom: 2rem;
  font-weight: 600;
  position: relative;
  display: inline-block;
}

.sponsor-content h4::after {
  content: "";
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 40px;
  height: 2px;
  background: linear-gradient(90deg, 
    transparent 0%, 
    var(--accent) 50%, 
    transparent 100%
  );
}

.sponsor-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2.5rem;
  margin: 2.5rem 0;
  flex-wrap: wrap;
}

.main-sponsor-logo {
  height: 70px;
  width: auto;
  filter: 
    drop-shadow(0 8px 25px rgba(98, 35, 126, 0.4))
    brightness(1.1);
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  padding: 10px;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.05),
    rgba(255, 255, 255, 0.02)
  );
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.main-sponsor-logo:hover {
  transform: 
    scale(1.08) 
    rotate(1deg)
    translateY(-3px);
  filter: 
    drop-shadow(0 12px 35px rgba(98, 35, 126, 0.6))
    brightness(1.15);
}

.sponsor-logo h3 {
  font-size: 1.8rem;
  background: linear-gradient(135deg,
    #ffffff 0%,
    rgba(255, 255, 255, 0.8) 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 0;
  font-weight: 700;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 15px rgba(98, 35, 126, 0.3);
}

.sponsor-description {
  max-width: 700px;
  margin: 2rem auto 0;
  color: rgba(255, 255, 255, 0.75);
  font-size: 1.05rem;
  line-height: 1.7;
  position: relative;
  padding: 2rem;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.03),
    rgba(255, 255, 255, 0.01)
  );
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.04);
  font-style: italic;
}

.sponsor-description::before {
  content: '"';
  position: absolute;
  top: -15px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 4rem;
  color: var(--accent);
  font-family: Georgia, serif;
  opacity: 0.3;
}

/* =========================================================================
   FOOTER INNER GRID - Modern Layout
   ========================================================================= */
footer .foot-inner {
  position: relative;
  z-index: 10;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 4rem;
  max-width: 1200px;
  margin: 0 auto;
  animation: slideUpFade 1s cubic-bezier(0.4, 0, 0.2, 1) forwards 0.2s;
  transform: translateY(30px);
  opacity: 0;
}

@keyframes slideUpFade {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Section Titles */
footer h3 {
  font-size: 1.4rem;
  background: linear-gradient(135deg,
    rgba(255, 255, 255, 0.95) 0%,
    rgba(255, 255, 255, 0.7) 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 1.5rem;
  font-weight: 700;
  position: relative;
  padding-bottom: 0.8rem;
}

footer h3::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 40px;
  height: 2px;
  background: linear-gradient(90deg, var(--accent), transparent);
  border-radius: 2px;
}

footer h4 {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 1.2rem;
  font-weight: 600;
  letter-spacing: 0.5px;
}

/* Text Content */
footer p {
  font-size: 1rem;
  line-height: 1.7;
  color: rgba(255, 255, 255, 0.75);
  margin-bottom: 1rem;
}

.foot-about p:first-of-type {
  font-size: 1.05rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.85);
}

/* Links - Elegant Style */
footer a {
  color: rgba(255, 255, 255, 0.85);
  text-decoration: none;
  transition: all 0.3s ease;
  position: relative;
  font-weight: 500;
}

footer a:hover {
  color: white;
  text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

/* Quick Links with Icon */
footer ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

footer ul li {
  margin-bottom: 0.7rem;
  padding-left: 0;
}

footer ul li a {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0.3rem 0;
  transition: all 0.3s ease;
}

footer ul li a::before {
  content: "→";
  font-size: 0.8rem;
  color: var(--accent);
  opacity: 0;
  transform: translateX(-10px);
  transition: all 0.3s ease;
}

footer ul li a:hover {
  transform: translateX(5px);
}

footer ul li a:hover::before {
  opacity: 1;
  transform: translateX(0);
}

/* Contact Info Box */
.contact-info {
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.04),
    rgba(255, 255, 255, 0.01)
  );
  padding: 1.5rem;
  border-radius: 16px;
  margin: 1rem 0;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.contact-info p {
  margin: 0.7rem 0;
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.8);
}

.contact-info strong {
  color: rgba(255, 255, 255, 0.95);
  font-weight: 600;
}

/* Social Icons - Modern Glass Style */
footer .socials {
  display: flex;
  gap: 1rem;
  margin-top: 1.5rem;
}

footer .socials a {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 14px;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.05),
    rgba(255, 255, 255, 0.02)
  );
  border: 1px solid rgba(255, 255, 255, 0.08);
  font-size: 1.1rem;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  color: rgba(255, 255, 255, 0.8);
  position: relative;
  overflow: hidden;
}

footer .socials a::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg,
    transparent,
    rgba(255, 255, 255, 0.1),
    transparent
  );
  transition: left 0.6s ease;
}

footer .socials a:hover {
  transform: translateY(-4px) scale(1.1);
  background: linear-gradient(145deg,
    rgba(98, 35, 126, 0.3),
    rgba(98, 35, 126, 0.15)
  );
  border-color: rgba(98, 35, 126, 0.4);
  box-shadow: 
    0 8px 25px rgba(98, 35, 126, 0.3),
    0 0 0 1px rgba(255, 255, 255, 0.05) inset;
  color: white;
}

footer .socials a:hover::before {
  left: 100%;
}

/* Sponsor Badge */
.sponsor-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(145deg,
    rgba(98, 35, 126, 0.3),
    rgba(98, 35, 126, 0.15)
  );
  color: white;
  padding: 0.6rem 1.5rem;
  border-radius: 50px;
  font-size: 0.85rem;
  margin-top: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 
    0 4px 15px rgba(98, 35, 126, 0.25),
    0 1px 0 rgba(255, 255, 255, 0.05) inset;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.sponsor-badge::before {
  content: "✓";
  color: var(--accent);
  font-weight: bold;
  font-size: 1.1rem;
}

.sponsor-badge:hover {
  transform: translateY(-2px);
  box-shadow: 
    0 6px 25px rgba(98, 35, 126, 0.4),
    0 1px 0 rgba(255, 255, 255, 0.1) inset;
  background: linear-gradient(145deg,
    rgba(98, 35, 126, 0.4),
    rgba(98, 35, 126, 0.25)
  );
}

.sponsor-badge small {
  color: white;
  font-weight: 500;
}

/* =========================================================================
   SUPPORTING PARTNERS SECTION
   ========================================================================= */
.supporting-partners {
  position: relative;
  z-index: 10;
  text-align: center;
  padding: 3rem 2rem;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.04),
    rgba(255, 255, 255, 0.01)
  );
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 24px;
  margin: 4rem auto;
  max-width: 1100px;
  border: 1px solid rgba(255, 255, 255, 0.06);
  box-shadow: 
    0 20px 40px rgba(0, 0, 0, 0.3),
    0 8px 32px rgba(98, 35, 126, 0.15);
  animation: slideUpFade 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards 0.4s;
  transform: translateY(30px);
  opacity: 0;
}

.supporting-partners h4 {
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 2.5rem;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-weight: 600;
  position: relative;
  display: inline-block;
}

.supporting-partners h4::after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 30px;
  height: 1px;
  background: rgba(255, 255, 255, 0.3);
}

.partner-logos {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 3rem;
  flex-wrap: wrap;
}

.partner-logos img {
  height: 55px;
  width: auto;
  object-fit: contain;
  filter: 
    grayscale(40%) 
    brightness(1.2);
  opacity: 0.9;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  padding: 12px;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.05),
    rgba(255, 255, 255, 0.02)
  );
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.partner-logos img:hover {
  transform: scale(1.12) rotate(2deg) translateY(-3px);
  filter: 
    grayscale(0%) 
    brightness(1.4);
  opacity: 1;
  box-shadow: 
    0 10px 30px rgba(98, 35, 126, 0.35),
    0 0 0 1px rgba(255, 255, 255, 0.05) inset;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.08),
    rgba(255, 255, 255, 0.03)
  );
}

/* =========================================================================
   FOOTER BOTTOM - Clean & Professional
   ========================================================================= */
.footer-bottom {
  position: relative;
  z-index: 10;
  text-align: center;
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.6);
  line-height: 1.7;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  padding-top: 2.5rem;
  margin-top: 3rem;
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
}

.copyright {
  margin-bottom: 1.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.7);
}

.legal-disclaimer {
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.6);
  max-width: 700px;
  margin: 1.5rem auto;
  padding: 1.5rem;
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.03),
    rgba(255, 255, 255, 0.01)
  );
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.04);
  line-height: 1.6;
}

.technical-credit {
  background: linear-gradient(145deg,
    rgba(255, 255, 255, 0.04),
    rgba(255, 255, 255, 0.01)
  );
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  padding: 2rem;
  border-radius: 20px;
  margin: 2rem 0;
  border: 1px solid rgba(255, 255, 255, 0.05);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.community-cta {
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  padding-top: 2rem;
  margin-top: 2rem;
  font-style: italic;
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.95rem;
  line-height: 1.6;
}

.footer-bottom a {
  font-weight: 600;
  color: white;
  position: relative;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-bottom a::after {
  content: "";
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 1px;
  background: var(--accent);
  transition: width 0.3s ease;
}

.footer-bottom a:hover {
  color: white;
  text-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
}

.footer-bottom a:hover::after {
  width: 100%;
}

/* =========================================================================
   RESPONSIVE DESIGN - Perfect on All Devices
   ========================================================================= */
@media (max-width: 1024px) {
  footer {
    padding: 5rem 1.5rem 2.5rem;
  }
  
  footer .foot-inner {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 3rem;
  }
  
  .sponsor-section,
  .supporting-partners {
    max-width: 90%;
  }
}

@media (max-width: 768px) {
  footer {
    padding: 4rem 1rem 2rem;
  }
  
  footer .foot-inner {
    grid-template-columns: 1fr;
    gap: 3rem;
    text-align: center;
  }
  
  footer h3::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .sponsor-section {
    padding: 2rem 1.5rem;
    margin-bottom: 4rem;
  }
  
  .sponsor-logo {
    flex-direction: column;
    gap: 2rem;
  }
  
  .sponsor-logo h3 {
    font-size: 1.6rem;
  }
  
  .main-sponsor-logo {
    height: 60px;
  }
  
  .partner-logos {
    flex-direction: column;
    gap: 2.5rem;
  }
  
  .partner-logos img {
    height: 50px;
    padding: 15px;
  }
  
  footer .socials {
    justify-content: center;
  }
  
  footer ul li a::before {
    display: none;
  }
  
  .footer-bottom {
    padding: 2rem 1rem 1rem;
  }
  
  .sponsor-badge {
    display: flex;
    justify-content: center;
    padding: 0.7rem 1.2rem;
  }
}

@media (max-width: 480px) {
  footer {
    padding: 3rem 1rem 1.5rem;
  }
  
  .sponsor-section {
    padding: 1.5rem 1rem;
    margin-bottom: 3rem;
    border-radius: 20px;
  }
  
  .sponsor-description {
    padding: 1.5rem 1rem;
    font-size: 1rem;
  }
  
  .supporting-partners {
    padding: 2rem 1rem;
    border-radius: 20px;
  }
  
  .foot-inner {
    gap: 2.5rem;
  }
  
  .footer-bottom {
    padding: 1.5rem 0.5rem 1rem;
  }
  
  .technical-credit {
    padding: 1.5rem;
  }
}

/* =========================================================================
   PERFORMANCE & SMOOTHNESS
   ========================================================================= */
* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

html {
  scroll-behavior: smooth;
}

    /* =========================================================================
       ANIMATIONS & UTIL
       ========================================================================= */
    .animate-on-scroll { animation: slideInFromBottom .8s ease-out both; opacity: 1; }
    @keyframes slideInFromBottom {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* responsive */
    @media (max-width: 980px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
      .container { padding: 0 1.2rem; }
    }

    @media (max-width: 520px) {

      .thumb { height: 120px; }
      .count-item { min-width: 56px; padding: .45rem .6rem; }
      .card { padding: 1.2rem; }
      .form .field { flex-basis: 100%; }
    }

    /* long file spacing: many comments below for readability and reference */
    /* ------------------------------------------------------------------------- */

/* ====================
   ABOUT US SECTION STYLES - BEST EVER IN THE WORLD
   ==================== */

/* Section Container – Solid Background (FIXED) */
#about.section {
  position: relative;
  padding: 8rem 0;
  background-color: #481465 !important; /* FIXED COLOR - DO NOT CHANGE */
  background-image: none !important;
  background: #481465 !important;
  overflow: hidden;
  isolation: isolate;
  min-height: 100vh;
  width: 100%;
}

/* ABSOLUTELY NO GRADIENT BACKGROUND - SOLID COLOR ONLY */
#about.section::before,
#about.section::after {
  background: none !important;
  background-image: none !important;
  background-color: transparent !important;
}

/* Container with max-width safety */
#about .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  position: relative;
  z-index: 1;
  width: 100%;
  box-sizing: border-box;
}

/* Section Header */
#about .section-header {
  text-align: center;
  margin-bottom: 3rem;
  position: relative;
  width: 100%;
}

/* Badge - Mobile First Design */
#about .section-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: rgba(212, 178, 230, 0.95);
  color: #481465;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.3px;
  border-radius: 50px;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  width: auto;
  max-width: 90%;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Title - Responsive Typography */
#about .title {
  font-size: 1.8rem;
  font-weight: 800;
  color: white;
  margin: 0 auto 1rem;
  line-height: 1.2;
  text-align: center;
  width: 100%;
  padding: 0 0.5rem;
  word-wrap: break-word;
  overflow-wrap: break-word;
  hyphens: auto;
}

/* Subtitle */
#about .subtitle {
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.6;
  max-width: 100%;
  margin: 0 auto;
  font-weight: 300;
  padding: 1rem;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(0, 0, 0, 0.2);
  box-sizing: border-box;
  word-wrap: break-word;
}

/* About Overview - Stack on Mobile */
#about .about-overview {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  margin-bottom: 3rem;
  width: 100%;
}

#about .overview-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  width: 100%;
  box-sizing: border-box;
  min-height: auto;
}

#about .overview-icon {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(245, 237, 255, 0.2);
  border-radius: 15px;
  color: white;
  font-size: 1.5rem;
  flex-shrink: 0;
}

#about .overview-text {
  width: 100%;
  text-align: center;
}

#about .overview-text h3 {
  font-size: 1.3rem;
  color: white;
  margin-bottom: 1rem;
  font-weight: 700;
  width: 100%;
  word-wrap: break-word;
}

#about .overview-text p {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.9rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* First Edition Highlight */
#about .first-edition-highlight {
  position: relative;
  padding: 1.5rem;
  background: rgba(163, 92, 208, 0.2);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  width: 100%;
  box-sizing: border-box;
  margin: 1rem 0;
}

#about .first-edition-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: rgba(255, 255, 255, 0.15);
  color: white;
  font-size: 0.8rem;
  font-weight: 700;
  border-radius: 50px;
  margin-bottom: 1rem;
  border: 1px solid rgba(255, 255, 255, 0.3);
  width: auto;
  max-width: 100%;
}

#about .highlight-text h3 {
  font-size: 1.3rem;
  color: white;
  margin-bottom: 1rem;
  font-weight: 700;
  width: 100%;
  text-align: center;
  word-wrap: break-word;
}

#about .highlight-text p {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.9rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* Values Grid - Single Column for Mobile */
#about .values-grid {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 3rem;
  width: 100%;
}

#about .value-card {
  position: relative;
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-align: center;
  width: 100%;
  box-sizing: border-box;
  min-height: auto;
}

#about .value-icon {
  width: 50px;
  height: 50px;
  margin: 0 auto 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(245, 237, 255, 0.2);
  border-radius: 12px;
  color: white;
  font-size: 1.5rem;
}

#about .value-card h3 {
  font-size: 1.1rem;
  color: white;
  margin-bottom: 1rem;
  font-weight: 700;
  width: 100%;
  word-wrap: break-word;
}

#about .value-card p {
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
  font-size: 0.85rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* Vision & Mission - Stacked */
#about .vision-mission {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 3rem;
  width: 100%;
}

#about .vm-card {
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  width: 100%;
  box-sizing: border-box;
}

#about .vm-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  text-align: center;
}

#about .vm-header svg {
  color: white;
  background: rgba(245, 237, 255, 0.2);
  padding: 0.75rem;
  border-radius: 12px;
  font-size: 1.2rem;
}

#about .vm-header h3 {
  font-size: 1.3rem;
  color: white;
  font-weight: 700;
  width: 100%;
  word-wrap: break-word;
}

#about .vm-card p {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.9rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* Mission List */
#about .mission-list {
  list-style: none;
  padding: 0;
  counter-reset: mission-counter;
  width: 100%;
}

#about .mission-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  margin-bottom: 1rem;
  padding: 1rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  border-left: 3px solid rgba(163, 92, 208, 0.5);
  width: 100%;
  box-sizing: border-box;
  position: relative;
}

#about .mission-list li::before {
  content: counter(mission-counter);
  counter-increment: mission-counter;
  position: absolute;
  top: 0;
  left: 0;
  width: 30px;
  height: 30px;
  background: rgba(163, 92, 208, 0.2);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.8rem;
  border-radius: 0 0 8px 0;
}

#about .mission-list li svg {
  flex-shrink: 0;
  margin-top: 0.25rem;
  color: rgba(255, 255, 255, 0.9);
  margin-left: 2rem;
  font-size: 0.9rem;
}

#about .mission-list li span {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.85rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* FAQ Section */
#about .faq-section {
  margin-top: 3rem;
  width: 100%;
}

#about .faq-container {
  max-width: 100%;
  margin: 0 auto 2rem;
  width: 100%;
}

#about .faq-item {
  margin-bottom: 1rem;
  border-radius: 15px;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  width: 100%;
  box-sizing: border-box;
}

#about .faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 600;
  color: white;
  box-sizing: border-box;
}

#about .faq-number {
  font-size: 0.8rem;
  font-weight: 700;
  color: white;
  background: rgba(163, 92, 208, 0.3);
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  flex-shrink: 0;
}

#about .faq-text {
  flex: 1;
  color: white;
  font-size: 0.9rem;
  word-wrap: break-word;
}

#about .faq-icon {
  flex-shrink: 0;
  color: rgba(255, 255, 255, 0.9);
  font-size: 0.9rem;
}

#about .faq-answer {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.03);
}

#about .answer-content {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
}

#about .answer-icon {
  flex-shrink: 0;
  margin-top: 0.25rem;
  color: rgba(255, 255, 255, 0.9);
  font-size: 0.9rem;
}

#about .answer-text {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.85rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

/* FAQ Empty State */
#about .faq-empty {
  text-align: center;
  padding: 2rem 1rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 20px;
  border: 2px dashed rgba(255, 255, 255, 0.2);
  width: 100%;
  box-sizing: border-box;
}

#about .faq-empty svg {
  color: rgba(255, 255, 255, 0.3);
  margin-bottom: 1rem;
  font-size: 2.5rem;
}

#about .faq-empty h3 {
  font-size: 1.3rem;
  color: white;
  margin-bottom: 0.75rem;
  font-weight: 700;
  width: 100%;
  word-wrap: break-word;
}

#about .faq-empty p {
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.9rem;
  max-width: 100%;
  margin: 0 auto;
  word-wrap: break-word;
}

/* FAQ Support */
#about .faq-support {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  padding: 1.5rem;
  background: rgba(163, 92, 208, 0.15);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  width: 100%;
  box-sizing: border-box;
  text-align: center;
}

#about .support-content h3 {
  font-size: 1.3rem;
  color: white;
  margin-bottom: 0.75rem;
  font-weight: 700;
  width: 100%;
  word-wrap: break-word;
}

#about .support-content p {
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.6;
  font-size: 0.9rem;
  font-weight: 300;
  width: 100%;
  word-wrap: break-word;
}

#about .support-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
  max-width: 300px;
}

/* Enhanced Button Styles */
#about .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;
  border-radius: 50px;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  width: 100%;
  box-sizing: border-box;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

#about .btn-primary {
  background: rgba(163, 92, 208, 0.9);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

#about .btn-outline {
  background: transparent;
  color: white;
  border: 2px solid rgba(255, 255, 255, 0.3);
}

/* ============================================
   ULTRA RESPONSIVE DESIGN - DOWN TO 320px
   ============================================ */

/* 320px - 359px (Smallest Mobile) */
@media (max-width: 359px) {
  #about.section {
    padding: 4rem 0.5rem;
  }
  
  #about .container {
    padding: 0 0.5rem;
  }
  
  #about .title {
    font-size: 1.5rem;
    padding: 0 0.25rem;
  }
  
  #about .section-badge {
    font-size: 0.65rem;
    padding: 0.4rem 0.8rem;
    gap: 0.4rem;
  }
  
  #about .subtitle {
    font-size: 0.8rem;
    padding: 0.75rem;
    line-height: 1.5;
  }
  
  #about .overview-content,
  #about .first-edition-highlight,
  #about .value-card,
  #about .vm-card,
  #about .faq-item,
  #about .faq-support {
    padding: 1rem;
    border-radius: 15px;
  }
  
  #about .overview-icon {
    width: 50px;
    height: 50px;
    font-size: 1.2rem;
    border-radius: 12px;
  }
  
  #about .overview-text h3,
  #about .highlight-text h3,
  #about .value-card h3,
  #about .vm-header h3,
  #about .faq-empty h3,
  #about .support-content h3 {
    font-size: 1.1rem;
  }
  
  #about .overview-text p,
  #about .highlight-text p,
  #about .value-card p,
  #about .vm-card p,
  #about .answer-text,
  #about .support-content p,
  #about .faq-empty p {
    font-size: 0.8rem;
    line-height: 1.5;
  }
  
  #about .value-icon {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
    border-radius: 10px;
  }
  
  #about .mission-list li {
    padding: 0.75rem;
    gap: 0.5rem;
  }
  
  #about .mission-list li span {
    font-size: 0.8rem;
    line-height: 1.5;
  }
  
  #about .mission-list li svg {
    margin-left: 1.75rem;
    font-size: 0.8rem;
  }
  
  #about .faq-question {
    padding: 0.75rem;
    gap: 0.5rem;
  }
  
  #about .faq-number {
    width: 25px;
    height: 25px;
    font-size: 0.7rem;
  }
  
  #about .faq-text {
    font-size: 0.8rem;
  }
  
  #about .btn {
    padding: 0.65rem 1.25rem;
    font-size: 0.85rem;
  }
  
  #about .faq-empty svg {
    font-size: 2rem;
  }
  
  /* Ensure no horizontal scroll */
  body, html {
    overflow-x: hidden;
    max-width: 100vw;
  }
  
  #about .container,
  #about .section-header,
  #about .about-overview,
  #about .values-grid,
  #about .vision-mission,
  #about .faq-container,
  #about .faq-support {
    width: 100%;
    max-width: 100%;
    margin-left: 0;
    margin-right: 0;
  }
}

/* 360px - 374px (Small Mobile) */
@media (min-width: 360px) and (max-width: 374px) {
  #about.section {
    padding: 4.5rem 0.75rem;
  }
  
  #about .title {
    font-size: 1.6rem;
  }
  
  #about .section-badge {
    font-size: 0.7rem;
  }
  
  #about .btn {
    padding: 0.7rem 1.5rem;
  }
}

/* 375px - 399px (iPhone SE/Android Small) */
@media (min-width: 375px) and (max-width: 399px) {
  #about.section {
    padding: 5rem 1rem;
  }
  
  #about .title {
    font-size: 1.7rem;
  }
  
  #about .overview-content,
  #about .first-edition-highlight {
    padding: 1.25rem;
  }
}

/* 400px - 479px (Medium Mobile) */
@media (min-width: 400px) and (max-width: 479px) {
  #about.section {
    padding: 5.5rem 1rem;
  }
  
  #about .title {
    font-size: 1.8rem;
  }
  
  #about .section-badge {
    font-size: 0.75rem;
  }
  
  #about .btn {
    max-width: 350px;
    margin: 0 auto;
  }
}

/* 480px - 575px (Large Mobile) */
@media (min-width: 480px) and (max-width: 575px) {
  #about.section {
    padding: 6rem 1.5rem;
  }
  
  #about .title {
    font-size: 2rem;
  }
  
  #about .subtitle {
    font-size: 1rem;
    padding: 1.25rem;
  }
  
  #about .overview-content {
    flex-direction: row;
    align-items: flex-start;
    text-align: left;
  }
  
  #about .overview-text {
    text-align: left;
  }
  
  #about .values-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
  
  #about .support-actions {
    flex-direction: row;
    justify-content: center;
  }
  
  #about .btn {
    width: auto;
    min-width: 150px;
  }
}

/* 576px - 767px (Small Tablet) */
@media (min-width: 576px) and (max-width: 767px) {
  #about.section {
    padding: 6.5rem 2rem;
  }
  
  #about .title {
    font-size: 2.2rem;
  }
  
  #about .section-badge {
    font-size: 0.8rem;
    padding: 0.75rem 1.5rem;
  }
  
  #about .subtitle {
    font-size: 1.05rem;
    padding: 1.5rem;
  }
  
  #about .overview-content {
    padding: 2rem;
  }
  
  #about .overview-icon {
    width: 70px;
    height: 70px;
    font-size: 1.8rem;
  }
  
  #about .values-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
  
  #about .value-card {
    padding: 2rem;
  }
  
  #about .vision-mission {
    flex-direction: row;
    flex-wrap: wrap;
  }
  
  #about .vm-card {
    flex: 1 1 calc(50% - 1rem);
    min-width: 250px;
  }
}

/* 768px - 991px (Tablet) */
@media (min-width: 768px) and (max-width: 991px) {
  #about.section {
    padding: 7rem 2rem;
  }
  
  #about .title {
    font-size: 2.5rem;
  }
  
  #about .section-badge {
    font-size: 0.9rem;
    padding: 0.75rem 1.75rem;
  }
  
  #about .subtitle {
    font-size: 1.1rem;
    padding: 2rem;
  }
  
  #about .values-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  
  #about .faq-support {
    flex-direction: row;
    text-align: left;
  }
  
  #about .support-actions {
    flex-direction: row;
    width: auto;
  }
}

/* 992px - 1199px (Small Desktop) */
@media (min-width: 992px) and (max-width: 1199px) {
  #about.section {
    padding: 8rem 3rem;
  }
  
  #about .title {
    font-size: 3rem;
  }
  
  #about .section-badge {
    font-size: 1rem;
    padding: 1rem 2rem;
  }
  
  #about .values-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* 1200px and above (Desktop) */
@media (min-width: 1200px) {
  #about.section {
    padding: 8rem 4rem;
  }
  
  #about .title {
    font-size: 3.5rem;
  }
  
  #about .subtitle {
    font-size: 1.2rem;
    padding: 2rem 3rem;
  }
  
  #about .overview-content {
    padding: 3rem;
  }
  
  #about .values-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
  }
}

/* ============================================
   ULTRA-OPTIMIZED FIXES FOR COMMON ISSUES
   ============================================ */

/* Prevent horizontal scroll on any device */
body, html, #about.section, #about .container {
  overflow-x: hidden;
  max-width: 100%;
  width: 100%;
}

/* Fix for iOS Safari */
@supports (-webkit-touch-callout: none) {
  #about.section {
    -webkit-overflow-scrolling: touch;
  }
}

/* Fix for Android Chrome */
@media (-webkit-device-pixel-ratio: 2) {
  #about .btn,
  #about .section-badge,
  #about .first-edition-badge {
    -webkit-tap-highlight-color: transparent;
  }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
  #about .value-card,
  #about .vm-card,
  #about .faq-item,
  #about .overview-content,
  #about .first-edition-highlight {
    border: 2px solid white !important;
    background: rgba(0, 0, 0, 0.9) !important;
  }
  
  #about .btn-outline {
    border: 2px solid white !important;
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  #about * {
    animation: none !important;
    transition: none !important;
  }
}

/* Print styles */
@media print {
  #about.section {
    background: white !important;
    color: black !important;
    padding: 2rem !important;
  }
  
  #about .title,
  #about .overview-text h3,
  #about .highlight-text h3,
  #about .value-card h3,
  #about .vm-header h3,
  #about .faq-empty h3,
  #about .support-content h3 {
    color: black !important;
  }
  
  #about .overview-text p,
  #about .highlight-text p,
  #about .value-card p,
  #about .vm-card p,
  #about .answer-text,
  #about .support-content p {
    color: #333 !important;
  }
  
  #about .btn,
  #about .faq-question .faq-icon,
  #about .section-badge,
  #about .first-edition-badge {
    display: none !important;
  }
}

/* Landscape orientation fixes */
@media (orientation: landscape) and (max-height: 500px) {
  #about.section {
    padding: 4rem 1rem !important;
    min-height: auto !important;
  }
  
  #about .title {
    font-size: 1.5rem !important;
    margin-bottom: 0.5rem !important;
  }
  
  #about .subtitle {
    padding: 0.5rem !important;
    margin-bottom: 1rem !important;
  }
  
  #about .about-overview,
  #about .values-grid,
  #about .vision-mission {
    margin-bottom: 1.5rem !important;
  }
}

/* Dark mode compatibility */
@media (prefers-color-scheme: dark) {
  #about.section {
    background-color: #481465 !important; /* KEEP ORIGINAL COLOR */
  }
  
  #about .btn-primary {
    background: rgba(163, 92, 208, 0.95) !important;
  }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
  #about .btn,
  #about .faq-question,
  #about .mission-list li {
    min-height: 44px; /* Apple's recommended touch target size */
    min-width: 44px;
  }
  
  #about .btn {
    padding: 1rem 2rem !important;
  }
}

/* Ultra-wide screens */
@media (min-width: 1920px) {
  #about .container {
    max-width: 1400px;
  }
}

/* ============================================
   CRITICAL PERFORMANCE OPTIMIZATIONS
   ============================================ */

/* Will-change for smooth animations */
#about .btn,
#about .faq-question,
#about .value-card,
#about .vm-card {
  will-change: transform, opacity;
  backface-visibility: hidden;
}

/* Hardware acceleration */
#about .overview-content,
#about .value-card,
#about .vm-card {
  transform: translateZ(0);
}

/* Image optimization */
#about img {
  max-width: 100%;
  height: auto;
}

/* Font loading optimization */
#about .title,
#about .subtitle,
#about .btn {
  font-display: swap;
}

/* ============================================
   ABSOLUTE FIX FOR 320px DEVICES
   ============================================ */

/* Specific fix for Samsung Galaxy Fold (280px) */
@media (max-width: 280px) {
  #about.section {
    padding: 3rem 0.25rem !important;
  }
  
  #about .container {
    padding: 0 0.25rem !important;
  }
  
  #about .title {
    font-size: 1.2rem !important;
    line-height: 1.1 !important;
  }
  
  #about .section-badge {
    font-size: 0.6rem !important;
    padding: 0.3rem 0.6rem !important;
  }
  
  #about .subtitle {
    font-size: 0.7rem !important;
    padding: 0.5rem !important;
  }
  
  #about .btn {
    padding: 0.5rem 1rem !important;
    font-size: 0.75rem !important;
  }
  
  /* Force single column layout */
  #about .values-grid,
  #about .vision-mission,
  #about .support-actions {
    display: flex !important;
    flex-direction: column !important;
  }
  
  /* Reduce padding everywhere */
  #about .overview-content,
  #about .first-edition-highlight,
  #about .value-card,
  #about .vm-card,
  #about .faq-item,
  #about .faq-support {
    padding: 0.75rem !important;
    margin: 0.5rem 0 !important;
  }
}

/* FINAL ASSURANCE - BACKGROUND COLOR IS PERMANENTLY FIXED */
#about.section {
  background: #481465 !important;
  background-color: #481465 !important;
  background-image: none !important;
}

/* Force remove any potential gradient */
#about.section::before,
#about.section::after,
#about .container::before,
#about .container::after {
  background: none !important;
  background-image: none !important;
}

/* ====================
   PARTNERSHIP SECTION STYLES - BIG & BEAUTIFUL LOGOS
   ==================== */

/* Section Container */
#partnership.section {
  position: relative;
  padding: 5rem 0;
  background-color: #481465;
  overflow: hidden;
  isolation: isolate;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

/* Container */
#partnership .container {
  max-width: 100%;
  margin: 0 auto;
  padding: 0 0.5rem;
  position: relative;
  width: 100%;
  box-sizing: border-box;
}

/* Title Styling - BIG & BOLD */
#partnership .title {
  font-size: 2.5rem;
  font-weight: 900;
  text-align: center;
  color: white;
  margin-bottom: 2rem;
  background: linear-gradient(135deg, #ffffff 0%, #d4b2e6 50%, #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  padding: 0 1rem;
  text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  letter-spacing: -0.5px;
  line-height: 1.1;
}

/* Subtitle - HIDDEN */
#partnership .subtitle {
  display: none;
}

/* Partners Container - FULL SCREEN */
#partnership .partners-container {
  position: relative;
  padding: 0;
  overflow: visible;
  width: 100%;
  margin: 0 auto;
}

/* Slider Wrapper - NO PADDING */
#partnership .partners-slider {
  position: relative;
  overflow: visible;
  padding: 0;
  width: 100%;
}

/* Track dengan Infinite Animation - TIGHT GAP */
#partnership .partners-track {
  display: flex;
  gap: 1rem;
  animation: slideInfiniteMobile 25s linear infinite;
  padding: 0.5rem 0;
  width: max-content;
  will-change: transform;
}

/* Untuk pause saat hover */
#partnership .partners-track:hover {
  animation-play-state: paused;
}

/* Infinite Animation - SLOWER FOR MOBILE */
@keyframes slideInfiniteMobile {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(calc(-180px * 8 - 1rem * 7));
  }
}

/* Partner Item - BIG & BEAUTIFUL */
#partnership .partner-item {
  flex: 0 0 180px; /* LARGER ON MOBILE */
  height: 180px; /* SQUARE 1:1 FOR BIG LOGOS */
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.12);
  border-radius: 20px;
  padding: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.2);
  box-shadow: 
    0 12px 32px rgba(0, 0, 0, 0.25),
    0 0 0 1px rgba(255, 255, 255, 0.1),
    inset 0 1px 0 rgba(255, 255, 255, 0.15);
  transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
  cursor: pointer;
  aspect-ratio: 1/1;
  position: relative;
  overflow: hidden;
  backdrop-filter: blur(10px);
}

/* GLOW EFFECT */
#partnership .partner-item::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, 
    #ff00ff, #00ffff, #ffff00, #ff00ff);
  background-size: 400% 400%;
  border-radius: 22px;
  z-index: -1;
  animation: glowRotate 3s linear infinite;
  opacity: 0;
  transition: opacity 0.3s ease;
}

#partnership .partner-item:hover::before {
  opacity: 1;
}

@keyframes glowRotate {
  0% { background-position: 0% 50%; }
  100% { background-position: 400% 50%; }
}

#partnership .partner-item:hover {
  transform: translateY(-12px) scale(1.08);
  background: rgba(255, 255, 255, 0.18);
  border-color: rgba(163, 92, 208, 0.6);
  box-shadow: 
    0 24px 48px rgba(0, 0, 0, 0.35),
    0 0 30px rgba(163, 92, 208, 0.3),
    0 0 0 2px rgba(255, 255, 255, 0.2),
    inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

/* SHIMMER EFFECT */
#partnership .partner-item::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, 
    transparent, 
    rgba(255, 255, 255, 0.15), 
    transparent);
  transition: left 0.7s ease;
}

#partnership .partner-item:hover::after {
  left: 100%;
}

/* Logo Container - MAXIMUM SIZE */
#partnership .partner-logo {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem;
  position: relative;
}

/* Logo Image - BIG & SHARP */
#partnership .partner-logo img {
  max-width: 90%;
  max-height: 90%;
  width: auto;
  height: auto;
  object-fit: contain;
  filter: 
    brightness(1.2)
    drop-shadow(0 4px 8px rgba(0, 0, 0, 0.4))
    contrast(1.1);
  transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
  transform-origin: center;
}

#partnership .partner-item:hover .partner-logo img {
  transform: scale(1.25);
  filter: 
    brightness(1.5)
    drop-shadow(0 8px 16px rgba(0, 0, 0, 0.6))
    contrast(1.2);
}

/* Partner Name - HIDDEN */
#partnership .partner-name {
  display: none;
}

/* Navigation Buttons - HIDDEN */
#partnership .partners-navigation {
  display: none;
}

/* ============================================
   MOBILE FIRST - BIG LOGOS FOR SMALL SCREENS
   ============================================ */

/* 280px - 319px (Smallest Mobile - Galaxy Fold) */
@media (max-width: 319px) {
  #partnership.section {
    padding: 3rem 0.25rem;
    min-height: 80vh;
  }
  
  #partnership .container {
    padding: 0 0.25rem;
  }
  
  #partnership .title {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    letter-spacing: -0.3px;
  }
  
  #partnership .partners-track {
    gap: 0.75rem;
    animation-duration: 20s;
  }
  
  #partnership .partner-item {
    flex: 0 0 140px; /* STILL BIG ON SMALL SCREENS */
    height: 140px;
    padding: 0.75rem;
    border-radius: 16px;
    border-width: 1.5px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-140px * 8 - 0.75rem * 7));
    }
  }
  
  #partnership .partner-logo img {
    max-width: 85%;
    max-height: 85%;
  }
}

/* 320px - 359px (Small Mobile) */
@media (min-width: 320px) and (max-width: 359px) {
  #partnership.section {
    padding: 3.5rem 0.5rem;
  }
  
  #partnership .title {
    font-size: 2rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 150px;
    height: 150px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-150px * 8 - 1rem * 7));
    }
  }
}

/* 360px - 374px (Standard Small Mobile) */
@media (min-width: 360px) and (max-width: 374px) {
  #partnership.section {
    padding: 4rem 0.75rem;
  }
  
  #partnership .title {
    font-size: 2.1rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 160px;
    height: 160px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-160px * 8 - 1rem * 7));
    }
  }
}

/* 375px - 399px (iPhone SE/Android Small) */
@media (min-width: 375px) and (max-width: 399px) {
  #partnership.section {
    padding: 4.5rem 1rem;
  }
  
  #partnership .title {
    font-size: 2.2rem;
  }
  
  #partnership .partners-track {
    gap: 1.25rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 170px;
    height: 170px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-170px * 8 - 1.25rem * 7));
    }
  }
}

/* 400px - 479px (Medium Mobile) */
@media (min-width: 400px) and (max-width: 479px) {
  #partnership.section {
    padding: 5rem 1rem;
  }
  
  #partnership .title {
    font-size: 2.3rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 180px;
    height: 180px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-180px * 8 - 1rem * 7));
    }
  }
}

/* 480px - 575px (Large Mobile) */
@media (min-width: 480px) and (max-width: 575px) {
  #partnership.section {
    padding: 5.5rem 1rem;
  }
  
  #partnership .title {
    font-size: 2.4rem;
  }
  
  #partnership .partners-track {
    gap: 1.5rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 200px; /* EVEN BIGGER */
    height: 200px;
    border-radius: 24px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-200px * 8 - 1.5rem * 7));
    }
  }
}

/* 576px - 767px (Small Tablet) */
@media (min-width: 576px) and (max-width: 767px) {
  #partnership.section {
    padding: 6rem 1.5rem;
  }
  
  #partnership .title {
    font-size: 2.8rem;
    margin-bottom: 2.5rem;
  }
  
  #partnershi .partners-track {
    gap: 1.75rem;
    animation-duration: 30s;
  }
  
  #partnership .partner-item {
    flex: 0 0 220px;
    height: 220px;
    border-radius: 28px;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-220px * 8 - 1.75rem * 7));
    }
  }
}

/* 768px - 991px (Tablet) */
@media (min-width: 768px) and (max-width: 991px) {
  #partnership.section {
    padding: 7rem 2rem;
  }
  
  #partnership .title {
    font-size: 3.2rem;
    margin-bottom: 3rem;
  }
  
  #partnership .partners-track {
    gap: 2rem;
    animation-duration: 35s;
    animation-name: slideInfiniteTablet;
  }
  
  #partnership .partner-item {
    flex: 0 0 240px;
    height: 240px;
    border-radius: 32px;
  }
  
  @keyframes slideInfiniteTablet {
    100% {
      transform: translateX(calc(-240px * 8 - 2rem * 7));
    }
  }
}

/* 992px - 1199px (Small Desktop) */
@media (min-width: 992px) and (max-width: 1199px) {
  #partnership.section {
    padding: 8rem 3rem;
  }
  
  #partnership .title {
    font-size: 3.5rem;
    margin-bottom: 3.5rem;
  }
  
  #partnership .partners-track {
    gap: 2.5rem;
    animation-duration: 40s;
    animation-name: slideInfiniteDesktop;
  }
  
  #partnership .partner-item {
    flex: 0 0 260px;
    height: 260px;
    border-radius: 36px;
  }
  
  @keyframes slideInfiniteDesktop {
    100% {
      transform: translateX(calc(-260px * 8 - 2.5rem * 7));
    }
  }
}

/* 1200px and above (Desktop) */
@media (min-width: 1200px) {
  #partnership.section {
    padding: 10rem 4rem;
  }
  
  #partnership .title {
    font-size: 4rem;
    margin-bottom: 4rem;
  }
  
  #partnership .partners-track {
    gap: 3rem;
    animation-duration: 50s;
    animation-name: slideInfiniteLarge;
  }
  
  #partnership .partner-item {
    flex: 0 0 300px; /* HUGE LOGOS ON DESKTOP */
    height: 300px;
    border-radius: 40px;
  }
  
  @keyframes slideInfiniteLarge {
    100% {
      transform: translateX(calc(-300px * 8 - 3rem * 7));
    }
  }
}

/* ============================================
   SPECIAL FIXES FOR BIG & BEAUTIFUL DISPLAY
   ============================================ */

/* Ultra-wide screens */
@media (min-width: 1600px) {
  #partnership.section {
    padding: 12rem 5rem;
  }
  
  #partnership .title {
    font-size: 4.5rem;
  }
  
  #partnership .partners-track {
    gap: 4rem;
    animation-duration: 60s;
  }
  
  #partnership .partner-item {
    flex: 0 0 320px;
    height: 320px;
    border-radius: 44px;
  }
  
  @keyframes slideInfiniteLarge {
    100% {
      transform: translateX(calc(-320px * 8 - 4rem * 7));
    }
  }
}

/* Landscape orientation - BIGGER LOGOS */
@media (orientation: landscape) and (max-height: 600px) {
  #partnership.section {
    padding: 4rem 1rem !important;
    min-height: 80vh;
  }
  
  #partnership .title {
    font-size: 2.5rem !important;
    margin-bottom: 1.5rem !important;
  }
  
  #partnership .partners-track {
    gap: 1.5rem;
    animation-duration: 20s;
  }
  
  #partnership .partner-item {
    flex: 0 0 180px !important;
    height: 180px !important;
  }
  
  @keyframes slideInfiniteMobile {
    100% {
      transform: translateX(calc(-180px * 8 - 1.5rem * 7));
    }
  }
}

/* iPad Pro Portrait */
@media (min-width: 1024px) and (max-width: 1366px) and (orientation: portrait) {
  #partnership.section {
    padding: 8rem 2rem;
  }
  
  #partnership .title {
    font-size: 3.8rem;
  }
  
  #partnership .partner-item {
    flex: 0 0 280px;
    height: 280px;
  }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
  #partnership .partners-track {
    animation: none !important;
    overflow-x: auto;
    justify-content: flex-start;
    padding: 0.5rem 0;
    gap: 1rem;
    scrollbar-width: thin;
    scrollbar-color: rgba(163, 92, 208, 0.6) transparent;
  }
  
  #partnership .partners-track::-webkit-scrollbar {
    height: 8px;
  }
  
  #partnership .partners-track::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    margin: 0 1rem;
  }
  
  #partnership .partners-track::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #a35cd0, #d4b2e6);
    border-radius: 4px;
  }
  
  #partnership .partner-item {
    flex-shrink: 0;
  }
  
  #partnership .partner-item:hover {
    transform: none;
  }
  
  #partnership .partner-item::before,
  #partnership .partner-item::after {
    display: none;
  }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
  #partnership .partner-item {
    border: 3px solid white !important;
    background: rgba(0, 0, 0, 0.95) !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5) !important;
  }
  
  #partnership .partner-logo img {
    filter: brightness(1.8) contrast(2) !important;
  }
}

/* Touch device optimizations - BIG TARGETS */
@media (hover: none) and (pointer: coarse) {
  #partnership .partner-item {
    min-height: 140px;
    min-width: 140px;
  }
  
  #partnership .partner-item:active {
    transform: scale(0.95) !important;
    background: rgba(255, 255, 255, 0.2) !important;
  }
  
  /* Add touch feedback */
  #partnership .partner-item {
    -webkit-tap-highlight-color: transparent;
  }
}

/* Fix untuk iOS Safari */
@supports (-webkit-touch-callout: none) {
  #partnership.section {
    -webkit-overflow-scrolling: touch;
  }
  
  #partnership .partners-track {
    -webkit-transform: translateZ(0);
  }
  
  #partnership .partner-item {
    -webkit-backdrop-filter: blur(10px);
  }
}

/* Print styles */
@media print {
  #partnership.section {
    background: white !important;
    padding: 2rem 0 !important;
    min-height: auto !important;
  }
  
  #partnership .title {
    color: black !important;
    -webkit-text-fill-color: black !important;
    background: none !important;
    text-shadow: none !important;
  }
  
  #partnership .partners-track {
    animation: none !important;
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem !important;
    width: 100% !important;
  }
  
  #partnership .partner-item {
    border: 1px solid #ccc !important;
    background: white !important;
    box-shadow: none !important;
    height: 120px !important;
  }
  
  #partnership .partner-logo img {
    filter: brightness(0) contrast(1.5) !important;
  }
}

/* Performance optimizations */
#partnership .partners-track,
#partnership .partner-item,
#partnership .partner-logo img {
  will-change: transform;
  backface-visibility: hidden;
  transform: translateZ(0);
}

/* ENSURE NO TEXT IS SHOWN - LOGOS ONLY */
#partnership .partner-name,
#partnership .partner-item > :not(.partner-logo),
#partnership .partner-logo > :not(img),
#partnership .subtitle {
  display: none !important;
  visibility: hidden !important;
  opacity: 0 !important;
  height: 0 !important;
  width: 0 !important;
  padding: 0 !important;
  margin: 0 !important;
  font-size: 0 !important;
  line-height: 0 !important;
  overflow: hidden !important;
}

/* Force square aspect ratio for big logos */
#partnership .partner-item {
  aspect-ratio: 1/1 !important;
}

/* Remove any potential text overflow */
#partnership .partner-item {
  text-indent: -9999px;
  overflow: hidden;
}

/* Final assurance - only logos visible and BIG */
#partnership .partner-logo {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  width: 100% !important;
  height: 100% !important;
}

#partnership .partner-logo img {
  display: block !important;
  width: auto !important;
  height: auto !important;
  max-width: 90% !important;
  max-height: 90% !important;
}

/* Add smooth loading for images */
#partnership .partner-logo img {
  opacity: 0;
  animation: fadeInLogo 0.5s ease forwards;
}

@keyframes fadeInLogo {
  to {
    opacity: 1;
  }
}

/* Add loading shimmer */
#partnership .partner-item.loading {
  background: linear-gradient(90deg, 
    rgba(255,255,255,0.1) 25%, 
    rgba(255,255,255,0.2) 50%, 
    rgba(255,255,255,0.1) 75%);
  background-size: 200% 100%;
  animation: loadingShimmer 1.5s infinite;
}

@keyframes loadingShimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}

/* Add gradient border animation on hover */
#partnership .partner-item:hover {
  animation: borderGlow 2s infinite;
}

@keyframes borderGlow {
  0%, 100% {
    box-shadow: 
      0 24px 48px rgba(0, 0, 0, 0.35),
      0 0 30px rgba(163, 92, 208, 0.3),
      0 0 0 2px rgba(255, 255, 255, 0.2),
      inset 0 1px 0 rgba(255, 255, 255, 0.2);
  }
  50% {
    box-shadow: 
      0 24px 48px rgba(0, 0, 0, 0.35),
      0 0 40px rgba(163, 92, 208, 0.4),
      0 0 0 3px rgba(255, 255, 255, 0.3),
      inset 0 1px 0 rgba(255, 255, 255, 0.3);
  }
}

/* Ensure the section takes full viewport height on mobile */
@media (max-width: 767px) {
  #partnership.section {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    min-height: 100dvh; /* New CSS unit for mobile */
  }
  
  #partnership .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
  }
}

/* Fix for very tall mobile screens */
@media (min-height: 800px) and (max-width: 767px) {
  #partnership.section {
    padding: 8rem 0 !important;
  }
  
  #partnership .partner-item {
    flex: 0 0 200px !important;
    height: 200px !important;
  }
}

/* Special fix for foldable devices */
@media (max-height: 500px) and (orientation: landscape) {
  #partnership.section {
    min-height: 120vh;
  }
  
  #partnership .title {
    font-size: 2rem !important;
  }
  
  #partnership .partner-item {
    flex: 0 0 150px !important;
    height: 150px !important;
  }
}

/* Add micro-interactions for mobile touch */
@media (hover: none) {
  #partnership .partner-item {
    transition: transform 0.2s ease, background 0.2s ease;
  }
  
  #partnership .partner-item:active {
    transition: transform 0.1s ease;
  }
}

/* Ensure logos are always crisp on retina displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  #partnership .partner-logo img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
  }
}
  </style>
</head>
<body>

  <!-- ===========================
     LOADING / PRELOADER - MINIMALIST
=========================== -->
<div class="loader-wrap" id="loader">
  
  <div class="loader-content">
    
    <!-- Brand Area -->
    <div class="brand-area">
      <div class="brand-logo">
        <div class="logo-circle">
          <img src="images/logo_default.png" alt="EntreVibes">
        </div>
        <h1 class="brand-name">UMSIDA EntreVibes</h1>
        <p class="brand-subtitle">UMSIDA Entrepreneurship Festival</p>
      </div>
    </div>
    
    <!-- Loading Animation -->
    <div class="loading-animation">
      <div class="spinner-ring"></div>
      <div class="loading-dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    
    
  </div>
  
  <div class="loader-footer">
    <p>© 2026 UMSIDA EntreVibes  • All Rights Reserved</p>
  </div>
  
</div>

  <!-- ===========================
       NAVBAR
       =========================== -->
  <header class="navbar" id="navbar" role="navigation" aria-label="Main Navigation">
    <div class="container nav-inner">
      <a href="#home" class="logo" aria-label=" Seluruh Indonesia">
        <img src="images/logo_default.png" 
            alt="Logo  Seluruh Indonesia" 
            style="height: 50px; width: auto; margin-right: 0.6rem; vertical-align: middle;">
        UMSIDA EntreVibes Vol. 1 
      </a>


      <nav class="nav-links" aria-label="Sekunder">
        <a href="#home">Beranda</a>

        <div class="nav-dropdown">
          <a href="#kompetisi">Kompetisi</a>
          <div class="dropdown-menu">
            <a href="#digipreneur">Lomba Digipreneur</a>
            <a href="#produk-inovasi">Lomba Produk Inovasi</a>
          </div>
        </div>

        <a href="#seminar">Seminar</a>
        <a href="#tenant">Tenant KWU & UMKM</a>
        <a href="#galeri">Galeri</a>
        <a href="/pendaftaran" class="cta-small">Daftar</a>
      </nav>


      <button class="hamburger" id="hambtn" aria-expanded="false" aria-controls="mobile-menu" title="Buka menu">
        <span class="bar" aria-hidden="true"></span>
        <span class="bar" aria-hidden="true"></span>
        <span class="bar" aria-hidden="true"></span>
      </button>
    </div>
  </header>

  <!-- mobile menu overlay -->
<div class="mobile-overlay" id="mobile-menu" aria-hidden="true">
  <div class="mobile-menu" role="menu" aria-label="Mobile Navigation">

    <a href="#home">Beranda</a>

    <!-- Dropdown Kompetisi -->
    <button type="button"
            class="mobile-dropdown-toggle"
            aria-expanded="false">
      Kompetisi
    </button>

    <div class="mobile-submenu" aria-hidden="true">
      <a href="#digipreneur" class="submenu">Lomba Digipreneur</a>
      <a href="#produk-inovasi" class="submenu">Lomba Produk Inovasi</a>
    </div>

    <a href="#seminar">Seminar</a>
    <a href="#tenant">Tenant KWU & UMKM</a>
    <a href="#galeri">Galeri</a>
    <a href="/pendaftaran" class="cta-small">Daftar</a>

  </div>
</div>

<!-- ===========================
     HERO / LANDING - ENTREVIBES UMSIDA VOL.1
=========================== -->
<main id="home" class="hero-section" role="main" aria-label="Hero Section">
  <div class="hero-container">
    
    <!-- Background Texture -->
    <div class="hero-bg-texture" aria-hidden="true">
      <div class="texture-overlay"></div>
      <div class="gradient-overlay"></div>
    </div>
    
    <!-- Badge -->
    <div class="hero-badge" aria-label="Event Badge">
      <span class="badge-icon">🚀</span>
      <span class="badge-text">Volume 1 • UMSIDA Entrepreneurship</span>
    </div>

    <!-- Main Title -->
    <h1 class="hero-title">
      <span class="title-line" style="display:block; margin-bottom: 1rem;">
        UMSIDA EntreVibes Vol. 1
      </span>

      <span class="title-line" style="display:block; font-weight: 500; font-size: 2.5rem;">
        Digital Edge 'n Culture,
        <span class="accent-text" style="font-weight: 600;">
          Shaping the Future.
        </span>
      </span>
    </h1>

    <!-- Subtitle -->
    <div class="hero-subtitle">
      <span class="subtitle-text">#DesireToCreate</span>
    </div>

    <!-- Description -->
    <p class="hero-desc">
      Volume pertama festival kewirausahaan UMSIDA yang menandai dimulainya 
      ekosistem startup kampus. Wadah bagi pelajar/mahasiswa untuk mengubah ide menjadi 
      bisnis nyata dengan bimbingan mentor dan peluang pendanaan.
    </p>

    <!-- CTA Buttons -->
    <div class="hero-ctas">
      <!-- Download Guidebook Button -->
     <a
      href="https://drive.google.com/drive/folders/1rZuKbK-cLo2XqMLVyaBmleeENW10LXHR?usp=drive_link"
      class="btn btn-primary btn-guidebook"
      target="_blank"
      rel="noopener noreferrer"
      aria-label="Buka Guidebook di Google Drive"
    >
      📘 BUKA GUIDEBOOK
    </a>

      </a>

      <!-- Explore Competitions Button -->
      <a 
        href="#competitions" 
        class="btn btn-ghost" 
        id="btnCompetitions"
        aria-label="Explore Competitions"
      >
        <span class="btn-icon">🌟</span>
        <span class="btn-text">Explore Programs</span>
      </a>
    </div>
    
    <!-- Volume 1 Badge -->
    <div class="volume-badge">
      <div class="volume-circle">
        <span class="volume-number">1</span>
        <span class="volume-st">st</span>
      </div>
      <div class="volume-label">Pioneering Edition</div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator" aria-hidden="true">
      <div class="scroll-line"></div>
      <div class="scroll-arrow">↓</div>
    </div>

  </div>
</main>
<!-- END HERO SECTION -->

<?php
// Helper function untuk memastikan link valid
if (!function_exists('safe_link')) {
    function safe_link($url) {
        if (empty($url)) return '#';
        return preg_match('#^https?://#', $url) ? $url : 'https://' . $url;
    }
}
?>

<section id="kompetisi" class="competitions-section">
  <div class="competitions-container">

    <div class="section-header">
      <div class="section-badge">
        <svg class="badge-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
        </svg>
        <span class="badge-text">EntreVibes UMSIDA</span>
      </div>

      <h2 class="section-title">
        Kategori <span class="accent-text">Kompetisi</span> & Non-Kompetisi
      </h2>

      <p class="section-subtitle">
        Beragam lomba inovatif dan kegiatan pengembangan diri — kompetisi,
        seminar, tenant UMKM, hingga konsultasi usaha.
      </p>
    </div>

    <div class="competitions-grid">
      <?php
      // Pastikan $db sudah terkoneksi sebelumnya
      if (isset($db)) {
          $stmt = $db->query("SELECT * FROM kompetisi ORDER BY kategori, judul");
          $kompetisis = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } else {
          $kompetisis = []; // Fallback jika db belum connect
      }
      
      foreach ($kompetisis as $k):
        $kategori = $k['kategori'];
        $is_konsultasi = ($k['jenis'] ?? '') === 'konsultasi';
        $is_seminar = ($k['jenis'] ?? '') === 'seminar';
      ?>
      
      <div 
        class="competition-card" 
        id="<?= htmlspecialchars($k['jenis']); ?>"
        data-category="<?= $kategori; ?>"
      >

      <style>
.competition-card.is-highlighted {
  transform: translateY(-6px);
  box-shadow:
    0 0 0 3px rgba(255, 193, 7, 0.55),
    0 12px 32px rgba(0, 0, 0, 0.15);
  z-index: 2;
}

.competition-card.is-highlighted::before {
  content: "";
  position: absolute;
  inset: -6px;
  border-radius: 18px;
  background: radial-gradient(
    circle,
    rgba(255, 193, 7, 0.35) 0%,
    rgba(255, 193, 7, 0) 70%
  );
  pointer-events: none;
  animation: highlightFade 1.4s ease-out forwards;
}

@keyframes highlightFade {
  from {
    opacity: 1;
    transform: scale(0.96);
  }
  to {
    opacity: 0;
    transform: scale(1);
  }
}
      </style>
        
        <div class="card-inner">

            <div class="card-front">
              
              <span class="card-badge <?= $kategori === 'lomba' ? 'creative-badge' : 'social-badge'; ?>">
                <?= $kategori === 'lomba' ? 'Lomba' : 'Non-Lomba'; ?>
              </span>


              <div class="card-icon">
                <?= $k['icon_svg']; ?>
              </div>

              <h3 class="card-title">
                <?= htmlspecialchars($k['judul']); ?>
              </h3>

              <p class="card-description">
                <?= htmlspecialchars($k['deskripsi']); ?>
              </p>

              <div class="card-details">
    <?php if (!empty($k['deadline'])): ?>
    <div class="detail-item">
        <svg class="detail-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
        </svg>
        <span>Deadline: <?= date('d M Y', strtotime($k['deadline'])); ?></span>
            </div>
            <?php endif; ?>

            <div class="detail-item">
                <svg class="detail-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                </svg>
                <span>
                    <strong>Biaya Registrasi:</strong> 
                    <?php if ($k['prize'] > 0): ?>
                        Rp <?= number_format($k['prize'], 0, ',', '.'); ?>
                    <?php else: ?>
                        <span class="free-text">Free Registration</span>
                    <?php endif; ?>
                </span>
            </div>

            <?php if ($kategori !== 'lomba'): ?>
            <div class="detail-item">
                <svg class="detail-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                <span><?= ($is_konsultasi) ? 'Gedung 3 UMSIDA' : 'Sertifikat Tersedia'; ?></span>
            </div>
            <?php endif; ?>
        </div>
            </div><div class="card-back">

              <h3><?= $kategori === 'lomba' ? 'Daftar Lomba' : 'Informasi Kegiatan'; ?></h3>

              <div class="card-actions">
                <?php if ($is_konsultasi): ?>
                  <div class="konsultasi-info">
                    <p>Konsultasi dilakukan secara <strong>offline</strong> selama event berlangsung di:</p>
                    <p><strong>📍 Lokasi:</strong> Gedung 3 Kampus UMSIDA</p>
                    <p><strong>⏰ Waktu:</strong> Sesuai jadwal yang ditentukan</p>
                    <p class="highlight-info">Datang langsung ke lokasi untuk konsultasi gratis dengan ahli!</p>
                  </div>

                <?php elseif ($kategori === 'lomba'): ?>
                  <?php if (!empty($k['registration_link'])): ?>
                    <a href="<?= safe_link($k['registration_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn primary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                      Daftar Lomba
                    </a>
                  <?php endif; ?>

                  <?php if (!empty($k['submission_link'])): ?>
                    <a href="<?= safe_link($k['submission_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn secondary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                      Upload Karya
                    </a>
                  <?php endif; ?>
                  
                  <?php if (!empty($k['guideline_link'])): ?>
                    <a href="<?= safe_link($k['guideline_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn secondary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                      Panduan (Guidebook)
                    </a>
                  <?php endif; ?>

                <?php else: ?>
                  <?php if (!empty($k['registration_link'])): ?>
                    <a href="<?= safe_link($k['registration_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn primary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                      Daftar Sekarang
                    </a>
                  <?php endif; ?>

                  <?php if (!empty($k['info_link'])): ?>
                    <a href="<?= safe_link($k['info_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn secondary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                      Info Lengkap
                    </a>
                  <?php endif; ?>

                  <?php if (!empty($k['guideline_link'])): ?>
                    <a href="<?= safe_link($k['guideline_link']); ?>" target="_blank" rel="noopener noreferrer" class="action-btn secondary">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                      Panduan Kegiatan
                    </a>
                  <?php endif; ?>
                <?php endif; ?>
              </div> <?php if (!empty($k['contact_person'])): ?>
                <div class="back-description">
                  <strong>Contact Person</strong><br>
                  <?= htmlspecialchars($k['contact_person']); ?>
                </div>
              <?php endif; ?>

            </div></div> </div> <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===========================
     TIMELINE SECTION
=========================== -->
<section class="section" id="timeline" aria-label="Timeline Kegiatan">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <svg class="badge-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.5 14.5L11 13V7h2v5l4 2-1.5 1.5z"/>
                </svg>
                <span class="badge-text">Jadwal Pelaksanaan</span>
            </div>
            
            <h2 class="title">Timeline Kegiatan</h2>
            <p class="subtitle">Jadwal lengkap pelaksanaan Entre Vibes UMSIDA 2025 - jangan lewatkan setiap tahapannya!</p>
        </div>

        <?php
        // ERROR HANDLING: Check if timeline data exists
        if (empty($timeline_items) || !is_array($timeline_items)):
        ?>
        
        <!-- Empty State Message -->
        <div class="timeline-empty-state">
            <div class="empty-state-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
            </div>
            <h3 class="empty-state-title">Timeline Belum Tersedia</h3>
            <p class="empty-state-message">
                Jadwal kegiatan masih dalam proses penyusunan. Timeline akan segera diumumkan dalam waktu dekat.
            </p>
            <div class="empty-state-actions">
                <button class="btn btn-primary" onclick="location.reload()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                    </svg>
                    Refresh Halaman
                </button>
                <a href="#contact" class="btn btn-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
        
        <?php else: ?>
        
        <!-- NORMAL TIMELINE (when data exists) -->
        <div class="timeline-container">
            <?php foreach($timeline_items as $index => $item): 
                // Sanitize and validate data
                $judul = isset($item['judul']) ? htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8') : 'Kegiatan';
                $tanggal_start = isset($item['tanggal_start']) ? htmlspecialchars($item['tanggal_start'], ENT_QUOTES, 'UTF-8') : '';
                $tanggal_end = isset($item['tanggal_end']) ? htmlspecialchars($item['tanggal_end'], ENT_QUOTES, 'UTF-8') : '';
                $deskripsi = isset($item['deskripsi']) ? htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8') : '';
                $link = isset($item['link']) ? htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') : '';
            ?>
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-marker">
                    <div class="timeline-dot">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <?php 
                            // Determine icon based on activity type
                            $icon_type = strtolower($judul);
                            if (strpos($icon_type, 'pendaftaran') !== false): ?>
                            <!-- Registration icon -->
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            <?php elseif (strpos($icon_type, 'lomba') !== false || strpos($icon_type, 'kompetisi') !== false): ?>
                            <!-- Competition icon -->
                            <path d="M17 4c-1.1 0-2 .9-2 2 0 .75.41 1.4 1.04 1.76l-1.03 2.05c-.02.05-.05.1-.08.16l3.58 2.08c.28-.22.61-.37.98-.41L19 9h2V7l-2.46-.04c-.13-.67-.7-1.19-1.41-1.19L17 4zM5 9l2.46.04c.13.67.7 1.19 1.41 1.19L9 12c1.1 0 2-.9 2-2 0-.75-.41-1.4-1.04-1.76l1.03-2.05c.02-.05.05-.1.08-.16L7.49 4.31c-.28.22-.61.37-.98.41L5 5H3v2l2.46.04z"/>
                            <path d="M12 15l-6.09 3.26L7 23l5-3.74L17 23l1.09-4.74L12 15z"/>
                            <?php elseif (strpos($icon_type, 'seminar') !== false || strpos($icon_type, 'workshop') !== false): ?>
                            <!-- Seminar/Workshop icon -->
                            <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm10 16H4V8h16v12z"/>
                            <path d="M13 10h-2v3H8v2h3v3h2v-3h3v-2h-3z"/>
                            <?php elseif (strpos($icon_type, 'penutupan') !== false || strpos($icon_type, 'akhir') !== false): ?>
                            <!-- Closing icon -->
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            <?php else: ?>
                            <!-- Default calendar icon -->
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 6v2h14V6H5zm2 4h10v2H7zm0 4h7v2H7z"/>
                            <?php endif; ?>
                        </svg>
                    </div>
                    <?php if($index < count($timeline_items)-1): ?>
                    <div class="timeline-line"></div>
                    <?php endif; ?>
                </div>
                <div class="timeline-content">
                    <div class="timeline-date">
                        <svg class="date-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                        <?= $tanggal_start; ?>
                        <?php if(!empty($tanggal_end) && $tanggal_end !== $tanggal_start): ?>
                            – <?= $tanggal_end; ?>
                        <?php endif; ?>
                    </div>
                    <h3>
                        <svg class="title-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <?php 
                            // Title icon based on activity type
                            if (strpos(strtolower($judul), 'pembukaan') !== false): ?>
                            <path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/>
                            <?php elseif (strpos(strtolower($judul), 'pendaftaran') !== false): ?>
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            <?php else: ?>
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                            <?php endif; ?>
                        </svg>
                        <?= $judul; ?>
                    </h3>
                    <p>
                        <svg class="desc-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.7;">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        <?= $deskripsi; ?>
                    </p>
                    
                    <?php if(!empty($link) && filter_var($link, FILTER_VALIDATE_URL)): ?>
                    <a href="<?= $link; ?>" class="timeline-link" target="_blank" rel="noopener noreferrer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                        </svg>
                        Info Selengkapnya
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Timeline Legend -->
        <div class="timeline-legend">
            <div class="legend-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#4CAF50">
                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                </svg>
                <span>Pendaftaran</span>
            </div>
            <div class="legend-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#2196F3">
                    <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/>
                </svg>
                <span>Kegiatan</span>
            </div>
            <div class="legend-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#FF9800">
                    <path d="M17 4c-1.1 0-2 .9-2 2 0 .75.41 1.4 1.04 1.76l-1.03 2.05c-.02.05-.05.1-.08.16l3.58 2.08c.28-.22.61-.37.98-.41L19 9h2V7l-2.46-.04c-.13-.67-.7-1.19-1.41-1.19L17 4z"/>
                </svg>
                <span>Kompetisi</span>
            </div>
        </div>
        
        <?php endif; ?>
        
        <?php 
        // Display database error if exists
        if (isset($database_error) && $database_error): 
        ?>
        <!-- Database Connection Error Message -->
        <div class="timeline-error" id="dbError">
            <div class="error-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <h3 class="error-title">Gagal Memuat Data</h3>
            <p class="error-message">Terjadi kesalahan saat menghubungkan ke database. Silakan coba beberapa saat lagi.</p>
            <button class="btn btn-error" onclick="location.reload()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                </svg>
                Coba Lagi
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>

  <!-- ===========================
       STATS
       =========================== -->
        <!-- <section class="section" aria-label="Pencapaian">
            <div class="container">
                <h2 class="title">Pencapaian Kami</h2>
                <p class="subtitle">Data statistik yang menunjukkan partisipasi dan dampak positif acara kami.</p>

                <div class="stats-grid">
                    <?php foreach($stats_items as $stat): ?>
                    <div class="stat animate-on-scroll">
                        <span class="num" data-target="<?= htmlspecialchars($stat['value']); ?>">0</span>
                        <span class="label"><?= htmlspecialchars($stat['label']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section> -->

        <section id="galleReels" class="galle-reels-section">
    <div class="reels-container">
        <!-- Header seperti GallePict -->
        <div class="galle-reels-header">
            <h1 class="galle-reels-title">Galle<span class="galle-reels-highlight">Reels</span></h1>
            <p class="galle-reels-subtitle">Instagram Reels Highlights dari UMSIDA Entrevibes Vol. 1</p>
        </div>
        
        <div class="reels-layout">
            <!-- Bagian Kiri: Single Reels Viewer -->
            <div class="reels-viewer">
                <div class="viewer-container">
                    <div class="single-reels-wrapper">
                        <!-- Navigation Controls -->
                        <div class="reels-nav-controls">
                            <button class="nav-btn prev-btn" id="prevReels" aria-label="Previous reels">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
                                </svg>
                            </button>
                            
                            <div class="current-reels">
                                <span class="reels-number" id="currentReels">1</span>
                                <span class="reels-total">/5</span>
                            </div>
                            
                            <button class="nav-btn next-btn" id="nextReels" aria-label="Next reels">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Single Reels Container -->
                        <div class="reels-display-container">
                            <div class="instagram-reels-embed" id="currentInstagramEmbed">
                                <!-- Instagram embed akan dimuat di sini -->
                                <div class="embed-loading">
                                    <div class="loading-spinner">
                                        <div class="spinner"></div>
                                    </div>
                                    <p>Loading Instagram Reels...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Reels Info -->
                        <div class="reels-info-panel">
                            <div class="reels-description">
                                <h3 id="reelsTitle">UMSIDA Entrevibes Highlights</h3>
                                <p id="reelsDesc">Video highlights terbaik dari acara UMSIDA Entrevibes Vol. 1</p>
                            </div>
                            
                            <a href="https://www.instagram.com/umsida_entrevibes/" target="_blank" class="view-instagram-btn">
                                <svg viewBox="0 0 24 24" width="18" height="18">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="none" stroke="currentColor" stroke-width="2"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" fill="none" stroke="currentColor" stroke-width="2"></line>
                                </svg>
                                View more on Instagram
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Info atau Konten lainnya -->
            <div class="reels-sidebar">
                <div class="sidebar-content">
                    <div class="sidebar-header">
                        <h3>About Entrevibes</h3>
                        <div class="instagram-badge">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="#833AB4"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="none" stroke="white" stroke-width="2"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" fill="none" stroke="white" stroke-width="2"></line>
                            </svg>
                            <span>@umsida_entrevibes</span>
                        </div>
                    </div>

                    <div class="sidebar-info">
                        <p>UMSIDA Entrevibes adalah acara tahunan yang menampilkan bakat dan kreativitas mahasiswa dalam bidang kewirausahaan.</p>
                        
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-number">5</div>
                                <div class="stat-label">Reels</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">250+</div>
                                <div class="stat-label">Likes</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50+</div>
                                <div class="stat-label">Comments</div>
                            </div>
                        </div>

                        <div class="reels-list">
                            <h4>All Reels</h4>
                            <div class="reels-thumbnails" id="reelsThumbnails">
                                <!-- Thumbnail list akan di-generate oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* GALLEREELS SECTION STYLES */
:root {
    --primary-blue: #1877F2;
    --primary-purple: #833AB4;
    --instagram-gradient: linear-gradient(45deg, #405DE6, #833AB4, #C13584, #E1306C, #FD1D1D);
    --white: #ffffff;
    --light-bg: #f8f9fa;
    --light-gray: #f0f0f0;
    --medium-gray: #e0e0e0;
    --dark-gray: #333333;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
    --border-radius: 16px;
    --border-radius-sm: 8px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.galle-reels-section * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.galle-reels-section {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    line-height: 1.6;
    color: var(--text-primary);
}

/* SECTION CONTAINER */
.galle-reels-section {
    background: #481465;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 80px 20px 40px;
    overflow: hidden;
}

.galle-reels-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23333333' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.reels-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* HEADER STYLES (Sama seperti GallePict) */
.galle-reels-header {
    text-align: center;
    margin-bottom: 60px;
    padding: 0 20px;
}

.galle-reels-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--white);
    margin-bottom: 15px;
    letter-spacing: -1px;
    position: relative;
    display: inline-block;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.galle-reels-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 4px;
    background: var(--instagram-gradient);
    border-radius: 2px;
}

.galle-reels-highlight {
    background: var(--instagram-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.galle-reels-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 700px;
    margin: 0 auto 30px;
    line-height: 1.7;
}

/* LAYOUT */
.reels-layout {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 40px;
    align-items: start;
}

@media (max-width: 1024px) {
    .reels-layout {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

/* LEFT SIDE: SINGLE REELS VIEWER */
.reels-viewer {
    background: var(--light-bg);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
}

.viewer-container {
    max-width: 600px;
    margin: 0 auto;
}

/* SINGLE REELS WRAPPER */
.single-reels-wrapper {
    background: var(--white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

/* NAVIGATION CONTROLS */
.reels-nav-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    background: var(--light-bg);
    border-bottom: 1px solid var(--medium-gray);
}

.nav-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--white);
    border: 1px solid var(--medium-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.nav-btn:hover {
    background: var(--light-bg);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.nav-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.nav-btn svg {
    width: 24px;
    height: 24px;
    fill: var(--text-primary);
}

.current-reels {
    display: flex;
    align-items: baseline;
    gap: 4px;
    font-weight: 600;
}

.reels-number {
    font-size: 2rem;
    color: var(--primary-purple);
}

.reels-total {
    font-size: 1.2rem;
    color: var(--text-secondary);
}

/* REELS DISPLAY CONTAINER */
.reels-display-container {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: var(--light-bg);
}

.instagram-reels-embed {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

/* LOADING STATE */
.embed-loading {
    text-align: center;
    padding: 40px;
}

.loading-spinner {
    margin: 0 auto 20px;
    width: 60px;
    height: 60px;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 4px solid var(--light-gray);
    border-top-color: var(--primary-purple);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.embed-loading p {
    color: var(--text-secondary);
    font-size: 1rem;
}

/* REELS INFO PANEL */
.reels-info-panel {
    padding: 25px;
    border-top: 1px solid var(--medium-gray);
    background: var(--white);
}

.reels-description h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 10px;
}

.reels-description p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 20px;
}

.view-instagram-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: var(--instagram-gradient);
    color: var(--white);
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.view-instagram-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(131, 58, 180, 0.3);
}

/* RIGHT SIDE: SIDEBAR */
.reels-sidebar {
    background: var(--light-bg);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    position: sticky;
    top: 30px;
}

.sidebar-header {
    margin-bottom: 25px;
}

.sidebar-header h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 15px;
}

.instagram-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: var(--white);
    border-radius: 50px;
    box-shadow: var(--shadow);
}

.instagram-badge span {
    font-weight: 600;
    color: var(--text-primary);
}

.sidebar-info p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 25px;
}

/* STATS GRID */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: var(--white);
    border-radius: var(--border-radius-sm);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-purple);
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-top: 5px;
}

/* REELS THUMBNAILS */
.reels-list h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 15px;
}

.reels-thumbnails {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.reel-thumbnail {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--white);
    border-radius: var(--border-radius-sm);
    cursor: pointer;
    transition: var(--transition);
    border: 2px solid transparent;
}

.reel-thumbnail:hover {
    transform: translateX(5px);
    box-shadow: var(--shadow);
}

.reel-thumbnail.active {
    border-color: var(--primary-purple);
    background: rgba(131, 58, 180, 0.05);
}

.thumb-number {
    width: 32px;
    height: 32px;
    background: var(--light-gray);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: var(--text-primary);
    flex-shrink: 0;
}

.reel-thumbnail.active .thumb-number {
    background: var(--primary-purple);
    color: var(--white);
}

.thumb-title {
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.95rem;
}

/* INSTAGRAM EMBED STYLING */
.instagram-media {
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
    border: none !important;
    border-radius: var(--border-radius) !important;
    overflow: hidden !important;
    margin: 0 !important;
    padding: 0 !important;
    box-shadow: var(--shadow) !important;
}

/* RESPONSIVE DESIGN */
@media (max-width: 1200px) {
    .galle-reels-title {
        font-size: 3rem;
    }
}

@media (max-width: 992px) {
    .galle-reels-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .galle-reels-section {
        padding: 70px 15px 30px;
    }
    
    .galle-reels-header {
        margin-bottom: 40px;
    }
    
    .galle-reels-title {
        font-size: 2.2rem;
    }
    
    .galle-reels-subtitle {
        font-size: 1.1rem;
    }
    
    .reels-layout {
        gap: 20px;
    }
    
    .reels-viewer,
    .reels-sidebar {
        padding: 20px;
    }
    
    .reels-nav-controls {
        padding: 15px;
    }
    
    .nav-btn {
        width: 44px;
        height: 44px;
    }
    
    .reels-display-container {
        min-height: 400px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    
    .stat-item {
        padding: 12px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .galle-reels-title {
        font-size: 1.8rem;
    }
    
    .galle-reels-subtitle {
        font-size: 1rem;
    }
    
    .reels-nav-controls {
        gap: 15px;
    }
    
    .nav-btn {
        width: 40px;
        height: 40px;
    }
    
    .reels-number {
        font-size: 1.8rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* ACCESSIBILITY */
@media (prefers-reduced-motion: reduce) {
    .galle-reels-section *,
    .galle-reels-section *::before,
    .galle-reels-section *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* FOCUS STATES */
button:focus-visible,
a:focus-visible,
.nav-btn:focus-visible {
    outline: 2px solid var(--primary-purple);
    outline-offset: 2px;
}

/* PRINT STYLES */
@media print {
    .reels-nav-controls,
    .view-instagram-btn {
        display: none;
    }
    
    .galle-reels-section {
        background: white !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data reels dari Instagram
    const reelsData = [
        {
            id: 1,
            title: "DINKOP and DISNAKER Visit",
            description: "Kunjungan ke DINKOP dan DISNAKER",
            instagramUrl: "https://www.instagram.com/reel/DThWNWRkSxd/?utm_source=ig_embed&amp;utm_campaign=loading"
        },
        {
            id: 2,
            title: "Reels Contents",
            description: "Reels tentang lomba kami",
            instagramUrl: "https://www.instagram.com/reel/DTDDMuekTRn/?utm_source=ig_embed&amp;utm_campaign=loading"
        },
        {
            id: 3,
            title: "Reels Contents",
            description: "Reels tentang lomba kami",
            instagramUrl: "https://www.instagram.com/reel/DS2IoIGkcRM/?utm_source=ig_embed&amp;utm_campaign=loading"
        },
        {
            id: 4,
            title: "Reels Contents",
            description: "Reels tentang lomba kami",
            instagramUrl: "https://www.instagram.com/reel/DSzlORzkQIA/?utm_source=ig_embed&amp;utm_campaign=loading"
        },
        {
            id: 5,
            title: "Reels Contents",
            description: "Reels tentang lomba kami",
            instagramUrl: "https://www.instagram.com/reel/DSpAIaVkes_/?utm_source=ig_embed&amp;utm_campaign=loading"
        }
    ];

    // State management
    let currentReelsIndex = 0;
    let instagramLoaded = false;

    // DOM Elements
    const currentReelsElement = document.getElementById('currentReels');
    const prevBtn = document.getElementById('prevReels');
    const nextBtn = document.getElementById('nextReels');
    const reelsTitle = document.getElementById('reelsTitle');
    const reelsDesc = document.getElementById('reelsDesc');
    const currentInstagramEmbed = document.getElementById('currentInstagramEmbed');
    const reelsThumbnails = document.getElementById('reelsThumbnails');

    // Initialize thumbnails
    function initializeThumbnails() {
        reelsThumbnails.innerHTML = '';
        reelsData.forEach((reel, index) => {
            const thumbnail = document.createElement('div');
            thumbnail.className = `reel-thumbnail ${index === currentReelsIndex ? 'active' : ''}`;
            thumbnail.innerHTML = `
                <div class="thumb-number">${index + 1}</div>
                <div class="thumb-title">${reel.title}</div>
            `;
            thumbnail.addEventListener('click', () => {
                changeReels(index);
            });
            reelsThumbnails.appendChild(thumbnail);
        });
    }

    // Load Instagram script
    function loadInstagramScript() {
        if (instagramLoaded) return;
        
        const script = document.createElement('script');
        script.src = 'https://www.instagram.com/embed.js';
        script.async = true;
        script.onload = function() {
            instagramLoaded = true;
            console.log('Instagram embed script loaded');
            loadCurrentReels();
        };
        script.onerror = function() {
            console.warn('Failed to load Instagram embed script');
            showFallback(currentReelsIndex);
        };
        document.body.appendChild(script);
    }

    // Show fallback for Instagram embed
    function showFallback(index) {
        const reel = reelsData[index];
        currentInstagramEmbed.innerHTML = `
            <div class="instagram-fallback">
                <div class="fallback-content">
                    <div class="fallback-header">
                        <div class="fallback-avatar">
                            <svg viewBox="0 0 24 24" width="40" height="40">
                                <rect x="2" y="2" width="20" height="20" rx="10" ry="10" fill="#833AB4"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="none" stroke="white" stroke-width="2"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" fill="none" stroke="white" stroke-width="2"></line>
                            </svg>
                        </div>
                        <div class="fallback-user">
                            <strong>@umsida_entrevibes</strong>
                            <span>UMSIDA Entrevibes Vol. 1</span>
                        </div>
                    </div>
                    <div class="fallback-video">
                        <svg viewBox="0 0 24 24" width="60" height="60" fill="#833AB4">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <div class="fallback-actions">
                        <a href="${reel.instagramUrl}" target="_blank" class="fallback-link">
                            View on Instagram
                        </a>
                    </div>
                </div>
            </div>
        `;
        
        // Add fallback styling
        const style = document.createElement('style');
        style.textContent = `
            .instagram-fallback {
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .fallback-content {
                padding: 20px;
            }
            .fallback-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 20px;
            }
            .fallback-avatar {
                flex-shrink: 0;
            }
            .fallback-user {
                display: flex;
                flex-direction: column;
            }
            .fallback-user strong {
                color: #333;
                font-size: 1rem;
            }
            .fallback-user span {
                color: #666;
                font-size: 0.9rem;
            }
            .fallback-video {
                background: #f0f0f0;
                border-radius: 8px;
                height: 300px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
            }
            .fallback-link {
                display: inline-block;
                padding: 12px 24px;
                background: linear-gradient(45deg, #405DE6, #833AB4);
                color: white;
                text-decoration: none;
                border-radius: 50px;
                font-weight: 600;
                font-size: 0.95rem;
            }
            .fallback-link:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(131, 58, 180, 0.3);
            }
        `;
        document.head.appendChild(style);
    }

    // Load current reels
    function loadCurrentReels() {
        const reel = reelsData[currentReelsIndex];
        
        // Update UI
        currentReelsElement.textContent = currentReelsIndex + 1;
        reelsTitle.textContent = reel.title;
        reelsDesc.textContent = reel.description;
        
        // Update active thumbnail
        document.querySelectorAll('.reel-thumbnail').forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentReelsIndex);
        });
        
        // Update button states
        prevBtn.disabled = currentReelsIndex === 0;
        nextBtn.disabled = currentReelsIndex === reelsData.length - 1;
        
        // Load Instagram embed
        if (instagramLoaded && window.instgrm) {
            currentInstagramEmbed.innerHTML = `
                <blockquote class="instagram-media" 
                            data-instgrm-permalink="${reel.instagramUrl}"
                            data-instgrm-version="14" 
                            style="background:#FFF; border:0; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin:0; max-width:100%; min-width:auto; padding:0; width:100%;">
                </blockquote>
            `;
            
            // Process the embed
            window.instgrm.Embeds.process();
        } else {
            showFallback(currentReelsIndex);
        }
    }

    // Change reels
    function changeReels(index) {
        if (index < 0 || index >= reelsData.length) return;
        
        // Add transition effect
        currentInstagramEmbed.style.opacity = '0.5';
        currentInstagramEmbed.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            currentReelsIndex = index;
            loadCurrentReels();
            
            // Remove transition effect
            setTimeout(() => {
                currentInstagramEmbed.style.opacity = '1';
                currentInstagramEmbed.style.transform = 'scale(1)';
            }, 50);
        }, 300);
    }

    // Navigation button events
    prevBtn.addEventListener('click', () => {
        if (currentReelsIndex > 0) {
            changeReels(currentReelsIndex - 1);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentReelsIndex < reelsData.length - 1) {
            changeReels(currentReelsIndex + 1);
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            if (currentReelsIndex > 0) {
                changeReels(currentReelsIndex - 1);
            }
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            if (currentReelsIndex < reelsData.length - 1) {
                changeReels(currentReelsIndex + 1);
            }
        }
    });

    // Initialize
    initializeThumbnails();
    loadInstagramScript();
    
    // Fallback if Instagram doesn't load in 5 seconds
    setTimeout(() => {
        if (!instagramLoaded) {
            showFallback(currentReelsIndex);
        }
    }, 5000);
    
    // Touch swipe for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    currentInstagramEmbed.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    currentInstagramEmbed.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0 && currentReelsIndex < reelsData.length - 1) {
                // Swipe left - next
                changeReels(currentReelsIndex + 1);
            } else if (diff < 0 && currentReelsIndex > 0) {
                // Swipe right - previous
                changeReels(currentReelsIndex - 1);
            }
        }
    }
    
    // Add animation on load untuk header
    setTimeout(() => {
        const header = document.querySelector('.galle-reels-header');
        if (header) {
            header.style.opacity = '0';
            header.style.transform = 'translateY(20px)';
            header.style.animation = 'fadeInUp 0.6s ease forwards';
            
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);
            
            setTimeout(() => {
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);
        }
    }, 300);
});
</script>

<style>
/* ===== VARIABLES & RESET ===== */
:root {
    --primary-blue: #1877F2;
    --primary-purple: #833AB4;
    --instagram-gradient: linear-gradient(45deg, #405DE6, #833AB4, #C13584, #E1306C, #FD1D1D);
    --white: #ffffff;
    --light-bg: #f8f9fa;
    --light-gray: #f0f0f0;
    --medium-gray: #e0e0e0;
    --dark-gray: #333333;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
    --border-radius: 16px;
    --border-radius-sm: 8px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.15);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallepict-section * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.gallepict-section {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    line-height: 1.6;
    color: var(--text-primary);
}

/* ===== GALLERYPICT SECTION ===== */
.gallepict-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 20px 40px;
    background: #481465;
    position: relative;
    overflow: hidden;
}

.gallepict-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23333333' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.gallepict-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* ===== HEADER ===== */
.gallepict-header {
    text-align: center;
    margin-bottom: 60px;
    padding: 0 20px;
}

.gallepict-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--white);
    margin-bottom: 15px;
    letter-spacing: -1px;
    position: relative;
    display: inline-block;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.gallepict-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 4px;
    background: var(--instagram-gradient);
    border-radius: 2px;
}

.gallepict-highlight {
    background: var(--instagram-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gallepict-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 700px;
    margin: 0 auto 30px;
    line-height: 1.7;
}

/* ===== FILTERS ===== */
.gallepict-filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 40px;
}

.gallepict-filter-btn {
    padding: 12px 28px;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    color: var(--text-primary);
    cursor: pointer;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.gallepict-filter-btn:hover {
    background: var(--white);
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

.gallepict-filter-btn.active {
    background: var(--primary-purple);
    color: var(--white);
    border-color: var(--primary-purple);
    box-shadow: 0 6px 20px rgba(131, 58, 180, 0.3);
}

/* ===== GALLERY GRID ===== */
.gallepict-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

/* ===== PHOTO CARD ===== */
.gallepict-card {
    background: var(--white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    animation: gallepictFadeIn 0.6s ease forwards;
    opacity: 0;
}

@keyframes gallepictFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.gallepict-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}

/* Image Container - Responsive untuk berbagai ratio */
.gallepict-img-container {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Default 1:1 ratio */
    overflow: hidden;
    background-color: var(--light-gray);
}

/* Ratio classes untuk berbagai aspek ratio */
.gallepict-ratio-1-1 {
    padding-bottom: 100%;
}

.gallepict-ratio-4-3 {
    padding-bottom: 75%;
}

.gallepict-ratio-3-4 {
    padding-bottom: 133.33%;
}

.gallepict-ratio-16-9 {
    padding-bottom: 56.25%;
}

.gallepict-ratio-9-16 {
    padding-bottom: 177.78%;
}

.gallepict-ratio-3-2 {
    padding-bottom: 66.67%;
}

.gallepict-ratio-2-3 {
    padding-bottom: 150%;
}

/* Image yang akan mengisi container */
.gallepict-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallepict-card:hover .gallepict-img {
    transform: scale(1.05);
}

/* Overlay & Badge */
.gallepict-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.5) 100%);
    opacity: 0;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallepict-card:hover .gallepict-overlay {
    opacity: 1;
}

.gallepict-ratio-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(5px);
}

/* Info Panel */
.gallepict-info {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.gallepict-card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 10px;
    line-height: 1.3;
}

.gallepict-card-desc {
    color: var(--text-secondary);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
}

.gallepict-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid var(--light-gray);
}

.gallepict-date {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.gallepict-actions {
    display: flex;
    gap: 10px;
}

.gallepict-action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--light-gray);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    color: var(--text-primary);
}

.gallepict-action-btn:hover {
    background: var(--primary-purple);
    color: var(--white);
    transform: scale(1.1);
}

/* ===== STATISTICS ===== */
.gallepict-stats {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 60px;
}

.gallepict-stat-box {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    min-width: 200px;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.gallepict-stat-box:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    background: var(--white);
}

.gallepict-stat-number {
    font-size: 3rem;
    font-weight: 800;
    background: var(--instagram-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.gallepict-stat-label {
    font-size: 1rem;
    color: var(--text-primary);
    margin-top: 10px;
    font-weight: 600;
}

/* ===== CTA SECTION ===== */
.gallepict-cta {
    text-align: center;
    background: rgba(255, 255, 255, 0.95);
    padding: 50px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    max-width: 800px;
    margin: 0 auto;
    backdrop-filter: blur(10px);
}

.gallepict-cta-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
}

.gallepict-cta-text {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.gallepict-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 40px;
    background: var(--instagram-gradient);
    color: var(--white);
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.gallepict-cta-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(131, 58, 180, 0.3);
}

/* ===== NOTIFICATION SYSTEM ===== */
.gallepict-notification {
    position: fixed;
    top: 100px !important; /* Jauh dari navbar */
    right: 30px;
    background: var(--primary-purple);
    color: white;
    padding: 15px 25px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(131, 58, 180, 0.4);
    z-index: 9999;
    font-weight: 600;
    max-width: 350px;
    animation: gallepictNotificationSlideIn 0.3s ease, gallepictNotificationFadeOut 0.3s ease 2.7s forwards;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes gallepictNotificationSlideIn {
    from { 
        transform: translateX(100%); 
        opacity: 0; 
    }
    to { 
        transform: translateX(0); 
        opacity: 1; 
    }
}

@keyframes gallepictNotificationFadeOut {
    from { 
        opacity: 1; 
        transform: translateX(0);
    }
    to { 
        opacity: 0; 
        transform: translateY(-10px); 
    }
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1200px) {
    .gallepict-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    
    .gallepict-title {
        font-size: 3rem;
    }
}

@media (max-width: 992px) {
    .gallepict-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .gallepict-title {
        font-size: 2.5rem;
    }
    
    .gallepict-stat-box {
        min-width: 170px;
        padding: 25px;
    }
    
    .gallepict-stat-number {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .gallepict-section {
        padding: 70px 15px 30px;
    }
    
    .gallepict-header {
        margin-bottom: 40px;
    }
    
    .gallepict-title {
        font-size: 2.2rem;
    }
    
    .gallepict-subtitle {
        font-size: 1.1rem;
    }
    
    .gallepict-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }
    
    .gallepict-info {
        padding: 20px;
    }
    
    .gallepict-card-title {
        font-size: 1.2rem;
    }
    
    .gallepict-stats {
        gap: 20px;
    }
    
    .gallepict-stat-box {
        min-width: 150px;
        padding: 20px;
    }
    
    .gallepict-stat-number {
        font-size: 2rem;
    }
    
    .gallepict-cta {
        padding: 40px 25px;
    }
    
    .gallepict-cta-title {
        font-size: 1.8rem;
    }
    
    .gallepict-notification {
        top: 90px !important;
        right: 20px;
        max-width: calc(100% - 40px);
    }
}

@media (max-width: 576px) {
    .gallepict-title {
        font-size: 1.8rem;
    }
    
    .gallepict-subtitle {
        font-size: 1rem;
    }
    
    .gallepict-filters {
        gap: 8px;
    }
    
    .gallepict-filter-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
    
    .gallepict-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .gallepict-stats {
        flex-direction: column;
        align-items: center;
    }
    
    .gallepict-stat-box {
        width: 100%;
        max-width: 300px;
    }
    
    .gallepict-cta-button {
        padding: 16px 30px;
        font-size: 1rem;
    }
    
    .gallepict-notification {
        top: 80px !important;
        right: 15px;
        left: 15px;
        max-width: none;
        text-align: center;
    }
}

@media (max-width: 400px) {
    .gallepict-grid {
        grid-template-columns: 1fr;
    }
    
    .gallepict-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .gallepict-actions {
        align-self: flex-end;
    }
}

/* ===== ACCESSIBILITY ===== */
@media (prefers-reduced-motion: reduce) {
    .gallepict-section *,
    .gallepict-section *::before,
    .gallepict-section *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

.gallepict-sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* ===== LOADING STATE ===== */
.gallepict-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 200px;
}

.gallepict-loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top-color: var(--primary-purple);
    border-radius: 50%;
    animation: gallepictSpin 1s linear infinite;
}

@keyframes gallepictSpin {
    to { transform: rotate(360deg); }
}
</style>

<section class="gallepict-section" id="gallepict">
    <div class="gallepict-container">
        <!-- Header -->
        <div class="gallepict-header">
            <h1 class="gallepict-title">Galle<span class="gallepict-highlight">Pict</span></h1>
            <p class="gallepict-subtitle">Jelajahi momen terbaik UMSIDA Entrevibes Vol. 1 melalui galeri foto kami yang responsif. Setiap foto dirancang untuk tampil sempurna di semua perangkat dengan berbagai aspek ratio.</p>
        </div>

        <!-- Filter Buttons -->
        <div class="gallepict-filters">
          <button class="gallepict-filter-btn active" data-filter="all">Semua Foto</button>
          <button class="gallepict-filter-btn" data-filter="prakompetisi">Prakompetisi</button>
          <button class="gallepict-filter-btn" data-filter="opening">Opening</button>
          <button class="gallepict-filter-btn" data-filter="competition">Kompetisi</button>
          <button class="gallepict-filter-btn" data-filter="seminar">Seminar</button>
          <button class="gallepict-filter-btn" data-filter="showcase">Showcase</button>
          <button class="gallepict-filter-btn" data-filter="closing">Penutupan</button>
      </div>

        <!-- Gallery Grid -->
        <div class="gallepict-grid" id="gallepictGrid">
            <!-- Photo cards akan di-generate oleh JavaScript -->
        </div>

        <!-- Statistics -->
        <div class="gallepict-stats">
            <div class="gallepict-stat-box">
                <div class="gallepict-stat-number" id="gallepictTotalPhotos">0</div>
                <div class="gallepict-stat-label">Total Foto</div>
            </div>
            <div class="gallepict-stat-box">
                <div class="gallepict-stat-number">7</div>
                <div class="gallepict-stat-label">Hari Acara</div>
            </div>
            <div class="gallepict-stat-box">
                <div class="gallepict-stat-number">15+</div>
                <div class="gallepict-stat-label">Kegiatan</div>
            </div>
            <div class="gallepict-stat-box">
                <div class="gallepict-stat-number">5</div>
                <div class="gallepict-stat-label">Kategori</div>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data foto dengan berbagai ratio untuk entrevibesumsida.my.id
    const gallepictPhotosData = [
        {
            id: 1,
            title: "Commitee Meeting",
            description: "Rapat koordinasi tim UMSIDA EntreVibes untuk membahas konsep, strategi, dan pengembangan kegiatan kreatif serta kewirausahaan mahasiswa.",
            category: "prakompetisi",
            ratio: "4-3",
            date: "29 Oktober 2026",
            imageUrl: "images/Documentation/W7 Commitee Meet.png"
        },
        {
            id: 2,
            title: "Committee Meeting",
            description: "Rapat koordinasi tim UMSIDA EntreVibes untuk membahas konsep, strategi, dan pengembangan kegiatan kreatif serta kewirausahaan mahasiswa.",
            category: "prakompetisi",
            ratio: "16-9",
            date: "2 Januari 2026",
            imageUrl: "images/Documentation/MEETING.png"
        },
        {
            id: 3,
            title: "Visit to Dinas Koperasi dan Usaha Mikro Sidoarjo",
            category: "prakompetisi",
            ratio: "16-9",
            description: "Kunjungan resmi UMSIDA Entrevibes Vol. 1 ke Dinas Koperasi dan Usaha Mikro Sidoarjo sebagai momen pembukaan kegiatan yang berfokus pada kolaborasi, edukasi, dan penguatan ekosistem kewirausahaan.",
            date: "6 Januari 2026",
            imageUrl: "images/Documentation/DINKOP and UMKM.png"
        },
        {
            id: 4,
            title: "Visit to Dinas Tenaga Kerja Sidoarjo",
            description: "Kunjungan UMSIDA yang diikuti oleh delegasi dari berbagai fakultas sebagai ajang persiapan dan silaturahmi sebelum rangkaian acara dimulai, dengan semangat kolaborasi dan antusiasme tinggi.",
            category: "prakompetisi",
            ratio: "16-9",
            date: "6 Januari 2026",
            imageUrl: "images/Documentation/DISNAKER.png"
        },
        {
            id: 5,
            title: "Meeting at UMSIDA Campus 1",
            description: "Rapat koordinasi dan sesi inspiratif UMSIDA Entrevibes bersama pembicara tamu yang membagikan pengalaman serta wawasan praktis di bidang kewirausahaan kepada peserta.",
            category: "prakompetisi",
            ratio: "4-3",
            date: "14 Januari 2026",
            imageUrl: "images/Documentation/UMSIDA KAMPUS 1.png"
        },
        {
            id: 6,
            title: "Visit to SMAS Hang Tuah 5 Sidoarjo",
            description: "Kunjungan UMSIDA Entrevibes ke SMAS Hang Tuah 5 Sidoarjo dalam rangka sosialisasi lomba UMSIDA EntreVibes, pengenalan rangkaian kegiatan, serta upaya menumbuhkan semangat dan minat kewirausahaan sejak dini di kalangan pelajar.",
            category: "prakompetisi",
            ratio: "4-3",
            date: "15 Januari 2026",
            imageUrl: "images/Documentation/VISIT SCHOOL.png"
        }
    ];

    // DOM Elements
    const gallepictGrid = document.getElementById('gallepictGrid');
    const gallepictFilterButtons = document.querySelectorAll('.gallepict-filter-btn');
    const gallepictTotalPhotosElement = document.getElementById('gallepictTotalPhotos');
    const gallepictUploadBtn = document.getElementById('gallepictUploadBtn');

    // Initialize gallery
    function gallepictInitGallery() {
        gallepictRenderPhotos(gallepictPhotosData);
        gallepictUpdateTotalPhotos();
        gallepictSetupEventListeners();
        
        // Add initial animation to photo cards
        setTimeout(() => {
            document.querySelectorAll('.gallepict-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        }, 300);
    }

    // Render photos to grid
    function gallepictRenderPhotos(photos) {
        gallepictGrid.innerHTML = '';
        
        if (photos.length === 0) {
            gallepictGrid.innerHTML = `
                <div class="gallepict-loading" style="grid-column: 1/-1;">
                    <p style="color: white; text-align: center; font-size: 1.2rem;">Tidak ada foto ditemukan untuk kategori ini.</p>
                </div>
            `;
            return;
        }
        
        photos.forEach(photo => {
            const photoCard = gallepictCreatePhotoCard(photo);
            gallepictGrid.appendChild(photoCard);
        });
    }

    // Create photo card element
    function gallepictCreatePhotoCard(photo) {
        const card = document.createElement('div');
        card.className = `gallepict-card`;
        card.dataset.category = photo.category;
        
        // Format ratio untuk display
        const ratioDisplay = photo.ratio.replace('-', ':');
        
        card.innerHTML = `
            <div class="gallepict-img-container gallepict-ratio-${photo.ratio}">
                <img src="${photo.imageUrl}" alt="${photo.title}" class="gallepict-img" loading="lazy">
                <div class="gallepict-overlay">
                    <div class="gallepict-ratio-badge" title="Aspect Ratio: ${ratioDisplay}">${ratioDisplay}</div>
                </div>
            </div>
            <div class="gallepict-info">
                <h3 class="gallepict-card-title">${photo.title}</h3>
                <p class="gallepict-card-desc">${photo.description}</p>
                <div class="gallepict-meta">
                    <div class="gallepict-date">${photo.date}</div>
                    <div class="gallepict-actions">
                        <button class="gallepict-action-btn" aria-label="Suka foto ini" data-photo-id="${photo.id}">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="gallepict-action-btn" aria-label="Bagikan foto" data-photo-id="${photo.id}">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }

    // Filter photos by category
    function gallepictFilterPhotos(category) {
        const allPhotos = gallepictPhotosData;
        
        if (category === 'all') {
            gallepictRenderPhotos(allPhotos);
        } else {
            const filteredPhotos = allPhotos.filter(photo => photo.category === category);
            gallepictRenderPhotos(filteredPhotos);
        }
        
        // Re-add animation to newly rendered cards
        setTimeout(() => {
            document.querySelectorAll('.gallepict-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.05}s`;
            });
        }, 50);
    }

    // Update total photos count
    function gallepictUpdateTotalPhotos() {
        gallepictTotalPhotosElement.textContent = gallepictPhotosData.length;
    }

    // Show notification dengan posisi aman dari navbar
    function gallepictShowNotification(message, type = 'info') {
        // Hapus notifikasi sebelumnya jika ada
        const existingNotification = document.querySelector('.gallepict-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Buat elemen notifikasi
        const notification = document.createElement('div');
        notification.className = 'gallepict-notification';
        notification.textContent = message;
        
        // Tambahkan ke body
        document.body.appendChild(notification);
        
        // Hapus otomatis setelah 3 detik
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    // Setup event listeners
    function gallepictSetupEventListeners() {
        // Filter buttons
        gallepictFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                gallepictFilterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Filter photos
                const filter = this.dataset.filter;
                gallepictFilterPhotos(filter);
                
                // Show notification
                if (filter === 'all') {
                    gallepictShowNotification('Menampilkan semua foto');
                } else {
                    const filterNames = {
                        'prakompetisi': 'Prakompetisi',
                        'opening': 'Opening Ceremony',
                        'competition': 'Kompetisi',
                        'seminar': 'Seminar',
                        'showcase': 'Showcase',
                        'closing': 'Penutupan'
                    };
                    gallepictShowNotification(`Menampilkan foto kategori: ${filterNames[filter]}`);
                }
            });
        });
        
        // Photo action buttons
        gallepictGrid.addEventListener('click', function(e) {
            const actionBtn = e.target.closest('.gallepict-action-btn');
            if (!actionBtn) return;
            
            const photoId = actionBtn.dataset.photoId;
            const icon = actionBtn.querySelector('i');
            const photoCard = actionBtn.closest('.gallepict-card');
            const photoTitle = photoCard.querySelector('.gallepict-card-title').textContent;
            
            if (icon.classList.contains('fa-heart')) {
                // Like button
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    actionBtn.style.color = '#E1306C';
                    actionBtn.style.background = 'rgba(225, 48, 108, 0.1)';
                    gallepictShowNotification(`"${photoTitle}" ditambahkan ke favorit`);
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    actionBtn.style.color = '';
                    actionBtn.style.background = '';
                    gallepictShowNotification(`"${photoTitle}" dihapus dari favorit`);
                }
            } else if (icon.classList.contains('fa-share-alt')) {
                // Share button
                const shareUrl = `https://entrevibesumsida.my.id/gallepict/photo/${photoId}`;
                if (navigator.share) {
                    // Web Share API
                    navigator.share({
                        title: photoTitle,
                        text: `Lihat foto "${photoTitle}" dari UMSIDA Entrevibes Vol. 1`,
                        url: shareUrl
                    }).then(() => {
                        gallepictShowNotification('Berhasil berbagi foto!');
                    }).catch(err => {
                        console.log('Error sharing:', err);
                        navigator.clipboard.writeText(shareUrl).then(() => {
                            gallepictShowNotification('Link foto disalin ke clipboard!');
                        });
                    });
                } else {
                    // Fallback copy to clipboard
                    navigator.clipboard.writeText(shareUrl).then(() => {
                        gallepictShowNotification(`Link "${photoTitle}" disalin ke clipboard!`);
                    });
                }
            } else if (icon.classList.contains('fa-expand-alt')) {
                // View details button
                gallepictShowNotification(`Melihat detail: ${photoTitle}`);
                
                // Highlight card sementara
                photoCard.style.boxShadow = '0 0 0 3px #833AB4, 0 12px 40px rgba(131, 58, 180, 0.3)';
                setTimeout(() => {
                    photoCard.style.boxShadow = '';
                }, 1500);
            }
        });
        
        // Upload photo button
        gallepictUploadBtn.addEventListener('click', function() {
            gallepictShowNotification('Fitur unggah foto akan segera tersedia di entrevibesumsida.my.id!');
            
            // Simulasi form upload
            setTimeout(() => {
                const newPhoto = {
                    id: gallepictPhotosData.length + 1,
                    title: "Foto Baru dari Peserta",
                    description: "Foto dokumentasi acara UMSIDA Entrevibes Vol. 1 yang diunggah oleh peserta.",
                    category: "user",
                    ratio: "4-3",
                    date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                    imageUrl: "https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80&domain=entrevibesumsida.my.id"
                };
                
                gallepictPhotosData.push(newPhoto);
                gallepictRenderPhotos(gallepictPhotosData);
                gallepictUpdateTotalPhotos();
                
                // Scroll ke foto baru
                setTimeout(() => {
                    const newCard = document.querySelector(`.gallepict-card:last-child`);
                    if (newCard) {
                        newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        newCard.style.boxShadow = '0 0 0 3px #833AB4, 0 12px 40px rgba(131, 58, 180, 0.4)';
                        setTimeout(() => {
                            newCard.style.boxShadow = '';
                        }, 2000);
                    }
                }, 300);
            }, 1500);
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const gallerySection = document.getElementById('gallepict');
            const isGalleryVisible = gallerySection && 
                gallerySection.getBoundingClientRect().top < window.innerHeight &&
                gallerySection.getBoundingClientRect().bottom > 0;
            
            if (!isGalleryVisible) return;
            
            if (e.key === 'Escape') {
                // Reset filter jika ada
                gallepictFilterButtons.forEach(btn => {
                    if (btn.dataset.filter === 'all') {
                        btn.click();
                    }
                });
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                // Navigasi filter dengan keyboard
                const activeFilter = document.querySelector('.gallepict-filter-btn.active');
                const filters = Array.from(gallepictFilterButtons);
                const currentIndex = filters.indexOf(activeFilter);
                
                if (e.key === 'ArrowLeft' && currentIndex > 0) {
                    filters[currentIndex - 1].click();
                } else if (e.key === 'ArrowRight' && currentIndex < filters.length - 1) {
                    filters[currentIndex + 1].click();
                }
            }
        });
    }

    // Initialize gallery on load
    gallepictInitGallery();
    
    // Intersection Observer untuk animasi saat scroll
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });
        
        // Observe cards setelah di-render
        setTimeout(() => {
            document.querySelectorAll('.gallepict-card').forEach(card => {
                observer.observe(card);
            });
        }, 500);
    }
    
    // Preload gambar untuk performa lebih baik
    window.addEventListener('load', function() {
        gallepictPhotosData.forEach(photo => {
            const img = new Image();
            img.src = photo.imageUrl;
        });
    });
});
</script>

   <!-- ===========================
     ABOUT US SECTION - PROFESSIONAL (FIRST EDITION)
=========================== -->
<section class="section" id="about" aria-label="Tentang Kami">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <div class="section-badge">
                <svg class="badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <span class="badge-text">Tentang Entre Vibes</span>
            </div>
            
            <h2 class="title">Tentang Kami</h2>
            <p class="subtitle">Entre Vibes UMSIDA adalah National Youth Competition terkemuka yang diinisiasi oleh UMSIDS. Sebagai edisi pertama, kami hadir dengan semangat membangun ekosistem pengembangan potensi generasi muda Indonesia yang berkelanjutan.</p>
        </div>

        <!-- Company Overview -->
        <div class="about-overview animate-on-scroll">
            <div class="overview-content">
                <div class="overview-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="overview-text">
                    <h3>Sejarah & Filosofi</h3>
                    <p>Entre Vibes UMSIDA lahir dari   dan Universitas Muhammadiyah Sidoarjo untuk menciptakan wadah kompetisi nasional yang holistik. Sebagai edisi perdana tahun 2025, kami berkomitmen membangun fondasi yang kuat untuk menciptakan tradisi keunggulan akademik dan pengembangan karakter bagi generasi muda Indonesia.</p>
                </div>
            </div>
            
            <div class="first-edition-highlight">
                <div class="first-edition-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span>EDISI PERTAMA 2025</span>
                </div>
                <div class="highlight-text">
                    <h3>Memulai Perjalanan Besar</h3>
                    <p>Sebagai penyelenggara edisi pertama, kami menghadirkan format kompetisi inovatif yang menggabungkan aspek akademik, kreativitas, dan pengembangan karakter. Fokus utama kami adalah membangun pengalaman berharga yang menjadi fondasi bagi kesuksesan peserta di masa depan.</p>
                </div>
            </div>
        </div>

        <!-- Core Values Grid -->
        <div class="section-header" style="margin-top: 4rem;">
            <h2 class="title">Nilai-Nilai Inti Kami</h2>
            <p class="subtitle">Prinsip yang menjadi fondasi setiap kegiatan dan program yang kami selenggarakan dalam edisi pertama ini.</p>
        </div>

        <div class="values-grid">
            <div class="value-card animate-on-scroll">
                <div class="value-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h3>Inovasi</h3>
                <p>Sebagai edisi pertama, kami berkomitmen menghadirkan format kompetisi yang segar, relevan dengan perkembangan zaman, dan memberikan pengalaman baru bagi peserta.</p>
            </div>

            <div class="value-card animate-on-scroll">
                <div class="value-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                </div>
                <h3>Excellence</h3>
                <p>Menetapkan standar kualitas tinggi sejak awal dengan sistem penilaian yang komprehensif dan pendampingan dari mentor berpengalaman.</p>
            </div>

            <div class="value-card animate-on-scroll">
                <div class="value-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3>Kolaborasi</h3>
                <p>Membangun jaringan antara peserta, mentor, dan institusi pendidikan untuk menciptakan komunitas pembelajaran yang dinamis.</p>
            </div>

            <div class="value-card animate-on-scroll">
                <div class="value-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <h3>Transparansi</h3>
                <p>Menjaga proses kompetisi yang adil, terbuka, dan dapat dipertanggungjawabkan kepada seluruh pemangku kepentingan.</p>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="vision-mission">
            <div class="vm-card animate-on-scroll">
                <div class="vm-header">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                    </svg>
                    <h3>Visi Kami</h3>
                </div>
                <p>Sebagai penyelenggara edisi pertama, kami bervisi menjadi pionir dalam menghadirkan platform kompetisi nasional yang tidak hanya menguji kemampuan akademis, tetapi juga membentuk karakter kepemimpinan dan jiwa entrepreneurship generasi muda Indonesia untuk bersaing di era global.</p>
            </div>

            <div class="vm-card animate-on-scroll">
                <div class="vm-header">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                    </svg>
                    <h3>Misi Kami</h3>
                </div>
                <ul class="mission-list">
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                        <span>Menghadirkan kompetisi nasional dengan standar tinggi sebagai edisi pertama yang akan menjadi acuan di masa depan</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                        <span>Membangun ekosistem pembelajaran yang mendukung pengembangan soft skills dan hard skills secara seimbang</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                        <span>Menjalin kemitraan strategis dengan berbagai pihak untuk memperluas dampak positif kompetisi</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                        <span>Menciptakan pengalaman kompetitif yang berkesan dan menjadi momentum awal bagi perkembangan peserta</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <div class="section-header">
                <h2 class="title">Pertanyaan Umum</h2>
                <p class="subtitle">Jawaban atas pertanyaan yang sering diajukan tentang Entre Vibes UMSIDA 2025</p>
            </div>

            <div class="faq-container">
                <?php 
                if (!empty($faq_items) && is_array($faq_items)):
                    foreach($faq_items as $index => $faq): 
                        $question = isset($faq['question']) ? htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') : '';
                        $answer = isset($faq['answer']) ? htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8') : '';
                ?>
                <div class="faq-item animate-on-scroll">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?= $index; ?>">
                        <span class="faq-number"><?= sprintf('%02d', $index + 1); ?></span>
                        <span class="faq-text"><?= $question; ?></span>
                        <svg class="faq-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                        </svg>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?= $index; ?>" hidden>
                        <div class="answer-content">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="answer-icon">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <div class="answer-text"><?= $answer; ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="faq-empty">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    <h3>FAQ Belum Tersedia</h3>
                    <p>Pertanyaan yang sering diajukan akan segera ditambahkan.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Additional Support -->
            <div class="faq-support animate-on-scroll">
                <div class="support-content">
                    <h3>Butuh Informasi Lebih Lanjut?</h3>
                    <p>Tim kami siap membantu menjelaskan lebih detail tentang Entre Vibes UMSIDA 2025. Jangan ragu untuk menghubungi kami.</p>
                </div>
                <div class="support-actions">
                    <a href="#contact-person" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                        </svg>
                        Hubungi Panitia
                    </a>
                    <a href="#timeline" class="btn btn-outline">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                        Lihat Timeline
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for FAQ functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const answer = this.nextElementSibling;
            
            // Close all other FAQs
            faqQuestions.forEach(q => {
                if (q !== this) {
                    q.setAttribute('aria-expanded', 'false');
                    q.nextElementSibling.hidden = true;
                }
            });
            
            // Toggle current FAQ
            this.setAttribute('aria-expanded', !isExpanded);
            answer.hidden = isExpanded;
        });
    });
    
    // Animate elements on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight - 100) {
                element.classList.add('animated');
            }
        });
    };
    
    // Initial check
    animateOnScroll();
    
    // Listen for scroll
    window.addEventListener('scroll', animateOnScroll);
});
</script>

  <section class="section" id="partnership" aria-label="Partnership">
    <div class="container">
        <h2 class="title">Bekerja Sama Dengan</h2>
        <p class="subtitle">
            Kolaborasi bersama institusi dan perusahaan terkemuka untuk mendukung generasi muda Seluruh Indonesia
        </p>
        <div class="partners-container">
            <div class="partners-slider">
                <div class="partners-track">
                    <?php
                    // Pastikan $partners sudah berisi data dari database
                    if (!empty($partners)) :
                        foreach ($partners as $partner):
                            // Gunakan key image_url sesuai data database
                            $imgSrc = isset($partner['image_url']) ? $partner['image_url'] : '';
                            $name = isset($partner['name']) ? $partner['name'] : '';
                    ?>
                        <div class="partner-item" tabindex="0">
                            <div class="partner-logo">
                                <?php if($imgSrc): ?>
                                    <img src="<?= htmlspecialchars($imgSrc); ?>" alt="<?= htmlspecialchars($name); ?>" />
                                <?php else: ?>
                                    <span>No Logo</span>
                                <?php endif; ?>
                            </div>
                            <span class="partner-name"><?= htmlspecialchars($name); ?></span>
                        </div>
                    <?php
                        endforeach;
                    else: ?>
                        <p>Tidak ada partner yang terdaftar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const track = document.querySelector('#partnership .partners-track');
  if (!track) return;
  
  // Pastikan ada partner items
  const items = track.querySelectorAll('.partner-item');
  if (items.length === 0) return;
  
  // Clone items untuk infinite effect (jika kurang dari 12)
  if (items.length < 12) {
    // Hitung berapa clone yang dibutuhkan untuk total minimal 12
    const clonesNeeded = Math.ceil(12 / items.length);
    
    // Clone setiap item
    for (let i = 0; i < clonesNeeded; i++) {
      items.forEach(item => {
        const clone = item.cloneNode(true);
        clone.classList.add('clone');
        track.appendChild(clone);
      });
    }
  }
  
  // Buat navigation buttons jika lebih dari 3 items
  if (items.length > 3) {
    const container = document.querySelector('#partnership .partners-container');
    const navHTML = `
      <div class="partners-navigation">
        <button class="nav-btn prev-btn" aria-label="Partner sebelumnya">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
          </svg>
        </button>
        <button class="nav-btn next-btn" aria-label="Partner berikutnya">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
          </svg>
        </button>
      </div>
    `;
    
    container.insertAdjacentHTML('beforeend', navHTML);
    
    // Navigation functionality
    const prevBtn = container.querySelector('.prev-btn');
    const nextBtn = container.querySelector('.next-btn');
    
    let isAnimating = false;
    const itemWidth = 280; // Sesuaikan dengan CSS
    const gap = 48; // Sesuaikan dengan gap di CSS
    
    function slide(direction) {
      if (isAnimating) return;
      
      isAnimating = true;
      const currentTransform = track.style.transform || 'translateX(0px)';
      const currentX = parseInt(currentTransform.match(/translateX\(([-\d.]+)px\)/)?.[1] || 0);
      
      const moveDistance = itemWidth + gap;
      const newX = direction === 'next' ? currentX - moveDistance : currentX + moveDistance;
      
      // Reset animation jika sudah sampai ujung
      const trackWidth = track.scrollWidth / 2;
      const resetX = Math.abs(newX) >= trackWidth ? 0 : newX;
      
      track.style.transition = 'transform 0.5s ease';
      track.style.transform = `translateX(${resetX}px)`;
      
      setTimeout(() => {
        track.style.transition = 'none';
        // Jika reset, atur transform ke 0 tanpa animasi
        if (resetX === 0) {
          track.style.transform = 'translateX(0px)';
        }
        isAnimating = false;
      }, 500);
    }
    
    // Event Listeners untuk navigation buttons
    prevBtn.addEventListener('click', () => slide('prev'));
    nextBtn.addEventListener('click', () => slide('next'));
  }
  
  // Pause animation on hover
  track.addEventListener('mouseenter', () => {
    track.style.animationPlayState = 'paused';
  });
  
  track.addEventListener('mouseleave', () => {
    track.style.animationPlayState = 'running';
  });
  
  // Touch support untuk mobile
  let touchStartX = 0;
  let isPaused = false;
  
  track.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
    track.style.animationPlayState = 'paused';
    isPaused = true;
  });
  
  track.addEventListener('touchend', (e) => {
    if (!touchStartX) return;
    
    const touchEndX = e.changedTouches[0].clientX;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > 50) { // Minimum swipe distance
      if (diff > 0) {
        // Swipe left - next
        slide('next');
      } else {
        // Swipe right - prev
        slide('prev');
      }
    }
    
    // Resume animation setelah 1 detik
    setTimeout(() => {
      if (isPaused) {
        track.style.animationPlayState = 'running';
        isPaused = false;
      }
    }, 1000);
    
    touchStartX = 0;
  });
  
  // Keyboard navigation support
  track.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      slide('prev');
    } else if (e.key === 'ArrowRight') {
      slide('next');
    }
  });
  
  // Function untuk slide (jika navigation buttons ada)
  function slide(direction) {
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    if (!prevBtn || !nextBtn) return;
    
    const track = document.querySelector('#partnership .partners-track');
    if (!track) return;
    
    const currentTransform = track.style.transform || 'translateX(0px)';
    const currentX = parseInt(currentTransform.match(/translateX\(([-\d.]+)px\)/)?.[1] || 0);
    
    const itemWidth = window.innerWidth < 768 ? 200 : 280;
    const gap = window.innerWidth < 768 ? 32 : 48;
    const moveDistance = itemWidth + gap;
    
    let newX;
    if (direction === 'next') {
      newX = currentX - moveDistance;
    } else {
      newX = currentX + moveDistance;
    }
    
    // Reset jika sudah mencapai batas
    const trackWidth = track.scrollWidth / 2;
    if (Math.abs(newX) >= trackWidth) {
      newX = 0;
    }
    
    track.style.transition = 'transform 0.5s ease';
    track.style.transform = `translateX(${newX}px)`;
    
    setTimeout(() => {
      if (Math.abs(newX) === 0) {
        track.style.transition = 'none';
        track.style.transform = 'translateX(0px)';
      }
    }, 500);
  }
});
</script>

<footer>
  <!-- Sponsor Utama -->
  <div class="sponsor-section">
    <div class="sponsor-content">
      <h4>Didukung Penuh oleh:</h4>
      <div class="sponsor-logo">
        <img src="images/2025.png" alt="PT. MicroHelix Tech Solutions Logo" class="main-sponsor-logo">
        <h3>PT. MicroHelix Tech Solutions</h3>
      </div>
      <p class="sponsor-description">
        Sebagai komitmen dalam mendukung pengembangan generasi muda dan dunia pendidikan, 
        PT. MicroHelix Tech Solutions dengan banggan menjadi sponsor utama dalam penyelenggaraan 
        platform kompetisi Entre Vibes UMSIDA ini.
      </p>
    </div>
  </div>

  <!-- Info & About -->
  <div class="foot-inner">
    <div class="foot-about">
      <h3>Entre Vibes UMSIDA</h3>
      <p>Platform terdepan untuk mengembangkan potensi dan prestasi generasi muda Seluruh Indonesia. Kami berkomitmen mendukung kreativitas, inovasi, dan semangat kompetitif para peserta melalui lomba-lomba yang inspiratif.</p>
      <div class="sponsor-badge">
        <small>Platform ini didukung penuh oleh <strong>PT. MicroHelix Tech Solutions</strong></small>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="foot-links">
      <h4>Navigasi Cepat</h4>
      <ul>
        <li><a href="#home">Beranda</a></li>
        <li><a href="#kompetisi">Kompetisi</a></li>
        <li><a href="#pendaftaran">Pendaftaran</a></li>
        <li><a href="#tentang">Tentang Kami</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#sponsor">Sponsor & Partner</a></li>
      </ul>
    </div>

    <!-- Social Media & Contact -->
    <div class="foot-social">
      <h4>Hubungi Kami</h4>
      <p>Untuk informasi kerjasama, sponsorship, dan partnership:</p>
      <div class="contact-info" id="contact-person">
          <div class="cp-wrapper">
              <a href="https://api.whatsapp.com/send/?phone=6287855094196&text=Halo%20Nabilah,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
                target="_blank" class="cp-link">
                  <div class="cp-icon">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.63 1.432h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                      </svg>
                  </div>
                  <div class="cp-text">
                      <span class="cp-label">Contact Person 1</span>
                      <span class="cp-name">Nabilah</span>
                  </div>
              </a>

              <a href="https://api.whatsapp.com/send/?phone=6282132019362&text=Halo%20Nurul,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
                target="_blank" class="cp-link">
                  <div class="cp-icon">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.63 1.432h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                      </svg>
                  </div>
                  <div class="cp-text">
                      <span class="cp-label">Contact Person 2</span>
                      <span class="cp-name">Nurul</span>
                  </div>
              </a>
          </div>
      </div>
      <style>
        .contact-info {
            margin-top: 20px;
        }

        .cp-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cp-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 18px;
            background: #f8f9fa;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            border: 1px solid #eee;
            transition: all 0.3s ease;
            max-width: 300px;
        }

        .cp-link:hover {
            background: #e9ecef;
            transform: translateX(5px);
            border-color: #25D366; /* Warna khas WA */
        }

        .cp-icon {
            color: #25D366;
            display: flex;
            align-items: center;
        }

        .cp-text {
            display: flex;
            flex-direction: column;
        }

        .cp-label {
            font-size: 0.75rem;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cp-name {
            font-weight: 700;
            font-size: 1rem;
        }
      </style>
      <h4>Media Sosial</h4>
      <div class="socials">
        <a href="https://www.instagram.com/umsida_entrevibes/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/@umsida_entrevibes" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
  </div>

  <!-- Supporting Logos -->
  <div class="foot-logos">
    <div class="supporting-partners">
      <h4>Partner Pendukung:</h4>
      <div class="partner-logos">
        <img src="images/logo_default.png" alt="Entre Vibes Logo">
        <img src="images/2025 CIRCLE.png" alt="MH Teams Logo">
        <img src="images/UMSIDA.png" alt="UMSIDA">
      </div>
    </div>
  </div>

  <!-- Footer Bottom: Credit & Legal -->
  <div class="footer-bottom">
    <div class="copyright">
      <p>&copy; 2025 Entre Vibes UMSIDA. Semua hak cipta dilindungi.</p>
      <p class="legal-disclaimer">
        Platform ini merupakan bagian dari program Corporate Social Responsibility 
        <strong>PT. MicroHelix Tech Solutions</strong> dalam mendukung dunia pendidikan 
        dan pengembangan bakat generasi muda Indonesia.
      </p>
    </div>
    
    <div class="technical-credit">
      <p>
        <strong>Pengembangan Teknologi:</strong> Platform ini dikembangkan oleh 
        <a href="https://mhteams.my.id" target="_blank">MicroHelix Tech Solutions</a> dari 
        <strong>PT. MicroHelix Tech Solutions</strong>.
      </p>
      <p>
        <strong>Butuh solusi digital untuk event atau organisasi Anda?</strong> 
        <a href="https://mhteams.my.id" target="_blank">Hubungi tim profesional kami</a> 
        untuk konsultasi dan penawaran khusus.
      </p>
    </div>
    
    <div class="community-cta">
      <p>
        Bergabunglah dalam ekosistem digital yang inovatif bersama 
        <strong>PT. MicroHelix Tech Solutions</strong> dan wujudkan event digital 
        yang profesional, interaktif, dan berdampak luas.
      </p>
    </div>
  </div>
</footer>

  <!-- ===========================
       LIGHTWEIGHT INLINE SCRIPTS
       =========================== -->
  <script>
    /* ========================================================================
       Utilities and initial setup
       - All JS is inline to keep single-file standalone property
       - Features:
         * Loader/progress
         * Navbar scroll effect
         * Mobile menu toggle
         * Countdown
         * Stats counter animation
         * Scroll animations via IntersectionObserver
         * Gallery lightbox
         * Testimonials slider
         * Form client-side validation
         * Dark mode toggle + persistence
       ======================================================================== */

    (function() {
      'use strict';

     /* =========================================================================
   LOADER ANIMATION - ELEGANT & SMOOTH FOR ENTREVIBES UMSIDA
   ========================================================================= */
document.addEventListener('DOMContentLoaded', function() {
    const loader = document.getElementById('loader');
    
    // Jika tidak ada loader, langsung return
    if (!loader) {
        console.warn('Loader element not found');
        document.body.style.overflow = '';
        document.body.style.height = '';
        return;
    }
    
    const progressBar = document.getElementById('progressbar');
    const progressPercent = document.getElementById('progressPercent'); // Elemen untuk persentase
    
    // Pastikan elemen progress bar ada
    if (!progressBar) {
        console.error('Progress bar element not found');
        completeLoading();
        return;
    }
    
    // Buat elemen persentase jika belum ada
    if (!progressPercent && document.querySelector('.progress-info')) {
        const progressInfo = document.querySelector('.progress-info');
        const percentSpan = document.createElement('span');
        percentSpan.id = 'progressPercent';
        percentSpan.className = 'percent';
        percentSpan.textContent = '0%';
        progressInfo.appendChild(percentSpan);
    }

    let progress = 0;
    let duration = 8000; // 8 detik - lebih realistis
    let animationId = null;
    let startTime = null;
    let forceCompleteTimeout = null;
    
    // Cegah multiple scroll prevention
    const originalOverflow = document.body.style.overflow;
    const originalHeight = document.body.style.height;
    
    function updateProgress(currentProgress) {
        // Pastikan progress bar ada
        if (!progressBar) return;
        
        // Update progress bar width dengan easing
        progressBar.style.width = currentProgress + '%';
        
        // Update percentage text
        const percentElement = document.getElementById('progressPercent');
        if (percentElement) {
            percentElement.textContent = Math.round(currentProgress) + '%';
            
            // Update status text berdasarkan progress
            const statusElement = document.querySelector('.status');
            if (statusElement) {
                if (currentProgress < 20) {
                    statusElement.textContent = 'Initializing...';
                } else if (currentProgress < 50) {
                    statusElement.textContent = 'Loading assets...';
                } else if (currentProgress < 80) {
                    statusElement.textContent = 'Preparing content...';
                } else {
                    statusElement.textContent = 'Finalizing...';
                }
            }
        }
        
        return currentProgress;
    }
    
    function animateProgress(timestamp) {
        if (!startTime) startTime = timestamp;
        
        const elapsed = timestamp - startTime;
        progress = Math.min((elapsed / duration) * 100, 99.9);
        
        // Easing function untuk progress yang lebih natural
        const easedProgress = easeInOutCubic(progress / 100) * 100;
        
        updateProgress(easedProgress);
        
        if (progress < 100) {
            animationId = requestAnimationFrame(animateProgress);
        } else {
            completeLoading();
        }
    }
    
    function easeInOutCubic(t) {
        return t < 0.5 
            ? 4 * t * t * t 
            : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }
    
    function startLoader() {
        // Reset state
        progress = 0;
        startTime = null;
        
        // Pastikan loader visible
        if (loader) {
            loader.style.display = 'flex';
            loader.classList.remove('hidden');
        }
        
        // Update initial state
        updateProgress(0);
        
        // Start animation
        animationId = requestAnimationFrame(animateProgress);
    }
    
    function completeLoading() {
        // Clear semua timeout dan animation frame
        if (animationId) {
            cancelAnimationFrame(animationId);
            animationId = null;
        }
        
        if (forceCompleteTimeout) {
            clearTimeout(forceCompleteTimeout);
            forceCompleteTimeout = null;
        }
        
        // Pastikan progress 100%
        updateProgress(100);
        
        // Tunggu sedikit untuk efek visual
        setTimeout(() => {
            if (!loader) {
                restoreScroll();
                return;
            }
            
            loader.classList.add('hidden');
            
            const handleTransitionEnd = () => {
                if (loader.parentNode) {
                    loader.style.display = 'none';
                }
                
                // Restore scrolling dengan delay
                setTimeout(restoreScroll, 100);
                
                // Dispatch event bahwa loading selesai
                window.dispatchEvent(new Event('loaderComplete'));
            };
            
            // Gunakan timeout sebagai fallback jika transitionend tidak terpicu
            const transitionFallback = setTimeout(() => {
                if (loader.parentNode) {
                    loader.style.display = 'none';
                }
                restoreScroll();
                window.dispatchEvent(new Event('loaderComplete'));
            }, 1000);
            
            loader.addEventListener('transitionend', function() {
                clearTimeout(transitionFallback);
                handleTransitionEnd();
            }, { once: true });
        }, 800);
    }
    
    function restoreScroll() {
        // Hanya restore jika kita yang mengubahnya
        if (document.body.style.overflow === 'hidden') {
            document.body.style.overflow = originalOverflow || '';
        }
        if (document.body.style.height === '100vh') {
            document.body.style.height = originalHeight || '';
        }
        
        // Juga reset pada html element untuk berjaga-jaga
        document.documentElement.style.overflow = '';
        document.documentElement.style.height = '';
    }
    
    function preventScroll() {
        // Hanya set jika belum di-set
        if (document.body.style.overflow !== 'hidden') {
            document.body.style.overflow = 'hidden';
            document.body.style.height = '100vh';
        }
    }
    
    // Cegah scrolling selama loading
    preventScroll();
    
    // Start loader setelah sedikit delay
    const startTimeout = setTimeout(startLoader, 300);
    
    // Backup: Force complete jika terlalu lama (12 detik)
    forceCompleteTimeout = setTimeout(() => {
        if (loader && !loader.classList.contains('hidden')) {
            console.log('Loader timeout - forcing completion');
            clearTimeout(startTimeout);
            completeLoading();
        }
    }, 12000);
    
    // Handle page load events
    let pageLoaded = false;
    window.addEventListener('load', function() {
        pageLoaded = true;
        // Jika halaman sudah load lebih cepat, percepat loading
        if (progress < 80) {
            console.log('Page loaded faster than expected, accelerating loader');
            // Percepat dengan mengurangi duration
            duration = Math.max(1000, duration * 0.3); // Kurangi jadi 30% dari sisa
        }
    });
    
    // Handle errors
    window.addEventListener('error', function(e) {
        console.error('Page error detected, completing loader:', e.message);
        clearTimeout(startTimeout);
        completeLoading();
    }, true);
    
    // Handle sebelumunload
    window.addEventListener('beforeunload', function() {
        // Clean up sebelum pindah halaman
        if (animationId) {
            cancelAnimationFrame(animationId);
        }
        if (forceCompleteTimeout) {
            clearTimeout(forceCompleteTimeout);
        }
        if (startTimeout) {
            clearTimeout(startTimeout);
        }
        restoreScroll();
    });
    
    // Handle jika user mencoba skip loading
    let skipAttempts = 0;
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && loader && !loader.classList.contains('hidden')) {
            skipAttempts++;
            if (skipAttempts >= 2) {
                console.log('User forced skip loading');
                clearTimeout(startTimeout);
                completeLoading();
            }
        }
    });
    
    // Juga handle click pada loader untuk skip
    if (loader) {
        loader.addEventListener('dblclick', function() {
            console.log('Double-click detected, skipping loader');
            clearTimeout(startTimeout);
            completeLoading();
        });
    }
    
    // Optimasi untuk mobile
    if ('connection' in navigator && navigator.connection) {
        const connection = navigator.connection;
        if (connection.saveData || (connection.effectiveType && connection.effectiveType.includes('2g'))) {
            // Untuk koneksi lambat, percepat sedikit
            duration = 5000;
        }
    }
});

      /* -------------------------
         Navbar scroll appearance
         ------------------------- */
      const navbar = document.getElementById('navbar');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 80) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
      });

      const dropdownToggle = document.querySelector('.mobile-dropdown-toggle');
  const submenu = document.querySelector('.mobile-submenu');

  if (dropdownToggle && submenu) {
    dropdownToggle.addEventListener('click', () => {
      const expanded = dropdownToggle.getAttribute('aria-expanded') === 'true';

      dropdownToggle.setAttribute('aria-expanded', !expanded);
      submenu.classList.toggle('active');
      submenu.setAttribute('aria-hidden', expanded);
    });
  }

  let hoverTimer;

  function isDesktop() {
    return window.innerWidth >= 1024; // laptop/PC
  }

  if (dropdownToggle && submenu) {
    dropdownToggle.addEventListener('mouseenter', () => {
      if (!isDesktop()) return;

      hoverTimer = setTimeout(() => {
        dropdownToggle.setAttribute('aria-expanded', 'true');
        submenu.classList.add('active');
        submenu.setAttribute('aria-hidden', 'false');
      }, 5000); // 5000 = 5 detik (ubah ke 8000 kalau mau)
    });

    dropdownToggle.addEventListener('mouseleave', () => {
      if (!isDesktop()) return;

      clearTimeout(hoverTimer);

      dropdownToggle.setAttribute('aria-expanded', 'false');
      submenu.classList.remove('active');
      submenu.setAttribute('aria-hidden', 'true');
    });
  }


      /* -------------------------
         Mobile Menu toggle
         ------------------------- */
      const hambtn = document.getElementById('hambtn');
      const mobileMenu = document.getElementById('mobile-menu');
      const closeMobile = document.getElementById('closeMobile');

      function openMobile() {
        hambtn.classList.add('active');
        mobileMenu.classList.add('active');
        mobileMenu.setAttribute('aria-hidden', 'false');
        hambtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
      }

      function closeMobileMenu() {
        hambtn.classList.remove('active');
        mobileMenu.classList.remove('active');
        mobileMenu.setAttribute('aria-hidden', 'true');
        hambtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }

      hambtn.addEventListener('click', () => {
        if (mobileMenu.classList.contains('active')) closeMobileMenu();
        else openMobile();
      });

      closeMobile && closeMobile.addEventListener('click', closeMobileMenu);

      // close mobile menu when clicking any anchor inside
      mobileMenu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', closeMobileMenu);
      });

      /* -------------------------
         Smooth anchor scrolling (accessible)
         ------------------------- */
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          if (!href || href === '#') return;
          const target = document.querySelector(href);
          if (!target) return;
          e.preventDefault();
          closeMobileMenu();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          // update focus for accessibility
          setTimeout(() => target.setAttribute('tabindex', '-1'), 600);
        });
      });

      /* -------------------------
         Countdown Timer
         - Set the event date here. Update as needed.
         - Use Asia/Jakarta timezone for reference (but Date uses local)
         ------------------------- */
      const eventDate = new Date('2025-11-01T09:00:00+07:00'); // 1 Nov 2025, 09:00 WIB
      const dElem = document.getElementById('days');
      const hElem = document.getElementById('hours');
      const mElem = document.getElementById('minutes');
      const sElem = document.getElementById('seconds');

      function updateCountdown() {
        const now = new Date();
        let diff = eventDate.getTime() - now.getTime();
        if (diff <= 0) {
          dElem.textContent = '0';
          hElem.textContent = '0';
          mElem.textContent = '0';
          sElem.textContent = '0';
          return;
        }
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        diff -= days * (1000 * 60 * 60 * 24);
        const hours = Math.floor(diff / (1000 * 60 * 60));
        diff -= hours * (1000 * 60 * 60);
        const minutes = Math.floor(diff / (1000 * 60));
        diff -= minutes * (1000 * 60);
        const seconds = Math.floor(diff / 1000);
        dElem.textContent = days;
        hElem.textContent = hours.toString().padStart(2,'0');
        mElem.textContent = minutes.toString().padStart(2,'0');
        sElem.textContent = seconds.toString().padStart(2,'0');
      }
      updateCountdown();
      setInterval(updateCountdown, 1000);

      /* -------------------------
         IntersectionObserver for animate-on-scroll
         ------------------------- */
      const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-on-scroll');
            // For stat numbers, trigger counting when in view
            if (entry.target.matches('.stat') || entry.target.closest('.stats-grid')) {
              runStats();
            }
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15, rootMargin: '0px 0px -80px 0px' });

      document.querySelectorAll('.animate-on-scroll').forEach(el => io.observe(el));
      document.querySelectorAll('.card').forEach(el => io.observe(el));
      document.querySelectorAll('.stat').forEach(el => io.observe(el));

      /* -------------------------
         Stats counters animation
         ------------------------- */
      let statsRun = false;
      function runStats() {
        if (statsRun) return;
        statsRun = true;
        document.querySelectorAll('.stat .num').forEach(el => {
          const target = parseInt(el.getAttribute('data-target') || el.textContent.replace(/\D/g,'') || '0', 10);
          let start = 0;
          const duration = 1600;
          const stepTime = Math.max(Math.floor(duration / target), 10);
          const increment = Math.max(Math.floor(target / (duration / stepTime)), 1);

          const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
              el.textContent = formatNumberShort(target);
              clearInterval(timer);
            } else {
              el.textContent = formatNumberShort(start);
            }
          }, stepTime);
        });
      }

      function formatNumberShort(n) {
        if (n >= 1000000) return (n/1000000).toFixed(0) + 'M+';
        if (n >= 1000) return (n/1000).toFixed(0) + 'K+';
        return n.toString();
      }

      /* -------------------------
         Gallery Lightbox (simple)
         ------------------------- */
      const thumbs = Array.from(document.querySelectorAll('.thumb'));
      const lightbox = document.getElementById('lightbox');
      const lightboxImage = document.getElementById('lightboxImage');
      const lightboxCaption = document.getElementById('lightboxCaption');
      const closeLight = document.getElementById('closeLight');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');

      let currentIndex = 0;

      function openLightbox(idx) {
        currentIndex = idx;
        const t = thumbs[currentIndex];
        const caption = t.querySelector('.caption') ? t.querySelector('.caption').textContent : 'Foto';
        const bg = t.style.backgroundImage || '';
        lightboxImage.style.backgroundImage = bg;
        lightboxCaption.textContent = caption;
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
      }

      function showPrev() {
        currentIndex = (currentIndex - 1 + thumbs.length) % thumbs.length;
        openLightbox(currentIndex);
      }
      function showNext() {
        currentIndex = (currentIndex + 1) % thumbs.length;
        openLightbox(currentIndex);
      }

      thumbs.forEach((t, i) => {
        t.addEventListener('click', () => openLightbox(i));
        t.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') openLightbox(i);
        });
      });

      closeLight && closeLight.addEventListener('click', closeLightbox);
      prevBtn && prevBtn.addEventListener('click', showPrev);
      nextBtn && nextBtn.addEventListener('click', showNext);
      lightbox && lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
      });
      document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'ArrowRight') showNext();
      });

      /* =========================================================================
   Testimonials slider - 1 testimoni per slide
   ========================================================================= */
    const slider = document.getElementById('testSlider');
    const dots = Array.from(document.querySelectorAll('.dot'));
    let slideIndex = 0;

    function updateSlider(index) {
      // Pastikan setiap slide 100% width dari container
      slider.style.transform = `translateX(-${index * 100}%)`;
      slider.style.transition = 'transform 0.6s ease-in-out';

      // Update dots
      dots.forEach(d => d.classList.remove('active'));
      dots.forEach(d => d.setAttribute('aria-selected','false'));
      const activeDot = dots[index];
      if(activeDot){
        activeDot.classList.add('active');
        activeDot.setAttribute('aria-selected','true');
      }
    }

    // Event click pada dot
    dots.forEach(d => {
      d.addEventListener('click', () => {
        slideIndex = parseInt(d.getAttribute('data-index'), 10) || 0;
        updateSlider(slideIndex);
      });
    });

    // Auto slide setiap 6 detik
    setInterval(() => {
      slideIndex = (slideIndex + 1) % dots.length;
      updateSlider(slideIndex);
    }, 6000);

    // Inisialisasi slider pertama
    updateSlider(slideIndex);


      /* -------------------------
         Registration form (client-side)
         ------------------------- */
      const regForm = document.getElementById('regForm');
      const resetBtn = document.getElementById('resetBtn');
      const formStatus = document.getElementById('formStatus');

      function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      }

      regForm.addEventListener('submit', (e) => {
        e.preventDefault();
        formStatus.textContent = '';
        const formData = new FormData(regForm);
        const name = (formData.get('name') || '').trim();
        const email = (formData.get('email') || '').trim();
        const category = (formData.get('category') || '').trim();

        if (!name) {
          formStatus.textContent = 'Nama wajib diisi.';
          formStatus.style.color = 'var(--accent2)';
          return;
        }
        if (!email || !validateEmail(email)) {
          formStatus.textContent = 'Masukkan email valid.';
          formStatus.style.color = 'var(--accent2)';
          return;
        }
        if (!category) {
          formStatus.textContent = 'Pilih kategori kompetisi.';
          formStatus.style.color = 'var(--accent2)';
          return;
        }

        // simulate submit (since standalone)
        formStatus.textContent = 'Mengirim...';
        formStatus.style.color = 'var(--muted)';
        setTimeout(() => {
          // show success message
          formStatus.textContent = 'Pendaftaran berhasil (simulasi). Cek email untuk konfirmasi.';
          formStatus.style.color = 'green';
          regForm.reset();
        }, 900);
      });

      resetBtn.addEventListener('click', () => {
        regForm.reset();
        formStatus.textContent = '';
      });

      /* -------------------------
         Dark mode toggle (persistent)
         ------------------------- */
      // create a floating toggle button
      const themeBtn = document.createElement('button');
      themeBtn.setAttribute('aria-label','Toggle dark mode');
      themeBtn.style.position = 'fixed';
      themeBtn.style.right = '18px';
      themeBtn.style.bottom = '18px';
      themeBtn.style.width = '56px';
      themeBtn.style.height = '56px';
      themeBtn.style.borderRadius = '14px';
      themeBtn.style.border = 'none';
      themeBtn.style.display = 'grid';
      themeBtn.style.placeItems = 'center';
      themeBtn.style.cursor = 'pointer';
      themeBtn.style.boxShadow = '0 8px 30px rgba(0,0,0,0.12)';
      themeBtn.style.zIndex = '1500';
      themeBtn.style.background = 'linear-gradient(135deg,var(--accent1),var(--accent2))';
      themeBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" stroke="#fff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
      document.body.appendChild(themeBtn);

      const root = document.documentElement;
      function setTheme(theme) {
        if (theme === 'dark') {
          root.setAttribute('data-theme','dark');
          localStorage.setItem('syc_theme','dark');
        } else {
          root.removeAttribute('data-theme');
          localStorage.setItem('syc_theme','light');
        }
      }

      themeBtn.addEventListener('click', () => {
        const current = localStorage.getItem('syc_theme') || 'light';
        setTheme(current === 'light' ? 'dark' : 'light');
      });

      // initialize theme from localStorage or prefer-color-scheme
      const saved = localStorage.getItem('syc_theme');
      if (saved) setTheme(saved);
      else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        setTheme(prefersDark ? 'dark' : 'light');
      }

      /* -------------------------
         Small improvements & accessibility
         ------------------------- */
      // focus outlines for keyboard users
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') document.body.classList.add('show-focus');
      });

      // Remove loader if page loads super fast
      window.addEventListener('load', () => {
        setTimeout(() => {
          if (!loader.classList.contains('hidden')) {
            loader.classList.add('hidden');
            setTimeout(() => loader.parentNode && loader.parentNode.removeChild(loader), 700);
          }
        }, 400);
      });

      /* -------------------------
         small helper: expose some functions to window for debugging if needed
         ------------------------- */
      window.SYC = {
        openLightbox,
        closeLightbox,
        showNext,
        showPrev,
        setTheme,
      };

      // end of IIFE
    })();
  </script>

  <script>
document.addEventListener("DOMContentLoaded", () => {
  const thumbs = document.querySelectorAll(".thumb");
  const lightbox = document.querySelector(".lightbox");
  const lightboxImg = document.querySelector(".lightbox .img");

  thumbs.forEach(thumb => {
    // Simulasi loading (hilangkan "loading" class setelah gambar ready)
    setTimeout(() => {
      thumb.classList.remove("loading");
    }, 1200);

    // Klik thumb -> buka lightbox
    thumb.addEventListener("click", () => {
      const bg = thumb.style.backgroundImage;
      lightboxImg.style.backgroundImage = bg;
      lightbox.classList.add("active");
    });
  });

  // Klik luar -> tutup
  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      lightbox.classList.remove("active");
    }
  });
});
</script>



<script>
document.addEventListener("DOMContentLoaded", () => {
  // Smooth scroll untuk anchor
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      if (targetId !== "#") {
        e.preventDefault();
        const section = document.querySelector(targetId);
        if (section) {
          section.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }
    });
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const guidebookBtn = document.getElementById("btnGuidebook");
  
  if (guidebookBtn) {
    fetch(guidebookBtn.href, { method: "HEAD" })
      .then(res => {
        if (!res.ok) {
          disableGuidebookBtn(guidebookBtn);
        }
      })
      .catch(() => {
        disableGuidebookBtn(guidebookBtn);
      });
  }

  function disableGuidebookBtn(btn) {
    btn.removeAttribute("href");
    btn.removeAttribute("download");
    btn.style.cursor = "not-allowed";
    btn.textContent = "Guidebook belum tersedia";
    btn.classList.add("disabled");
    btn.addEventListener("click", e => {
      e.preventDefault();
      alert("⚠️ Guidebook belum tersedia.");
    });
  }
});
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    let progress = 0;
    let progressBar = document.getElementById("progressbar");
    let loaderWrap = document.getElementById("loader");

    // Interval untuk animasi progress
    let interval = setInterval(() => {
      if (progress >= 100) {
        clearInterval(interval);

        // Delay sedikit biar smooth
        setTimeout(() => {
          loaderWrap.classList.add("hidden");
        }, 500);
      } else {
        progress++;
        progressBar.style.width = progress + "%";
      }
    }, 50); // setiap 50ms naik 1% → selesai ~5 detik
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const HIGHLIGHT_CLASS = "is-highlighted";
    const DURATION = 2200;
    
    const filterButtons = document.querySelectorAll('#kompetisi .filter-btn');
    const gridCards = document.querySelectorAll('#kompetisi .competition-card');

    // 1. Fungsi Helper untuk membersihkan Card Front
    const cleanFrontCards = () => {
        document.querySelectorAll('.card-front .detail-item, .card-front a, .card-front button').forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes('guidebook') || text.includes('panduan')) {
                item.remove();
            }
        });
    };

    // 2. Logika Utama Highlight & Auto-Filter
    function handleNavigationHighlight() {
        const hash = location.hash;
        if (!hash) return;

        const target = document.querySelector(hash);
        if (!target || !target.classList.contains("competition-card")) return;

        // --- Fitur Cerdas: Buka Filter Secara Otomatis ---
        const targetCategory = target.getAttribute('data-category');
        const activeBtn = document.querySelector(`.filter-btn[data-filter="${targetCategory}"]`);
        
        if (activeBtn) {
            activeBtn.click(); // Memicu klik pada filter agar card muncul
        }

        // --- Proses Highlight ---
        // Scroll ke target
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Hapus highlight lama
        document.querySelectorAll("." + HIGHLIGHT_CLASS).forEach(el => el.classList.remove(HIGHLIGHT_CLASS));

        // Tambah highlight baru
        setTimeout(() => {
            target.classList.add(HIGHLIGHT_CLASS);
            setTimeout(() => target.classList.remove(HIGHLIGHT_CLASS), DURATION);
        }, 300); // Delay sedikit agar scroll selesai dulu
    }

    // 3. Event Listener Filter
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            gridCards.forEach(card => {
                const category = card.getAttribute('data-category');
                card.classList.remove('flipped', 'hovered');

                if (filter === 'all' || category === filter) {
                    card.style.display = 'flex';
                    setTimeout(() => { card.style.opacity = '1'; }, 10);
                } else {
                    card.style.display = 'none';
                }
            });
            cleanFrontCards();
        });
    });

    // 4. Inisialisasi
    cleanFrontCards();
    handleNavigationHighlight();
    window.addEventListener("hashchange", handleNavigationHighlight);

    // 5. Timeline Animation
    const timelineItems = document.querySelectorAll('.timeline-item');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-on-scroll');
            }
        });
    }, { threshold: 0.3 });

    timelineItems.forEach(item => observer.observe(item));
});
</script>
</body>
</html>