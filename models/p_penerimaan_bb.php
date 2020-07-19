<?php

require_once("../config/koneksi.php");
if(isset($_POST['btnSimpan'])){
	$id_pengadaan = isset($_POST['id_pengadaan'])?$con->real_escape_string($_POST['id_pengadaan']):'';
	$id_bahan = isset($_POST['id_bahan'])?$con->real_escape_string($_POST['id_bahan']):'';
	$tgl_penerimaan = isset($_POST['tgl_penerimaan'])?$con->real_escape_string($_POST['tgl_penerimaan']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
	
	$id_user = $_SESSION['user'];

	$proses = 0;
	if($_POST['btnSimpan']=="Simpan"){
		$sql = "UPDATE pengadaan SET tgl_penerimaan = '$tgl_penerimaan', sts = $id_user WHERE id_pengadaan = '$id_pengadaan'";
		if(mysqli_query($con, $sql)){
			$sql = "SELECT jumlah FROM bahan WHERE id_bahan = $id_bahan";
			$q = mysqli_query($con, $sql);
			while($row = mysqli_fetch_array($q)){
				$jumlah += $row['jumlah'];
			}
			$sql = "UPDATE bahan SET jumlah = $jumlah WHERE id_bahan = $id_bahan";
			$q = mysqli_query($con, $sql);
			if(mysqli_query($con, $sql)){
				$proses = 1;
			}
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
		echo mysqli_error($con);
	}

	header("location:../index.php?p=penerimaan_bb");
}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
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
	header("location:../index.php?p=penerimaan_bb");
}

?>

