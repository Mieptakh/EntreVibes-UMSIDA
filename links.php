<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MicroHelix LinkHub | UMSIDA EntreVibes Vol. 1</title>
    <link rel="shortcut icon" href="images/logo_default.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(239, 166, 9, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(98, 35, 126, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 50% 50%, rgba(98, 35, 126, 0.1) 0%, transparent 30%);
            z-index: -1;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Platform Header */
        .platform-header {
            text-align: center;
            margin-bottom: 25px;
            padding-top: 20px;
        }

        .platform-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gradient-accent);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(239, 166, 9, 0.3);
        }

        .brand-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 6px 15px rgba(98, 35, 126, 0.3);
        }

        .logo-image {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: contain;
            background: white;
            padding: 5px;
            box-shadow: 0 6px 15px rgba(98, 35, 126, 0.2);
            border: 2px solid var(--primary);
        }

        .logo-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            text-align: center;
        }

        .platform-name {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 10px;
            background: var(--gradient-mix);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .platform-tagline {
            font-size: 0.95rem;
            color: var(--muted);
            font-weight: 400;
            margin-bottom: 20px;
            line-height: 1.4;
            padding: 0 15px;
        }

        /* Profile Header */
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            background: var(--card);
            border-radius: var(--radius);
            padding: 25px;
            box-shadow: 0 10px 30px var(--shadow);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            border-radius: 50%;
            border: 4px solid var(--accent);
            padding: 5px;
            background: var(--gradient-primary);
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
            background: white;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .profile-subtitle {
            font-size: 1rem;
            color: var(--muted);
            margin-bottom: 15px;
            font-weight: 500;
        }

        .event-description {
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.5;
            padding: 12px 15px;
            background: rgba(239, 166, 9, 0.08);
            border-radius: 10px;
            border-left: 4px solid var(--accent);
            margin-top: 15px;
            text-align: left;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 25px 0;
        }

        .stat-item {
            text-align: center;
            padding: 15px 10px;
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(98, 35, 126, 0.1);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 5px;
            font-weight: 500;
        }

        /* Links Container */
        .links-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .link-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 18px;
            text-decoration: none;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 6px 20px var(--shadow);
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .link-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(98, 35, 126, 0.1), 
                transparent);
            transition: left 0.6s ease;
        }

        .link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(98, 35, 126, 0.2);
            border-color: var(--accent);
        }

        .link-card:hover::before {
            left: 100%;
        }

        .link-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            color: white;
        }

        .link-content {
            flex: 1;
        }

        .link-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
        }

        .link-description {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.4;
        }

        .link-arrow {
            color: var(--accent);
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .link-card:hover .link-arrow {
            transform: translateX(5px);
        }

        /* Categories */
        .category-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 30px 0 15px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(98, 35, 126, 0.2);
        }

        .category-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .category-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .category-subtitle {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 400;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 40px;
            border-top: 1px solid var(--glass-border);
        }

        .company-collaboration {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .collaboration-text {
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 500;
        }

        .collaboration-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .company-logo {
            width: 120px;
            height: auto;
            object-fit: contain;
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .company-logo:hover {
            opacity: 1;
        }

        .company-tagline {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.4;
            max-width: 400px;
            margin: 15px auto;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--card);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px var(--shadow);
        }

        .social-link:hover {
            background: var(--gradient-accent);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(239, 166, 9, 0.3);
        }

        .copyright {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 20px;
        }

        /* Highlight Link */
        .link-card.highlight {
            background: linear-gradient(135deg, rgba(239, 166, 9, 0.1), rgba(98, 35, 126, 0.1));
            border: 1px solid rgba(239, 166, 9, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 5px 20px rgba(239, 166, 9, 0.1); }
            50% { box-shadow: 0 5px 25px rgba(239, 166, 9, 0.2); }
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(98, 35, 126, 0.3);
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .profile-name {
                font-size: 1.5rem;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            
            .link-card {
                padding: 15px;
            }
            
            .link-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
            
            .platform-name {
                font-size: 1.8rem;
            }
            
            .collaboration-logos {
                flex-direction: column;
                gap: 15px;
            }
            
            .company-logo {
                width: 100px;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="container">
        <!-- Platform Header -->
        <div class="platform-header loading" style="animation-delay: 0.1s">
            <div class="platform-badge">
                <i class="fas fa-cube"></i>
                <span>MicroHelix LinkHub</span>
            </div>
            
            <div class="brand-logos">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="logo-text">LinkHub</div>
                </div>
                <div class="logo-container">
                    <img src="images/2025 CIRCLE.png" alt="MicroHelix Logo" class="logo-image" onerror="this.src='https://via.placeholder.com/50/62237e/ffffff?text=MH'">
                    <div class="logo-text">MicroHelix</div>
                </div>
                <div class="logo-container">
                    <img src="images/UMSIDA.png" alt="UMSIDA Logo" class="logo-image" onerror="this.src='https://via.placeholder.com/50/efa609/ffffff?text=UMS'">
                    <div class="logo-text">UMSIDA</div>
                </div>
            </div>
            
            <h1 class="platform-name">Digital Link Center</h1>
            <p class="platform-tagline">Platform terintegrasi yang menghubungkan semua aset digital, komunitas, dan peluang dalam satu tempat yang profesional.</p>
        </div>

        <!-- Profile Header -->
        <div class="profile-header loading" style="animation-delay: 0.2s">
            <div class="profile-avatar">
                <img src="images/logo_default.png" alt="UMSIDA EntreVibes Logo" onerror="this.src='https://via.placeholder.com/120/62237e/ffffff?text=EV'">
            </div>
            <h1 class="profile-name">UMSIDA EntreVibes</h1>
            <p class="profile-subtitle">Volume 1 • Digital Edge 'n Culture, Shaping the Future</p>
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Kategori</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Peserta</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Seminar</div>
                </div>
            </div>
            
            <div class="event-description">
                <i class="fas fa-star" style="color: var(--accent); margin-right: 8px;"></i>
                Acara tahunan yang memadukan kewirausahaan digital, inovasi produk, dan pengembangan budaya untuk membentuk masa depan yang lebih baik melalui kolaborasi UMSIDA dan MicroHelix.
            </div>
        </div>

        <!-- Main Links -->
        <div class="category-header loading" style="animation-delay: 0.5s">
            <div class="category-icon">
                <i class="fas fa-home"></i>
            </div>
            <div>
                <h3 class="category-title">Akses Utama</h3>
                <p class="category-subtitle">Portal dan pendaftaran acara utama</p>
            </div>
        </div>
        <div class="links-container">
            <!-- Main Website -->
            <a href="https://entrevibesumsida.my.id" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 0.6s">
                <div class="link-icon" style="background: var(--gradient-primary)">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-external-link-alt" style="font-size: 0.8rem;"></i>
                        Website Resmi EntreVibes
                    </div>
                    <div class="link-description">Portal informasi lengkap tentang acara, jadwal, pengumuman, dan semua kebutuhan peserta.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

        </div>

        <!-- Competition Categories -->
        <div class="category-header loading" style="animation-delay: 0.8s">
            <div class="category-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <h3 class="category-title">Kategori Kompetisi</h3>
                <p class="category-subtitle">Pilih kategori yang sesuai dengan minat dan keahlian</p>
            </div>
        </div>
        <div class="links-container">
            <!-- Digipreneur -->
            <a href="https://entrevibesumsida.my.id/#digipreneur" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 0.9s">
                <div class="link-icon" style="background: linear-gradient(135deg, #FF6B6B, #FF8E8E)">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-desktop" style="font-size: 0.8rem;"></i>
                        Lomba Digipreneur
                    </div>
                    <div class="link-description">Kompetisi kewirausahaan digital untuk pelajar & mahasiswa dengan ide bisnis berbasis teknologi inovatif.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Product Innovation -->
            <a href="https://entrevibesumsida.my.id/#produk-inovasi" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.0s">
                <div class="link-icon" style="background: linear-gradient(135deg, #4ECDC4, #44A08D)">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-flask" style="font-size: 0.8rem;"></i>
                        Lomba Produk Inovasi
                    </div>
                    <div class="link-description">Kompetisi inovasi produk kreatif dan teknologi dengan potensi komersialisasi dan dampak sosial tinggi.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Seminar -->
            <a href="https://entrevibesumsida.my.id/#seminar" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.1s">
                <div class="link-icon" style="background: linear-gradient(135deg, #FFD166, #FFB347)">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-users" style="font-size: 0.8rem;"></i>
                        Seminar Nasional
                    </div>
                    <div class="link-description">Webinar & workshop dengan pembicara inspiratif dari industri, akademisi, dan praktisi terkemuka.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Media & Documentation -->
        <div class="category-header loading" style="animation-delay: 1.2s">
            <div class="category-icon">
                <i class="fas fa-photo-video"></i>
            </div>
            <div>
                <h3 class="category-title">Media & Dokumentasi</h3>
                <p class="category-subtitle">Konten visual dan informasi pelaksanaan acara</p>
            </div>
        </div>
        <div class="links-container">
            <!-- Gallery -->
            <a href="https://entrevibesumsida.my.id/#gallepict" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.3s">
                <div class="link-icon" style="background: linear-gradient(135deg, #833AB4, #C13584)">
                    <i class="fas fa-images"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-camera" style="font-size: 0.8rem;"></i>
                        Galeri Foto Acara
                    </div>
                    <div class="link-description">Kumpulan dokumentasi visual kegiatan dan momen penting selama pelaksanaan EntreVibes Volume 1.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Reels -->
            <a href="https://entrevibesumsida.my.id/#galleReels" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.4s">
                <div class="link-icon" style="background: linear-gradient(45deg, #405DE6, #833AB4, #C13584, #E1306C, #FD1D1D)">
                    <i class="fas fa-film"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-video" style="font-size: 0.8rem;"></i>
                        Video Highlights
                    </div>
                    <div class="link-description">Rekaman video dan Instagram Reels yang menampilkan keseruan, dinamika, dan highlights acara.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Timeline -->
            <a href="https://entrevibesumsida.my.id/#timeline" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.5s">
                <div class="link-icon" style="background: linear-gradient(135deg, #2D3047, #419D78)">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-clock" style="font-size: 0.8rem;"></i>
                        Timeline & Jadwal
                    </div>
                    <div class="link-description">Jadwal lengkap semua kegiatan, deadline pendaftaran, dan timeline pelaksanaan acara secara detail.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Contact & Partnership -->
        <div class="category-header loading" style="animation-delay: 1.6s">
            <div class="category-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <div>
                <h3 class="category-title">Kontak & Partnership</h3>
                <p class="category-subtitle">Hubungi kami untuk informasi dan kerjasama</p>
            </div>
        </div>
        <div class="links-container">
            <!-- WhatsApp 1 -->
            <a href="https://api.whatsapp.com/send/?phone=6287855094196&text=Halo%20Nabilah,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.7s">
                <div class="link-icon" style="background: linear-gradient(135deg, #25D366, #128C7E)">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-comment-dots" style="font-size: 0.8rem;"></i>
                        WhatsApp (Nabilah)
                    </div>
                    <div class="link-description">Kontak untuk informasi pendaftaran, teknis lomba, dan pertanyaan umum tentang acara EntreVibes.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- WhatsApp 2 -->
            <a href="https://api.whatsapp.com/send/?phone=6282132019362&text=Halo%20Nurul,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.8s">
                <div class="link-icon" style="background: linear-gradient(135deg, #075E54, #25D366)">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-comments" style="font-size: 0.8rem;"></i>
                        WhatsApp (Nurul)
                    </div>
                    <div class="link-description">Kontak untuk partnership, sponsorship, dan kerjasama institusional dengan MicroHelix Tech Solutions.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Partnership Info -->
            <a href="https://entrevibesumsida.my.id/#partnership" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.9s">
                <div class="link-icon" style="background: linear-gradient(135deg, #8A2BE2, #4B0082)">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">
                        <i class="fas fa-business-time" style="font-size: 0.8rem;"></i>
                        Informasi Partnership
                    </div>
                    <div class="link-description">Peluang kerjasama dan sponsorship dengan MicroHelix Tech Solutions untuk pengembangan bersama yang berkelanjutan.</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Footer -->
        <div class="footer loading" style="animation-delay: 2.0s">
            <div class="company-collaboration">
                <div class="collaboration-text">
                    <i class="fas fa-handshake" style="color: var(--accent); margin-right: 8px;"></i>
                    Kolaborasi Strategis
                </div>
                <div class="collaboration-logos">
                    <img src="images/logo_microhelix.png" alt="MicroHelix Logo" class="company-logo" onerror="this.src='https://via.placeholder.com/120/62237e/ffffff?text=MicroHelix+Tech'">
                    <img src="images/logo_umsida.png" alt="UMSIDA Logo" class="company-logo" onerror="this.src='https://via.placeholder.com/120/efa609/2a1a35?text=UMSIDA'">
                </div>
                <p class="company-tagline">
                    "Mengembangkan solusi teknologi inovatif untuk menghubungkan ide, komunitas, dan peluang dalam ekosistem digital yang dinamis dan berkelanjutan."
                </p>
            </div>
            
            <div class="social-links">
                <a href="https://www.instagram.com/umsida_entrevibes/" target="_blank" class="social-link">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@umsida_entrevibes" target="_blank" class="social-link">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://entrevibesumsida.my.id" target="_blank" class="social-link">
                    <i class="fas fa-globe"></i>
                </a>
                <a href="https://microhelix.id" target="_blank" class="social-link">
                    <i class="fas fa-building"></i>
                </a>
            </div>
            
            <div class="copyright">
                <p>© 2026 MicroHelix LinkHub • UMSIDA EntreVibes Vol. 1</p>
                <p style="margin-top: 5px; font-size: 0.75rem; opacity: 0.8;">Platform dikembangkan oleh PT. MicroHelix Tech Solutions • All rights reserved</p>
            </div>
        </div>
    </div>

    <script>
        // Simple loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElements = document.querySelectorAll('.loading');
            
            loadingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');
            
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    themeIcon.className = 'fas fa-moon';
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    themeIcon.className = 'fas fa-sun';
                    localStorage.setItem('theme', 'dark');
                }
            });
            
            // Load saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
            }
            
            // Add click animation
            document.querySelectorAll('.link-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(98, 35, 126, 0.15);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Add keyframe for ripple
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>