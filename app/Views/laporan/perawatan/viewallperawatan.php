<table class="table table-bordered" style="border: 1px solid;">
    <thead>
        <tr class="text-center">
            <th colspan="8">Laporan Seluruh Perawatan</th>
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
        $prev_idperawatan = '';
        $prev_idbooking = '';
        $prev_pasien = '';
        $prev_dokter = '';
        $prev_tglperawatan = '';
        $group_key_count = [];
        
        // Hitung jumlah baris per kelompok
        foreach ($perawatan as $item) {
            $group_key = $item['idperawatan'] . '_' . $item['idbooking'] . '_' . $item['nama_pasien'] . '_' . $item['nama_dokter'] . '_' . $item['tglperawatan'];
            if (!isset($group_key_count[$group_key])) {
                $group_key_count[$group_key] = 0;
            }
            $group_key_count[$group_key]++;
        }
        
        foreach ($perawatan as $row): 
            $totalBiaya += $row['total'];
            $group_key = $row['idperawatan'] . '_' . $row['idbooking'] . '_' . $row['nama_pasien'] . '_' . $row['nama_dokter'] . '_' . $row['tglperawatan'];
            $rowspan = $group_key_count[$group_key];
            
            $show_idperawatan = ($prev_idperawatan != $row['idperawatan']);
            $show_idbooking = ($prev_idbooking != $row['idbooking'] || $show_idperawatan);
            $show_pasien = ($prev_pasien != $row['nama_pasien'] || $show_idbooking);
            $show_dokter = ($prev_dokter != $row['nama_dokter'] || $show_idbooking);
            $show_tglperawatan = ($prev_tglperawatan != $row['tglperawatan'] || $show_idbooking);
        ?>
        <tr>
            <?php if ($show_idperawatan): ?>
            <td rowspan="<?= $rowspan ?>"><?= $no++ ?></td>
            <td rowspan="<?= $rowspan ?>"><?= $row['idperawatan'] ?></td>
            <?php endif; ?>
            
            <?php if ($show_idbooking): ?>
            <td rowspan="<?= $rowspan ?>"><?= $row['idbooking'] ?></td>
            <?php endif; ?>
            
            <?php if ($show_pasien): ?>
            <td rowspan="<?= $rowspan ?>"><?= $row['nama_pasien'] ?></td>
            <?php endif; ?>
            
            <?php if ($show_dokter): ?>
            <td rowspan="<?= $rowspan ?>"><?= $row['nama_dokter'] ?></td>
            <?php endif; ?>
            
            <?php if ($show_tglperawatan): ?>
            <td rowspan="<?= $rowspan ?>"><?= date('d-m-Y', strtotime($row['tglperawatan'])) ?></td>
            <?php endif; ?>
            
            <td><?= $row['qty'] ?></td>
            <td style="text-align: right;">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        </tr>
        <?php 
            $prev_idperawatan = $row['idperawatan'];
            $prev_idbooking = $row['idbooking'];
            $prev_pasien = $row['nama_pasien'];
            $prev_dokter = $row['nama_dokter'];
            $prev_tglperawatan = $row['tglperawatan'];
        endforeach; 
        ?>
        
        <tr>
            <th colspan="7" style="text-align: right;">Total Biaya:</th>
            <th style="text-align: right;">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></th>
        </tr>
    </tbody>
</table> 