<?php
    require_once("../config/koneksi.php");
	if(isset($_GET['table'])):
        $id_bom = $_GET['id_bom'];
?>
	<table class="table">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Produk</th>
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
        <?php
            $i=0;
            $b = $_GET['table'];
            $bln = "00$b";
            $thn = date("Y");
            $bln = substr($bln, strlen($bln)-2, 2);
            $sql = "SELECT 
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
            //echo $sql;
            $q = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($q)):
        ?>
            <tr>
                <td><?= ++$i; ?></td>
                <td><?= $row['nama_bom']; ?></td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control" name="M1" id="M1" placeholder="Jumlah" value="<?= isset($row['M1'])?$row['M1']:''; ?>" required >
                        <div class="input-group-append">
                            <span class="input-group-text" id="st-add" ><?= $row['satuan']; ?></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control" name="M2" id="M2" placeholder="Jumlah" value="<?= isset($row['M2'])?$row['M2']:''; ?>" required >
                        <div class="input-group-append">
                            <span class="input-group-text" id="st-add" ><?= $row['satuan']; ?></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control" name="M3" id="M3" placeholder="Jumlah" value="<?= isset($row['M3'])?$row['M3']:''; ?>" required >
                        <div class="input-group-append">
                            <span class="input-group-text" id="st-add" ><?= $row['satuan']; ?></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control" name="M4" id="M4" placeholder="Jumlah" value="<?= isset($row['M4'])?$row['M4']:''; ?>" required >
                        <div class="input-group-append">
                            <span class="input-group-text" id="st-add" ><?= $row['satuan']; ?></span>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
		</tbody>
	</table>
<?php endif; ?>