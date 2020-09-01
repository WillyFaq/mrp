<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-list-ol"></i> BOM</h1>
</div>
<?php
    $ket = "Data";
    if(isset($_GET['ket'])){
        $ket = $_GET['ket'];
        $form = $ket;
        if($ket == "ubah"){
            $id = $_GET['id'];
            $sql = "SELECT * FROM bom WHERE id_bom = $id ";
            $q = mysqli_query($con, $sql);
            $rw = mysqli_fetch_array($q);
            $id_bom = $rw['id_bom'];
            $nama_bom = $rw['nama_bom'];
            $jumlah = $rw['jumlah'];
            $satuan = $rw['satuan'];
            $LT = $rw['LT'];
        }elseif($ket == "detail"){
            $id = $_GET['id'];
            $sql = "SELECT * FROM bom WHERE id_bom = $id ";
            $q = mysqli_query($con, $sql);
            $rw = mysqli_fetch_array($q);
            $id_bom = $rw['id_bom'];
            $nama_bom = $rw['nama_bom'];
            $jumlah = $rw['jumlah'];
            $satuan = $rw['satuan'];
            $LT = $rw['LT'];
        }
    }

?>
<div class="row row_angket">
    <div class="col mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> BOM</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=bom&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
                </div>
                <?php } ?>
            </div>
            <div class="card-body">
            <?php
                if(!isset($form)):
            ?>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Lead Time</th>
                            <th>Bahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT * FROM bom";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama_bom']; ?></td>
                            <td><?= $row['jumlah'].' '.$row['satuan']; ?></td>
                            <td><?= $row['LT'].' Minggu'; ?></td>
                            <td>
                                <pre>
<?php
    $bahan = get_bahan($row['id_bom']);
    $ret = "";
    foreach ($bahan as $k => $v) {
        $ret .= "|_ $v[nama_bahan] - $v[jumlah] $v[satuan]<br>";
        if(isset($v['child'])){
            foreach ($v['child'] as $a => $b) {
                $ret .= "\t|_ $b[nama_bahan] - $b[jumlah] $b[satuan]<br>";
            }
        }
    }
    echo $ret;
