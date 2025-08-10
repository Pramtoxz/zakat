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
                        <a href="<?= site_url('program/formtambah') ?>" class="btn btn-danger">Tambah Program</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelprogram">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Program</th>
                                    <th>Nama Program</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
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
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelprogram').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/program/view',
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
        var idprogram = $(this).data('idprogram');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data program ini?',
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
                    url: "<?php echo site_url('program/delete'); ?>",
                    data: {
                        idprogram: idprogram
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
                            $('#tabelprogram').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data program',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data program',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var idprogram = $(this).data('idprogram');
    window.location.href = "<?php echo site_url('program/formedit/'); ?>" + idprogram;
});

$(document).on('click', '.btn-detail', function() {
    var idprogram = $(this).data('idprogram');
    window.location.href = "<?php echo site_url('program/detail/'); ?>" + idprogram;
});

$(document).on('click', '.btn-status', function() {
    var idprogram = $(this).data('idprogram');
    Swal.fire({
        title: 'Ubah Status Program',
        text: "Apakah Anda yakin ingin mengubah status program ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo site_url('program/status/'); ?>" + idprogram;
            Swal.fire({
                title: 'Sukses!',
                text: 'Status berhasil di ubah',
                icon: 'success'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>