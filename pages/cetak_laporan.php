<?php
    require_once("../config/koneksi.php");
    if(isset($_GET['cetak'])){
        $page = $_GET['cetak'];
        $ket = join(explode("_", $_GET['cetak']), " ");
    }
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
    <title>Laporan <?= ucwords($ket); ?> | CV. Sainty Teknologi</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.css" rel="stylesheet">

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <style>
        .page_header{
            text-align: center;
            border-bottom: 2px solid black;
        }
        h1,h2,h3,h4,h5,p{
            color: #000;
            margin: 0;
        }
        .table{
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container page_header">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h2>Laporan <?= ucwords($ket); ?></h2>
                <h1>CV. Sainty Teknologi</h1>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <br>
    <br>
    <div class="container">
    <?php
        $dir = "../pages/laporan";
        $pages = scandir($dir);
        unset($pages[0],$pages[1]);
        if(isset($_GET['cetak'])){
            $p = $_GET['cetak'].".php";
            if(in_array($p, $pages)){
                $ctk = true;
                include "$dir/$p";
            }else{
                include "pages/404.php";
            }
        }else{
            include "$dir/home.php";
        }
    ?>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>
