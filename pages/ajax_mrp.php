<?php
    require_once("../config/koneksi.php");
	if(isset($_GET['table'])):
        $id_bom = $_GET['id_bom'];

        $b = $_GET['table'];
        $thn = date("Y");
        $sql = "SELECT * FROM mps a JOIN bom b ON a.id_bom = b.id_bom 
                WHERE MONTH(a.bulan) = $b AND YEAR(a.bulan) = $thn AND a.id_bom = $id_bom 
                ORDER BY bulan DESC";
        $q = mysqli_query($con, $sql);
        if(mysqli_num_rows($q)>0):
?>
	<table class="table table-bordered tbl_mrp">
		<thead class="thead-dark">
			<tr>
				<th width="28%" rowspan="2">Produk</th>
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
            $mps = [];
            $i=0;
            while($row = mysqli_fetch_array($q)):
                $mps[] = $row["M1"];
                $mps[] = $row["M2"];
                $mps[] = $row["M3"];
                $mps[] = $row["M4"];
        ?>
            <tr>
                <td class="text-left"><?= $row['nama_bom']; ?> (<?= $row['satuan']; ?>)</td>
                <td>
                    <?= $row['M1']*1000; ?>
                </td>
                <td>
                    <?= $row['M2']*1000; ?>
                </td>
                <td>
                    <?= $row['M3']*1000; ?>
                </td>
                <td>
                    <?= $row['M4']*1000; ?>
                </td>
            </tr>
        <?php endwhile; ?>
		</tbody>
	</table>
    <pre>
<?php

$mrp = new MRP();

$sql = "SELECT id_bahan FROM bom_detail WHERE id_bom = $id_bom";
$q = mysqli_query($con, $sql);
$id_bahan = [];
while($row = mysqli_fetch_array($q)){
    $id_bahan[] = $row['id_bahan'];
}

