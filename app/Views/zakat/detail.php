<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Detail Zakat</h3>
                </div>
                <div class="card-body">
                    <?php if ($zakat['online'] == 0): ?>
                    <!-- Tampilan untuk Offline (online = 0) -->
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID Zakat:</strong>
                            <p><?= $zakat['idzakat'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>ID Donatur:</strong>
                            <p><?= $zakat['id_donatur'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nama Donatur:</strong>
                            <p><?= $zakat['nama_donatur'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Alamat Donatur:</strong>
                            <p><?= $zakat['alamat'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>No HP:</strong>
                            <p><?= $zakat['nohp'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Zakat:</strong>
                            <p>
                                <?php
                                $badges = [
                                    'emas' => '<span class="badge badge-warning">Emas</span>',
                                    'fidyah' => '<span class="badge badge-info">Fidyah</span>',
                                    'maal' => '<span class="badge badge-success">Maal</span>',
                                    'penghasilan' => '<span class="badge badge-primary">Penghasilan</span>',
                                ];
                                $jenis = strtolower($zakat['jeniszakat']);
                                echo $badges[$jenis] ?? ucfirst($zakat['jeniszakat']);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nominal:</strong>
                            <p class="h5 text-success">Rp <?= number_format($zakat['nominal'], 0, ',', '.') ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p>
                                <?php
                                $badges = [
                                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                                    'pending' => '<span class="badge badge-warning">Pending</span>'
                                ];
                                echo $badges[$zakat['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Tipe Pembayaran:</strong>
                            <p>
                                <span class="badge badge-secondary">Offline</span>
                            </p>
                        </div>
                    </div>
                    
                    <?php else: ?>
                    <!-- Tampilan untuk Online (online = 1) -->
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID Zakat:</strong>
                            <p><?= $zakat['idzakat'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>ID Donatur:</strong>
                            <p><?= $zakat['id_donatur'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Jenis Zakat:</strong>
                            <p>
                                <?php
                                $badges = [
                                    'emas' => '<span class="badge badge-warning">Emas</span>',
                                    'fidyah' => '<span class="badge badge-info">Fidyah</span>',
                                    'maal' => '<span class="badge badge-success">Maal</span>',
                                    'penghasilan' => '<span class="badge badge-primary">Penghasilan</span>',
                                ];
                                $jenis = strtolower($zakat['jeniszakat']);
                                echo $badges[$jenis] ?? ucfirst($zakat['jeniszakat']);
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nominal:</strong>
                            <p class="h5 text-success">Rp <?= number_format($zakat['nominal'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p>
                                <?php
                                $badges = [
                                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                                    'pending' => '<span class="badge badge-warning">Pending</span>'
                                ];
                                echo $badges[$zakat['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipe Pembayaran:</strong>
                            <p>
                                <span class="badge badge-info">Online</span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tanggal Transfer:</strong>
                            <p><?= $zakat['tgltransfer'] ? date('d-m-Y', strtotime($zakat['tgltransfer'])) : 'Belum ada tanggal' ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Bukti Bayar:</strong>
                            <p>
                                <?php if ($zakat['buktibayar']): ?>
                                    <a href="/uploads/zakat/<?= $zakat['buktibayar'] ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    Tidak ada bukti bayar
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($zakat['buktibayar']): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Preview Bukti Bayar:</strong>
                            <div class="mt-2">
                                <img src="/uploads/zakat/<?= $zakat['buktibayar'] ?>" class="img-fluid" style="max-height: 400px; border: 1px solid #ddd; border-radius: 5px;" alt="Bukti Bayar">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Tombol Aksi -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="/zakat" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                <a href="/zakat/formedit/<?= $zakat['idzakat'] ?>" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Zakat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Script khusus untuk halaman detail zakat jika diperlukan
</script>
<?= $this->endSection() ?>