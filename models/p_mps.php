<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_mps = isset($_POST['id_mps'])?$con->real_escape_string($_POST['id_mps']):'';
	$id_bom = isset($_POST['id_bom'])?$con->real_escape_string($_POST['id_bom']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
	$tanggal = isset($_POST['tanggal'])?$con->real_escape_string($_POST['tanggal']):'';

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO mps (id_bom, jumlah, tanggal)  VALUES ($id_bom, $jumlah, '$tanggal')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE mps SET id_bom = $id_bom, jumlah = $jumlah, tanggal = '$tanggal' WHERE id_mps = $id_mps";
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

	header("location:../index.php?p=prod_schedule");
}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM mps WHERE id_mps = '$id'";

	$proses = mysqli_query($con, $sql);
	if($proses){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil dihapus!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal dihapus!";
	}
	header("location:../index.php?p=prod_schedule");
}

?>