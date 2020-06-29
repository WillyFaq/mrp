<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_user = isset($_POST['id_user'])?$con->real_escape_string($_POST['id_user']):'';
	$username = isset($_POST['username'])?$con->real_escape_string($_POST['username']):'';
	$password = isset($_POST['password'])?$con->real_escape_string($_POST['password']):'';
	$nama_user = isset($_POST['nama_user'])?$con->real_escape_string($_POST['nama_user']):'';
	$jabatan = isset($_POST['jabatan'])?$con->real_escape_string($_POST['jabatan']):'';

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO user (username,  password,  nama_user,  jabatan)  VALUES ('$username', '$password',  '$nama_user',  '$jabatan')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE user SET username = '$username',  password = '$password',  nama_user = '$nama_user',  jabatan = '$jabatan' WHERE id_user = '$id_user'";
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

	header("location:../index.php?p=user");
}

if(isset($_GET['id'])){
	$nip = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM user WHERE id_user = '$nip'";

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
	header("location:../index.php?p=user");
}

?>