<?php

	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$host	= 'localhost';
	$user	= 'root';
	$pass	= '';
	$db		= 'dbmrp';

	$con=mysqli_connect($host, $user, $pass, $db);
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	function direct($link){
		echo '<script>document.location="'.$link.'"</script>';
	}

	function get_jabatan($id = null){
		$jab = ["Atasan", "PPIC", "Gudang", "Pengadaan", "Produksi"];
		if(is_null($id)){
			return $jab;
		}else{
			return $jab[$id];
		}
	}

	function get_satuan(){
		$sat = ["Ton", "Kg", "Liter"];
		if(is_null($id)){
			return $sat;
		}
	}

	function get_bahan($id){
		$sql = "SELECT a.*, b.nama_bahan, b.satuan FROM bom_detail a JOIN bahan b ON a.id_bahan = b.id_bahan WHERE a.id_bom = $id ORDER BY a.level ASC";
		$q = mysqli_query($GLOBALS['con'], $sql);
		$id = 0;
		$data = [];
		while($row = mysqli_fetch_array($q)){
			$data[] = array(
									'id_bom_detail' => $row['id_bom_detail'],
									'id_bahan' => $row['id_bahan'],
									'jumlah' => $row['jumlah'],
									'level' => $row['level'],
									'nama_bahan' => $row['nama_bahan'],
									'satuan' => $row['satuan'],
									);  
			/*if($row['level']==1){
				$data[$id] = array(
									'id_menu_detail' => $row['id_menu_detail'],
									'id_bahan' => $row['id_bahan'],
									'jumlah' => $row['jumlah'],
									'level' => $row['level'],
									'nama_bahan' => $row['nama_bahan'],
									'satuan' => $row['satuan'],
									);  
				$id++;

			}else{
				if(!isset($current_level)){
					$current_level = $row['level'];
				}
				if(!isset($j)){
					$j==0;
				}
				$parent = $id-1;
				$data[$parent]['child'][] = array(
											'id_menu_detail' => $row['id_menu_detail'],
											'id_bahan' => $row['id_bahan'],
											'jumlah' => $row['jumlah'],
											'level' => $row['level'],
											'nama_bahan' => $row['nama_bahan'],
											'satuan' => $row['satuan'],
											);
				$j++;
			}*/
		}
		return $data;
	}

	function gen_tab($jml=0){
		$ret = "";
		if($jml>0){
			for($i = 0; $i < $jml; $i++){
				$ret .= "\t";
			}
		}
		return $ret;
	}
?>