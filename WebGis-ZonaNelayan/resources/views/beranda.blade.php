<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - WebGIS Zona Nelayan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }

        /* --- Navbar Minimalis --- */
        .navbar {
            background: #ffffff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-brand {
            font-size: 24px;
            font-weight: 800;
            color: #0056b3;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* --- Hero Section --- */
        .hero {
            background: linear-gradient(135deg, #0056b3 0%, #00a8ff 100%);
            color: white;
            padding: 80px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: 800;
        }
        .hero p {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto 40px auto;
            line-height: 1.6;
            opacity: 0.9;
        }
        .btn-cta {
            background-color: #ffffff;
            color: #0056b3;
            padding: 18px 40px;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        }

        /* --- Dashboard Statistik --- */
        .dashboard {
            max-width: 1000px;
            margin: -40px auto 50px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            position: relative;
            z-index: 10;
        }
        .stat-card {
            background: white;
            padding: 30px 20px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: #333;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Warna khusus untuk setiap kartu */
        .card-total .stat-number { color: #0056b3; }
        .card-aman .stat-number { color: #28a745; }
        .card-rawan .stat-number { color: #ffc107; }
        .card-larangan .stat-number { color: #dc3545; }

        /* --- Tentang Sistem --- */
        .about-section {
            max-width: 800px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }
        .about-section h2 {
            font-size: 28px;
            color: #0056b3;
            margin-bottom: 20px;
        }
        .about-section p {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .dashboard { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="nav-brand">🌊 WebGIS Nelayan</a>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Pemetaan Partisipatif Laut Kita</h1>
        <p>
            Platform pelaporan kondisi laut secara real-time dari nelayan, untuk nelayan. 
            Bersama-sama memetakan zona aman, zona rawan bahaya, dan zona perlindungan untuk keselamatan pelayaran bersama.
        </p>
        <a href="/peta" class="btn-cta">🧭 Buka Peta Interaktif</a>
    </section>

    <!-- Dashboard Statistik -->
    <section class="dashboard">
        <div class="stat-card card-total">
            <div class="stat-icon">📊</div>
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total Laporan</div>
        </div>
        <div class="stat-card card-aman">
            <div class="stat-icon">🟢</div>
            <div class="stat-number">{{ $aman }}</div>
            <div class="stat-label">Zona Aman</div>
        </div>
        <div class="stat-card card-rawan">
            <div class="stat-icon">🟡</div>
            <div class="stat-number">{{ $rawan }}</div>
            <div class="stat-label">Zona Rawan</div>
        </div>
        <div class="stat-card card-larangan">
            <div class="stat-icon">🔴</div>
            <div class="stat-number">{{ $larangan }}</div>
            <div class="stat-label">Zona Larangan</div>
        </div>
    </section>

    <!-- Tentang Sistem -->
    <section class="about-section">
        <h2>Dari Nelayan, Untuk Nelayan</h2>
        <p>
            Sistem WebGIS ini merubah data koordinat dari para pelaut di lapangan menjadi 
            visualisasi peta yang sangat mudah dipahami. Dengan saling berbagi informasi 
            titik koordinat laut, kita dapat mencegah kecelakaan laut dan melestarikan terumbu karang 
            melalui data yang aktual dan bersumber langsung dari laut kita sendiri.
        </p>
    </section>

</body>
</html>
