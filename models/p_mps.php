<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	//print_r($_POST);
	$id_mps = isset($_POST['id_mps'])?$con->real_escape_string($_POST['id_mps']):'';
	$id_bom = isset($_POST['id_bom'])?$con->real_escape_string($_POST['id_bom']):'';
	$bulan = isset($_POST['bulan'])?date("Y-m-d", mktime(0, 0, 0, $con->real_escape_string($_POST['bulan']), 1, date("Y"))):'';
	$M1 = isset($_POST['M1'])?$con->real_escape_string($_POST['M1']):'';
	$M2 = isset($_POST['M2'])?$con->real_escape_string($_POST['M2']):'';
	$M3 = isset($_POST['M3'])?$con->real_escape_string($_POST['M3']):'';
	$M4 = isset($_POST['M4'])?$con->real_escape_string($_POST['M4']):'';

	$M1 = $M1/1000; 
	$M2 = $M2/1000; 
	$M3 = $M3/1000; 
	$M4 = $M4/1000; 

	
	mysqli_autocommit($con,FALSE);
	$proses = [];
	if($_POST['btnSimpan']=="Tambah"){
		$sql = "SELECT * FROM mps WHERE id_bom = $id_bom AND bulan = '$bulan'";
		$q = mysqli_query($con, $sql);
		if(mysqli_num_rows($q)>0){
			$row = mysqli_fetch_array($q);
			$id_mps = $row['id_mps'];
			$sql = "UPDATE mps SET id_bom = $id_bom, bulan = '$bulan', M1 = $M1, M2 = $M2, M3 = $M3, M4 = $M4  WHERE id_mps = $id_mps";
			$proses[] = mysqli_query($con, $sql)?1:0;
		}else{
			$sql = "INSERT INTO mps (id_bom, bulan, M1, M2, M3, M4)  VALUES ($id_bom, '$bulan', $M1, $M2, $M3, $M4)";
			$proses[] = mysqli_query($con, $sql)?1:0;
			$id_mps = mysqli_insert_id($con);
		}
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE mps SET id_bom = $id_bom, bulan = '$bulan', M1 = $M1, M2 = $M2, M3 = $M3, M4 = $M4  WHERE id_mps = $id_mps";
		$proses[] = mysqli_query($con, $sql)?1:0;
	}

	$sql = "SELECT * FROM mps ORDER BY bulan";
	$q = mysqli_query($con, $sql);
	$mps = [];
	while($row = mysqli_fetch_array($q)){
		$mps[$row['id_mps']] = array(
									'id_mps' => $row['id_mps'],
									'id_bom' => $row['id_bom'],
									'bulan' => $row['bulan'],
									'M' => [ $row['M1'], $row['M2'], $row['M3'], $row['M4'] ],
									);
	}

	$sql = "DELETE FROM mrp";
	$proses[] = mysqli_query($con, $sql)?1:0;

	$mrp = new MRP();
	$data = [];
	foreach ($mps as $k => $v) {
		$b = date("m", strtotime($v['bulan']));
		$t = date("Y", strtotime($v['bulan']));
		$data[$k] =  $mrp->get_mrp($con, $v['id_bom'], $v['M'], (int)$b, $t);
		$data_porel[$k] = $mrp->get_porel();
		//print_pre($data_porel[$k]);
	    foreach ($data_porel[$k] as $key => $value) {
	        foreach ($value as $a => $c) {
	        	if($c['date']>=0){
	                $weeks = get_week($b, $t);
	                $data_porel[$k][$key][$a]['tgl'] = $weeks[$c['date']];
	            }else{ 
	                $bb = $b-1;
	                $cb = 5 + $c['date'];
	                $weeks = get_week($bb, $t);
	                $data_porel[$k][$key][$a]['tgl'] = $weeks[$cb];
	            }
	        }
	    }
	    //print_pre($data_porel[$k]);
	    //$data[$k]['porel'] = $data_porel; 
	    $p_mrp = insert_mrp($con, $data[$k], $v['id_bom'], (int)$b, $t);
	    $p_perencanaan = insert_perencanaan($con, $data_porel[$k], (int)$b, $t, $v['id_bom']);
	    $p_pengeluaran = insert_pengeluaran($con, $data[$k], (int)$b, $t, $v['id_bom']);
	    $proses = array_merge($proses, $p_mrp);
	    $proses = array_merge($proses, $p_perencanaan);
	    $proses = array_merge($proses, $p_pengeluaran);

	}

	

	/*
	print_pre($data);
	print_pre($proses);*/
	if(!in_array(0, $proses)){
        mysqli_commit($con);
        $_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
    }else{
        mysqli_rollback($con);
        $_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
		echo mysqli_error($con);
    }

	/*if($proses){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
		echo mysqli_error($con);
	}
*/
	header("location:../index.php?p=mps");
}



