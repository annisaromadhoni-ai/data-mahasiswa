
<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT
        mahasiswa.*,
        COALESCE(jurusan.nama_jurusan, mahasiswa.jurusan) AS nama_prodi
    FROM mahasiswa
    LEFT JOIN jurusan
        ON mahasiswa.id_jurusan = jurusan.id_jurusan
    ORDER BY mahasiswa.id DESC
");

if (!$query) {
    die("Gagal mengambil data mahasiswa: " . mysqli_error($koneksi));
}

$totalData = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Mahasiswa | Sistem Informasi</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --tosca-dark: #0f766e;
            --tosca: #14b8a6;
            --tosca-light: #ccfbf1;
            --page-bg: #f0fdfa;
            --text-dark: #164e4a;
            --text-muted: #718b88;
            --border-color: #dcefeb;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text-dark);
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 14px;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(
                120deg,
                var(--tosca-dark),
                #11998e
            );
            padding: 17px 0;
            box-shadow: 0 5px 20px rgba(15, 118, 110, 0.15);
        }

        .navbar-brand {
            color: var(--white) !important;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: 0.7px;
        }

        .brand-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            margin-right: 10px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.18);
            font-size: 19px;
            vertical-align: middle;
        }

        /* AREA UTAMA */
        .main-container {
            max-width: 1200px;
            margin: 42px auto;
        }

        /* KARTU KONTEN */
        .content-card {
            background: var(--white);
            border: 1px solid #e1f2ee;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 12px 35px rgba(15, 118, 110, 0.07);
        }

        /* JUDUL */
        .page-label {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 12px;
            border-radius: 20px;
            background: var(--tosca-light);
            color: var(--tosca-dark);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .page-title {
            color: var(--tosca-dark);
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .page-description {
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        /* KARTU STATISTIK */
        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 19px 22px;
            margin-bottom: 28px;
            background: linear-gradient(120deg, #f0fdfa, #ffffff);
            border: 1px solid var(--border-color);
            border-radius: 15px;
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--tosca-light);
            color: var(--tosca-dark);
            font-size: 25px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 3px;
        }

        .stat-number {
            color: var(--tosca-dark);
            font-size: 23px;
            font-weight: 700;
            line-height: 1.3;
        }

        /* TOMBOL TAMBAH */
        .btn-tambah {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px 19px;
            background: var(--tosca);
            border: 1px solid var(--tosca);
            border-radius: 10px;
            color: var(--white);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-tambah:hover {
            background: var(--tosca-dark);
            border-color: var(--tosca-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(15, 118, 110, 0.2);
        }

        /* JUDUL TABEL */
        .table-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--text-dark);
            font-size: 16px;
            font-weight: 600;
        }

        .heading-line {
            display: inline-block;
            width: 5px;
            height: 23px;
            border-radius: 5px;
            background: var(--tosca);
        }

        /* TABEL */
        .table-responsive {
            overflow-x: auto;
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .table {
            min-width: 650px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            vertical-align: middle;
        }

        .table thead th {
            padding: 17px 15px;
            background: var(--tosca-dark);
            color: var(--white);
            border: none;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px 15px;
            color: #385b57;
            border-color: var(--border-color);
            font-size: 13px;
            vertical-align: middle;
            transition: background 0.2s ease;
        }

        .table tbody tr:nth-child(even) td {
            background: #f7fdfb;
        }

        .table-hover tbody tr:hover td {
            background: #e4faf5;
            color: var(--tosca-dark);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .number-cell {
            color: var(--tosca-dark) !important;
            font-weight: 600;
        }

        .student-name {
            color: #234e49 !important;
            font-weight: 600;
        }

        /* LABEL JURUSAN */
        .badge-jurusan {
            display: inline-block;
            max-width: 230px;
            padding: 7px 12px;
            border-radius: 30px;
            background: var(--tosca-light);
            color: var(--tosca-dark);
            font-size: 11px;
            font-weight: 600;
            line-height: 1.6;
            white-space: normal;
            text-align: center;
        }

        /* DATA KOSONG */
        .empty-state {
            padding: 45px 20px !important;
            text-align: center;
        }

        .empty-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 58px;
            height: 58px;
            margin-bottom: 14px;
            border-radius: 18px;
            background: var(--tosca-light);
            font-size: 27px;
        }

        .empty-title {
            color: var(--tosca-dark);
            font-size: 15px;
            font-weight: 600;
        }

        /* FOOTER */
        .footer-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #edf5f3;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 11px;
        }

        .footer-highlight {
            color: var(--tosca-dark);
            font-weight: 600;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-container {
                margin: 22px auto;
                padding-left: 15px;
                padding-right: 15px;
            }

            .content-card {
                padding: 20px 15px;
                border-radius: 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .stat-card {
                padding: 15px;
                margin-bottom: 23px;
            }

            .btn-tambah {
                width: 100%;
            }

            .footer-area {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="brand-icon">🎓</span>
                DATA MAHASISWA
            </a>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="container main-container">
        <div class="content-card">

            <!-- JUDUL DAN TOMBOL -->
            <div class="d-flex flex-column flex-md-row
                        justify-content-between align-items-md-center
                        gap-3 mb-4">

                <div>
                    <span class="page-label">
                        SISTEM INFORMASI AKADEMIK
                    </span>

                    <h1 class="page-title">
                        Daftar Data Mahasiswa
                    </h1>

                    <p class="page-description mb-0">
                        Kelola dan lihat informasi mahasiswa yang
                        tersimpan dalam database dengan mudah.
                    </p>
                </div>

                <div>
                    <a href="insert.php" class="btn-tambah">
                        <span>＋</span>
                        Tambah Mahasiswa
                    </a>
                </div>

            </div>

            <!-- KARTU STATISTIK -->
            <div class="stat-card">
                <div class="stat-icon">👥</div>

                <div>
                    <div class="stat-label">
                        Total Mahasiswa Terdaftar
                    </div>

                    <div class="stat-number">
                        <?= $totalData; ?>
                        <span style="font-size: 13px; font-weight: 500;">
                            Mahasiswa
                        </span>
                    </div>
                </div>
            </div>

            <!-- JUDUL TABEL -->
            <div class="table-heading">
                <span class="heading-line"></span>
                Data Mahasiswa
            </div>

            <!-- TABEL MAHASISWA -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th class="text-center" style="width: 65px;">
                                No.
                            </th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        if ($totalData > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>

                            <tr>
                                <td class="text-center number-cell">
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nim']); ?>
                                </td>

                                <td class="student-name">
                                    <?= htmlspecialchars($data['nama']); ?>
                                </td>

                                <td>
                                    <span class="badge-jurusan">
                                        <?= htmlspecialchars(
                                            $data['nama_prodi'] ?? ''
                                        ); ?>
                                    </span>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['alamat']); ?>
                                </td>
                            </tr>

                        <?php
                            }
                        } else {
                        ?>

                            <tr>
                                <td colspan="5" class="empty-state">
                                    <div class="empty-icon">📚</div>

                                    <div class="empty-title">
                                        Belum Ada Data Mahasiswa
                                    </div>

                                    <p class="text-secondary mb-0 mt-2">
                                        Klik tombol Tambah Mahasiswa
                                        untuk memasukkan data baru.
                                    </p>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>

            <!-- FOOTER -->
            <div class="footer-area">
                <span class="footer-text">
                    © <?= date('Y'); ?>
                    <span class="footer-highlight">
                        Sistem Informasi Data Mahasiswa
                    </span>
                </span>

                <span class="footer-text">
                    Menampilkan
                    <span class="footer-highlight">
                        <?= $totalData; ?> mahasiswa
                    </span>
                </span>
            </div>

        </div>
    </div>

</body>
</html>
