<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_bahan = isset($_POST['id_bahan'])?$con->real_escape_string($_POST['id_bahan']):'';
	$nama_bahan = isset($_POST['nama_bahan'])?$con->real_escape_string($_POST['nama_bahan']):'';
	$satuan = isset($_POST['satuan'])?$con->real_escape_string($_POST['satuan']):'';

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO bahan (nama_bahan, satuan, jumlah)  VALUES ('$nama_bahan', '$satuan', 0)";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE bahan SET nama_bahan = '$nama_bahan',  satuan = '$satuan' WHERE id_bahan = '$id_bahan'";
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

	header("location:../index.php?p=bahan");
}

if(isset($_GET['id'])){
	$nip = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM bahan WHERE id_bahan = '$nip'";

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
	header("location:../index.php?p=bahan");
}

?>