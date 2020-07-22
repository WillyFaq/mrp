<style>
.error{width: 12.6rem;}
</style>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-paste"></i> Laporan</h1>
</div>
<?php
	if(isset($_GET['ket'])){
        $page = $_GET['ket'];
		$ket = join(explode("_", $_GET['ket']), " ");
	}

?>
<iframe class="iframe_cetak" src="" width="0" height="0" frameborder="0"></iframe>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan <?= ucwords($ket); ?></h6>
                <div class="dropdown no-arrow">
                    <a href="#" data-href="pages/cetak_laporan.php?cetak=<?= $page; ?>" class="btn btn-warning btn-cetak" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="fa fa-print"></i></a>
                </div>
            </div>
            <div class="card-body">
            <?php
                $dir = "pages/laporan";
                $pages = scandir($dir);
                unset($pages[0],$pages[1]);
                if(isset($_GET['ket'])){
                    $p = $_GET['ket'].".php";
                    if(in_array($p, $pages)){
                        include "$dir/$p";
                    }else{
                        include "pages/404.php";
                    }
                }else{
                    include "$dir/home.php";
                }
            ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-cetak").click(function(){
            var href = $(this).attr("data-href");
            $(".iframe_cetak").attr("src", href);
            return false;
        });
    });
</script>