?>
                                </pre>
                            </td>
                            <td>
                                <a href="index.php?p=bom&ket=detail&id=<?= $row['id_bom'] ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                                <a href="index.php?p=bom&ket=ubah&id=<?= $row['id_bom'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_bom'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php elseif(isset($form) && $form=="detail"): ?>
                <?php include("bom_detail.php"); ?>
                <?php else: ?>
                <form method="post" action="models/p_bom.php">
                    <input type="hidden" name="id_bom" value="<?= isset($id_bom)?$id_bom:''; ?>" >
                    <div class="form-group row">
                        <label for="nama_bom" class="col-sm-2 col-form-label">Nama BOM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_bom" id="nama_bom" placeholder="Nama BOM" value="<?= isset($nama_bom)?$nama_bom:''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="0.1" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?= isset($jumlah)?$jumlah:''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="satuan" id="satuan" required>
                                <option value="">[Pilih Satuan]</option>
                                <?php
                                    $sat = get_satuan();
                                    foreach ($sat as $k => $v) {
                                        $sel = "";
                                        if(isset($satuan) && $satuan==$v){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$v.'" '.$sel.'>'.$v.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="LT" class="col-sm-2 col-form-label">Lead Time</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" min="0" step="1" class="form-control" name="LT" id="LT" placeholder="Lead Time" value="<?= isset($LT)?$LT:''; ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Minggu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <hr>
                    </div>
                    <div class="form-group row">
                        <label for="bahan" class="col-sm-2 col-form-label">Bahan</label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-success btn_tambah">Tambah Bahan</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bhn" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Nama Bahan</th>
                                        <th>Jumlah</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody_bahan">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
                            <input type="submit" class="btn btn-primary" name="btnSimpan" value="<?= ucfirst($form); ?>">
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Bahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body load-modal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modaljumlah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Bahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Batal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="models/p_user.php">
                    <input type="hidden" id="id_bahan_inp" >
                    <div class="form-group row">
                        <label for="nama_bahan" class="col-sm-2 col-form-label">Nama Bahan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_bahan_inp" placeholder="Nama Bahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah_bahan" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <input type="number" min="0" step="0.1" class="form-control" id="jumlah_bahan_inp" value="0">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="st-add" ></span>
                                </div>
                            </div>
                            <input type="hidden" id="satuan_bahan_inp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah_bahan" class="col-sm-2 col-form-label">Level</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <input type="number" min="1" step="1" class="form-control" id="level_bahan_inp" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row parent_box" style="display: none">
                        <label for="parent_bahan" class="col-sm-2 col-form-label">Parent</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <select id="parent_bahan_inp" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn_tambah_jumlah_bahan">Tambah Bahan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success btnhapus-link" href="login.html">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var data_bhn = [];   

    <?php
        if(isset($id_bom)){
            $sql = "SELECT a.*, IF(a.parent=0, a.parent, (SELECT c.nama_bahan FROM bahan c WHERE c.id_bahan = a.parent) ) AS parent_txt, b.nama_bahan, b.satuan FROM bom_detail a JOIN bahan b ON a.id_bahan = b.id_bahan WHERE id_bom = $id_bom";
            $q = mysqli_query($con, $sql);
            $bom_detail = [];
            while($row = mysqli_fetch_array($q)){
    ?>
            data_bhn.push({
                id_bahan : '<?= $row["id_bahan"]?>',
                nama_bahan : '<?= $row["nama_bahan"]?>',
                satuan_bahan : '<?= $row["satuan"]?>',
                jumlah_bahan : '<?= $row["jumlah"]?>',
                level_bahan : '<?= $row["level"]?>',
                parent_bahan : '<?= $row["parent"]?>',
                txt_parent_bahan : '<?= $row["parent_txt"]?>',
            });
    <?php      
            }
    ?>
            tambah_bahan(data_bhn);
    <?php
        }
    ?>

    $(document).ready(function(){
        $(".btn_tambah").click(function(){
            $(".load-modal").load("pages/ajax_bahan.php");
            $("#modalBahan").modal('show');
        });

        $(".btn_tambah_jumlah_bahan").click(function(){
            if($("#jumlah_bahan_inp").val()>0){
                var idb = $("#id_bahan_inp").val();
                var level = $("#level_bahan_inp").val();
                var parent = level==1?0:$("#parent_bahan_inp").val();
                var txt_parent = level==1?0:$("#parent_bahan_inp>[value='"+parent+"']").text();
                console.log(txt_parent);
                var cek = cek_bahan(idb, parent); 
                console.log(cek);
                if(cek>=0){
                    var jml = $("#jumlah_bahan_inp").val();
                    jml = parseInt(jml) + parseInt(data_bhn[cek].jumlah_bahan);
                    data_bhn[cek].jumlah_bahan = jml;
                    data_bhn[cek].level_bahan = level;
                    data_bhn[cek].parent_bahan = parent;
                }else{
                    bhn = {
                                    id_bahan : idb,
                                    nama_bahan : $("#nama_bahan_inp").val(),
                                    satuan_bahan : $("#satuan_bahan_inp").val(),
                                    jumlah_bahan : $("#jumlah_bahan_inp").val(),
                                    level_bahan : level,
                                    parent_bahan : parent,
                                    txt_parent_bahan : txt_parent,
                                    };
                    data_bhn.push(bhn);
                }
                console.log(data_bhn);
                $("#modaljumlah").modal('hide');
                tambah_bahan(data_bhn);
                
            }
        });
        
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_bom.php?id="+id);
        });

        $("#level_bahan_inp").change(function(){
            if($(this).val()>1){
                $(".parent_box").show();
                $("#parent_bahan_inp").html(" ");
                var opt = "";
                for(var i=0; i<data_bhn.length; i++){
                    var lvl = $(this).val();
                    lvl = parseInt(lvl) - 1;
                    if(data_bhn[i].level_bahan==lvl){
                        opt += '<option value="'+data_bhn[i].id_bahan+'">'+data_bhn[i].nama_bahan+'</option>';
                    }
                }
                $("#parent_bahan_inp").append(opt);
            }
        });

    });

    function cek_bahan(id, parent) {
        for(var i=0; i<data_bhn.length; i++){
            if(id == data_bhn[i].id_bahan && parent == data_bhn[i].parent){
                return i;
            }
        }
        return -1;
    }

    function pilih_bahan(id, nama, satuan){
        console.log(id+" "+nama+" "+satuan);
        $("#modalBahan").modal('hide');
        $("#id_bahan_inp").val(id);
        $("#nama_bahan_inp").val(nama);
        $("#satuan_bahan_inp").val(satuan);
        $("#st-add").html(satuan);
        $("#modaljumlah").modal('show');

        $("#jumlah_bahan_inp").val(0);
        $("#level_bahan_inp").val(1);
        $(".parent_box").hide();
        console.log(data_bhn.length);
        if(data_bhn.length==0){
            $("#level_bahan_inp").attr("max", 1);
        }else{
            $("#level_bahan_inp").attr("max", 2);
            //$("#level_bahan_inp").removeAttr("max");
        }
    }


    function tambah_bahan(data_bhn){
        /*id_bahan_class*/
        var frm = '';
        $(".tbody_bahan").html(" ");
        for(var i=0; i<data_bhn.length; i++){
            frm += gen_data_bahan(data_bhn[i], i);
        }
        $(".tbody_bahan").append(frm);
        /*var frm = '';
        var no = $(".id_bahan_class").length;
        if(no>0){
            $(".id_bahan_class").each(function(){
                console.log($(this).val());
                var idd = $(this).val();
                if(idd == data_bhn.id_bahan){
                    var jml = $("#jmlbhn_"+idd).val();
                    var j = parseInt(data_bhn.jumlah_bahan) + parseInt(jml);
                    data_bhn.jumlah_bahan = j;
                    $("#bhn_"+data_bhn.id_bahan).remove();
                    frm = gen_data_bahan(data_bhn);

                }else{
                    frm = gen_data_bahan(data_bhn);
                }
            });
        }else{
            frm = gen_data_bahan(data_bhn);
        }
        $(".tbody_bahan").append(frm);*/
    }

    function gen_data_bahan(data_bhn, idx){
        var ret = '';
        ret += '<tr id="bhn_'+idx+'">';
            ret += '<input type="hidden" id="idbhn_'+idx+'" class="id_bahan_class" name="id_bahan[]" value="'+data_bhn.id_bahan+'">';
            ret += '<input type="hidden" id="jmlbhn_'+idx+'" name="jumlah_bahan[]" value="'+data_bhn.jumlah_bahan+'">';
            ret += '<input type="hidden" id="lvlbhn_'+idx+'" name="level_bahan[]" value="'+data_bhn.level_bahan+'">';
            ret += '<input type="hidden" id="prntbhn_'+idx+'" name="parent_bahan[]" value="'+data_bhn.parent_bahan+'">';
            //ret += '<td>1</td>';
            ret += '<td>'+data_bhn.nama_bahan+'</td>';
            ret += '<td>'+data_bhn.jumlah_bahan+' '+data_bhn.satuan_bahan+'</td>';
            var par = '';
            if(data_bhn.level_bahan!=1){
                par = "("+data_bhn.txt_parent_bahan+")";
            }
            ret += '<td>'+data_bhn.level_bahan+' '+par+'</td>';
            ret += '<td>';
                ret += '<button type="button" onclick="hapus_bahan('+idx+')" class="btn btn-sm btn-danger btn_hapus_bahan" data-id="'+data_bhn.id_bahan+'" data-toggle="tooltip" data-placement="top" title="Hapus">';
                    ret += '<i class="fa fa-trash"></i>';
                ret += '</button>';
            ret += '</td>';
        ret += '</tr>';
        return ret;
    }

    function hapus_bahan(id) {
        $("#bhn_"+id).remove();
        data_bhn.splice(id, 1);
        tambah_bahan(data_bhn);
    }
</script>