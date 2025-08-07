<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>

            <div class="card-body">
                <?= form_open('user/save', ['id' => 'formtambahuser']) ?>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username">
                            <div class="invalid-feedback error_username"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email">
                            <div class="invalid-feedback error_email"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password">
                            <div class="invalid-feedback error_password"></div>
                            <small class="form-text text-muted">Password minimal 6 karakter</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password_confirm">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi password">
                            <div class="invalid-feedback error_password_confirm"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="ketua">Ketua</option>
                                <option value="program">Program</option>
                                <option value="keuangan">Keuangan</option>
                                <option value="mustahik">Mustahik</option>
                                <option value="donatur">Donatur</option>
                            </select>
                            <div class="invalid-feedback error_role"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback error_status"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                        <i class="fas fa-save"></i> SIMPAN
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url('user') ?>">Kembali</a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#formtambahuser').submit(function(e) {
        e.preventDefault();
        
        // Validasi password confirmation
        var password = $('#password').val();
        var passwordConfirm = $('#password_confirm').val();
        
        if (password !== passwordConfirm) {
            $('.error_password_confirm').text('Password konfirmasi tidak sama');
            $('#password_confirm').addClass('is-invalid');
            return false;
        }

        var formData = new FormData(this);
        
        $('#tombolSimpan').prop('disabled', true);
        $('#tombolSimpan').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url('user') ?>';
                        }
                    });
                } else {
                    if (response.errors) {
                        // Clear previous errors
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        
                        // Show new errors
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('.error_' + field).text(message);
                        });
                    }
                    
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'Terjadi kesalahan',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                $('#tombolSimpan').prop('disabled', false);
                $('#tombolSimpan').html('<i class="fas fa-save"></i> SIMPAN');
            }
        });
    });

    // Clear error on input change
    $('.form-control').on('input change', function() {
        $(this).removeClass('is-invalid');
        var fieldName = $(this).attr('name');
        $('.error_' + fieldName).text('');
    });
});
</script>
<?= $this->endSection() ?>