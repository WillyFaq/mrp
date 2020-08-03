<?php

require_once("../config/koneksi.php");

if(isset($_GET['ket'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "SELECT * FROM pengeluaran WHERE id_pengeluaran = $id";
    $q = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($q);
    $id_bahan = $row['id_bahan'];
    $jumlah = $row['jumlah'];

    $update = "UPDATE pengeluaran SET sts = 1 WHERE id_pengeluaran = $id";
    $proses = 0;
    if(mysqli_query($con, $update)){
        $sql = "SELECT jumlah FROM bahan WHERE id_bahan = $id_bahan";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)){
            $jumlah = $row['jumlah'] - $jumlah;
        }
        $sql = "UPDATE bahan SET jumlah = $jumlah WHERE id_bahan = $id_bahan";
        $q = mysqli_query($con, $sql);
        if(mysqli_query($con, $sql)){
            $proses = 1;
        }
    }
	if($proses==1){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
	}
	header("location:../index.php?p=pengeluaran_bb");
}

?>