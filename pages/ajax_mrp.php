<?php
    require_once("../config/koneksi.php");
	if(isset($_GET['table'])):
        $id_bom = $_GET['id_bom'];
?>
	<table class="table table-bordered tbl_mrp">
		<thead class="thead-dark">
			<tr>
				<th width="28%" rowspan="2">Menu</th>
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
            $b = $_GET['table'];
            $thn = date("Y");
            $sql = "SELECT * FROM mps a JOIN bom b ON a.id_bom = b.id_bom WHERE MONTH(a.bulan) = $b AND YEAR(a.bulan) = $thn AND a.id_bom = $id_bom ORDER BY bulan DESC";
            $q = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($q)):
                $mps[] = $row["M1"];
                $mps[] = $row["M2"];
                $mps[] = $row["M3"];
                $mps[] = $row["M4"];
        ?>
            <tr>
                <td class="text-left"><?= $row['nama_bom']; ?></td>
                <td>
                    <?= $row['M1']; ?>
                </td>
                <td>
                    <?= $row['M2']; ?>
                </td>
                <td>
                    <?= $row['M3']; ?>
                </td>
                <td>
                    <?= $row['M4']; ?>
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

$sql = "SELECT * FROM mrp WHERE id_bahan IN (".join($id_bahan, ",").") AND MONTH(bulan) = $b";
$q = mysqli_query($con, $sql);

if(mysqli_num_rows($q)>0){

}else{
    $data = $mrp->get_mrp($con, $id_bom, $mps, $b, $thn);
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
    }

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
            $sql = "INSERT INTO mrp (id_bahan, bulan, minggu, GR, SR, OHI, NR, POR, POREL) VALUES ";
            $sql .= "($value[id_bahan], $weeks[$i], $i, $g, $s, $o, $n, $p, $pr)";
            echo "$sql<br>";
        }
        echo "<hr>";
    }

    // perencanaan bahan baku
    foreach ($data_porel as $k => $row){
        foreach ($row as $c => $d){
            $sql =  "INSERT INTO pengadaan (id_user, id_bahan, tgl_pengadaan, jumlah, keterangan) VALUES ";
            $sql .= "(4, $k, '$d[tgl]', $d[val], 'MRP')";
            //echo "$sql<br>";  
        }
    }

    // pengeluran bahan baku
    foreach ($data as $key => $value) {
        foreach ($value['mrp']["GR"] as $k => $v) {
            if($k>0){
                //$cb = 5 + $k;
                $weeks = get_week($b, $thn);
                //print_r($weeks);
                //echo "$v - ".$weeks[$k]."<br>";
            }
        }
        //echo "<hr>";
    }   

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
