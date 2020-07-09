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
	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO mps (id_bom, bulan, M1, M2, M3, M4)  VALUES ($id_bom, '$bulan', $M1, $M2, $M3, $M4)";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE mps SET id_bom = $id_bom, bulan = '$bulan', M1 = $M1, M2 = $M2, M3 = $M3, M4 = $M4  WHERE id_mps = $id_mps";
		$proses = mysqli_query($con, $sql);
	}

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
	header("location:../index.php?p=mps");

}


?>