function insert_mrp($con, $data, $id_bom, $b, $thn){
	$ret = [];
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
            $sql_cek = "SELECT * FROM mrp WHERE id_bom = $id_bom AND id_bahan = $value[id_bahan] AND bulan = '$week' AND minggu = $i ";
            $q = mysqli_query($con, $sql_cek);
            if(mysqli_num_rows($q)>0){
	            $row = mysqli_fetch_array($q);
	            $id_mrp = $row['id_mrp'];
	            $sql = "UPDATE mrp SET GR = $g, SR = $s, OHI = $o, NR = $n, POR = $p, POREL = $pr WHERE id_mrp = $id_mrp";
            }else{
	            $sql = "INSERT INTO mrp (id_bom, id_bahan, bulan, minggu, GR, SR, OHI, NR, POR, POREL) VALUES ";
	            $sql .= "($id_bom, $value[id_bahan], '$week', $i, $g, $s, $o, $n, $p, $pr)";
            }
            //echo "<hr>$sql<hr>";
            $ret[] = mysqli_query($con, $sql)?1:0;
        }
    }
    return $ret;
}

function insert_perencanaan($con, $data_porel, $b, $thn, $id_bom){
	$ret = [];
	foreach ($data_porel as $k => $row){
        foreach ($row as $c => $d){
        	$id_user = $_SESSION['user'];
            $week = date("Y-m-d", strtotime($d['tgl']));
            $sql_cek = "SELECT * FROM pengadaan WHERE id_bahan = $k AND tgl_pengadaan = '$week' AND idb = $id_bom ";
            $q = mysqli_query($con, $sql_cek);
            if(mysqli_num_rows($q)>0){
	            $row = mysqli_fetch_array($q);
	            $id_pengadaan = $row['id_pengadaan'];
	            $sql = "UPDATE pengadaan SET jumlah = $d[val] WHERE id_pengadaan = $id_pengadaan";
            }else{
	            $sql =  "INSERT INTO pengadaan (id_user, id_bahan, tgl_pengadaan, jumlah, keterangan, sts, idb) VALUES ";
	            $sql .= "($id_user, $k, '$week', $d[val], 'MRP', 0, $id_bom)";
            }
            //echo "$sql<br>";
            $ret[] = mysqli_query($con, $sql)?1:0;
        }
    }
    return $ret;
}

function insert_pengeluaran($con, $data, $b, $thn, $id_bom){
	$ret = [];
	foreach ($data as $key => $value) {
		//print_pre($value);
		/*if($value['id_bahan']==1){
        	print_pre($value['mrp']["GR"]);*/

		//}
        foreach ($value['mrp']["GR"] as $k => $v) {
            if($k>0){
                if($v>0){
                	//echo "$k => $v <br>";
                    $weeks = get_week($b, $thn);
                    $week = date("Y-m-d", strtotime($weeks[$k]));
                    $sql_cek = "SELECT * FROM pengeluaran WHERE id_bahan = $key AND tgl_pengeluaran = '$week' AND idb = $id_bom ";
		            
		            $q = mysqli_query($con, $sql_cek);
		            if(mysqli_num_rows($q)>0){
			            $row = mysqli_fetch_array($q);
			            $id_pengeluaran = $row['id_pengeluaran'];
			            $sql = "UPDATE pengeluaran SET jumlah = $v WHERE id_pengeluaran = $id_pengeluaran";
		            }else{
	                    $sql = "INSERT INTO pengeluaran (id_bahan, tgl_pengeluaran, jumlah, keterangan, sts, idb) VALUES ";
	                    $sql .= "($key, '$week', $v, 'Produksi', 0, $id_bom)";
	                }
					/*
            		echo "$k => $sql_cek<br>";
            		echo "$k => $sql<br>";
                    */
                    $ret[] = mysqli_query($con, $sql)?1:0;
                }
            }
        }
        //}
    } 
    return $ret;
}

?>