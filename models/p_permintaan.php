<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_permintaan = isset($_POST['id_permintaan'])?$con->real_escape_string($_POST['id_permintaan']):'';
	$id_bom = isset($_POST['id_bom'])?$con->real_escape_string($_POST['id_bom']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
	$tanggal = isset($_POST['tanggal'])?$con->real_escape_string($_POST['tanggal']):'';

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO permintaan (id_bom, jumlah, tanggal)  VALUES ($id_bom, $jumlah, '$tanggal')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE permintaan SET id_bom = $id_bom, jumlah = $jumlah, tanggal = '$tanggal' WHERE id_permintaan = $id_permintaan";
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

	header("location:../index.php?p=permintaan");
}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM permintaan WHERE id_permintaan = '$id'";

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
	header("location:../index.php?p=permintaan");
}

?>