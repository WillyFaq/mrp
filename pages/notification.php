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
        <!-- <div class="dropdown-item text-center small text-gray-500"></div> -->
        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
    </div>
</li>