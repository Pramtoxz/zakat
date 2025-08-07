<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Edit Permohonan</h3>
            </div>

            <div class="card-body">
                <?= form_open('permohonan/updatedata/' . $permohonan['idpermohonan'], ['id' => 'formeditpermohonan', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpermohonan">ID Permohonan</label>
                            <input type="text" id="idpermohonan" name="idpermohonan" class="form-control" value="<?= $permohonan['idpermohonan'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_mustahik">Mustahik <span class="text-danger">*</span></label>
                            <select id="id_mustahik" name="id_mustahik" class="form-control">
                                <option value="">Pilih Mustahik</option>
                                <?php foreach ($mustahiks as $mustahik): ?>
                                    <option value="<?= $mustahik['id_mustahik'] ?>" <?= $permohonan['id_mustahik'] == $mustahik['id_mustahik'] ? 'selected' : '' ?>>
                                        <?= $mustahik['nama'] ?> - <?= $mustahik['id_mustahik'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_id_mustahik"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="kategoriasnaf">Kategori Asnaf <span class="text-danger">*</span></label>
                            <select id="kategoriasnaf" name="kategoriasnaf" class="form-control" onchange="loadSyaratInfo(this.value)">
                                <option value="">Pilih Kategori Asnaf</option>
                                <?php foreach ($syarats as $syarat): ?>
                                    <option value="<?= $syarat['kategori_asnaf'] ?>" <?= $permohonan['kategoriasnaf'] == $syarat['kategori_asnaf'] ? 'selected' : '' ?>>
                                        <?= ucfirst($syarat['kategori_asnaf']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_kategoriasnaf"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jenisbantuan">Jenis Bantuan <span class="text-danger">*</span></label>
                            <input type="text" id="jenisbantuan" name="jenisbantuan" class="form-control" placeholder="Masukkan jenis bantuan" value="<?= $permohonan['jenisbantuan'] ?>">
                            <div class="invalid-feedback error_jenisbantuan"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglpengajuan">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" id="tglpengajuan" name="tglpengajuan" class="form-control" value="<?= $permohonan['tglpengajuan'] ?>">
                            <div class="invalid-feedback error_tglpengajuan"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="dokumen">Dokumen Pendukung (PDF)</label>
                            <input type="file" id="dokumen" name="dokumen" class="form-control" accept=".pdf" onchange="validatePDF(this)">
                            <div class="invalid-feedback error_dokumen"></div>
                            <small class="form-text text-muted">
                                <?php if ($permohonan['dokumen']): ?>
                                    File saat ini: <a href="/uploads/permohonan/<?= $permohonan['dokumen'] ?>" target="_blank" class="text-primary"><i class="fas fa-file-pdf"></i> <?= $permohonan['dokumen'] ?></a><br>
                                <?php endif; ?>
                                Format: PDF saja (Maksimal: 5MB). Kosongkan jika tidak ingin mengubah.
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="alasan">Alasan Permohonan <span class="text-danger">*</span></label>
                            <textarea id="alasan" name="alasan" class="form-control" rows="4" placeholder="Jelaskan alasan permohonan bantuan"><?= $permohonan['alasan'] ?></textarea>
                            <div class="invalid-feedback error_alasan"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" id="tombolUpdate" style="margin-right: 1rem;">
                        <i class="fas fa-save"></i> UPDATE
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url('permohonan') ?>">Kembali</a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <!-- Info Card -->
    <div class="col-md-4">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title">Informasi Permohonan</h3>
            </div>
            <div class="card-body">
                <p><strong>Status Saat Ini:</strong> 
                    <?php
                    $badges = [
                        'diproses' => '<span class="badge badge-warning">Diproses</span>',
                        'diterima' => '<span class="badge badge-success">Diterima</span>',
                        'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                    ];
                    echo $badges[$permohonan['status']] ?? '<span class="badge badge-secondary">Unknown</span>';
                    ?>
                </p>
                <p><strong>Tgl Pengajuan:</strong> <?= date('d-m-Y', strtotime($permohonan['tglpengajuan'])) ?></p>
                <?php if ($permohonan['tgldisetujui']): ?>
                    <p><strong>Tgl Disetujui:</strong> <?= date('d-m-Y', strtotime($permohonan['tgldisetujui'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card bg-warning">
            <div class="card-header">
                <h3 class="card-title">Informasi Kategori Asnaf</h3>
            </div>
            <div class="card-body">
                <div id="info-syarat">
                    <small>
                        <strong>Pilih kategori asnaf untuk melihat syarat dan ketentuan</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#formeditpermohonan').submit(function(e) {
        e.preventDefault();

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
                if (response.sukses) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.sukses,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url('permohonan') ?>';
                        }
                    });
                } else {
                    if (response.error) {
                        // Clear previous errors
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        
                        // Show new errors
                        $.each(response.error, function(field, message) {
                            var fieldName = field.replace('error_', '');
                            $('#' + fieldName).addClass('is-invalid');
                            $('.error_' + fieldName).text(message);
                        });
                    }
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan validasi',
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

    // Load syarat info untuk kategori yang sudah dipilih saat edit
    var selectedKategori = $('#kategoriasnaf').val();
    if (selectedKategori) {
        loadSyaratInfo(selectedKategori);
    }
});

// Fungsi validasi PDF
function validatePDF(input) {
    const file = input.files[0];
    if (file) {
        // Validasi ekstensi file
        const fileName = file.name.toLowerCase();
        if (!fileName.endsWith('.pdf')) {
            Swal.fire({
                title: 'Format File Salah!',
                text: 'Hanya file PDF yang diperbolehkan',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            input.value = '';
            return false;
        }
        
        // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                title: 'File Terlalu Besar!',
                text: 'Ukuran file maksimal 5MB',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            input.value = '';
            return false;
        }
        
        // Validasi MIME type - lebih fleksibel untuk PDF
        if (file.type !== 'application/pdf' && file.type !== '') {
            // Jika MIME type kosong, periksa ekstensi saja (beberapa browser tidak set MIME type dengan benar)
            if (file.type !== '' && !file.type.includes('pdf')) {
                Swal.fire({
                    title: 'Format File Salah!',
                    text: 'File harus berformat PDF',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                input.value = '';
                return false;
            }
        }
        
        // Tampilkan nama file yang dipilih
        console.log('File PDF dipilih:', fileName, 'Size:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
    }
    return true;
}

// Fungsi untuk memuat informasi syarat berdasarkan kategori asnaf
function loadSyaratInfo(kategori) {
    if (kategori === '') {
        $('#info-syarat').html(`
            <small>
                <strong>Pilih kategori asnaf untuk melihat syarat dan ketentuan</strong>
            </small>
        `);
        return;
    }

    // Tampilkan loading
    $('#info-syarat').html(`
        <small>
            <i class="fas fa-spinner fa-spin"></i> Memuat informasi syarat...
        </small>
    `);

    $.ajax({
        type: 'POST',
        url: '<?= base_url('permohonan/getSyaratByKategori') ?>',
        data: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            kategori: kategori
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#info-syarat').html(`
                    <small>
                        <strong>${response.data.kategori_asnaf.toUpperCase()}</strong><br>
                        ${response.data.isi_syarat}
                    </small>
                `);
            } else {
                $('#info-syarat').html(`
                    <small>
                        <strong class="text-danger">Informasi syarat tidak ditemukan</strong>
                    </small>
                `);
            }
        },
        error: function(xhr, status, error) {
            $('#info-syarat').html(`
                <small>
                    <strong class="text-danger">Terjadi kesalahan saat memuat informasi syarat</strong>
                </small>
            `);
        }
    });
}
</script>
<?= $this->endSection() ?>