<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-home"></i> Home</h1>
</div>
<div class="row">
    <!-- Users -->
    <div class="col-xl-3 col-md-6 mb-4">
      	<div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          	<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              	<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
		              	<?php
		              		
		              	?>
		              	<div class="h5 mb-0 font-weight-bold text-gray-800 counter-dash"><?= get_count_users(); ?></div>
		            </div>
		            <div class="col-auto">
		              	<i class="fas fa-users fa-2x text-gray-300"></i>
		            </div>
	          	</div>
	        </div>
      	</div>
    </div>
    <!-- Bahan -->
    <div class="col-xl-3 col-md-6 mb-4">
      	<div class="card border-left-success shadow h-100 py-2">
	        <div class="card-body">
	          	<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              	<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Bahan Baku</div>
		              	<div class="h5 mb-0 font-weight-bold text-gray-800 counter-dash"><?= get_count_bahan(); ?></div>
		            </div>
		            <div class="col-auto">
		              	<i class="fas fa-flask fa-2x text-gray-300"></i>
		            </div>
	          	</div>
	        </div>
      	</div>
    </div>
    <!-- BOM -->
    <div class="col-xl-3 col-md-6 mb-4">
      	<div class="card border-left-warning shadow h-100 py-2">
	        <div class="card-body">
	          	<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              	<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">BOM</div>
		              	<div class="h5 mb-0 font-weight-bold text-gray-800 counter-dash"><?= get_count_bom(); ?></div>
		            </div>
		            <div class="col-auto">
		              	<i class="fas fa-sitemap fa-2x text-gray-300"></i>
		            </div>
	          	</div>
	        </div>
      	</div>
    </div>
    <!-- Permintaan -->
    <div class="col-xl-3 col-md-6 mb-4">
      	<div class="card border-left-danger shadow h-100 py-2">
	        <div class="card-body">
	          	<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              	<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Permintaan</div>
		              	<div class="h5 mb-0 font-weight-bold text-gray-800 counter-dash"><?= get_count_permintaan(); ?></div>
		            </div>
		            <div class="col-auto">
		              	<i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
		            </div>
	          	</div>
	        </div>
      	</div>
    </div>


</div>
<div class="row">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Permintaan</h6>
            </div>
            <div class="card-body">
            	<canvas id="permintaanLineChart" height="300px"></canvas>
            </div>
        </div>
    </div>

	<!-- <div class="col mb-4">
		<div class="card shadow mb-4">
	            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
	                <h6 class="m-0 font-weight-bold text-primary">Permintaan</h6>
	            </div>
	            <div class="card-body">
	            </div>
	        </div>
	    </div> -->
</div>

<pre>
<?php
	$sql = "SELECT 
				a.id_bom,
				b.nama_bom,
				SUM(a.jumlah) AS 'jumlah',
				a.tanggal
			FROM permintaan a
			JOIN bom b ON a.id_bom = b.id_bom
			GROUP BY MONTH(a.tanggal)";
	$q = mysqli_query($con, $sql);
	$data_line = [];
	$tmp_data = [];
	$labels = [];
	$i = 0;
	while($row = mysqli_fetch_array($q)){
		$tmp_data[] = $row;
		$data_line[$row['id_bom']] = array(
											"label" => $row['nama_bom'],
											"backgroundColor" => "COLORS[$i]",
											"borderColor" => "COLORS[$i]",
											"data" => [],
										);
		$labels[] = date("F", strtotime($row['tanggal']));
		$i++;
	}

	foreach ($tmp_data as $key => $value) {
		$data_line[$value['id_bom']]["data"][] = $value['jumlah'];
	}
	//print_r($data_line);
?>
</pre>

<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/vendor/chart.js/utils.js"></script>
<script type="text/javascript">
	Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	Chart.defaults.global.defaultFontColor = '#858796';

	var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var COLORS = [
		'#4dc9f6',
		'#f67019',
		'#f53794',
		'#537bc4',
		'#acc236',
		'#166a8f',
		'#00a950',
		'#58595b',
		'#8549ba'
	];
	var config = {
		type: 'line',
		data: {
			labels: ["<?= join($labels, '", "'); ?>"],
			datasets: [
			<?php
				foreach ($data_line as $k => $v) {
			?>
			{
				label: '<?= $v["label"]; ?>',
				backgroundColor: <?= $v["backgroundColor"]; ?>,
				borderColor: <?= $v["borderColor"]; ?>,
				data: [<?= join($v['data'], ', '); ?>],
				fill: false,
			},
			<?php
				}
			?>
			]
			/*{
				label: 'My First dataset',
				backgroundColor: COLORS[0],
				borderColor: COLORS[0],
				data: [
					100,
					200,
					100,
					300,
					200,
					500,
					300
				],
				fill: false,
			}*/
		},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			title: {
				display: false
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			legend: {
		      position: "bottom"
		    },
		}
	};


	window.onload = function() {
		var ctx = document.getElementById('permintaanLineChart').getContext('2d');
		window.myLine = new Chart(ctx, config);
	};


	function number_format(number, decimals, dec_point, thousands_sep) {
	  // *     example: number_format(1234.56, 2, ',', ' ');
	  // *     return: '1 234,56'
	  number = (number + '').replace(',', '').replace(' ', '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + Math.round(n * k) / k;
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '').length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1).join('0');
	  }
	  return s.join(dec);
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".counter-dash").each(function(){
		    var val = $(this).html();
		    var elm = $(this);
		    $(this).html(0);
		    var a = 0;
		    var intv = setInterval(function(){
		      	a++;
		      	elm.html(a);
		      	if(a>=val)stop();
		    }, 10);
		    function stop(){
		      	clearInterval(intv);
		    }
	  	});		
	});
</script>