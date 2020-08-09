<?php

require_once("../config/koneksi.php");
if(isset($_POST['btnSimpan'])){
	$id_pengadaan = isset($_POST['id_pengadaan'])?$con->real_escape_string($_POST['id_pengadaan']):'';
	$id_bahan = isset($_POST['id_bahan'])?$con->real_escape_string($_POST['id_bahan']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
	$tgl_pengadaan = isset($_POST['tgl_pengadaan'])?$con->real_escape_string($_POST['tgl_pengadaan']):'';
	$keterangan = isset($_POST['keterangan'])?$con->real_escape_string($_POST['keterangan']):'';

	$id_user = $_SESSION['user'];

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO pengadaan (id_user, id_bahan, tgl_pengadaan, jumlah, keterangan)  VALUES ($id_user, $id_bahan, '$tgl_pengadaan', $jumlah, '$keterangan')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE pengadaan SET id_user = $id_user, id_bahan = '$id_bahan', tgl_pengadaan = '$tgl_pengadaan', jumlah = '$jumlah', keterangan = '$keterangan' WHERE id_pengadaan = '$id_pengadaan'";
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

	header("location:../index.php?p=pengadaan_bb");
}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "SELECT * FROM pengadaan WHERE id_pengadaan = '$id'";
	$q = mysqli_query($con, $sql);
	$sts = 0;
	while($row = mysqli_fetch_array($q)){
		$sts = $row['sts'];
		$jml = $row['jumlah'];
		if($sts != 0){
			$sql = "SELECT * FROM bahan WHERE id_bahan = $row[id_bahan]";
			$q = mysqli_query($con, $sql);
			$jmlbhn = 0;
			while($brow = mysqli_fetch_array($q)){
				$jmlbhn = $brow['jumlah'];
			}
			$jml = $jmlbhn - $jml;
			$sql = "UPDATE bahan SET jumlah = $jml WHERE id_bahan = $row[id_bahan]";
		}
	}


	$sql = "DELETE FROM pengadaan WHERE id_pengadaan = '$id'";

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
	header("location:../index.php?p=pengadaan_bb");
}

?>

