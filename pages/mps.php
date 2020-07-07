<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-calendar-alt"></i> Production Schedule</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT a.*, b.nama_bom, b.satuan FROM permintaan a JOIN bom b ON a.id_bom = b.id_bom WHERE id_permintaan = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_permintaan = $row['id_permintaan'];
			$id_bom = $row['id_bom'];
			$nama_bom = $row['nama_bom'];
			$satuan = $row['satuan'];
            $jumlah = $row['jumlah'];
            $tanggal = $row['tanggal'];
		}
	}

?>
<div class="row">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Production Schedule</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=mps&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
                </div>
            	<?php } ?>
            </div>
            <div class="card-body">
            <?php
                /*$aw = 7;
                $ak = $aw+11;
                for($i=$aw; $i<=$ak; $i++){
                    $bln = mktime(0, 0, 0, $i, 1, 0);
                    echo date("m", $bln);
                    echo "<br>";
                }*/
                if(!isset($form)):
            ?>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Menu</th>
                            <th colspan="4">Minggu</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            <?php else: ?>
                <form method="post" action="models/p_permintaan.php">
                    <input type="hidden" name="id_mps" value="<?= isset($id_mps)?$id_mps:''; ?>" >
                    <div class="form-group row">
                        <label for="menu" class="col-sm-2 col-form-label">Menu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="menu" id="menu" placeholder="Menu" value="<?= isset($nama_bom)?$nama_bom:''; ?>" required>
                        </div>
                        <input type="hidden" id="id_bom" name="id_bom" value="<?= isset($id_bom)?$id_bom:''; ?>" required>
                    </div>
                    <div class="form-group row">
                        <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="bulan" id="cb_bulan" required>
                                <option value="">[Pilih Bulan]</option>
                                <?php
                                    $sat = get_bulan();
                                    foreach ($sat as $k => $v) {
                                        $sel = "";
                                        if(isset($_GET['table']) && $_GET['table']==$k){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="load_tbl"></div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <input type="submit" class="btn btn-primary" name="btnSimpan" value="<?= ucfirst($form); ?>">
                        </div>
                    </div>
                </form>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Bahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body load-modal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#cb_bulan").change(function(){
            //var url = document.URL;
            //document.location=url+'&table='+$(this).val();
            var id_bom = $("#id_bom").val();
            if(id_bom!=''){
                var tbl = $(this).val();
                $(".load_tbl").load("pages/ajax_mps.php?table="+tbl+"&id_bom="+id_bom);
            }
        });

        $("#menu").click(function(){
            $(".load-modal").load("pages/ajax_bom.php");
            $("#modalBahan").modal('show');
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_mps.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });


    function pilih_bahan(id, nama, satuan){
        //console.log(id+" "+nama+" "+satuan);
        $("#modalBahan").modal('hide');
        $("#id_bom").val(id);
        $("#menu").val(nama);
        $("#satuan").val(satuan);
        /*
        $("#satuan_bahan_inp").val(satuan);
        $("#modaljumlah").modal('show');*/
    }
</script>