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
	
	if($_POST['btnSimpan']=='Tambah'){
		$sql = "INSERT INTO bom (nama_bom, satuan, jumlah, LT) VALUES ('$nama_bom', '$satuan', $jumlah, $LT)";
		
	}else if($_POST['btnSimpan']=='Ubah'){
		$sql = "UPDATE bom SET nama_bom = '$nama_bom', satuan = '$satuan', jumlah = $jumlah, LT = $LT WHERE id_bom=$id_bom";
		/*
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
		}*/
	}

	if(mysqli_query($con, $sql)){
		if($_POST['btnSimpan']=='Tambah'){
			$id_bom = mysqli_insert_id($con);
		}
		foreach ($_POST['id_bahan'] as $k => $v) {
			$id_bahan = $v;
			$jml_bahan = $_POST['jumlah_bahan'][$k];
			$lvl_bahan = $_POST['level_bahan'][$k];
			$parent = $_POST['parent_bahan'][$k];
			$sql = "SELECT * FROM bom_detail WHERE id_bom = $id_bom AND id_bahan = $id_bahan AND parent = $parent";
			$q = mysqli_query($con, $sql);
			if(mysqli_num_rows($q)>0){
				$sql2 = "UPDATE bom_detail SET jumlah = $jml_bahan, level = $lvl_bahan, parent = $parent WHERE id_bom = $id_bom AND id_bahan = $id_bahan";
			}else{
				$sql2 = "INSERT INTO bom_detail (id_bom, id_bahan, jumlah, level, parent) VALUES ($id_bom, $id_bahan, $jml_bahan, $lvl_bahan, $parent)";
			}
			echo $sql2."<br>";
			if(mysqli_query($con, $sql2)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
			}
		}
		$sql = "SELECT id_bahan,parent FROM bom_detail WHERE id_bom = $id_bom";
		$q = mysqli_query($con, $sql);
		$idbarr = [];
		$parr = [];
		while($row = mysqli_fetch_array($q)){
			$idbarr[] = $row['id_bahan'];
			$parr[] = $row['parent'];
		}
		foreach ($idbarr as $k => $v) {
			if(!in_array($v, $_POST['id_bahan'])){
				$p = $parr[$k];
				$sqlqq = "DELETE FROM bom_detail WHERE id_bom = $id_bom AND id_bahan = $v AND parent = $p";
				if(mysqli_query($con, $sqlqq)){
					$proses[] = 1;
				}else{
					$proses[] = 0;
				}
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