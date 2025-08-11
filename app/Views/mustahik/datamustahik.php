<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('mustahik/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelMustahik">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Mustahik</th>
                                    <th>Nama Mustahik</th>
                                    <th>No HP</th>
                                    <th>Jenkel</th>
                                    <th class="no-short">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="modal-header"
                style="background-color: #28a745; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-id-card mr-2"></i> Detail Mustahik
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detail-content" style="overflow-y: auto;">
                <!-- Detail Mustahik akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="createUserModalLabel"><i class="fas fa-user-plus mr-2"></i> Buat Akun User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCreateUser">
                    <input type="hidden" id="user_id_mustahik" name="id_mustahik">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback error-username"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback error-email"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback error-password"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSubmitCreateUser">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelMustahik').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/mustahik/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    $(document).on('click', '.btn-delete', function() {
        var id_mustahik = $(this).data('id_mustahik');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('mustahik/delete'); ?>",
                    data: {
                        id_mustahik: id_mustahik
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.sukses,
                                icon: 'success'
                            });
                            // Refresh DataTable
                            $('#tabelMustahik').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var id_mustahik = $(this).data('id_mustahik');
    window.location.href = "<?php echo site_url('mustahik/formedit/'); ?>" + id_mustahik;
});

$(document).on('click', '.btn-detail', function() {
    var id_mustahik = $(this).data('id_mustahik');
    $.ajax({
        type: "GET",
        url: "<?= site_url('mustahik/detail/') ?>" + id_mustahik,
        dataType: 'html',
        success: function(response) {
            $('#detail-content').html(response);
            document.getElementById('detailModal').classList.remove('hidden');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Gagal memuat detail mustahik');
        }
    });
});

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Tutup modal jika mengklik diluar modal
window.onclick = function(event) {
    var modal = document.getElementById('detailModal');
    if (event.target == modal) {
        modal.classList.add('hidden');
    }
}

// Event handler untuk tombol create user
$(document).on('click', '.btn-create-user', function() {
    var id_mustahik = $(this).data('id_mustahik');
    $('#user_id_mustahik').val(id_mustahik);
    // Reset form
    $('#formCreateUser')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
});

// Submit form create user
$('#btnSubmitCreateUser').on('click', function() {
    var id_mustahik = $('#user_id_mustahik').val();
    
    $.ajax({
        url: '<?= site_url('mustahik/createUser/') ?>' + id_mustahik,
        type: 'POST',
        data: $('#formCreateUser').serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#createUserModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message
                }).then(function() {
                    $('#tabelmustahik').DataTable().ajax.reload();
                });
            } else if (response.errors) {
                // Tampilkan pesan error validasi
                if (response.errors.username) {
                    $('#username').addClass('is-invalid');
                    $('.error-username').text(response.errors.username);
                }
                if (response.errors.email) {
                    $('#email').addClass('is-invalid');
                    $('.error-email').text(response.errors.email);
                }
                if (response.errors.password) {
                    $('#password').addClass('is-invalid');
                    $('.error-password').text(response.errors.password);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Terjadi kesalahan saat membuat akun user'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengirim data'
            });
            console.error(xhr.responseText);
        }
    });
});
</script>
<?= $this->endSection() ?>