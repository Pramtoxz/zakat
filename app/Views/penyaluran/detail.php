<div class="row">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted text-muted">ID Penyaluran</div>
                    <div class="col-sm-8"><strong><?= $penyaluran['id'] ?></strong></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted text-muted">Jenis Dana</div>
                    <div class="col-sm-8">
                        <?php if ($penyaluran['jenisdana'] == 'zakat'): ?>
                            <span class="badge badge-success">Zakat</span>
                        <?php elseif ($penyaluran['jenisdana'] == 'donasi'): ?>
                            <span class="badge badge-primary">Donasi</span>
                        <?php else: ?>
                            <span class="badge badge-secondary"><?= ucfirst($penyaluran['jenisdana']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Penerima (Mustahik)</div>
                    <div class="col-sm-8"><?= $penyaluran['nama_mustahik'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Alamat Penerima</div>
                    <div class="col-sm-8"><?= $penyaluran['alamat_mustahik'] ?? '-' ?></div>
                </div>
                <?php if ($penyaluran['jenisdana'] == 'zakat' && !empty($penyaluran['kategoriasnaf'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Kategori Asnaf</div>
                    <div class="col-sm-8">
                        <span class="badge badge-info"><?= ucfirst($penyaluran['kategoriasnaf']) ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Jenis Bantuan</div>
                    <div class="col-sm-8"><?= $penyaluran['jenisbantuan'] ?? '-' ?></div>
                </div>
                <?php endif; ?>
                <?php if ($penyaluran['jenisdana'] == 'donasi' && !empty($penyaluran['namaprogram'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Program Donasi</div>
                    <div class="col-sm-8">
                        <span class="badge badge-warning"><?= $penyaluran['namaprogram'] ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Kategori Program</div>
                    <div class="col-sm-8"><?= $penyaluran['namakategori'] ?? '-' ?></div>
                </div>
                <?php endif; ?>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Nominal</div>
                    <div class="col-sm-8">
                        <strong class="text-success">Rp <?= number_format($penyaluran['nominal'], 0, ',', '.') ?></strong>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Tanggal Penyaluran</div>
                    <div class="col-sm-8">
                        <i class="fas fa-calendar mr-1"></i> 
                        <?= date('d F Y', strtotime($penyaluran['tglpenyaluran'])) ?>
                    </div>
                </div>
                <?php if (!empty($penyaluran['deskripsi'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Deskripsi</div>
                    <div class="col-sm-8"><?= nl2br(htmlspecialchars($penyaluran['deskripsi'])) ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($penyaluran['foto'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold text-muted">Foto Bukti</div>
                    <div class="col-sm-8">
                        <img src="<?= base_url('uploads/penyaluran/' . $penyaluran['foto']) ?>" 
                             alt="Foto Bukti Penyaluran" 
                             class="img-thumbnail" 
                             style="max-width: 300px; max-height: 200px;">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>