<?php
require('koneksi.php');

$koneksiObj = new Koneksi(); // Membuat objek koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['txt_id'];
    $userPass = $_POST['txt_pass'];
    $userName = $_POST['txt_nama'];

    $query = "UPDATE user_detail SET user_password=?, user_fullname=? WHERE id=?";
    $stmt = $koneksiObj->koneksi->prepare($query);

    if ($stmt) {
        $stmt->bindParam(1, $userPass);
        $stmt->bindParam(2, $userName);
        $stmt->bindParam(3, $userId);

        if ($stmt->execute()) {
            header('Location: home.php');
            exit();
        } else {
            echo "Gagal melakukan update.";
        }
    } else {
        echo "Gagal mempersiapkan statement.";
    }
}

$id = $_GET['id'];
$query = "SELECT * FROM user_detail WHERE id=?";
$stmt = $koneksiObj->koneksi->prepare($query);

if ($stmt) {
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $id = $result['id'];
        $userMail = $result['user_email'];
        $userPass = $result['user_password'];
        $userName = $result['user_fullname'];
    } else {
        echo "Gagal menjalankan query.";
    }
} else {
    echo "Gagal mempersiapkan statement.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Profil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <form action="edit.php" method="POST">
            <input type="hidden" name="txt_id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label>Email :</label>
                <input type="text" class="form-control" name="txt_email" value="<?php echo $userMail; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Password :</label>
                <input type="password" class="form-control" name="txt_pass" value="<?php echo $userPass; ?>">
            </div>
            <div class="form-group">
                <label>Nama :</label>
                <input type="text" class="form-control" name="txt_nama" value="<?php echo $userName; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
        <a href="home.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
