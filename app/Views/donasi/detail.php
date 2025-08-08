<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Detail Donasi</h3>
                </div>
                <div class="card-body">
                    <?php if ($donasi['online'] == 0): ?>
                    <!-- Tampilan untuk Offline (online = 0) -->
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID Zakat:</strong>
                            <p><?= $donasi['iddonasi'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>ID Donatur:</strong>
                            <p><?= $donasi['id_donatur'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nama Donatur:</strong>
                            <p><?= $donasi['nama_donatur'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Alamat Donatur:</strong>
                            <p><?= $donasi['alamat'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>No HP:</strong>
                            <p><?= $donasi['nohp'] ?></p>
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
                                $jenis = strtolower($donasi['namaprogram']);
                                echo $badges[$jenis] ?? ucfirst($donasi['namaprogram']);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nominal:</strong>
                            <p class="h5 text-success">Rp <?= number_format($donasi['nominal'], 0, ',', '.') ?></p>
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
                                echo $badges[$donasi['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
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
                            <p><?= $donasi['iddonasi'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>ID Donatur:</strong>
                            <p><?= $donasi['id_donatur'] ?></p>
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
                                $jenis = strtolower($donasi['namaprogram']);
                                echo $badges[$jenis] ?? ucfirst($donasi['namaprogram']);
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nominal:</strong>
                            <p class="h5 text-success">Rp <?= number_format($donasi['nominal'], 0, ',', '.') ?></p>
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
                                echo $badges[$donasi['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
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
                            <p><?= $donasi['tgltransfer'] ? date('d-m-Y', strtotime($donasi['tgltransfer'])) : 'Belum ada tanggal' ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Bukti Bayar:</strong>
                            <p>
                                <?php if ($donasi['buktibayar']): ?>
                                    <a href="/uploads/zakat/<?= $donasi['buktibayar'] ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    Tidak ada bukti bayar
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($donasi['buktibayar']): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Preview Bukti Bayar:</strong>
                            <div class="mt-2">
                                <img src="/uploads/zakat/<?= $donasi['buktibayar'] ?>" class="img-fluid" style="max-height: 400px; border: 1px solid #ddd; border-radius: 5px;" alt="Bukti Bayar">
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
                                <a href="/zakat/formedit/<?= $donasi['iddonasi'] ?>" class="btn btn-primary">
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