<?php if($_SESSION['type']==3): ?>
<?php
    $sql = "SELECT * FROM bahan";
    $q = mysqli_query($con, $sql);
    $data = [];
    while($row = mysqli_fetch_array($q)){
        if($row['rop']>$row['jumlah']){
            array_push($data, array(
                                    'id_bahan' => $row['id_bahan'],
                                    'nama_bahan' => $row['nama_bahan'],
                                    ));
        }
    }
    $nr = sizeof($data);
?>
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <?php if($nr>0):?>
        <span class="badge badge-danger badge-counter"><?= $nr; ?></span>
        <?php endif;?>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notifikasi Pemesanan Bahan Baku :
        </h6>

        <div class="scroll_notification">
        <?php
            foreach ($data as $k => $v):
        ?>
        <a class="dropdown-item d-flex align-items-center" href="">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas fa-box-open text-white"></i>
                </div>
            </div>
            <div>
                <span class="font-weight-bold"><strong><?= $v['nama_bahan']; ?></strong></span>
            </div>
        </a>
        <?php endforeach; ?>
        </div>
        <!-- <div class="dropdown-item text-center small text-gray-500"></div> -->
        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
    </div>
</li>
<?php endif; ?>



<?php if($_SESSION['type']==2): ?>
<?php
    $tgl = date("Y-m-d");
    $sql = "SELECT * FROM pengadaan a JOIN bahan b ON a.id_bahan = b.id_bahan WHERE tgl_pengadaan = '$tgl'";
    $q = mysqli_query($con, $sql);
    $data = [];
    while($row = mysqli_fetch_array($q)){
        $data[] = $row;
    }

    $sql = "SELECT * FROM pengeluaran a JOIN bahan b ON a.id_bahan = b.id_bahan WHERE tgl_pengeluaran = '$tgl'";
    $q = mysqli_query($con, $sql);
    $data2 = [];
    while($row = mysqli_fetch_array($q)){
        $data2[] = $row;
    }

    $nr = sizeof($data) + sizeof($data2);
?>
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <?php if($nr>0):?>
        <span class="badge badge-danger badge-counter"><?= $nr; ?></span>
        <?php endif;?>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notifikasi Penerimaan Bahan Baku :
        </h6>
        <div class="scroll_notification">
            
        <?php
            foreach ($data as $k => $v):
        ?>
        <a class="dropdown-item d-flex align-items-center" href="index.php?p=penerimaan_bb">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas fa-box-open text-white"></i>
                </div>
            </div>
            <div>
                <span class="font-weight-bold"><strong><?= $v['nama_bahan']; ?></strong></span>
            </div>
        </a>
        <?php endforeach; ?>
        </div>
        <div class="dropdown-item text-center small text-gray-500"></div>
        <h6 class="dropdown-header">
            Notifikasi Pengeluaran Bahan Baku :
        </h6>
        <div class="scroll_notification">
            <?php
            foreach ($data2 as $k => $v):
            ?>
            <a class="dropdown-item d-flex align-items-center" href="index.php?p=pengeluaran_bb">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-box-open text-white"></i>
                    </div>
                </div>
                <div>
                    <span class="font-weight-bold"><strong><?= $v['nama_bahan']; ?></strong></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
    </div>
</li>

<?php endif; ?>