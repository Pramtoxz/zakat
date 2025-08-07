<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPermohonan">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Permohonan</th>
                <th>Nama Mustahik</th>
                <th>Kategori Asnaf</th>
                <th>Jenis Bantuan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelPermohonan').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("penyaluran/getPermohonanAjax") ?>',
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
    $(document).on('click', '.btn-pilih-permohonan', function() {
        var id_permohonan = $(this).data('id');
        var nama_permohonan = $(this).data('nama');
        
        $('#idpermohonan').val(id_permohonan);
        $('#namapermohonan').val(nama_permohonan);

        $('#modalPermohonan').modal('hide');
        
        // Show success message
        if (typeof toastr !== 'undefined') {
            toastr.success('Permohonan berhasil dipilih', 'Sukses');
        }
    });
});
</script>