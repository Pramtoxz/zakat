<table class="table table-bordered" style="border: 1px solid;">
    <thead>
        <tr class="text-center">
            <th colspan="8">Laporan Perawatan Bulan <?= $bulan ?> Tahun <?= $tahun ?></th>
        </tr>
        <tr class="text-center">
            <th style="width: 15px;">No</th>
            <th>ID Perawatan</th>
            <th>ID Booking</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Tanggal Perawatan</th>
            <th>Jumlah Obat</th>
            <th>Total Biaya</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $totalBiaya = 0;
        
        foreach ($perawatan as $row): 
            $totalBiaya += $row['total'];
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['idperawatan'] ?></td>
            <td><?= $row['idbooking'] ?></td>
            <td><?= $row['nama_pasien'] ?></td>
            <td><?= $row['nama_dokter'] ?></td>
            <td><?= date('d-m-Y', strtotime($row['tglperawatan'])) ?></td>
            <td><?= $row['qty'] ?></td>
            <td style="text-align: right;">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
        
        <tr>
            <th colspan="7" style="text-align: right;">Total Biaya:</th>
            <th style="text-align: right;">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></th>
        </tr>
    </tbody>
</table> 