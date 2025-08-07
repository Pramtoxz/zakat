<?php 
    $no = 1; 
    $grandtotal = 0;
?>
<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Tanggal Penyaluran</th>
        <th>Mustahik</th>
        <th>Program Donasi</th>
        <th>Nominal</th>
    </tr>
    <?php foreach ($penyaluran as $key => $value) { 
        $grandtotal += $value['nominal'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d-m-Y', strtotime($value['tglpenyaluran'])) ?></td>
        <td><?= $value['nama_mustahik'] ?></td>
        <td><?= $value['namaprogram'] ?? '-' ?></td>
        <td><?= 'Rp ' . number_format($value['nominal'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="4" class="text-right"><b>Grand Total</b></td>
        <td><b><?= 'Rp ' . number_format($grandtotal, 0, ',', '.') ?></b></td>
    </tr>
</table>
