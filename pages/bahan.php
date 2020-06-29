<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-flask"></i> Bahan Baku</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT * FROM bahan WHERE id_bahan = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_bahan = $row['id_bahan'];
            $nama_bahan = $row['nama_bahan'];
            $satuan = $row['satuan'];
		}
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Bahan Baku</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=bahan&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
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
            				<th>Nama Bahan</th>
            				<th>Satuan</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT * FROM bahan";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
                            <td><?= $row['nama_bahan']; ?></td>
                            <td><?= $row['satuan']; ?></td>
            				<td>
                                <a href="index.php?p=bahan&ket=ubah&id=<?= $row['id_bahan'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_bahan'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_bahan.php">
            		<input type="hidden" name="id_bahan" value="<?= isset($id_bahan)?$id_bahan:''; ?>" >
                    <div class="form-group row">
                        <label for="nama_bahan" class="col-sm-2 col-form-label">Nama Bahan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" placeholder="Nama Bahan" value="<?= isset($nama_bahan)?$nama_bahan:''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="satuan" id="satuan" required>
                                <option value="">[Pilih Satuan]</option>
                                <?php
                                    $sat = get_satuan();
                                    foreach ($sat as $k => $v) {
                                        $sel = "";
                                        if(isset($satuan) && $satuan==$v){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$v.'" '.$sel.'>'.$v.'</option>';
                                    }
                                ?>
                            </select>
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

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
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
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_bahan.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });
</script>