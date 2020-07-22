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
		$jab = ["Atasan", "PPIC", "Gudang", "Pengadaan", "Produksi", "Admin Web"];
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

	function get_bulan($bln=''){
		$bulan = ["", 
					"January", 
					"Februari", 
					"Maret",
					"April",
					"Mei",
					"Juni",
					"Juli",
					"Agustus",
					"September",
					"Oktober",
					"November",
				];
		unset($bulan[0]);
		if($bln!=''){
			return $bulan[$bln];
		}else{
			return $bulan;
		}
	}

	
	function get_week($b, $thn){
	    $month = date("F", strtotime("01-$b-$thn"));
	    $weeks = array();
	    $firstDayOfMonth = new DateTime("1st $month");
	    $lastDayOfMonth = new DateTime($firstDayOfMonth->format('t M Y'));
	    $oneDay = new DateInterval('P1D');
	    $period = new DatePeriod($firstDayOfMonth, $oneDay, $lastDayOfMonth->add($oneDay));
	    $tmp_w = -1;
	    foreach($period as $date){
	        $w = intval($date->format('W')) - intval($firstDayOfMonth->format('W'));
	        if($tmp_w!=$w){
	            $weeks[$w] = $date->format('d-m-Y');
	            $tmp_w = $w;
	        }
	    }
	    return $weeks;
	}

	class MRP{

		private $data_porel;

		function get_mrp($con, $id_bom, $mps, $b, $thn){
			$sql = "SELECT 
			            a.*,
			            b.*,
			            c.nama_bahan,
			            c.satuan,
			            c.LT,
			            c.rop
			        FROM bom a 
			        JOIN bom_detail b ON a.id_bom = b.id_bom 
			        JOIN bahan c ON b.id_bahan = c.id_bahan 
			        WHERE a.id_bom = $id_bom";
			$q = mysqli_query($con, $sql);
			$data = [];
			$i = 0;
			while($row = mysqli_fetch_array($q)){
			    $GR = [];
			    $SR = [];
			    $OHI = [];
			    $NR = [];
			    $POR = [];
			    $POREL = [];
			    for ($k=0; $k<=sizeof($mps); $k++) {
			        $GR[$k]=0;
			        if($k>0){
			            $v = $mps[$k-1];
			            if($row['level']==1){
			                $GR[$k] = ($row['jumlah'] * $v);
			                $cur = $row['id_bahan'];
			            }else{
			                $jml = $data[$cur]['mrp']['GR'][$k];
			                $GR[$k] = $jml * $row['jumlah'];//($row['jumlah'] * $v);
			            }
			        }
			        $SR[$k]=0;
			        $OHI[$k]=0;
			        $NR[$k]=0;
			        $POR[$k]=0;
			        $POREL[$k]=0;
			    }
			    $bln = "00".$b;
			    $bln = substr($bln, strlen($bln)-2, 2);
			    $sql_sr = "SELECT 
			                    id_bahan,
			                    jumlah,
			                    WEEK(tgl_pengadaan) - WEEK('$thn-$bln-01') AS 'minggu' 
			                FROM pengadaan
			                WHERE MONTH(tgl_pengadaan) = $b AND id_bahan = $row[id_bahan]";
			    $q_sr = mysqli_query($con, $sql_sr);
			    while($row_sr = mysqli_fetch_array($q_sr)){
			        if($row_sr['minggu']==0){
			            $OHI[$row_sr['minggu']] += $row_sr["jumlah"];
			            $SR[$row_sr['minggu']] = 0;
			        }else{
			            $OHI[$row_sr['minggu']] += $row_sr["jumlah"];
			            $SR[$row_sr['minggu']] = $row_sr["jumlah"];
			        }
			    }
			    $bln = $b-1;
			    $sql_ohi = "SELECT 
			                  id_bahan,
			                  jumlah
			                FROM bahan
			                WHERE id_bahan = $row[id_bahan]";
			    $q_ohi = mysqli_query($con, $sql_ohi);
			    while($row_ohi = mysqli_fetch_array($q_ohi)){
			        $OHI[0] += $row_ohi["jumlah"];
			        $OHI[1] += $row_ohi["jumlah"];
			    }
			    $data[$row['id_bahan']] = array(
			                                    'id_bahan' => $row['id_bahan'],
			                                    'nama_bahan' => $row['nama_bahan'],
			                                    'satuan' => $row['satuan'],
			                                    'LT' => $row['LT'],
			                                    'level' => $row['level'],
			                                    'rop' => $row['rop'],
			                                    'mrp' => array(
			                                        'GR' => $GR,
			                                        'SR' => $SR,
			                                        'OHI' => $OHI,
			                                        'NR' => $NR,
			                                        'POR' => $POR,
			                                        'PORel' => $POREL)
			                                );
			    $i++;
			}

			$this->data_porel = [];
			foreach ($data as $key => $value) {
			    foreach ($value['mrp']['GR'] as $a => $c) {
			        if($a>0){
			            //$sr = 
			            $ohi = $data[$key]['mrp']['OHI'][$a];
			            $kur = $ohi - $c;
			            if($kur <= 0){
			                $data[$key]['mrp']['NR'][$a] += $c - $ohi;
			                $data[$key]['mrp']['POR'][$a] += $c - $ohi;
			                $data[$key]['mrp']['OHI'][$a] = $ohi;
			            }else{
			                if($a+1 <= 3){
			                    $data[$key]['mrp']['OHI'][$a+1] = $kur;
			                }
			            }



			            if($data[$key]['mrp']['NR'][$a]!=0){
			                $idx = $a-$value['LT'];
			                $idx = $idx<0?0:$idx;
			                $data[$key]['mrp']['PORel'][$idx] += $data[$key]['mrp']['NR'][$a];
			                $this->data_porel[$key][] = array(
			                                            "date" => $a-$value['LT'],
			                                            "val" => $data[$key]['mrp']['NR'][$a]
			                                            );
			            }
			        }
			    }
			}

			return $data;
		}

		public function get_porel(){
			return $this->data_porel;
		}
	}


	///-------------------------- Dahsboard Things

	function get_count_users(){
		$sql = "SELECT * FROM user";
  		$q = mysqli_query($GLOBALS['con'], $sql);
  		return mysqli_num_rows($q);
	}
	function get_count_bahan(){
		$sql = "SELECT * FROM bahan";
  		$q = mysqli_query($GLOBALS['con'], $sql);
  		return mysqli_num_rows($q);
	}
	function get_count_bom(){
		$sql = "SELECT * FROM bom";
  		$q = mysqli_query($GLOBALS['con'], $sql);
  		return mysqli_num_rows($q);
	}
	function get_count_permintaan(){
		$sql = "SELECT SUM(jumlah) AS 'total' FROM permintaan WHERE YEAR(tanggal) = '".date("Y")."' ";
  		$q = mysqli_query($GLOBALS['con'], $sql);
  		$tot = 0;
  		while($row = mysqli_fetch_array($q)){
  			$tot += $row['total'];
  		}
  		return $tot;
	}
?>