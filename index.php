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
    
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <!-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> -->
                <img src="assets/img/logo.png" alt="Logo" width="50px">
                <div class="sidebar-brand-text mx-3" style="text-align:left;font-size: 0.8em;">cv. Sainty Teknologi</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
                <!-- Nav Item - Dashboard -->
            <div class="scrollable-sidebar">
                <li class="nav-item" id="home">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Master
                </div>
                <li class="nav-item" id="bahan">
                    <a class="nav-link" href="index.php?p=bahan">
                        <i class="fas fa-fw fa-flask"></i>
                        <span>Bahan</span>
                    </a>
                </li>
                <li class="nav-item" id="bom">
                    <a class="nav-link" href="index.php?p=bom">
                        <i class="fas fa-fw fa-sitemap"></i>
                        <span>BOM</span>
                    </a>
                </li>
                <li class="nav-item" id="permintaan">
                    <a class="nav-link" href="index.php?p=permintaan">
                        <i class="fas fa-fw fa-cart-arrow-down"></i>
                        <span>Permintaan</span>
                    </a>
                </li>
                <li class="nav-item" id="mps">
                    <a class="nav-link" href="index.php?p=mps">
                        <i class="far fa-fw fa-calendar-alt"></i>
                        <span>Production Schedule</span>
                    </a>
                </li>
                <div class="sidebar-heading">
                    Transaksi
                </div>
                <li class="nav-item" id="mrp">
                    <a class="nav-link" href="index.php?p=mrp">
                        <i class="fas fa-fw fa-list-ul"></i>
                        <span>MRP</span>
                    </a>
                </li>
                <li class="nav-item" id="penerimaan_bb">
                    <a class="nav-link" href="index.php?p=penerimaan_bb">
                        <i class="fas fa-fw fa-boxes"></i>
                        <span>Penerimaan Bahan Baku</span>
                    </a>
                </li>
                <li class="nav-item" id="pengeluaran_bb">
                    <a class="nav-link" href="index.php?p=pengeluaran_bb">
                        <i class="fas fa-fw fa-box-open"></i>
                        <span>Pengeluaran Bahan Baku</span>
                    </a>
                </li>
                <div class="sidebar-heading">
                    Laporan
                </div>
                <li class="nav-item" id="laporan">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
                        <i class="fas fa-fw fa-paste"></i>
                        <span>laporan</span>
                    </a>
                    <div id="collapseLaporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="index.php?p=laporan&ket=bahan_baku">Bahan Baku</a>
                            <a class="collapse-item" href="index.php?p=laporan&ket=penerimaan_bahan_baku">Penerimaan Bahan Baku</a>
                            <a class="collapse-item" href="index.php?p=laporan&ket=pengeluaran_bahan_baku">Pengeluaran Bahan Baku</a>
                            <a class="collapse-item" href="index.php?p=laporan&ket=perencanaan_bahan_baku">Perencanaan Bahan Baku</a>
                            <a class="collapse-item" href="index.php?p=laporan&ket=pemesanan_bahan_baku">Pemesanan Bahan Baku</a>
                            <a class="collapse-item" href="index.php?p=laporan&ket=jadwal_produksi">Jadwal Produksi</a>
                        </div>
                    </div>
                </li>
                <div class="sidebar-heading">
                    Setting
                </div>
                <li class="nav-item" id="user">
                    <a class="nav-link" href="index.php?p=user">
                        <i class="fas fa-fw fa-users"></i>
                        <span>User</span>
                    </a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center m-center">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Alerts -->
                    <?php include 'pages/notification.php'; ?>
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            <img class="img-profile rounded-circle" src="assets/img/user.png">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="index.php?p=user&ket=ubah&id=1">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid main-content">
            <?php
                $dir = "pages";
                $pages = scandir($dir);
                unset($pages[0],$pages[1]);
                if(isset($_GET['p'])){
                    $p = $_GET['p'].".php";
                    if(in_array($p, $pages)){
                        include "$dir/$p";
                    }else{
                        include "$dir/404.php";
                    }
                }else{
                    include "$dir/home.php";
                }
            ?>
            </div>
            <!-- /.container-fluid -->
          </div>
          <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Hapus Modal-->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-success btnhapus-link" href="#">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php?logout=true">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["flash"])){ ?>

    <div class="alert alert-<?= $_SESSION["flash"]["type"]; ?> alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION["flash"]["head"]; ?></strong><br><?= $_SESSION["flash"]["msg"]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['flash']); } ?>

    

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> 

    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('.dataTable').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
            setTimeout(function(){
                $(".alert").hide(500);
            }, 3000);

            var url = document.URL;
            var segments = url.split('?');
            if(segments[1]!=undefined){
                var lk = segments[1].split('&');
                var id = lk[0].replace("p=", "");
                $("#"+id).addClass("active");
            }else{
                $("#home").addClass("active");
            }
        });
    </script>
    
</body>

</html>
