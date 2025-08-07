<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-eye mr-2"></i> Detail Program</h3>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (!empty($program['foto'])): ?>
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('assets/img/program/' . $program['foto']) ?>" alt="Foto Program" class="img-fluid rounded shadow" style="max-width: 100%; max-height: 300px;">
                                </div>
                            <?php else: ?>
                                <div class="text-center mb-4">
                                    <div class="bg-light rounded p-5" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                    <p class="text-muted mt-2">Tidak ada foto</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>ID Program:</strong></div>
                                <div class="col-sm-8"><?= $program['idprogram'] ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Nama Program:</strong></div>
                                <div class="col-sm-8"><?= $program['namaprogram'] ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Kategori:</strong></div>
                                <div class="col-sm-8"><?= $program['namakategori'] ?? 'Tidak ada kategori' ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge badge-<?= $program['status'] == 'tersedia' ? 'success' : 'secondary' ?> badge-lg">
                                        <?= ucfirst($program['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Deskripsi:</strong></div>
                                <div class="col-sm-8"><?= nl2br(htmlspecialchars($program['deskripsi'])) ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Ubah Status Program</h5>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select class="form-control" id="statusProgram">
                                        <option value="tersedia" <?= $program['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                        <option value="selesai" <?= $program['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-warning" id="btnUpdateStatus">
                                        <i class="fas fa-sync-alt mr-1"></i> Update Status
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a class="btn btn-secondary btn-lg px-4" href="<?= base_url('program') ?>">
                                <i class="fas fa-arrow-left mr-1"></i> KEMBALI
                            </a>
                            <a class="btn btn-primary btn-lg px-4 ml-2" href="<?= base_url('program/formedit/' . $program['idprogram']) ?>">
                                <i class="fas fa-edit mr-1"></i> EDIT
                            </a>
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
$(document).ready(function() {
    $('#btnUpdateStatus').click(function() {
        var status = $('#statusProgram').val();
        var idprogram = '<?= $program['idprogram'] ?>';
        
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengubah status menjadi ' + status + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('program/updateStatus') ?>",
                    data: {
                        idprogram: idprogram,
                        status: status
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnUpdateStatus').html('<i class="fas fa-spin fa-spinner"></i> Tunggu...');
                        $('#btnUpdateStatus').prop('disabled', true);
                    },
                    complete: function() {
                        $('#btnUpdateStatus').html('<i class="fas fa-sync-alt mr-1"></i> Update Status');
                        $('#btnUpdateStatus').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.sukses,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response.error) {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal mengubah status program',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>