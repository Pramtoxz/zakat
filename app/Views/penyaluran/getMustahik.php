<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelMustahik">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Mustahik</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Jenis Kelamin</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelMustahik').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("penyaluran/viewGetMustahik") ?>',
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

$(document).ready(function() {
    $(document).on('click', '.btn-pilih-mustahik', function() {
        var id_mustahik = $(this).data('id');
        var nama_mustahik = $(this).data('nama');
        
        $('#id_mustahik').val(id_mustahik);
        $('#namamustahik').val(nama_mustahik);

        $('#modalMustahik').modal('hide');
        
        // Show success message
        if (typeof toastr !== 'undefined') {
            toastr.success('Mustahik berhasil dipilih', 'Sukses');
        }
    });
});
</script>