//$sql = "SELECT * FROM mrp WHERE id_bom = $id_bom AND id_bahan IN (".join($id_bahan, ",").") AND MONTH(bulan) = $b";
$sql = "SELECT * FROM mrp WHERE id_bom = $id_bom AND id_bahan IN (".join($id_bahan, ",").") AND MONTH(bulan) = $b";
$q = mysqli_query($con, $sql);
if(mysqli_num_rows($q)>0){
    $sql = "SELECT
                a.id_mrp,
                a.id_bom,
                a.id_bahan,
                c.nama_bahan,
                c.satuan,
                c.LT,
                b.level,
                c.rop,
                a.bulan,
                a.minggu,
                a.GR,
                a.SR,
                a.OHI,
                a.NR,
                a.POR,
                a.POREL
            FROM mrp a
            JOIN bom_detail b ON a.id_bahan = b.id_bahan
            JOIN bahan c ON b.id_bahan = c.id_bahan
            WHERE a.id_bom = $id_bom AND MONTH(a.bulan) = $b";
        //echo $sql;
    $q = mysqli_query($con, $sql);
    $tmp_data = [];
    while($row = mysqli_fetch_array($q)){
        $tmp_data[$row['id_mrp']] = $row;
    }   
    foreach ($tmp_data as $key => $row) {
        $data[$row['id_bahan']] = array(
                                        'id_bahan' => $row['id_bahan'], 
                                        'nama_bahan' => $row['nama_bahan'], 
                                        'satuan' => $row['satuan'], 
                                        'LT' => $row['LT'], 
                                        'level' => $row['level'], 
                                        'rop' => $row['rop'], 
                                        'mrp' => array(
                                                        'GR' => [],
                                                        'SR' => [],
                                                        'OHI' => [],
                                                        'NR' => [],
                                                        'POR' => [],
                                                        'PORel' => []
                                                        )
                                        );
    }


    foreach ($tmp_data as $key => $row) {
        $data[$row['id_bahan']]['mrp']['GR'][$row['minggu']] = $row['GR'];
        $data[$row['id_bahan']]['mrp']['SR'][$row['minggu']] = $row['SR'];
        $data[$row['id_bahan']]['mrp']['OHI'][$row['minggu']] = $row['OHI'];
        $data[$row['id_bahan']]['mrp']['NR'][$row['minggu']] = $row['NR'];
        $data[$row['id_bahan']]['mrp']['POR'][$row['minggu']] = $row['POR'];
        $data[$row['id_bahan']]['mrp']['PORel'][$row['minggu']] = $row['POREL'];
    }


}else{
    //echo "disini";
    /*$data = $mrp->get_mrp($con, $id_bom, $mps, $b, $thn);
    
    $data_porel = $mrp->get_porel();

    foreach ($data_porel as $key => $value) {
        foreach ($value as $a => $c) {
            if($c['date']>=0){
                $weeks = get_week($b, $thn);
                $data_porel[$key][$a]['tgl'] = $weeks[$c['date']];
            }else{ 
                $bb = $b-1;
                $cb = 5 + $c['date'];
                $weeks = get_week($bb, $thn);
                $data_porel[$key][$a]['tgl'] = $weeks[$cb];
            }
        }
    }*/
/*
    mysqli_autocommit($con,FALSE);
    $process = [];
    // insert mrp
    foreach ($data as $key => $value) {
        $weeks = get_week($b, $thn);
        for($i=0; $i<=4; $i++){
            
            $g = $value['mrp']['GR'][$i];
            $s = $value['mrp']['SR'][$i];
            $o = $value['mrp']['OHI'][$i];
            $n = $value['mrp']['NR'][$i];
            $p = $value['mrp']['POR'][$i];
            $pr = $value['mrp']['PORel'][$i];
            $week = date("Y-m-d", strtotime($weeks[$i]));
            $sql = "INSERT INTO mrp (id_bom, id_bahan, bulan, minggu, GR, SR, OHI, NR, POR, POREL) VALUES ";
            $sql .= "($id_bom, $value[id_bahan], '$week', $i, $g, $s, $o, $n, $p, $pr)";
            if(mysqli_query($con, $sql)){
                $process[] = 1; 
            }else{
                $process[] = 0; 
            }
        }
    }

    // perencanaan bahan baku
    foreach ($data_porel as $k => $row){
        foreach ($row as $c => $d){
            $week = date("Y-m-d", strtotime($d['tgl']));
            $sql =  "INSERT INTO pengadaan (id_user, id_bahan, tgl_pengadaan, jumlah, keterangan, sts) VALUES ";
            $sql .= "(4, $k, '$week', $d[val], 'MRP', 0)";
            //echo "$sql<br>"; 
            if(mysqli_query($con, $sql)){
                $process[] = 1; 
            }else{
                $process[] = 0; 
            } 
        }
    }

    // pengeluran bahan baku
    foreach ($data as $key => $value) {
        foreach ($value['mrp']["GR"] as $k => $v) {
            if($k>0){
                if($v>0){
                    $weeks = get_week($b, $thn);
                    $week = date("Y-m-d", strtotime($weeks[$k]));
                    $sql = "INSERT INTO pengeluaran (id_bahan, tgl_pengeluaran, jumlah, keterangan, sts) VALUES ";
                    $sql .= "($key, '$week', $v, 'Produksi', 0)";
                    if(mysqli_query($con, $sql)){
                        $process[] = 1; 
                    }else{
                        $process[] = 0; 
                    }
                }
            }
        }
    } 

    if(!in_array(0, $process)){
        mysqli_commit($con);
    }else{
        mysqli_rollback($con);
    }*/

}

?>
    </pre>
    <?php
    foreach ($data as $k => $row):
    ?>
    <table class="table table-bordered tbl_mrp">
        <thead class="thead-dark">
            <tr>
                <th width="20%">Item</th>
                <th width="80%" colspan="5">Minggu</th>
            </tr>
            <tr>
                <th class="text-left">
                    <?= $row['nama_bahan']; ?> (<?= $row['satuan']; ?>) <br>
                    LT : <?= $row['LT']; ?>, Lvl : <?= $row['level']; ?>
                </th>
                <th width="10%">0</th>
                <th width="10%">1</th>
                <th width="10%">2</th>
                <th width="10%">3</th>
                <th width="10%">4</th>
            </tr>
        </thead>
        <tbody class="thead-dark">
        <?php
            foreach ($row['mrp'] as $namrp => $val):
        ?>
            <tr>
                <th><?= $namrp; ?></th>
                <?php
                foreach ($val as $a => $b) {
                    //if($b==0)$b='';
                    echo "<td>$b</td>";
                }
                ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>
