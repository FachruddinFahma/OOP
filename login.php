<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "user";
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);

        $query = "SELECT * FROM user_detail WHERE user_email = '$email'";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userVal = $row['user_email'];
            $passVal = $row['user_password'];
            $userName = $row['user_fullname'];

            if ($userVal == $email && $passVal == $password) {
                return $userName;
            } else {

                return false;
            }
        } else {
            return false;
        }
    }
}

$koneksi = new Database();
$conn = $koneksi->getConnection();
$user = new User($conn);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['txt_email'];
    $pass = $_POST['txt_pass'];

    if (!empty(trim($email)) && !empty(trim($pass))) {
        $result = $user->login($email, $pass);

        if ($result !== false) {
            header('Location: home.php?user_fullname=' . urlencode($result));
            exit();
        } else {
            $error = 'Username atau password salah!!';
        }
    } else {
        $error = 'Data tidak boleh kosong!!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <form action="login.php" method="POST">
                            <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ?>
                            <div class="form-group">
                                <label for="txt_email">Email</label>
                                <input type="text" class="form-control" name="txt_email">
                            </div>
                            <div class="form-group">
                                <label for="txt_pass">Password</label>
                                <input type="password" class="form-control" name="txt_pass">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <p class="mt-3">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
