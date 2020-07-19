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
			$sql = "SELECT * FROM mps a JOIN bom b ON a.id_bom = b.id_bom WHERE id_mps = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_mps = $row['id_mps'];
			$id_bom = $row['id_bom'];
			$nama_bom = $row['nama_bom'];
            $satuan = $row['satuan'];
			$bulan = (int)date("m", strtotime($row['bulan']));
            $M1 = $row['M1'];
            $M2 = $row['M2'];
            $M3 = $row['M3'];
            $M4 = $row['M4'];

            $bln = date("m", strtotime($row['bulan']));
            $thn = date("Y");
            $sql2 = "SELECT 
                        b.nama_bom, 
                        b.satuan,
                        SUM( IF(WEEK(a.tanggal) - WEEK('$thn-$bln-01') = 1, a.jumlah, 0) ) AS M1,
                        SUM( IF(WEEK(a.tanggal) - WEEK('$thn-$bln-01') = 2, a.jumlah, 0) ) AS M2,
                        SUM( IF(WEEK(a.tanggal) - WEEK('$thn-$bln-01') = 3, a.jumlah, 0) ) AS M3,
                        SUM( IF(WEEK(a.tanggal) - WEEK('$thn-$bln-01') = 4, a.jumlah, 0) ) AS M4
                    FROM permintaan a 
                    JOIN bom b ON a.id_bom = b.id_bom 
                    WHERE a.id_bom = $id_bom
                    ORDER BY tanggal ASC";
            $q2 = mysqli_query($con, $sql2);
            while($row2 = mysqli_fetch_array($q2)){
                if($M1<$row2["M1"]){
                    $M1=$row2["M1"];
                }
                if($M2<$row2["M2"]){
                    $M2=$row2["M2"];
                }
                if($M3<$row2["M3"]){
                    $M3=$row2["M3"];
                }
                if($M4<$row2["M4"]){
                    $M4=$row2["M4"];
                }
            }
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
                            <th rowspan="2">Bulan</th>
                            <th colspan="4">Minggu</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT * FROM mps a JOIN bom b ON a.id_bom = b.id_bom ORDER BY bulan DESC";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama_bom']; ?></td>
                            <td><?= get_bulan((int)date("m", strtotime($row['bulan']))); ?></td>
                            <td><?= $row['M1']; ?></td>
                            <td><?= $row['M2']; ?></td>
                            <td><?= $row['M3']; ?></td>
                            <td><?= $row['M4']; ?></td>
                            <td>
                                <a href="index.php?p=mps&ket=ubah&id=<?= $row['id_mps'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <form method="post" action="models/p_mps.php">
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
                                        if(isset($bulan) && $bulan==$k){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="load_tbl">
                    <?php
                        if(isset($M1)):
                    ?>
                    <table class="table">
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
                            <tr>
                                <td>1</td>
                                <td><?= $row['nama_bom']; ?></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="M1" id="M1" placeholder="Jumlah" value="<?= isset($M1)?$M1:''; ?>" required >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="st-add" ><?= $satuan; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="M2" id="M2" placeholder="Jumlah" value="<?= isset($M2)?$M2:''; ?>" required >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="st-add" ><?= $satuan; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="M3" id="M3" placeholder="Jumlah" value="<?= isset($M3)?$M3:''; ?>" required >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="st-add" ><?= $satuan; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="M4" id="M4" placeholder="Jumlah" value="<?= isset($M4)?$M4:''; ?>" required >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="st-add" ><?= $satuan; ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php endif; ?>
                    </div>
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