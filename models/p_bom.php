<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	
	$id_bom = isset($_POST['id_bom'])?$con->real_escape_string($_POST['id_bom']):'';
	$nama_bom = isset($_POST['nama_bom'])?$con->real_escape_string($_POST['nama_bom']):'';
	$jumlah = isset($_POST['jumlah'])?$con->real_escape_string($_POST['jumlah']):'';
	$satuan = isset($_POST['satuan'])?$con->real_escape_string($_POST['satuan']):'';
	$LT = isset($_POST['LT'])?$con->real_escape_string($_POST['LT']):'';

	$proses = [];
	mysqli_autocommit($con,FALSE);
	
	if($_POST['btnSimpan']=='Ubah'){
		$sql = "DELETE FROM bom WHERE id_bom = $id_bom";
		if(mysqli_query($con, $sql)){
			mysqli_commit($con);
			$proses[] = 1;
		}else{
			mysqli_rollback($con);
			$proses[] = 0;
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
			header("location:../index.php?p=bom");
			exit();
		}
	}



	$sql = "INSERT INTO bom (nama_bom, satuan, jumlah, LT) VALUES ('$nama_bom', '$satuan', $jumlah, $LT)";
	if(mysqli_query($con, $sql)){
		$id_bom = mysqli_insert_id($con);
		foreach ($_POST['id_bahan'] as $k => $v) {
			$id_bahan = $v;
			$jml_bahan = $_POST['jumlah_bahan'][$k];
			$lvl_bahan = $_POST['level_bahan'][$k];
			//echo "$id_bahan - $jml_bahan - $lvl_bahan <br>";
			$sql2 = "INSERT INTO bom_detail (id_bom, id_bahan, jumlah, level) VALUES ($id_bom, $id_bahan, $jml_bahan, $lvl_bahan)";
			if(mysqli_query($con, $sql2)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
			}
		}
	}else{
		$proses[] = 0;
	}

	if($proses){
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
	header("location:../index.php?p=bom");
}


if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM bom WHERE id_bom = $id";

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
	header("location:../index.php?p=bom");
}

?>