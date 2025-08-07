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
                        <a href="<?= site_url('kategori/formtambah') ?>" class="btn btn-danger">Tambah Kategori</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelkategori">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
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
    $('#tabelkategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/kategori/view',
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
        var idkategori = $(this).data('idkategori');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data kategori ini?',
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
                        url: "<?php echo site_url('kategori/delete'); ?>",
                        data: {
                            idkategori: idkategori
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
                            $('#tabelkategori').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data kategori',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data kategori',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var idkategori = $(this).data('idkategori');
    window.location.href = "<?php echo site_url('kategori/formedit/'); ?>" + idkategori;
});


</script>
<?= $this->endSection() ?> 