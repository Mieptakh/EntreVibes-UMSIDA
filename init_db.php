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
            ["Pemerintah Provinsi Seluruh Indonesia", "/images/MHTeams.png"]
        ];
        $stmt = $db->prepare("INSERT INTO partners (name, image_url) VALUES (?, ?)");
        foreach ($partnersData as $p) $stmt->execute($p);
    }

    // ==============================
    // KOMPETISI
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM kompetisi")->fetchColumn() == 0) {

        $kompetisiData = [
            ["Lomba Digipreneur","Kompetisi ide dan bisnis digital.","<svg></svg>","lomba","digipreneur","https://summitofstars.mhteams.my.id/pendaftaran",null,"https://bit.ly/bookletcompetition",null,"2026-01-20",0,null],
            ["Lomba Produk Inovasi","Kompetisi produk kreatif.","<svg></svg>","lomba","produk-inovasi","https://summitofstars.mhteams.my.id/pendaftaran",null,"https://bit.ly/bookletcompetition",null,"2026-01-20",0,null],
            ["Seminar Entrepreneur","Seminar Digipreneur.","<svg></svg>","non-lomba","seminar","https://summitofstars.mhteams.my.id/seminar",null,null,null,null,50000,"CP Seminar: 0878-5509-4196"],
            ["Tenant UMKM & KWU","Fasilitasi UMKM.","<svg></svg>","non-lomba","tenant","https://summitofstars.mhteams.my.id/tenant",null,null,null,null,0,"CP Tenant: 0821-3201-9362"],
            ["Konsultasi Usaha","Konsultasi bisnis.","<svg></svg>","non-lomba","konsultasi","https://summitofstars.mhteams.my.id/konsultasi",null,null,null,null,0,"CP Konsultasi: 0821-3201-9362"]
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
    // DUMMY DATA TIMELINE (BARU DITAMBAHKAN)
    // ==============================
    if ($db->query("SELECT COUNT(*) FROM timeline")->fetchColumn() == 0) {
        $timelineData = [
            // Format: tanggal_start, tanggal_end, judul, deskripsi, link
            [
                "2025-12-01", 
                "2025-12-15", 
                "Pembukaan Pendaftaran", 
                "Pendaftaran dibuka untuk semua kategori lomba dan kegiatan", 
                "https://summitofstars.mhteams.my.id/pendaftaran"
            ],
            [
                "2025-12-16", 
                "2025-12-31", 
                "Pengumpulan Proposal Lomba", 
                "Batas akhir pengumpulan proposal untuk lomba Digipreneur dan Produk Inovasi", 
                "https://bit.ly/bookletcompetition"
            ],
            [
                "2026-01-05", 
                "2026-01-05", 
                "Seminar Digipreneur", 
                "Seminar nasional dengan pembicara ahli di bidang kewirausahaan digital", 
                "https://summitofstars.mhteams.my.id/seminar"
            ],
            [
                "2026-01-10", 
                "2026-01-12", 
                "Presentasi Finalis Lomba", 
                "Presentasi finalis lomba Digipreneur dan Produk Inovasi", 
                null
            ],
            [
                "2026-01-15", 
                "2026-01-17", 
                "Pameran UMKM & Workshop", 
                "Pameran produk UMKM dan workshop kewirausahaan", 
                "https://summitofstars.mhteams.my.id/tenant"
            ],
            [
                "2026-01-18", 
                "2026-01-18", 
                "Penutupan & Pengumuman Pemenang", 
                "Malam puncak dan pengumuman pemenang semua kategori lomba", 
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