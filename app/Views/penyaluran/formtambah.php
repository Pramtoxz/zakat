<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-hand-holding-heart mr-2"></i> Tambah Penyaluran Dana</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('penyaluran/save', ['id' => 'formtambahpenyaluran', 'enctype' => 'multipart/form-data']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-10">

                            <!-- Jenis Dana -->
                            <div class="form-group row mb-4">
                                <label for="jenisdana" class="col-sm-3 col-form-label"><strong>Jenis Dana <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <select id="jenisdana" name="jenisdana" class="form-control" onchange="handleJenisDanaChange()">
                                        <option value="">-- Pilih Jenis Dana --</option>
                                        <option value="zakat">Zakat</option>
                                        <option value="donasi">Donasi</option>
                                    </select>
                                    <div class="invalid-feedback error_jenisdana"></div>
                                </div>
                            </div>

                            <!-- Input Permohonan (untuk Zakat) -->
                            <div class="form-group row mb-4" id="input-permohonan" style="display: none;">
                                <label for="idpermohonan" class="col-sm-3 col-form-label"><strong>Permohonan <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" id="idpermohonan" name="idpermohonan" class="form-control" readonly>
                                        <input type="text" id="namapermohonan" name="namapermohonan" class="form-control" placeholder="Pilih permohonan..." readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalPermohonan">
                                                <i class="fas fa-search"></i> Cari Permohonan
                                            </button>
                                        </div>
                                        <div class="invalid-feedback error_idpermohonan"></div>
                                    </div>
                                    <small class="form-text text-muted">Pilih permohonan zakat yang telah disetujui</small>
                                </div>
                            </div>

                            <!-- Input Mustahik (untuk Donasi) -->
                            <div class="form-group row mb-4" id="input-mustahik" style="display: none;">
                                <label for="id_mustahik" class="col-sm-3 col-form-label"><strong>Mustahik <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" id="id_mustahik" name="id_mustahik" class="form-control" readonly>
                                        <input type="text" id="namamustahik" name="namamustahik" class="form-control" placeholder="Pilih mustahik..." readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalMustahik">
                                                <i class="fas fa-search"></i> Cari Mustahik
                                            </button>
                                        </div>
                                        <div class="invalid-feedback error_id_mustahik"></div>
                                    </div>
                                    <small class="form-text text-muted">Pilih penerima dana donasi</small>
                                </div>
                            </div>

                            <!-- Input Program Donasi (untuk Donasi) -->
                            <div class="form-group row mb-4" id="input-program-donasi" style="display: none;">
                                <label for="idprogram" class="col-sm-3 col-form-label"><strong>Program Donasi <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <select id="idprogram" name="idprogram" class="form-control">
                                        <option value="">-- Pilih Program Donasi --</option>
                                        <?php foreach ($programs as $program): ?>
                                            <option value="<?= $program['idprogram'] ?>"><?= $program['namaprogram'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback error_idprogram"></div>
                                    <small class="form-text text-muted">Pilih program donasi yang akan disalurkan</small>
                                </div>
                            </div>

                            <!-- Nominal -->
                            <div class="form-group row mb-4">
                                <label for="nominal" class="col-sm-3 col-form-label"><strong>Nominal <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" id="nominal" name="nominal" class="form-control" placeholder="Masukkan nominal dana" min="0">
                                        <div class="invalid-feedback error_nominal"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Penyaluran -->
                            <div class="form-group row mb-4">
                                <label for="tglpenyaluran" class="col-sm-3 col-form-label"><strong>Tanggal Penyaluran <span class="text-danger">*</span></strong></label>
                                <div class="col-sm-9">
                                    <input type="date" id="tglpenyaluran" name="tglpenyaluran" class="form-control" value="<?= date('Y-m-d') ?>">
                                    <div class="invalid-feedback error_tglpenyaluran"></div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group row mb-4">
                                <label for="deskripsi" class="col-sm-3 col-form-label"><strong>Deskripsi</strong></label>
                                <div class="col-sm-9">
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Keterangan tambahan (opsional)"></textarea>
                                    <div class="invalid-feedback error_deskripsi"></div>
                                </div>
                            </div>

                            <!-- Foto Bukti -->
                            <div class="form-group row mb-4">
                                <label for="foto" class="col-sm-3 col-form-label"><strong>Foto Bukti</strong></label>
                                <div class="col-sm-9">
                                    <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                                    <div class="invalid-feedback error_foto"></div>
                                    <small class="form-text text-muted">Format: JPG, PNG, JPEG (Maksimal: 2MB)</small>
                                </div>
                            </div>
                            
                            <!-- Tombol Submit -->
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-success btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN PENYALURAN
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('penyaluran') ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> KEMBALI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?= form_close() ?>

                    <!-- Modal Pilih Permohonan (untuk Zakat) -->
                    <div class="modal fade" id="modalPermohonan" tabindex="-1" role="dialog" aria-labelledby="modalPermohonanLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalPermohonanLabel">
                                        <i class="fas fa-file-alt mr-2"></i>Pilih Permohonan Zakat
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Konten akan dimuat dari getPermohonan.php -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i>Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pilih Mustahik (untuk Donasi) -->
                    <div class="modal fade" id="modalMustahik" tabindex="-1" role="dialog" aria-labelledby="modalMustahikLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="modalMustahikLabel">
                                        <i class="fas fa-users mr-2"></i>Pilih Mustahik
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Konten akan dimuat dari getMustahik.php -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i>Tutup
                                    </button>
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
$(function() {
    // Modal akan menggunakan file terpisah untuk DataTables
    
    // Fungsi untuk menangani perubahan jenis dana
    window.handleJenisDanaChange = function() {
        const jenisDana = $('#jenisdana').val();
        
        // Reset semua input
        resetInputs();
        
        if (jenisDana === 'zakat') {
            // Tampilkan input permohonan, sembunyikan input mustahik dan program donasi
            $('#input-permohonan').show();
            $('#input-mustahik').hide();
            $('#input-program-donasi').hide();
            
            // Reset input mustahik dan program
            $('#id_mustahik').val('');
            $('#namamustahik').val('');
            $('#idprogram').val('');
        } else if (jenisDana === 'donasi') {
            // Tampilkan input mustahik dan program donasi, sembunyikan input permohonan
            $('#input-mustahik').show();
            $('#input-program-donasi').show();
            $('#input-permohonan').hide();
            
            // Reset input permohonan
            $('#idpermohonan').val('');
            $('#namapermohonan').val('');
        } else {
            // Sembunyikan semua input tambahan
            $('#input-permohonan').hide();
            $('#input-mustahik').hide();
            $('#input-program-donasi').hide();
        }
    };
    
    // Fungsi untuk mereset semua input dan validasi
    function resetInputs() {
        // Reset input values
        $('#idpermohonan').val('');
        $('#namapermohonan').val('');
        $('#id_mustahik').val('');
        $('#namamustahik').val('');
        $('#idprogram').val('');
        
        // Reset validation classes
        $('.form-control').removeClass('is-invalid is-valid');
        $('.invalid-feedback').text('');
    }
    
    // Event handler untuk modal permohonan
    $('#modalPermohonan').on('show.bs.modal', function(e) {
        var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Load data dari getPermohonan.php
        $.get('<?= base_url('penyaluran/getPermohonan') ?>', function(data) {
            $('#modalPermohonan .modal-body').html(data);
        });
    });
    
    // Event handler untuk modal mustahik
    $('#modalMustahik').on('show.bs.modal', function(e) {
        var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Load data dari getMustahik.php
        $.get('<?= base_url('penyaluran/getMustahik') ?>', function(data) {
            $('#modalMustahik .modal-body').html(data);
        });
    });
    
    // Event handler untuk tombol pilih permohonan sudah ada di getPermohonan.php
    
    // Event handler untuk tombol pilih mustahik sudah ada di getMustahik.php
    
    // Form submission handler
    $('#formtambahpenyaluran').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="fas fa-spinner fa-spin mr-1"></i> MENYIMPAN...').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save mr-1"></i> SIMPAN PENYALURAN').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    // Handle validation errors
                    let err = response.error;
                    
                    // Reset all validation classes
                    $('.form-control').removeClass('is-invalid is-valid');
                    $('.invalid-feedback').text('');
                    
                    // Show errors
                    Object.keys(err).forEach(function(field) {
                        if (err[field]) {
                            const fieldName = field.replace('error_', '');
                            $('#' + fieldName).addClass('is-invalid');
                            $('.error_' + fieldName).text(err[field]);
                        }
                    });
                    
                    // Show error notification
                    Swal.fire({
                        title: 'Validasi Error!',
                        text: 'Silakan periksa kembali data yang Anda masukkan',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (response.sukses) {
                    // Show success notification
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.sukses,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url('penyaluran') ?>';
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

        return false;
    });
    
    // Clear error on input change
    $('.form-control').on('input change', function() {
        $(this).removeClass('is-invalid');
        const fieldName = $(this).attr('name');
        if (fieldName) {
            $('.error_' + fieldName).text('');
        }
    });
    
    // Initialize toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
});
</script>
<?= $this->endSection() ?>