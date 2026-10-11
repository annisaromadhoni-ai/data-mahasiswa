<?php
include 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if ($aksi == 'tambah') {

    $nim = mysqli_real_escape_string(
        $koneksi, $_POST['nim']
    );

    $nama = mysqli_real_escape_string(
        $koneksi, $_POST['nama']
    );

    $alamat = mysqli_real_escape_string(
        $koneksi, $_POST['alamat']
    );

    $id_jurusan = isset($_POST['id_jurusan'])
        ? (int) $_POST['id_jurusan']
        : 0;

    // Periksa apakah jurusan tersedia
    $cek_jurusan = mysqli_query(
        $koneksi,
        "SELECT nama_jurusan FROM jurusan
         WHERE id_jurusan = $id_jurusan"
    );

    if (!$cek_jurusan || mysqli_num_rows($cek_jurusan) == 0) {
        die("Jurusan tidak ditemukan. Silakan kembali dan pilih jurusan.");
    }

    $data_jurusan = mysqli_fetch_assoc($cek_jurusan);

    $jurusan = mysqli_real_escape_string(
        $koneksi, $data_jurusan['nama_jurusan']
    );

    // Simpan data mahasiswa
    $query = mysqli_query(
        $koneksi,
        "INSERT INTO mahasiswa
        (nim, nama, jurusan, id_jurusan, alamat)
        VALUES
        ('$nim', '$nama', '$jurusan', $id_jurusan, '$alamat')"
    );

    if ($query) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menambahkan data: "
             . mysqli_error($koneksi);
    }

} else {
    header("Location: index.php");
    exit();
}
?>