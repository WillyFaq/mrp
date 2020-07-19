<table class="table">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Menu</th>
            <th rowspan="2">Bulan</th>
            <th colspan="4">Minggu</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i=0;
        $sql = "SELECT * FROM mps a JOIN bom b ON a.id_bom = b.id_bom ORDER BY bulan DESC";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)):
    ?>
        <tr>
            <td><?= ++$i; ?></td>
            <td><?= $row['nama_bom']; ?></td>
            <td><?= get_bulan((int)date("m", strtotime($row['bulan']))); ?></td>
            <td><?= $row['M1']; ?></td>
            <td><?= $row['M2']; ?></td>
            <td><?= $row['M3']; ?></td>
            <td><?= $row['M4']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>