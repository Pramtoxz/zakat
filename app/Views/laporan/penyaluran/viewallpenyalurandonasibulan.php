<?php
    // Array nama bulan dalam bahasa Indonesia
    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
?>
<text>Bulan :</text> <b><?= isset($namaBulan[(int)$bulan]) ? $namaBulan[(int)$bulan] : $bulan ?></b>
<text>Tahun :</text> <b><?= $tahun ?></b>
<br><br>
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
