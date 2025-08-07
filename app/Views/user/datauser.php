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
                        <a href="<?= site_url('user/formtambah') ?>" class="btn btn-danger">Tambah User</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabeluser">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Created At</th>
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

<!-- Modal Detail User -->
<div class="modal fade" id="modalDetailUser" tabindex="-1" role="dialog" aria-labelledby="modalDetailUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailUserLabel">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Username:</strong>
                        <p id="detail-username"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p id="detail-email"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Role:</strong>
                        <p id="detail-role"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="detail-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Last Login:</strong>
                        <p id="detail-last-login"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Created At:</strong>
                        <p id="detail-created-at"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Updated At:</strong>
                        <p id="detail-updated-at"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabeluser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/user/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [1, 'asc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    // Event handler untuk tombol detail
    $('#tabeluser').on('click', '.btn-detail', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/user/detail',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var user = response.data;
                    
                    $('#detail-username').text(user.username);
                    $('#detail-email').text(user.email);
                    $('#detail-role').html(getRoleBadge(user.role));
                    $('#detail-status').html(getStatusBadge(user.status));
                    $('#detail-last-login').text(user.last_login_formatted);
                    $('#detail-created-at').text(user.created_at_formatted);
                    $('#detail-updated-at').text(user.updated_at_formatted);
                    
                    $('#modalDetailUser').modal('show');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data', 'error');
            }
        });
    });

    // Event handler untuk tombol edit
    $('#tabeluser').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        window.location.href = '/user/formedit/' + id;
    });

    // Event handler untuk tombol delete
    $('#tabeluser').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus user ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user/delete',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#tabeluser').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            }
        });
    });

    // Helper functions untuk badge
    function getRoleBadge(role) {
        var badges = {
            'admin': '<span class="badge badge-danger">Admin</span>',
            'ketua': '<span class="badge badge-primary">Ketua</span>',
            'program': '<span class="badge badge-info">Program</span>',
            'keuangan': '<span class="badge badge-warning">Keuangan</span>',
            'mustahik': '<span class="badge badge-success">Mustahik</span>',
            'donatur': '<span class="badge badge-dark">Donatur</span>'
        };
        return badges[role] || '<span class="badge badge-secondary">Unknown</span>';
    }

    function getStatusBadge(status) {
        if (status === 'active') {
            return '<span class="badge badge-success">Aktif</span>';
        } else {
            return '<span class="badge badge-secondary">Tidak Aktif</span>';
        }
    }
});
</script>
<?= $this->endSection() ?>