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
        <th>ID Zakat</th>
        <th>Nama Donatur</th>
        <th>Tanggal</th>
        <th>Nominal</th>
        <th>Jenis Zakat</th>
        <th>Tipe</th>
        <th>Nominal</th>
    </tr>
    <?php foreach ($booking as $key => $value) { 
        $grandtotal += $value['nominal'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idzakat'] ?></td>
        <td><?= $value['nama_donatur'] ?></td>
        <td><?= date('d-m-Y', strtotime($value['created_at'])) ?></td>
        <td><?= $value['nominal'] ?></td>
        <td><?= $value['jeniszakat'] ?></td>
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
        <td colspan="7" class="text-right"><b>Grand Total</b></td>
        <td><b><?= 'Rp ' . number_format($grandtotal, 0, ',', '.') ?></b></td>
    </tr>
</table>