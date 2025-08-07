<br><br>
<text>Dari : <text> <b><?= date('d F Y', strtotime($tglmulai)) ?></b> <text>Sampai : <text> <b><?= date('d F Y', strtotime($tglakhir)) ?></b>
<br><br>
<?php 
    $no = 1; 
    $grandtotal = 0;
?>
<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>ID Donasi</th>
        <th>Nama Donatur</th>
        <th>Tanggal</th>
        <th>Program Donasi</th>
        <th>Tipe</th>
        <th>Nominal</th>
    </tr>
    <?php foreach ($donasi as $key => $value) { 
        $grandtotal += $value['nominal'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['iddonasi'] ?></td>
        <td><?= $value['nama_donatur'] ?></td>
        <td><?= date('d-m-Y', strtotime($value['created_at'])) ?></td>
        <td><?= $value['namaprogram'] ?></td>
        <td>
            <?php if ($value['online'] == 1): ?>
                <span class="badge badge-info">Online</span>
            <?php else: ?>
                <span class="badge badge-secondary">Offline</span>
            <?php endif; ?>
        </td>
        <td><?= 'Rp ' . number_format($value['nominal'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="6" class="text-right"><b>Grand Total</b></td>
        <td><b><?= 'Rp ' . number_format($grandtotal, 0, ',', '.') ?></b></td>
    </tr>
</table>