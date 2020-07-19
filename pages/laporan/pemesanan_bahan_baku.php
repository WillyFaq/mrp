<style>
    .dataTables_filter{
        display: none;
    }
</style>
<form action="" class="mb-4">
    <div class="row">
        <div class="col">
            <label for="">Filter</label>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="date" class="form-control inp_filter" id="tgl1" placeholder="Tanggal">
        </div>
        <div class="col">
            <input type="date" class="form-control inp_filter" id="tgl2" placeholder="Tanggal">
        </div>
    </div>
</form>
<table class="table dataTableLaporan">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Bahan</th>
            <th>Tangal Pengadaan</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i=0;
        $sql = "SELECT 
                    a.*, 
                    b.nama_user, 
                    c.nama_bahan, 
                    c.satuan
                FROM pengadaan a 
                JOIN user b ON a.id_user = b.id_user 
                JOIN bahan c ON a.id_bahan = c.id_bahan 
                WHERE a.sts = 0 
                ORDER BY a.tgl_pengadaan DESC";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)):
    ?>
        <tr>
            <td><?= ++$i; ?></td>
            <td><?= $row['nama_bahan']; ?></td>
            <td><?= date("d-m-Y", strtotime($row['tgl_pengadaan'])); ?></td>
            <td><?= $row['jumlah']." ".$row['satuan']; ?></td>
            <td><?= $row['keterangan']; ?></td>
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
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var tgl1 = $('#tgl1').val();
            var tgl2 = $('#tgl2').val();
            tgl1 = tgl1!=''?Date.parse(tgl1):'';
            tgl2 = tgl2!=''?Date.parse(tgl2):'';
            //console.log(tgl1);
            //var t_tgl = Date.parse(data[2]);
            var t = data[2].split("-");
            var t_tgl = t[2]+"-"+t[1]+"-"+t[0];
            t_tgl = Date.parse(t_tgl);
            if(tgl1=='' && tgl2==''){
                return true;
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