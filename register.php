<?php
class Koneksi {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "user";
    protected $koneksi;

    public function __construct() {
        try {
            $this->koneksi = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }
}

class crud extends koneksi {

    public function insertData($email, $pass, $name) {
        try {
            $sql = "INSERT INTO user_detail (user_email, user_password, user_fullname, level) VALUES (:email, :pass, :name, 2)";
            $result = $this->koneksi->prepare($sql);
            $result->bindParam(":email", $email, PDO::PARAM_STR);
            $result->bindParam(":pass", $pass, PDO::PARAM_STR);
            $result->bindParam(":name", $name, PDO::PARAM_STR);
            $result->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}

$obj = new crud;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['txt_email'];
    $pass = $_POST['txt_pass'];
    $name = $_POST['txt_name'];

    if ($obj->insertData($email, $pass, $name)) {
        echo '<div class="alert alert-success">Data berhasil disimpan</div>';
    } else {
        echo '<div class="alert alert-danger">Data gagal disimpan</div>';
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="txt_email">Email</label>
                        <input type="text" class="form-control" name="txt_email" required>
                    </div>
                    <div class="form-group">
                        <label for="txt_pass">Password</label>
                        <input type="password" class="form-control" name="txt_pass" required>
                    </div>
                    <div class="form-group">
                        <label for="txt_name">Nama</label>
                        <input type="text" class="form-control" name="txt_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                </form>
                <p class="mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
