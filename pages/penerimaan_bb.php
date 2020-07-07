<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-boxes"></i> Penerimaan Bahan Baku</h1>
</div>
<?php
    $ket = "Data";
    if(isset($_GET['ket'])){
        $ket = $_GET['ket'];
        $form = $ket;
        if($ket == "ubah"){
            $id = $_GET['id'];
            $sql = "SELECT a.*, b.nama_user, c.nama_bahan, c.satuan FROM penerimaan a JOIN user b ON a.id_user = b.id_user JOIN bahan c ON a.id_bahan = c.id_bahan WHERE a.id_pengadaan = $id";
            $q = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($q);
            $id_bahan = $row['id_bahan'];
            $nama_bahan = $row['nama_bahan'];
            $satuan = $row['satuan'];
            $jumlah = $row['jumlah'];
            $tgl_pengadaan = $row['tgl_pengadaan'];
            $keterangan = $row['keterangan'];
        }
    }

?>
<div class="row row_angket">
    <div class="col mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Penerimaan Bahan Baku</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=penerimaan_bb&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
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
                            <th>Nama Bahan</th>
                            <th>Jumlah</th>
                            <th>Tangal Terima</th>
                            <th>Keterangan</th>
                            <th>Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT a.*, b.nama_user, c.nama_bahan, c.satuan FROM penerimaan a JOIN user b ON a.id_user = b.id_user JOIN bahan c ON a.id_bahan = c.id_bahan ORDER BY a.tgl_pengadaan DESC";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama_bahan']; ?></td>
                            <td><?= $row['jumlah']." ".$row['satuan']; ?></td>
                            <td><?= date("d-m-Y", strtotime($row['tgl_pengadaan'])); ?></td>
                            <td><?= $row['keterangan']; ?></td>
                            <td><?= $row['nama_user']; ?></td>
                            <td>
                                <!-- <a href="index.php?p=penerimaan_bb&ket=ubah&id=<?= $row['id_pengadaan'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                 -->
                                 <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_pengadaan'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <form method="post" action="models/p_permintaan_bb.php">
                    <input type="hidden" id="id_pengadaan" name="id_pengadaan" value="<?= isset($id_pengadaan)?$id_pengadaan:''; ?>" >
                    <div class="form-group row">
                        <label for="nama_bahan" class="col-sm-2 col-form-label">Nama Bahan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" placeholder="Nama Bahan" value="<?= isset($nama_bahan)?$nama_bahan:''; ?>" required>
                        </div>
                        <input type="hidden" id="id_bahan" name="id_bahan" value="<?= isset($id_bahan)?$id_bahan:''; ?>" required>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" min="1" step="0.1" class="form-control" id="jumlah" name="jumlah" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="st-add" ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_pengadaan" class="col-sm-2 col-form-label">Tgl Pengadaan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_pengadaan" id="tgl_pengadaan" placeholder="Tgl Pengadaan" value="<?= isset($tgl_pengadaan)?$tgl_pengadaan:''; ?>" max="<?= date("Y-m-d")?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" rows="5"><?= isset($keterangan)?$keterangan:''; ?></textarea>
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


<script type="text/javascript">
    $(document).ready(function(){

        $("#nama_bahan").click(function(){
            $(".load-modal").load("pages/ajax_bahan.php");
            $("#modalBahan").modal('show');
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_permintaan_bb.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });


    function pilih_bahan(id, nama, satuan){
        //console.log(id+" "+nama+" "+satuan);
        $("#modalBahan").modal('hide');
        $("#id_bahan").val(id);
        $("#nama_bahan").val(nama);
        $("#st-add").html(satuan);
        /*
        $("#satuan_bahan_inp").val(satuan);
        $("#modaljumlah").modal('show');*/
    }
</script>