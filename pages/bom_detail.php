<script type="text/javascript" src="assets/js/gstatic.loader.js"></script>
<style>
.jml_class{
	color: #FF0000;
}
.google-visualization-orgchart-node{
	border:none;
}
</style>
<div id="chart_div"></div>

<script type="text/javascript">
<?php
	echo "var data_bahan = [\n";
	echo "\t[\n";
	echo "\t\t{\n";
	echo "\t\t\t'v':'$id_bom',\n";
	echo "\t\t\t'f':'<strong>$nama_bom</strong><div class=\"jml_class\">$jumlah $satuan</div>',\n";
	echo "\t\t},\n";
	echo "\t\t'',\n";
	echo "\t\t'$nama_bom'\n";
	echo "\t],\n";
	$bahan = get_bahan($id_bom);
	$dai = '';
	foreach ($bahan as $k => $row) {
		if($row['level']==1){
			$cur_id = $id_bom.$row['id_bahan'].$row['level'];
			$ida = $cur_id;
			$cur_level = $row['level'];
			$parent = $id_bom;
		}else{
			if($cur_level==1){$cur_level++;}
			$ida = $id_bom.$row['id_bahan'].$row['level'];
			if($row['level'] == $cur_level){
				$parent = $cur_id;
				$dai = $id_bom.$row['id_bahan'].$row['level'];
				$cur_level = $row['level'];
			}else{
				$cur_id = $dai;
				$parent = $cur_id;
				$cur_level = $row['level'];
			}
		}
		echo "\t[\n";
		echo "\t\t{\n";
		echo "\t\t\t'v':'$ida',\n";
		echo "\t\t\t'f':'<strong>$row[nama_bahan]</strong><div class=\"jml_class\">$row[jumlah] $row[satuan]</div>',\n";
		echo "\t\t},\n";
		echo "\t\t'$parent',\n";
		echo "\t\t'$row[nama_bahan]'\n";
		echo "\t],\n";
	}
	echo "];\n";
?>	
	//console.log(data);
	google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Parent');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows(data_bahan);
        /*data.addRows([
        	[
        		{
        			'v':'1', 
        			'f':'Chemical Frit<div class="jml_class">1 Ton</div>'
        		},
           		'', 
           		'Chemical Frit'
           	],
           	[
        		{
        			'v':'2', 
        			'f':'Frit Mentah tipe A Q1<div class="jml_class">505 Kg</div>'
        		},
           		'1', 
           		'Frit Mentah tipe A Q1'
           	],
        	['Frit Mentah tipe A Q1<div class="jml_class">505 Kg</div>', '1', 'Chemical Frit'],
        ]);*/

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});
    }
</script>