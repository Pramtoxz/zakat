<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>

            <div class="card-body">
                <?= form_open('user/updatedata/' . $user['id'], ['id' => 'formedituser']) ?>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" value="<?= $user['username'] ?>">
                            <div class="invalid-feedback error_username"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="<?= $user['email'] ?>">
                            <div class="invalid-feedback error_email"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <div class="invalid-feedback error_password"></div>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter jika diisi.</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password_confirm">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi password baru">
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
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="ketua" <?= $user['role'] == 'ketua' ? 'selected' : '' ?>>Ketua</option>
                                <option value="program" <?= $user['role'] == 'program' ? 'selected' : '' ?>>Program</option>
                                <option value="keuangan" <?= $user['role'] == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                <option value="mustahik" <?= $user['role'] == 'mustahik' ? 'selected' : '' ?>>Mustahik</option>
                                <option value="donatur" <?= $user['role'] == 'donatur' ? 'selected' : '' ?>>Donatur</option>
                            </select>
                            <div class="invalid-feedback error_role"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback error_status"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" id="tombolUpdate" style="margin-right: 1rem;">
                        <i class="fas fa-save"></i> UPDATE
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url('user') ?>">Kembali</a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <!-- Info Card -->
    <div class="col-md-4">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title">Informasi User</h3>
            </div>
            <div class="card-body">
                <p><strong>Dibuat:</strong> <?= date('d-m-Y H:i', strtotime($user['created_at'])) ?></p>
                <p><strong>Terakhir Diupdate:</strong> <?= $user['updated_at'] ? date('d-m-Y H:i', strtotime($user['updated_at'])) : '-' ?></p>
                <p><strong>Last Login:</strong> <?= $user['last_login'] ? date('d-m-Y H:i', strtotime($user['last_login'])) : 'Belum pernah login' ?></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#formedituser').submit(function(e) {
        e.preventDefault();
        
        // Validasi password confirmation jika password diisi
        var password = $('#password').val();
        var passwordConfirm = $('#password_confirm').val();
        
        if (password !== '' && password !== passwordConfirm) {
            $('.error_password_confirm').text('Password konfirmasi tidak sama');
            $('#password_confirm').addClass('is-invalid');
            return false;
        }

        var formData = new FormData(this);
        
        $('#tombolUpdate').prop('disabled', true);
        $('#tombolUpdate').html('<i class="fas fa-spinner fa-spin"></i> Mengupdate...');

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
                $('#tombolUpdate').prop('disabled', false);
                $('#tombolUpdate').html('<i class="fas fa-save"></i> UPDATE');
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