<?php
    require_once("config/koneksi.php");
    /*if(!isset($_SESSION['user']) && $_SESSION['user']==""){
        header("location:login.php");
    }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MRP | CV. Sainty Teknologi">
    <meta name="author" content="Azizar">
    <link rel="shortcut icon" href="assets/img/logo.ico">
    <title>MRP | CV. Sainty Teknologi</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="assets/vendor/jquery/jquery.min.js"></script>
</head>
<body class="bg-gradient-primary">
    <?php
        if(isset($_GET['logout'])){
            $_SESSION['user'] = '';
            $_SESSION['type'] = '';
            $_SESSION['name'] = '';
            unset($_SESSION['user']);
            unset($_SESSION['type']);
            unset($_SESSION['name']);
        }
        if(isset($_POST['btnlogin'])){
            //print_r($_POST);
            $username = isset($_POST['username'])?$con->real_escape_string($_POST['username']):'';
            $password = isset($_POST['password'])?$con->real_escape_string($_POST['password']):'';
            
            $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password';";
            $q = mysqli_query($con, $sql);
            $nr = mysqli_num_rows($q);
            if($nr>0){
                $row = mysqli_fetch_array($q);
                $_SESSION['user'] = $row['id_user'];
                $_SESSION['type'] = $row['jabatan'];
                $_SESSION['name'] = $row['nama_user'];

                $_SESSION["flash"]["type"] = "success";
                $_SESSION["flash"]["head"] = "Login Sukses";
                $_SESSION["flash"]["msg"] = "Selamat datang <br><strong>$_SESSION[name]</strong>!";
                header("location:index.php");
                exit();
            }else{
                $_SESSION["flash"]["type"] = "danger";
                $_SESSION["flash"]["head"] = "Login Gagal";
                $_SESSION["flash"]["msg"] = "<br>Username/password Salah!";
                header("location:login.php");
                exit();
            }
        }
    ?>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
            </div>
            <div class="col-xl-10 col-lg-12 col-md-9">
                <h1> <br></h1>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        </div>
                                        <input type="submit" name="btnlogin" value="Login" class="btn btn btn-primary btn-user btn-block">
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["flash"])){ ?>

    <div class="alert alert-<?= $_SESSION["flash"]["type"]; ?> alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION["flash"]["head"]; ?></strong> <?= $_SESSION["flash"]["msg"]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['flash']); } ?>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){
                $(".alert").hide(500);
                <?php
                    //unset($_SESSION['flash']);
                ?>
            }, 3000);
        });
    </script>
</body>

</html>
