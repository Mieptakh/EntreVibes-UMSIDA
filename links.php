<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMSIDA EntreVibes Vol. 1 - Linktree</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #481465;
            --primary-dark: #3a1052;
            --accent: #EFA609;
            --light: #FDFCFD;
            --text: #2A1A35;
            --muted: #6D5A7A;
            --gradient: linear-gradient(135deg, #481465, #5c1f7f);
            --gradient-accent: linear-gradient(135deg, #EFA609, #FFB347);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            /* Menggunakan gambar sebagai layer utama, lalu ditimpa dengan gradient halus */
            background-image: 
            radial-gradient(circle at 20% 80%, rgba(239, 166, 9, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(72, 20, 101, 0.2) 0%, transparent 50%),
            url('images/Background.png'); /* Path ke gambar Anda */
            
            background-size: cover;          /* Gambar menutupi seluruh area */
            background-position: center;     /* Gambar selalu di tengah */
            background-repeat: no-repeat;    /* Gambar tidak mengulang (tiling) */
            background-attachment: fixed;    /* Background tetap diam saat di-scroll (efek parallax) */
            
            color: var(--light);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Profile */
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
            padding-top: 30px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            border-radius: 50%;
            border: 4px solid var(--accent);
            padding: 5px;
            background: var(--gradient);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #FFF, #E6D8FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .profile-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 15px;
            font-weight: 300;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(239, 166, 9, 0.15);
            color: #FFD166;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(239, 166, 9, 0.3);
            backdrop-filter: blur(10px);
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 30px 0;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.12);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
        }

        /* Links Container */
        .links-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 40px;
        }

        .link-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 18px;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
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
                rgba(255, 255, 255, 0.1), 
                transparent);
            transition: left 0.6s ease;
        }

        .link-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
            box-shadow: 0 10px 30px rgba(239, 166, 9, 0.2);
        }

        .link-card:hover::before {
            left: 100%;
        }

        .link-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .link-content {
            flex: 1;
        }

        .link-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .link-description {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .link-arrow {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .link-card:hover .link-arrow {
            transform: translateX(5px);
            color: var(--accent);
        }

        /* Categories */
        .category-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(239, 166, 9, 0.3);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--gradient-accent);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(239, 166, 9, 0.3);
        }

        .copyright {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 20px;
        }

        /* Highlight Link */
        .link-card.highlight {
            background: linear-gradient(135deg, rgba(239, 166, 9, 0.2), rgba(72, 20, 101, 0.3));
            border: 1px solid rgba(239, 166, 9, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 5px 20px rgba(239, 166, 9, 0.1); }
            50% { box-shadow: 0 5px 25px rgba(239, 166, 9, 0.3); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .profile-name {
                font-size: 1.7rem;
            }
            
            .profile-avatar {
                width: 120px;
                height: 120px;
            }
            
            .link-card {
                padding: 15px;
            }
            
            .link-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
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
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header loading" style="animation-delay: 0.2s">
            <div class="profile-avatar">
                <img src="images/logo_default.png" alt="UMSIDA EntreVibes Logo">
            </div>
            <h1 class="profile-name">UMSIDA EntreVibes</h1>
            <p class="profile-subtitle">Volume 1 • Digital Edge 'n Culture, Shaping the Future</p>
            <div class="profile-badge">
                <i class="fas fa-bolt"></i>
                <span>#DesireToCreate</span>
            </div>
        </div>

        <!-- Main Links -->
        <h3 class="category-title loading" style="animation-delay: 0.6s">🌐 Akses Utama</h3>
        <div class="links-container">

            <!-- Main Website -->
            <a href="https://entrevibesumsida.my.id" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 0.8s">
                <div class="link-icon" style="background: linear-gradient(135deg, #481465, #6a1b9a)">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">🏠 Website Resmi</div>
                    <div class="link-description">Kunjungi website utama EntreVibes UMSIDA</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Registration -->
            <a href="https://entrevibesumsida.my.id/#kompetisi" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 0.9s">
                <div class="link-icon" style="background: linear-gradient(135deg, #2196F3, #21CBF3)">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">📝 Pendaftaran Online</div>
                    <div class="link-description">Daftar semua kategori lomba secara online</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Competition Categories -->
        <h3 class="category-title loading" style="animation-delay: 1.0s">🏆 Kategori Kompetisi</h3>
        <div class="links-container">
            <!-- Digipreneur -->
            <a href="https://entrevibesumsida.my.id/#digipreneur" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.1s">
                <div class="link-icon" style="background: linear-gradient(135deg, #FF6B6B, #FF8E8E)">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">💻 Lomba Digipreneur</div>
                    <div class="link-description">Kompetisi digital entrepreneurship untuk pelajar & mahasiswa</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Product Innovation -->
            <a href="https://entrevibesumsida.my.id/#produk-inovasi" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.2s">
                <div class="link-icon" style="background: linear-gradient(135deg, #4ECDC4, #44A08D)">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">🔬 Lomba Produk Inovasi</div>
                    <div class="link-description">Kompetisi inovasi produk kreatif dan teknologi</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Seminar -->
            <a href="https://entrevibesumsida.my.id/#seminar" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.3s">
                <div class="link-icon" style="background: linear-gradient(135deg, #FFD166, #FFB347)">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">🎤 Seminar Nasional</div>
                    <div class="link-description">Webinar & workshop dengan pembicara inspiratif</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Media & Documentation -->
        <h3 class="category-title loading" style="animation-delay: 1.4s">📱 Media & Dokumentasi</h3>
        <div class="links-container">
            <!-- Gallery -->
            <a href="https://entrevibesumsida.my.id/#gallepict" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.5s">
                <div class="link-icon" style="background: linear-gradient(135deg, #833AB4, #C13584)">
                    <i class="fas fa-images"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">📸 Galeri Foto</div>
                    <div class="link-description">Kumpulan dokumentasi kegiatan EntreVibes</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Reels -->
            <a href="https://entrevibesumsida.my.id/#galleReels" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.6s">
                <div class="link-icon" style="background: linear-gradient(45deg, #405DE6, #833AB4, #C13584, #E1306C, #FD1D1D)">
                    <i class="fas fa-film"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">🎬 Instagram Reels</div>
                    <div class="link-description">Video highlights acara EntreVibes</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Timeline -->
            <a href="https://entrevibesumsida.my.id/#timeline" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.7s">
                <div class="link-icon" style="background: linear-gradient(135deg, #2D3047, #419D78)">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">📅 Timeline Acara</div>
                    <div class="link-description">Jadwal lengkap semua kegiatan</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Contact & Partnership -->
        <h3 class="category-title loading" style="animation-delay: 1.8s">🤝 Kontak & Partnership</h3>
        <div class="links-container">
            <!-- WhatsApp 1 -->
            <a href="https://api.whatsapp.com/send/?phone=6287855094196&text=Halo%20Nabilah,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 1.9s">
                <div class="link-icon" style="background: linear-gradient(135deg, #25D366, #128C7E)">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">💬 WhatsApp (Nabilah)</div>
                    <div class="link-description">Contact Person 1 - Pendaftaran & informasi</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- WhatsApp 2 -->
            <a href="https://api.whatsapp.com/send/?phone=6282132019362&text=Halo%20Nurul,%20saya%20ingin%20bertanya%20tentang%20Entre%20Vibes" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 2.0s">
                <div class="link-icon" style="background: linear-gradient(135deg, #075E54, #25D366)">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">💬 WhatsApp (Nurul)</div>
                    <div class="link-description">Contact Person 2 - Partnership & sponsor</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Partnership Info -->
            <a href="https://entrevibesumsida.my.id/#partnership" 
               target="_blank" 
               class="link-card loading" 
               style="animation-delay: 2.1s">
                <div class="link-icon" style="background: linear-gradient(135deg, #8A2BE2, #4B0082)">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="link-content">
                    <div class="link-title">🤝 Info Partnership</div>
                    <div class="link-description">Kerjasama & sponsorship dengan MicroHelix</div>
                </div>
                <div class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Footer -->
        <div class="footer loading" style="animation-delay: 2.2s">
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
            </div>
            <div class="copyright">
                <p>© 2026 UMSIDA EntreVibes Vol. 1</p>
                <p style="margin-top: 5px; font-size: 0.75rem; opacity: 0.7;">Didukung oleh PT. MicroHelix Tech Solutions</p>
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
                        background: rgba(255, 255, 255, 0.4);
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