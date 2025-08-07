<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Detail Permohonan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID Permohonan:</strong>
                            <p><?= $permohonan['idpermohonan'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nama Mustahik:</strong>
                            <p><?= $permohonan['nama_mustahik'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Alamat:</strong>
                            <p><?= $permohonan['alamat'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>No HP:</strong>
                            <p><?= $permohonan['nohp'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Kategori Asnaf:</strong>
                            <p><?= ucfirst($permohonan['kategoriasnaf']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Bantuan:</strong>
                            <p><?= $permohonan['jenisbantuan'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tanggal Pengajuan:</strong>
                            <p><?= date('d-m-Y', strtotime($permohonan['tglpengajuan'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Disetujui:</strong>
                            <p><?= $permohonan['tgldisetujui'] ? date('d-m-Y', strtotime($permohonan['tgldisetujui'])) : '-' ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p>
                                <?php
                                $badges = [
                                    'diproses' => '<span class="badge badge-warning">Diproses</span>',
                                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                                ];
                                echo $badges[$permohonan['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Dokumen:</strong>
                            <p>
                                <?php if ($permohonan['dokumen']): ?>
                                    <a href="/uploads/permohonan/<?= $permohonan['dokumen'] ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>
                                <?php else: ?>
                                    Tidak ada dokumen
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Alasan Permohonan:</strong>
                            <p><?= $permohonan['alasan'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Ubah Status Permohonan</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical d-block" role="group">
                        <button type="button" class="btn btn-warning btn-status mb-2" data-status="diproses" <?= $permohonan['status'] == 'diproses' ? 'disabled' : '' ?>>
                            <i class="fas fa-clock"></i> Diproses
                        </button>
                        <button type="button" class="btn btn-success btn-status mb-2" data-status="diterima" <?= $permohonan['status'] == 'diterima' ? 'disabled' : '' ?>>
                            <i class="fas fa-check"></i> Diterima
                        </button>
                        <button type="button" class="btn btn-danger btn-status mb-2" data-status="ditolak" <?= $permohonan['status'] == 'ditolak' ? 'disabled' : '' ?>>
                            <i class="fas fa-times"></i> Ditolak
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Aksi</h3>
                </div>
                <div class="card-body">
                    <a href="/permohonan/formedit/<?= $permohonan['idpermohonan'] ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Edit Permohonan
                    </a>
                    <a href="/permohonan" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Event handler untuk tombol ubah status
    $('.btn-status').click(function() {
        var status = $(this).data('status');
        var idpermohonan = '<?= $permohonan['idpermohonan'] ?>';
        
        Swal.fire({
            title: 'Konfirmasi Ubah Status',
            text: 'Apakah Anda yakin ingin mengubah status menjadi "' + status.toUpperCase() + '"?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/permohonan/updateStatus',
                    type: 'POST',
                    data: {
                        idpermohonan: idpermohonan,
                        status: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.sukses,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Gagal mengubah status', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat mengubah status', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>