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
                        <a href="<?= site_url('donasi/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabeldonasi">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Donasi</th>
                                    <th>Donatur</th>
                                    <th>Program</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Donasi</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>ID Donasi:</strong>
                        <p id="detail-iddonasi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Donatur:</strong>
                        <p id="detail-donatur"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Program:</strong>
                        <p id="detail-program"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nominal:</strong>
                        <p id="detail-nominal"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tanggal Transfer:</strong>
                        <p id="detail-tgltransfer"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="detail-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Online:</strong>
                        <p id="detail-online"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Bukti Bayar:</strong>
                        <p id="detail-bukti"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi Bukti Bayar -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verifikasi Bukti Bayar</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>ID donasi:</strong>
                        <p id="verify-iddonasi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Donatur:</strong>
                        <p id="verify-donatur"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nominal:</strong>
                        <p id="verify-nominal"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status Saat Ini:</strong>
                        <p id="verify-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Bukti Bayar:</strong>
                        <div id="verify-bukti" class="mt-2"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Ubah Status:</strong>
                        <div class="btn-group d-block mt-2">
                            <button type="button" class="btn btn-success btn-verify-status mr-2" data-status="diterima">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button type="button" class="btn btn-danger btn-verify-status" data-status="ditolak">
                                <i class="fas fa-times"></i> Tolak
                            </button>
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
    // Initialize DataTable
    $('#tabeldonasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/donasi/view',
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

    let currentdonasiId = null;

    // Event handler untuk tombol detail
    $('#tabeldonasi').on('click', '.btn-detail', function() {
        var iddonasi = $(this).data('iddonasi');
        
        // Redirect ke halaman detail
        window.location.href = '/donasi/detail/' + iddonasi;
    });

    // Event handler untuk tombol edit
    $('#tabeldonasi').on('click', '.btn-edit', function() {
        var iddonasi = $(this).data('iddonasi');
        window.location.href = '/donasi/formedit/' + iddonasi;
    });

    // Event handler untuk tombol delete
    $('#tabeldonasi').on('click', '.btn-delete', function() {
        var iddonasi = $(this).data('iddonasi');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data donasi ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/donasi/delete',
                    type: 'POST',
                    data: {
                        iddonasi: iddonasi
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success');
                            $('#tabeldonasi').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', 'Gagal menghapus data', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            }
        });
    });

    // Event handler untuk tombol verifikasi
    $('#tabeldonasi').on('click', '.btn-verify', function() {
        var iddonasi = $(this).data('iddonasi');
        currentdonasiId = iddonasi;
        
        // Ambil data bukti bayar
        $.ajax({
            url: '/donasi/getBuktiBayar',
            type: 'POST',
            data: {
                iddonasi: iddonasi
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var donasi = response.data;
                    
                    $('#verify-iddonasi').text(donasi.iddonasi);
                    $('#verify-donatur').text(donasi.nama_donatur);
                    $('#verify-nominal').text('Rp ' + parseInt(donasi.nominal).toLocaleString('id-ID'));
                    $('#verify-status').html(getStatusBadge(donasi.status));
                    
                    // Handle bukti bayar
                    if (donasi.buktibayar) {
                        $('#verify-bukti').html('<img src="/uploads/donasi/' + donasi.buktibayar + '" class="img-fluid" style="max-height: 300px;" alt="Bukti Bayar">');
                    } else {
                        $('#verify-bukti').text('Tidak ada bukti bayar');
                    }
                    
                    $('#verifyModal').modal('show');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data', 'error');
            }
        });
    });

    // Event handler untuk verifikasi status
    $('.btn-verify-status').click(function() {
        var status = $(this).data('status');
        
        Swal.fire({
            title: 'Konfirmasi Verifikasi',
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
                    url: '/donasi/verifyPayment',
                    type: 'POST',
                    data: {
                        iddonasi: currentdonasiId,
                        status: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success');
                            $('#verifyModal').modal('hide');
                            $('#tabeldonasi').DataTable().ajax.reload();
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

function getStatusBadge(status) {
    var badges = {
        'diterima': '<span class="badge badge-success">Diterima</span>',
        'ditolak': '<span class="badge badge-danger">Ditolak</span>',
        'pending': '<span class="badge badge-warning">Pending</span>'
    };
    return badges[status] || '<span class="badge badge-secondary">Unknown</span>';
}

function getOnlineBadge(online) {
    return online == 1 ? '<span class="badge badge-info">Online</span>' : '<span class="badge badge-secondary">Offline</span>';
}
</script>
<?= $this->endSection() ?>