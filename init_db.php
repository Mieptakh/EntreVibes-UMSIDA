<?php
// ==============================
// INIT DATABASE: SQLite (FULL FIX)
// ==============================

// Lokasi database
$dbDir  = __DIR__ . '/database';
$dbFile = $dbDir . '/competitions.db';

// Pastikan folder database ada
if (!is_dir($dbDir)) {
    if (!mkdir($dbDir, 0777, true)) {
        die("❌ Gagal membuat folder database.");
    }
}
if (!is_writable($dbDir)) {
    die("❌ Folder database tidak writable.");
}

try {
    // ==============================
    // Koneksi SQLite
    // ==============================
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ==============================
    // CREATE TABLES
    // ==============================
    $db->exec("
        CREATE TABLE IF NOT EXISTS faq (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            question TEXT NOT NULL,
            answer TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS pendaftaran (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            school TEXT,
            email TEXT NOT NULL,
            phone TEXT,
            category TEXT NOT NULL,
            teamname TEXT,
            members TEXT,
            note TEXT,
            idcard TEXT,
            proof TEXT,
            twibbon TEXT,
            transfer TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS partners (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            image_url TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS kompetisi (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            judul TEXT NOT NULL,
            deskripsi TEXT NOT NULL,
            icon_svg TEXT NOT NULL,
            kategori TEXT NOT NULL CHECK(kategori IN ('lomba','non-lomba')),
            jenis TEXT,
            registration_link TEXT,
            submission_link TEXT,
            guideline_link TEXT,
            info_link TEXT,
            deadline TEXT,
            prize INTEGER DEFAULT 0,
            contact_person TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS timeline (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tanggal_start TEXT NOT NULL,
            tanggal_end TEXT NOT NULL,
            judul TEXT NOT NULL,
            deskripsi TEXT NOT NULL,
            link TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS stats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            label TEXT NOT NULL,
            value INTEGER NOT NULL
        );

        CREATE TABLE IF NOT EXISTS galeri (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            image_url TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL CHECK(role='admin'),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // ==============================
    // ADMIN DEFAULT
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM users")->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([
            "admin",
            password_hash("admin123", PASSWORD_DEFAULT),
            "admin"
        ]);
    }

    // ==============================
    // FAQ
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM faq")->fetchColumn() == 0) {
        $faqData = [
            ["Berapa biaya pendaftaran?", "Biaya tergantung kategori lomba, detail tersedia di booklet."],
            ["Apakah dapat sertifikat?", "Ya, semua peserta mendapatkan sertifikat."]
        ];
        $stmt = $db->prepare("INSERT INTO faq (question, answer) VALUES (?, ?)");
        foreach ($faqData as $f) $stmt->execute($f);
    }

    // ==============================
    // PARTNERS
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM partners")->fetchColumn() == 0) {
        $partnersData = [
            ["PT. MicroHelix Tech Solutions", "/images/PT. MicroHelix.png"],
            ["UMSIDA Sinergi Utama", "/images/UMSIDA Sinergi Utama.png"],
            ["BIZNET", "/images/BIZNET.png"],
            ["OneSeven", "/images/OneSeven.png"],
            ["PT Kalbe Farma", "/images/PT Kalbe Farma.png"],
            ["SuryaMart", "/images/SuryaMart.png"],
            ["Posee Studio", "/images/PoseeStudio.png"],
            ["Bank JATIM", "/images/PT Bank JATIM.png"]
        ];
        $stmt = $db->prepare("INSERT INTO partners (name, image_url) VALUES (?, ?)");
        foreach ($partnersData as $p) $stmt->execute($p);
    }

    // ==============================
    // KOMPETISI
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM kompetisi")->fetchColumn() == 0) {

// Hapus data lama terlebih dahulu jika perlu: $db->query("TRUNCATE TABLE kompetisi");

$kompetisiData = [
    [
        "Lomba Digipreneur",
        "Kompetisi ide dan bisnis digital.",
        '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-5c1.62-2.2 5-3 5-3l1 1"/><path d="M12 15v5s3.03-.55 5-2c2.2-1.62 3-5 3-5l-1-1"/></svg>',
        "lomba", "digipreneur", "https://forms.gle/dph6PVP7DbUm6V1s5", null, 
        "https://ugc.production.linktr.ee/6f6fac74-5fe9-4c01-8a72-91adc7c188c9_FINAL-JUKNIS-LOMBA-DIGIPRENEUR-VOL.1.pdf",
        null, "2026-01-20", 50000, "CP Novia Ayu: 085100220691"
    ],
    [
        "Lomba Produk Inovasi",
        "Kompetisi produk kreatif mahasiswa.",
        '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>',
        "lomba", "produk-inovasi", "https://forms.gle/vUehR3dfsBZApBX77", null, 
        "https://drive.google.com/file/d/1wsSOACiBZHPQs6OYez3qMXLqKw9EHMNP/view",
        null, "2026-01-20", 50000, "CP Fabian: 085330691314"
    ],
    [
        "Seminar Entrepreneur",
        "Seminar Digipreneur & Upgrade Skill.",
        '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        "non-lomba", "seminar", "https://forms.gle/Uv9BqkKAfGJt6t917", null, null, null, null, 50000, "CP Panitia: 08123456789"
    ],
    [
        "Tenant UMKM & KWU",
        "Fasilitasi Bazar UMKM Mahasiswa.",
        '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
        "non-lomba", "tenant", "https://forms.gle/Uv9BqkKAfGJt6t917", null, 
        "https://drive.google.com/file/d/1O-gfoB3yVkkAjnz9b9cmHQyY-fB4SfWp/view",
        null, null, 100000, "CP Della: 082244103331" // Biaya diubah jadi 100k
    ],
    [
        "Konsultasi Usaha",
        "Konsultasi bisnis langsung dengan ahli.",
        '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>',
        "non-lomba", "konsultasi", "https://summitofstars.mhteams.my.id/konsultasi", null, null, null, null, 0, "Lokasi: Gedung 3 UMSIDA"
    ]
];

        $stmt = $db->prepare("
            INSERT INTO kompetisi (
                judul, deskripsi, icon_svg, kategori, jenis,
                registration_link, submission_link, guideline_link,
                info_link, deadline, prize, contact_person
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($kompetisiData as $k) {
            $stmt->execute($k);
        }
    }

    // ==============================
// DATA TIMELINE HASIL EKSTRAK GAMBAR
// ==============================
if ($db->query("SELECT COUNT(*) FROM timeline")->fetchColumn() == 0) {
    $timelineData = [
        [
            "2025-11-03",
            "2025-11-24",
            "Pre-Event Preparation",
            "Humas promosi, pembukaan batch 1 & 2 lomba Digipreneur, perencanaan dan finalisasi keseluruhan event",
            null
        ],
        [
            "2025-12-20",
            "2026-01-20",
            "Registration Period",
            "Periode pendaftaran lomba, seminar, dan seluruh rangkaian kegiatan EntreVibes Vol.1",
            null
        ],
        [
            "2026-01-29",
            "2026-01-29",
            "Event Day",
            "Interactive sessions, exhibition booths, dan brand activations bersama partner dan tenant",
            null
        ],
        [
            "2026-01-30",
            "2026-01-30",
            "Post Event",
            "Ucapan terima kasih kepada sponsor, publikasi highlight reels, dan social media recap pasca acara",
            null
        ]
    ];

    $stmt = $db->prepare("
        INSERT INTO timeline (tanggal_start, tanggal_end, judul, deskripsi, link)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($timelineData as $t) {
        $stmt->execute($t);
    }
}

    // ==============================
    // STATS DATA
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM stats")->fetchColumn() == 0) {
        $statsData = [
            ["Peserta", 0],
            ["Lomba", 5],
            ["Hari", 3],
            ["Penghargaan", 15]
        ];
        $stmt = $db->prepare("INSERT INTO stats (label, value) VALUES (?, ?)");
        foreach ($statsData as $s) $stmt->execute($s);
    }

    echo "✅ INIT DB BERHASIL<br>";
    echo "✅ Dummy data timeline berhasil ditambahkan<br>";
    echo "Admin: <b>admin</b> | Password: <b>admin123</b><br>";
    echo "Total timeline: " . $db->query("SELECT COUNT(*) FROM timeline")->fetchColumn() . " item";

} catch (PDOException $e) {
    die("❌ DB ERROR: " . $e->getMessage());
}