<?php
    require_once("../config/koneksi.php");
?>
<table class="table dataTable">
	<thead>
		<tr>
			<th>No</th>
			<th>Produk</th>
			<th>Jumlah</th>
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
		<tr id="pl_<?= $row['id_bom'] ?>">
			<td><?= ++$i; ?></td>
            <td class="nama"><?= $row['nama_bom']; ?></td>
            <td class="satuan"><?= $row['satuan']; ?></td>
            <td>
                <pre>
<?php
    $bahan = get_bahan($row['id_bom']);
    $ret = "";
    foreach ($bahan as $k => $v) {
        $ret .= "|_ $v[nama_bahan] - $v[jumlah] $v[satuan]<br>";
        if(isset($v['child'])){
            foreach ($v['child'] as $a => $b) {
                $ret .= "\t|_ $b[nama_bahan] - $b[jumlah] $b[satuan]<br>";
            }
        }
    }
    echo $ret;
?>
                </pre>
            </td>
			<td>
                <button type="button" class="btn btn-sm btn-success btn_pilih_bahan" data-id="<?= $row['id_bom'] ?>" data-toggle="tooltip" data-placement="top" title="Pilih" >
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