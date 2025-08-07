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
                        <a href="<?= site_url('penyaluran/formtambah') ?>" class="btn btn-danger">Tambah Penyaluran</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelPenyaluran">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Penyaluran</th>
                                    <th>Mustahik</th>
                                    <th>Jenis Dana</th>
                                    <th>Nominal</th>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="modal-header"
                style="background-color: #20C997; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-handshake mr-2"></i> Detail Penyaluran Dana
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detail-content" style="overflow-y: auto; max-height: 70vh;">
                <!-- Detail Penyaluran akan dimuat melalui AJAX -->
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelPenyaluran').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/penyaluran/view',
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
        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus Penyaluran ini?',
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
                    url: "<?php echo site_url('penyaluran/delete'); ?>",
                    data: {
                        id: id
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
                            $('#tabelPenyaluran').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus penyaluran',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus penyaluran',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    window.location.href = "<?php echo site_url('penyaluran/formedit/'); ?>" + id;
});

$(document).on('click', '.btn-detail', function() {
    var id = $(this).data('id');
    console.log('Detail button clicked for ID:', id);
    
    $.ajax({
        type: "GET",
        url: "<?= site_url('penyaluran/detail/') ?>" + id,
        dataType: 'html',
        beforeSend: function() {
            console.log('Loading detail for ID:', id);
            $('#detail-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
        },
        success: function(response) {
            console.log('Detail loaded successfully');
            $('#detail-content').html(response);
            $('#detailModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error loading detail:', xhr.responseText);
            $('#detail-content').html('<div class="alert alert-danger">Gagal memuat detail penyaluran</div>');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memuat detail penyaluran: ' + error
            });
        }
    });
});

// Modal akan ditutup otomatis oleh Bootstrap
// Tidak perlu custom close function

// Toggle status penyaluran
$(document).on('click', '.btn-toggle-status', function() {
    var id = $(this).data('id');
    var currentStatus = $(this).data('status');
    
    $.ajax({
        type: "POST",
        url: "<?= site_url('penyaluran/toggleStatus') ?>",
        data: {
            id: id,
            status: currentStatus
        },
        dataType: 'json',
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.sukses,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#tabelPenyaluran').DataTable().ajax.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.error || 'Gagal mengubah status penyaluran'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengubah status penyaluran'
            });
            console.error(xhr.responseText);
        }
    });
});
</script>
<?= $this->endSection() ?>