<?php
require ('koneksi.php');
require ('query.php');
$obj = new crud;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1>Selamat Datang <?php ;?></h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = $obj->lihatData();
                $no = 1;
                if($data->rowCount()>0){
                    while ($row=$data->fetch(PDO::FETCH_ASSOC)){
                ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['user_email']; ?></td>
                            <td><?php echo $row['user_fullname']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                <?php
                        $no++;
                    }
                }
                ?>
            </tbody>
        </table>
        <p><a href="login.php" class="btn btn-secondary">Log Out</a></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
