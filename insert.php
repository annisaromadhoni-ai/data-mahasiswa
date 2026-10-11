
<?php
include 'koneksi.php';

$query_jurusan = mysqli_query(
    $koneksi,
    "SELECT id_jurusan, nama_jurusan
     FROM jurusan
     ORDER BY nama_jurusan ASC"
);

if (!$query_jurusan) {
    die("Gagal mengambil data jurusan: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Data Mahasiswa</title>

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
            min-height: 100vh;
            background: var(--page-bg);
            color: var(--text-dark);
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 14px;
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
            display: inline-flex;
            align-items: center;
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
        }

        /* CONTAINER */
        .form-container {
            max-width: 790px;
            margin: 40px auto;
        }

        /* KARTU FORMULIR */
        .form-card {
            padding: 32px;
            background: var(--white);
            border: 1px solid #e1f2ee;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(15, 118, 110, 0.08);
        }

        /* TOMBOL KEMBALI */
        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--tosca-dark);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-kembali:hover {
            color: var(--tosca);
            transform: translateX(-3px);
        }

        /* JUDUL */
        .page-label {
            display: inline-block;
            margin-bottom: 12px;
            padding: 6px 12px;
            border-radius: 20px;
            background: var(--tosca-light);
            color: var(--tosca-dark);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .page-title {
            margin-bottom: 9px;
            color: var(--tosca-dark);
            font-size: 26px;
            font-weight: 700;
        }

        .page-description {
            margin-bottom: 0;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .title-divider {
            width: 55px;
            height: 4px;
            margin-top: 18px;
            border-radius: 10px;
            background: var(--tosca);
        }

        /* LABEL FORM */
        .form-label {
            margin-bottom: 9px;
            color: var(--text-dark);
            font-size: 13px;
            font-weight: 600;
        }

        .required-mark {
            color: var(--tosca);
        }

        /* INPUT DAN SELECT */
        .form-control,
        .form-select {
            min-height: 47px;
            padding: 12px 14px;
            border: 1px solid #d5e9e6;
            border-radius: 10px;
            background-color: #fbfefd;
            color: var(--text-dark);
            font-family: inherit;
            font-size: 13px;
            transition: border-color 0.2s ease,
                        box-shadow 0.2s ease,
                        background-color 0.2s ease;
        }

        textarea.form-control {
            min-height: 125px;
            resize: vertical;
        }

        .form-control::placeholder {
            color: #9bb2ae;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #8ddbd0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--tosca);
            background-color: var(--white);
            color: var(--text-dark);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
            outline: none;
        }

        /* JARAK ANTAR FORM */
        .form-group {
            margin-bottom: 22px;
        }

        /* TOMBOL SIMPAN */
        .btn-simpan {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 45px;
            padding: 11px 22px;
            border: 1px solid var(--tosca);
            border-radius: 10px;
            background: var(--tosca);
            color: var(--white);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-simpan:hover {
            transform: translateY(-2px);
            border-color: var(--tosca-dark);
            background: var(--tosca-dark);
            color: var(--white);
            box-shadow: 0 7px 15px rgba(15, 118, 110, 0.2);
        }

        /* TOMBOL RESET */
        .btn-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 45px;
            padding: 11px 22px;
            border: 1px solid #c8ded9;
            border-radius: 10px;
            background: var(--white);
            color: var(--text-muted);
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .btn-reset:hover {
            border-color: var(--tosca);
            background: var(--tosca-light);
            color: var(--tosca-dark);
        }

        /* CATATAN BAWAH FORM */
        .form-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 24px;
            padding: 13px 15px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: #f7fdfb;
            color: var(--text-muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .note-icon {
            color: var(--tosca-dark);
            font-size: 15px;
        }

        /* FOOTER */
        .footer-text {
            margin-top: 20px;
            color: var(--text-muted);
            font-size: 11px;
            text-align: center;
        }

        .footer-text span {
            color: var(--tosca-dark);
            font-weight: 600;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .form-container {
                margin: 22px auto;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-card {
                padding: 22px 18px;
                border-radius: 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .form-actions {
                display: flex;
                flex-direction: column;
            }

            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand text-decoration-none" href="index.php">
                <span class="brand-icon">🎓</span>
                DATA MAHASISWA
            </a>
        </div>
    </nav>

    <!-- FORM TAMBAH MAHASISWA -->
    <div class="container form-container">
        <div class="form-card">

            <!-- TOMBOL KEMBALI -->
            <a href="index.php" class="btn-kembali">
                <span>←</span>
                Kembali ke Daftar Data
            </a>

            <!-- JUDUL FORM -->
            <div class="mt-4 mb-4">
                <span class="page-label">
                    FORMULIR AKADEMIK
                </span>

                <h1 class="page-title">
                    Tambah Data Mahasiswa
                </h1>

                <p class="page-description">
                    Lengkapi informasi mahasiswa di bawah ini
                    dengan benar untuk menyimpan data baru.
                </p>

                <div class="title-divider"></div>
            </div>

            <!-- FORM -->
            <form action="proses.php?aksi=tambah" method="POST">

                <!-- NIM -->
                <div class="form-group">
                    <label for="nim" class="form-label">
                        NIM <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nim"
                        name="nim"
                        placeholder="Contoh: 2503010"
                        autocomplete="off"
                        required
                    >
                </div>

                <!-- NAMA -->
                <div class="form-group">
                    <label for="nama" class="form-label">
                        Nama Lengkap <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama lengkap mahasiswa"
                        autocomplete="name"
                        required
                    >
                </div>

                <!-- JURUSAN -->
                <div class="form-group">
                    <label for="jurusan" class="form-label">
                        Jurusan <span class="required-mark">*</span>
                    </label>

                    <select
                        class="form-select"
                        id="jurusan"
                        name="id_jurusan"
                        required
                    >
                        <option value="">-- Pilih Jurusan --</option>

                        <?php while ($jurusan = mysqli_fetch_assoc($query_jurusan)) { ?>
                            <option value="<?= (int) $jurusan['id_jurusan']; ?>">
                                <?= htmlspecialchars($jurusan['nama_jurusan']); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <!-- ALAMAT -->
                <div class="form-group mb-4">
                    <label for="alamat" class="form-label">
                        Alamat <span class="required-mark">*</span>
                    </label>

                    <textarea
                        class="form-control"
                        id="alamat"
                        name="alamat"
                        rows="4"
                        placeholder="Masukkan alamat lengkap mahasiswa"
                        required
                    ></textarea>
                </div>

                <!-- TOMBOL -->
                <div class="form-actions d-flex flex-wrap gap-2">
                    <button
                        type="submit"
                        name="submit"
                        class="btn btn-simpan"
                    >
                        <span>✓</span>
                        Simpan Data
                    </button>

                    <button
                        type="reset"
                        class="btn btn-reset"
                    >
                        <span>↻</span>
                        Reset Form
                    </button>
                </div>

                <!-- CATATAN -->
                <div class="form-note">
                    <span class="note-icon">ⓘ</span>

                    <span>
                        Pastikan NIM, nama, jurusan, dan alamat
                        sudah benar sebelum menekan tombol
                        Simpan Data. Kolom bertanda
                        <span class="required-mark">*</span>
                        wajib diisi.
                    </span>
                </div>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="footer-text">
            © <?= date('Y'); ?>
            <span>Sistem Informasi Data Mahasiswa</span>
        </div>
    </div>

</body>
</html>
