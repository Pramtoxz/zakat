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
        <th>ID Penyaluran</th>
        <th>Tanggal Penyaluran</th>
        <th>Mustahik</th>
        <th>Jenis Dana</th>
        <th>Program/ID Permohonan</th>
        <th>Nominal</th>
    </tr>
    <?php foreach ($penyaluran as $key => $value) { 
        $grandtotal += $value['nominal'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['id'] ?></td>
        <td><?= date('d-m-Y', strtotime($value['tglpenyaluran'])) ?></td>
        <td><?= $value['nama_mustahik'] ?></td>
        <td>
            <?php if ($value['jenisdana'] == 'zakat'): ?>
                <span class="badge badge-success">Zakat</span>
            <?php else: ?>
                <span class="badge badge-primary">Donasi</span>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($value['jenisdana'] == 'zakat'): ?>
                <?= $value['idpermohonan'] ? 'PM-' . $value['idpermohonan'] . ' (' . ucfirst($value['kategoriasnaf']) . ' - ' . $value['jenisbantuan'] . ')' : '-' ?>
            <?php else: ?>
                <?= $value['namaprogram'] ?? '-' ?>
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
