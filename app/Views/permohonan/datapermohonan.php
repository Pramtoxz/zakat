<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Permohonan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('permohonan/formtambah') ?>" class="btn btn-danger">Tambah Permohonan</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelpermohonan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Permohonan</th>
                                    <th>Nama Mustahik</th>
                                    <th>Kategori Asnaf</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Tgl Pengajuan</th>
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

<!-- Modal Detail Permohonan -->
<div class="modal fade" id="modalDetailPermohonan" tabindex="-1" role="dialog" aria-labelledby="modalDetailPermohonanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailPermohonanLabel">Detail Permohonan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>ID Permohonan:</strong>
                        <p id="detail-idpermohonan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nama Mustahik:</strong>
                        <p id="detail-nama-mustahik"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Alamat:</strong>
                        <p id="detail-alamat"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>No HP:</strong>
                        <p id="detail-nohp"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Kategori Asnaf:</strong>
                        <p id="detail-kategoriasnaf"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenis Bantuan:</strong>
                        <p id="detail-jenisbantuan"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tanggal Pengajuan:</strong>
                        <p id="detail-tglpengajuan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Disetujui:</strong>
                        <p id="detail-tgldisetujui"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="detail-status"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Dokumen:</strong>
                        <p id="detail-dokumen"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Alasan:</strong>
                        <p id="detail-alasan"></p>
                    </div>
                </div>
                
                <!-- Status Management -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <hr>
                        <h6><strong>Ubah Status Permohonan:</strong></h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-warning btn-status" data-status="diproses">
                                <i class="fas fa-clock"></i> Diproses
                            </button>
                            <button type="button" class="btn btn-success btn-status" data-status="diterima">
                                <i class="fas fa-check"></i> Diterima
                            </button>
                            <button type="button" class="btn btn-danger btn-status" data-status="ditolak">
                                <i class="fas fa-times"></i> Ditolak
                            </button>
                        </div>
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
    $('#tabelpermohonan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/permohonan/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [1, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    let currentPermohonanId = null;

    // Event handler untuk tombol detail - menggunakan modal langsung seperti MustahikController
    $('#tabelpermohonan').on('click', '.btn-detail', function() {
        var idpermohonan = $(this).data('idpermohonan');
        currentPermohonanId = idpermohonan;
        
        // Redirect ke halaman detail
        window.location.href = '/permohonan/detail/' + idpermohonan;
    });

    // Event handler untuk tombol edit
    $('#tabelpermohonan').on('click', '.btn-edit', function() {
        var idpermohonan = $(this).data('idpermohonan');
        window.location.href = '/permohonan/formedit/' + idpermohonan;
    });

    // Event handler untuk tombol delete
    $('#tabelpermohonan').on('click', '.btn-delete', function() {
        var idpermohonan = $(this).data('idpermohonan');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus permohonan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/permohonan/delete',
                    type: 'POST',
                    data: {
                        idpermohonan: idpermohonan
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success');
                            $('#tabelpermohonan').DataTable().ajax.reload();
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

    // Event handler untuk tombol ubah status
    $(document).on('click', '.btn-status', function() {
        var status = $(this).data('status');
        
        if (!currentPermohonanId) {
            Swal.fire('Error!', 'ID Permohonan tidak ditemukan', 'error');
            return;
        }

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
                        id: currentPermohonanId,
                        status: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#tabelpermohonan').DataTable().ajax.reload();
                            $('#modalDetailPermohonan').modal('hide');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat mengubah status', 'error');
                    }
                });
            }
        });
    });

    // Helper function untuk badge status
    function getStatusBadge(status) {
        var badges = {
            'diproses': '<span class="badge badge-warning">Diproses</span>',
            'diterima': '<span class="badge badge-success">Diterima</span>',
            'ditolak': '<span class="badge badge-danger">Ditolak</span>'
        };
        return badges[status] || '<span class="badge badge-secondary">Unknown</span>';
    }
});
</script>
<?= $this->endSection() ?>