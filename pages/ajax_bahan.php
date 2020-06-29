<?php
    require_once("../config/koneksi.php");
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
		<tr id="pl_<?= $row['id_bahan'] ?>">
			<td><?= ++$i; ?></td>
            <td class="nama"><?= $row['nama_bahan']; ?></td>
            <td class="satuan"><?= $row['satuan']; ?></td>
			<td>
                <button type="button" class="btn btn-sm btn-success btn_pilih_bahan" data-id="<?= $row['id_bahan'] ?>" data-toggle="tooltip" data-placement="top" title="Pilih" >
                    <i class="fa fa-check"></i>
                </button>
            </td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>



<script type="text/javascript">
    $(document).ready(function(){
        var table = $('.dataTable').DataTable();
        $('[data-toggle="tooltip"]').tooltip();

        $(".btn_pilih_bahan").click(function(){
            var id = $(this).attr("data-id");
            var nama = $("#pl_"+id+">.nama").html();
            var satuan = $("#pl_"+id+">.satuan").html();
            //console.log(id+" "+nama+" "+satuan);
            pilih_bahan(id, nama, satuan);
        });
    });
</script>