<?php
$menu = [   
            array(
                    'group' => 'Master',
                    'menu' => [
                                array(
                                        'id' => 0,
                                        'link' => 'index.php?p=bahan',
                                        'text' => 'Bahan',
                                        'pages' => 'bahan.php',
                                        'icon' => 'fas fa-fw fa-flask',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 1,
                                        'link' => 'index.php?p=bom',
                                        'text' => 'BOM',
                                        'pages' => 'bom.php',
                                        'icon' => 'fas fa-fw fa-sitemap',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 2,
                                        'link' => 'index.php?p=permintaan',
                                        'text' => 'Permintaan',
                                        'pages' => 'permintaan.php',
                                        'icon' => 'fas fa-fw fa-cart-arrow-down',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 3,
                                        'link' => 'index.php?p=mps',
                                        'text' => 'Production Schedule',
                                        'pages' => 'mps.php',
                                        'icon' => 'far fa-fw fa-calendar-alt',
                                        'type' => 0
                                    ),
                            ]
                ),
            array(
                    'group' => 'Transaksi',
                    'menu' => [
                                array(
                                        'id' => 4,
                                        'link' => 'index.php?p=mrp',
                                        'text' => 'MRP',
                                        'pages' => 'mrp.php',
                                        'icon' => 'fas fa-fw fa-list-ul',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 5,
                                        'link' => 'index.php?p=pengadaan_bb',
                                        'text' => 'Pengadaan Bahan Baku',
                                        'pages' => 'pengadaan_bb.php',
                                        'icon' => 'fas fa-fw fa-boxes',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 6,
                                        'link' => 'index.php?p=penerimaan_bb',
                                        'text' => 'Penerimaan Bahan Baku',
                                        'pages' => 'penerimaan_bb.php',
                                        'icon' => 'fas fa-fw fa-boxes',
                                        'type' => 0
                                    ),
                                array(
                                        'id' => 7,
                                        'link' => 'index.php?p=pengeluaran_bb',
                                        'text' => 'Pengeluaran Bahan Baku',
                                        'pages' => 'pengeluaran_bb.php',
                                        'icon' => 'fas fa-fw fa-box-open',
                                        'type' => 0
                                    )
                            ]
            ),
            array(
                    'group' => 'Laporan',
                    'menu' => [
                                array(
                                    'id' => 8,
                                    'link' => 'index.php?p=laporan',
                                    'text' => 'Laporan',
                                    'pages' => 'laporan.php',
                                    'icon' => 'fas fa-fw fa-paste',
                                    'type' => 1,
                                    'child' => [
                                                array(
                                                        'id' => 81,
                                                        'link' => '&ket=bahan_baku',
                                                        'text' => 'Bahan Baku',
                                                        'pages' => 'bahan_baku.php',
                                                        ),
                                                array(
                                                        'id' => 82,
                                                        'link' => '&ket=penerimaan_bahan_baku',
                                                        'text' => 'Penerimaan Bahan Baku',
                                                        'pages' => 'penerimaan_bahan_baku.php',
                                                        ),
                                                array(
                                                        'id' => 83,
                                                        'link' => '&ket=pengeluaran_bahan_baku',
                                                        'text' => 'Pengeluaran Bahan Baku',
                                                        'pages' => 'pengeluaran_bahan_baku.php',
                                                        ),
                                                array(
                                                        'id' => 84,
                                                        'link' => '&ket=perencanaan_bahan_baku',
                                                        'text' => 'Perencanaan Bahan Baku',
                                                        'pages' => 'perencanaan_bahan_baku.php',
                                                        ),
                                                array(
                                                        'id' => 85,
                                                        'link' => '&ket=pemesanan_bahan_baku',
                                                        'text' => 'Pemesanan Bahan Baku',
                                                        'pages' => 'pemesanan_bahan_baku.php',
                                                        ),
                                                array(
                                                        'id' => 86,
                                                        'link' => '&ket=jadwal_produksi',
                                                        'text' => 'Jadwal Produksi',
                                                        'pages' => 'jadwal_produksi.php',
                                                        ),
                                                ]
                                ),
                            ]
            ),
            array(
                    'group' => 'Setting',
                    'menu' => [
                                array(
                                        'id' => 9,
                                        'link' => 'index.php?p=user',
                                        'text' => 'User',
                                        'pages' => 'user.php',
                                        'icon' => 'fas fa-fw fa-users',
                                        'type' => 0
                                    )
                                ]
            )
        ];
