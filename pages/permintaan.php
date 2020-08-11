<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-cart-arrow-down"></i> Permintaan</h1>
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
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Permintaan</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=permintaan&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
                </div>
            	<?php } ?>
            </div>
            <div class="card-body">
            <?php
            	if(!isset($form)):
            ?>
            	<table class="table dataTable">
            		<thead>
            			<tr>
            				<th>No</th>
            				<th>Menu</th>
            				<th>Jumlah</th>
            				<th>Tanggal</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT a.*, b.nama_bom, b.satuan FROM permintaan a JOIN bom b ON a.id_bom = b.id_bom ORDER BY tanggal DESC";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
                            $date = explode("-",$row['tanggal']);
                            $date = $date[2].' '.get_bulan((int)$date[1]).' '.$date[0];
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
                            <td><?= $row['nama_bom']; ?></td>
                            <td><?= $row['jumlah']." ".$row['satuan']; ?></td>
                            <td><?= $date; ?></td>
            				<td>
                                <a href="index.php?p=permintaan&ket=ubah&id=<?= $row['id_permintaan'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_permintaan'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_permintaan.php">
            		<input type="hidden" name="id_permintaan" value="<?= isset($id_permintaan)?$id_permintaan:''; ?>" >
                    <div class="form-group row">
                        <label for="menu" class="col-sm-2 col-form-label">Menu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="menu" id="menu" placeholder="Menu" value="<?= isset($nama_bom)?$nama_bom:''; ?>" required>
                        </div>
                        <input type="hidden" id="id_bom" name="id_bom" value="<?= isset($id_bom)?$id_bom:''; ?>" required>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?= isset($satuan)?$satuan:''; ?>" readonly >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                        	<input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?= isset($jumlah)?$jumlah:''; ?>" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                        	<input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?= isset($tanggal)?$tanggal:''; ?>" min="<?= date("Y-m-d")?>" required >
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
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

        $("#menu").click(function(){
            $(".load-modal").load("pages/ajax_bom.php");
            $("#modalBahan").modal('show');
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_permintaan.php?id="+id);
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