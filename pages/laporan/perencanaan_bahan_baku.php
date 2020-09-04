<?php
    $type = 1;
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
    if(!isset($ctk)){
?>
<style>
    .dataTables_filter{
        display: none;
    }
</style>
<form action="" class="mb-4">
    <div class="row mb-4">
        <div class="col-2">
            <label for="">Filter</label>
        </div>
        <div class="col">
            <select class="form-control" id="jenis_filter">
                <option value="1" <?= $type=="1"?'selected':''?> >Perpesanan</option>
                <option value="2" <?= $type=="2"?'selected':''?> >Perbulan</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row" id="fil_tgl" <?= $type==1?'':'style="display:none;"'; ?> >
        <div class="col-2">
            Tanggal
        </div>
        <div class="col">
            <input type="date" class="form-control inp_filter" id="tgl1" placeholder="Tanggal">
        </div>
        <div class="col">
            <input type="date" class="form-control inp_filter" id="tgl2" placeholder="Tanggal">
        </div>
    </div>
    <div class="row" id="fil_bln" <?= $type==2?'':'style="display:none;"'; ?> >
        <div class="col-2">
            Bulan
        </div>
        <div class="col">
            <select class="form-control inp_filter" name="bulan" id="cb_bulan" required>
                <option value="">[Pilih Bulan]</option>
                <?php
                    $sat = get_bulan();
                    foreach ($sat as $k => $v) {
                        $sel = "";
                        if(isset($bulan) && $bulan==$k){
                            $sel = 'selected';
                        }
                        echo '<option value="'.$v.'" '.$sel.'>'.$v.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
</form>
<table class="table dataTableLaporan">
    <?php

        $t = "Tanggal Perencanaan";
        $sql = "SELECT
            b.nama_bahan,
            a.bulan  AS 'tgl',
            a.GR AS 'jumlah',
            b.satuan
        FROM mrp a
        JOIN bahan b ON a.id_bahan = b.id_bahan
        WHERE a.GR <> 0
        ORDER BY 1,2";
        if($type==2){
            $t = "Bulan Perencanaan";
            $sql = "SELECT
                b.nama_bahan,
                MONTH(a.bulan) AS 'tgl',
                SUM(a.GR) AS 'jumlah',
                b.satuan
            FROM mrp a
            JOIN bahan b ON a.id_bahan = b.id_bahan
            GROUP BY b.nama_bahan
            ORDER BY 1,2";
        }

    ?>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Bahan</th>
            <th><?= $t; ?></th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i=0;
        
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)):
            $tgl = ($type==1)?date("d-m-Y", strtotime($row['tgl'])):get_bulan($row['tgl']);
    ?>
        <tr>
            <td><?= ++$i; ?></td>
            <td><?= $row['nama_bahan']; ?></td>
            <td><?= $tgl; ?></td>
            <td><?= $row['jumlah']." ".$row['satuan']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<script type="text/javascript">
    
    $(document).ready(function(){
        var table = $('.dataTableLaporan').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false
        });

        $(".inp_filter").change(function(){
            table.draw();
        });

        $("#jenis_filter").change(function(){
            var link = "index.php?p=laporan&ket=perencanaan_bahan_baku";
            link += "&type="+$(this).val();
            document.location = link;
        });

        $("#tgl1").change(function(){
            var v = $(this).val();
            console.log(v);
            var href = $(".btn-cetak").attr("data-href");
            href += "&tgl1="+v;
            $(".btn-cetak").attr("data-href", href);
        });
        $("#tgl2").change(function(){
            var v = $(this).val();
            console.log(v);
            var href = $(".btn-cetak").attr("data-href");
            href += "&tgl2="+v;
            $(".btn-cetak").attr("data-href", href);
        });

        $("#cb_bulan").change(function(){
            var v = $(this).val();
            //console.log(v);
            var href = $(".btn-cetak").attr("data-href");
            href += "&bln="+v;
            $(".btn-cetak").attr("data-href", href);
        });
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var tgl1 = $('#tgl1').val();
            var tgl2 = $('#tgl2').val();
            var bln = $("#cb_bulan").val();
            tgl1 = tgl1!=''?Date.parse(tgl1):'';
            tgl2 = tgl2!=''?Date.parse(tgl2):'';
            //console.log(tgl1);
            //var t_tgl = Date.parse(data[2]);
            var t = data[2].split("-");
            var t_tgl = t[2]+"-"+t[1]+"-"+t[0];
            t_tgl = Date.parse(t_tgl);
            if(tgl1=='' && tgl2==''){
                if(bln==''){
                    return true;
                }else{
                    if(data[2] == bln){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                if(tgl1!='' && tgl2==''){
                    if(t_tgl>=tgl1){
                        return true;
                    }
                }else if(tgl1=='' && tgl2!=''){
                    if(t_tgl<=tgl2){
                        return true;
                    }
                }else{
                    if(tgl1<tgl2){
                        if(t_tgl>=tgl1 && t_tgl<=tgl2){
                            return true;
                        }
                    }
                }
            }

            return false;
        }
    );
    
</script>
<?php }else{ ?>
<?php
    $type = isset($_GET['type'])?$_GET['type']:1;
    if($type==1){
        $whr = "";
        if(isset($_GET['tgl1']) || isset($_GET['tgl2']) ){
            if(isset($_GET['tgl1'])){
                $tgl1 = $_GET['tgl1'];
                $whr = " AND a.bulan >= '$tgl1' ";
            }
            if(isset($_GET['tgl2'])){
                $tgl2 = $_GET['tgl2'];
                $whr .= " AND a.bulan <= '$tgl2' ";
            }
            echo "<p>Pertanggal : ";
            echo date("d-m-Y", strtotime($tgl1));
            echo " s/d ";
            echo date("d-m-Y", strtotime($tgl2));
            echo "</p><br>";
        }

        $t = "Tanggal Perencanaan";
        $sql = "SELECT
            b.nama_bahan,
            a.bulan  AS 'tgl',
            a.GR AS 'jumlah',
            b.satuan
        FROM mrp a
        JOIN bahan b ON a.id_bahan = b.id_bahan
        WHERE a.GR <> 0 $whr
        ORDER BY 1,2";

    }else{
        $whr = "";
        if(isset($_GET['bln']) ){
            echo "<p>Bulan : $_GET[bln] </p><br>";
            $b = get_rev_bulan($_GET['bln']);
            $whr = " WHERE MONTH(a.bulan) = $b ";
        }

        $t = "Bulan Perencanaan";
        $sql = "SELECT
            b.nama_bahan,
            MONTH(a.bulan) AS 'tgl',
            SUM(a.GR) AS 'jumlah',
            b.satuan
        FROM mrp a
        JOIN bahan b ON a.id_bahan = b.id_bahan
        $whr
        GROUP BY b.nama_bahan
        ORDER BY 1,2";
    }
?>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Bahan</th>
            <th><?= $t; ?></th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i=0;
        
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)):
            $tgl = ($type==1)?date("d-m-Y", strtotime($row['tgl'])):get_bulan($row['tgl']);
    ?>
        <tr>
            <td><?= ++$i; ?></td>
            <td><?= $row['nama_bahan']; ?></td>
            <td><?= $tgl; ?></td>
            <td><?= $row['jumlah']." ".$row['satuan']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php } ?>