//print_r($menu);

//$jabatan = [0, 1, 2, 3, 4, 5];
$akses = [
            [8],
            [0, 1, 2, 3, 4, 5, 8],
            [6, 7, 8, 82, 83],
            [8, 84, 85],
            [8, 86],
            [0, 1, 2, 3, 4, 5, 8, 9]
        ];
?>

    <li class="nav-item" id="home">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <?php foreach($menu as $k => $v): ?>
        <?php if(in_array($v['menu'][0]['id'], $akses[$_SESSION['type']])): ?>
        <div class="sidebar-heading">
            <?= $v['group']; ?>
        </div>
        <?php endif; ?>
        <?php foreach($v['menu'] as $a => $b): ?>
            <?php if(in_array($b['id'], $akses[$_SESSION['type']])): ?>
                <?php if($b['type']==0): ?>
                    <li class="nav-item" id="<?= str_replace(".php", "", $b['pages']); ?>">
                        <a class="nav-link" href="<?= $b['link']; ?>">
                            <i class="<?= $b['icon']; ?>"></i>
                            <span><?= $b['text']; ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item" id="<?= str_replace(".php", "", $b['pages']); ?>">
                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
                            <i class="<?= $b['icon']; ?>"></i>
                            <span><?= $b['text']; ?></span>
                        </a>
                        <div id="collapseLaporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <?php foreach($b['child'] as $x => $z):?>
                                    <?php if(in_array($z['id'], $akses[$_SESSION['type']])): ?>
                                    <a class="collapse-item" href="<?= $b['link'].$z['link'];?>"><?= $z['text']; ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <!-- <div class="sidebar-heading">
        Master
    </div>
    <li class="nav-item" id="bahan">
        <a class="nav-link" href="index.php?p=bahan">
            <i class="fas fa-fw fa-flask"></i>
            <span>Bahan</span>
        </a>
    </li>
    <li class="nav-item" id="bom">
        <a class="nav-link" href="index.php?p=bom">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>BOM</span>
        </a>
    </li>
    <li class="nav-item" id="permintaan">
        <a class="nav-link" href="index.php?p=permintaan">
            <i class="fas fa-fw fa-cart-arrow-down"></i>
            <span>Permintaan</span>
        </a>
    </li>
    <li class="nav-item" id="mps">
        <a class="nav-link" href="index.php?p=mps">
            <i class="far fa-fw fa-calendar-alt"></i>
            <span>Production Schedule</span>
        </a>
    </li>
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item" id="mrp">
        <a class="nav-link" href="index.php?p=mrp">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>MRP</span>
        </a>
    </li>
    <li class="nav-item" id="pengadaan_bb">
        <a class="nav-link" href="index.php?p=pengadaan_bb">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Pengadaan Bahan Baku</span>
        </a>
    </li>
    <li class="nav-item" id="penerimaan_bb">
        <a class="nav-link" href="index.php?p=penerimaan_bb">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Penerimaan Bahan Baku</span>
        </a>
    </li>
    <li class="nav-item" id="pengeluaran_bb">
        <a class="nav-link" href="index.php?p=pengeluaran_bb">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Pengeluaran Bahan Baku</span>
        </a>
    </li>
    <div class="sidebar-heading">
        Laporan
    </div>
    <li class="nav-item" id="laporan">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-paste"></i>
            <span>laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?p=laporan&ket=bahan_baku">Bahan Baku</a>
                <a class="collapse-item" href="index.php?p=laporan&ket=penerimaan_bahan_baku">Penerimaan Bahan Baku</a>
                <a class="collapse-item" href="index.php?p=laporan&ket=pengeluaran_bahan_baku">Pengeluaran Bahan Baku</a>
                <a class="collapse-item" href="index.php?p=laporan&ket=perencanaan_bahan_baku">Perencanaan Bahan Baku</a>
                <a class="collapse-item" href="index.php?p=laporan&ket=pemesanan_bahan_baku">Pemesanan Bahan Baku</a>
                <a class="collapse-item" href="index.php?p=laporan&ket=jadwal_produksi">Jadwal Produksi</a>
            </div>
        </div>
    </li>
    <div class="sidebar-heading">
        Setting
    </div>
    <li class="nav-item" id="user">
        <a class="nav-link" href="index.php?p=user">
            <i class="fas fa-fw fa-users"></i>
            <span>User</span>
        </a>
    </li> -->