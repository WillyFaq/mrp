<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Bahan</th>
            <th>Jumlah</th>
            <th>Safety Stok</th>
            <th>ROP</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i=0;
        $sql = "SELECT * FROM bahan";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)):
    ?>
        <tr>
            <td><?= ++$i; ?></td>
            <td><?= $row['nama_bahan']; ?></td>
            <td><?= $row['jumlah'].' '.$row['satuan']; ?></td>
            <td><?= $row['ss'].' '.$row['satuan']; ?></td>
            <td><?= $row['rop'].' '.$row['satuan']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>