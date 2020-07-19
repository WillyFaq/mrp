<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-list-ul"></i> MRP</h1>
</div>
<div class="row">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Material Requiremen Planing</h6>
            </div>
            <div class="card-body">
            	<?php if(!isset($_GET['ket'])): ?>
            	<table class="table dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama BOM</th>
                            <th>Jumlah</th>
                            <th>Lead Time</th>
                            <th>Bahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT * FROM bom";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama_bom']; ?></td>
                            <td><?= $row['jumlah'].' '.$row['satuan']; ?></td>
                            <td><?= $row['LT'].' Minggu'; ?></td>
                            <td>
                                <pre>
<?php
    $bahan = get_bahan($row['id_bom']);
    foreach ($bahan as $k => $v) {
        $level = (int)$v['level'] - 1;
        echo gen_tab($level)."|_ $v[nama_bahan] - $v[jumlah] $v[satuan]<br>";
    }
?>
                                </pre>
                            </td>
                            <td>
                                <a href="index.php?p=mrp&ket=lihat&id=<?= $row['id_bom'] ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: 
                	$id_bom = $_GET['id'];
                ?>
				
                <form action="">
                	<input type="hidden" id="id_bom" name="id_bom" value="<?= isset($id_bom)?$id_bom:''; ?>">
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
                </form>
                <div class="load_mrp"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//$(".load_mrp").load("pages/ajax_mrp.php?table=8&id_bom=8");
		$("#cb_bulan").change(function(){
			var id_bom = $("#id_bom").val();
            if(id_bom!=''){
                var tbl = $(this).val();
                $(".load_mrp").load("pages/ajax_mrp.php?table="+tbl+"&id_bom="+id_bom);
                console.log("pages/ajax_mrp.php?table="+tbl+"&id_bom="+id_bom);
            }
		});
	});
</script>