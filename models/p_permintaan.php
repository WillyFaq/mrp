<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_permintaan = isset($_POST['id_permintaan'])?$con->real_escape_string($_POST['id_permintaan']):'';
	$id_bom = isset($_POST['id_bom'])?$con->real_escape_string($_POST['id_bom']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
    $jumlah = $jumlah/1000;
	$tanggal = isset($_POST['tanggal'])?$con->real_escape_string($_POST['tanggal']):'';

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO permintaan (id_bom, jumlah, tanggal)  VALUES ($id_bom, $jumlah, '$tanggal')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
        $sql = "SELECT * FROM permintaan WHERE id_permintaan = $id_permintaan";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)){
            $tgl = $row['tanggal'];
        }
        if(cek_mps($con, $tgl)){
            $_SESSION["flash"]["type"] = "danger";
            $_SESSION["flash"]["head"] = "Terjadi Kesalahan";
            $_SESSION["flash"]["msg"] = "Data sedang digunakan!";

            header("location:../index.php?p=permintaan");
            exit();
        }else{
    		$sql = "UPDATE permintaan SET id_bom = $id_bom, jumlah = $jumlah, tanggal = '$tanggal' WHERE id_permintaan = $id_permintaan";
    		$proses = mysqli_query($con, $sql);
        }
	}

	ssdanrop($con);

	if($proses){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
		echo mysqli_error($con);
	}

	header("location:../index.php?p=permintaan");
}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';

    $sql = "SELECT * FROM permintaan WHERE id_permintaan = $id";
    $q = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($q)){
        $tgl = $row['tanggal'];
    }
    if(cek_mps($con, $tgl)){
        $_SESSION["flash"]["type"] = "danger";
        $_SESSION["flash"]["head"] = "Terjadi Kesalahan";
        $_SESSION["flash"]["msg"] = "Data sedang digunakan!";
    }else{
        $sql = "DELETE FROM permintaan WHERE id_permintaan = '$id'";
        $proses = mysqli_query($con, $sql);
        if($proses){
            ssdanrop($con);
            $_SESSION["flash"]["type"] = "success";
            $_SESSION["flash"]["head"] = "Sukses";
            $_SESSION["flash"]["msg"] = "Data berhasil dihapus!";
        }else{
            $_SESSION["flash"]["type"] = "danger";
            $_SESSION["flash"]["head"] = "Terjadi Kesalahan";
            $_SESSION["flash"]["msg"] = "Data gagal dihapus!";
        }   
    }
	
	header("location:../index.php?p=permintaan");
}

function cek_mps($con, $tgl){
    $sql = "SELECT * FROM mps WHERE MONTH(bulan) = MONTH('$tgl')";
    $q = mysqli_query($con, $sql);
    $nr = mysqli_num_rows($q);
    if($nr>0){
        return true;
    }else{
        return false;
    }
}

function ssdanrop($con){
    $tmp_data = [];
    $sql = "SELECT 
                a.*, 
                b.nama_bom, 
                b.satuan,
                d.id_bahan,
                d.nama_bahan,
                d.LT,
                c.jumlah AS 'per_parent',
                c.level
            FROM permintaan a 
            JOIN bom b ON a.id_bom = b.id_bom 
            JOIN bom_detail c ON b.id_bom = c.id_bom
            JOIN bahan d ON c.id_bahan = d.id_bahan
            ORDER BY tanggal DESC, d.id_bahan ASC";
    $q = mysqli_query($con, $sql);
    
    while($row = mysqli_fetch_array($q)){
        $d = [];
        if($row['level']==1){
            $jml = $row['jumlah'] * $row['per_parent'];
            $d = array(
                        'nama_bahan' => $row['nama_bahan'],
                        'jumlah' => $row['jumlah'],
                        'per_parent' => $row['per_parent'],
                        'level' => $row['level'],
                        'butuh' => $jml,
                        'LT' => $row['LT']
                        );
        }else{
            $d = array(
                        'nama_bahan' => $row['nama_bahan'],
                        'jumlah' => $row['jumlah'],
                        'per_parent' => $row['per_parent'],
                        'level' => $row['level'],
                        'butuh' => $jml * $row['per_parent'],
                        'LT' => $row['LT']
                        );
        }
        $tmp_data[$row['id_permintaan']][$row['id_bahan']] = $d;
    }
    $max = [];
    $sum = [];
    $count = [];
    $LT_arr = [];
    foreach ($tmp_data as $k => $v) {
        foreach ($v as $a => $b) {
            if(!isset($max[$a])){
                $max[$a] = $b['butuh'];
            }else{
                if($b['butuh']>$max[$a]){
                    $max[$a] = $b['butuh'];
                }
            }
            if(!isset($sum[$a])){
                $sum[$a] = $b['butuh'];
                $count[$a] = 1;
            }else{
                $sum[$a] += $b['butuh'];
                $count[$a] += 1;
            }
            $LT_arr[$a] = $b['LT'];
        }
    }
    $avg = [];
    foreach ($sum as $a => $b) {
        $avg[$a] = $sum[$a] / $count[$a];
    }
    $data = [];
    foreach ($sum as $k => $v) {
        $LTD = $LT_arr[$k] * $avg[$k];
        $ss = ($LT_arr[$k] * $max[$k]) - ($LT_arr[$k] * $avg[$k]);
        $rop = $ss + $LTD;
        $sql = "UPDATE bahan SET ss = $ss, rop = $rop WHERE id_bahan = $k";
        $pp = mysqli_query($con, $sql);
        //echo '<script>alert("'.$sql.'");</script>';
    }
}

?>