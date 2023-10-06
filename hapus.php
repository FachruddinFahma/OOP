<?php
require('koneksi.php');

$koneksiObj = new Koneksi();
$koneksi = $koneksiObj->getKoneksi();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Periksa apakah id adalah angka
    if (!is_numeric($id)) {
        echo "ID harus berupa angka.";
        exit();
    }

    // Persiapkan statement DELETE
    $query = "DELETE FROM user_detail WHERE id = ?";
    $stmt = $koneksi->prepare($query);

    if ($stmt) {
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            header('Location: home.php');
            exit();
        } else {
            echo "Gagal melakukan penghapusan.";
        }
    } else {
        echo "Gagal mempersiapkan statement.";
    }
} else {
    echo "ID tidak ditemukan.";
}
