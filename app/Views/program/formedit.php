<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Edit Data Program</h3>
            </div>

            <div class="card-body">
                <?= form_open('program/updatedata/'.$program['idprogram'], ['id' => 'formeditprogram', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idprogram">ID Program</label>
                            <input type="text" id="idprogram" name="idprogram" class="form-control" value="<?= $program['idprogram'] ?>" readonly>
                            <div class="invalid-feedback error_idprogram"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="namaprogram">Nama Program</label>
                            <input type="text" id="namaprogram" name="namaprogram" class="form-control" value="<?= $program['namaprogram'] ?>" placeholder="Masukkan nama program">
                            <div class="invalid-feedback error_namaprogram"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idkategori">Kategori</label>
                            <select id="idkategori" name="idkategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategoris as $kategori): ?>
                                    <option value="<?= $kategori['idkategori'] ?>" <?= ($program['idkategori'] == $kategori['idkategori']) ? 'selected' : '' ?>><?= $kategori['namakategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_idkategori"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglmulai">Tanggal Mulai</label>
                            <input type="date" id="tglmulai" name="tglmulai" class="form-control" value="<?= $program['tglmulai'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglselesai">Tanggal Selesai</label>
                            <input type="date" id="tglselesai" name="tglselesai" class="form-control" value="<?= $program['tglselesai'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi program"><?= $program['deskripsi'] ?></textarea>
                            <div class="invalid-feedback error_deskripsi"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Preview -->
    <div class="col-md-4">
        <div class="card bg-success" style="padding-left: 10px; padding-right: 10px; height: 362px;">
            <div class="card-header">
                <h3 class="card-title">Foto Program</h3>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*" onchange="previewFoto()">
                    <label class="custom-file-label" for="foto"><?= !empty($program['foto']) ? $program['foto'] : 'Pilih foto' ?></label>
                    <div class="invalid-feedback error_foto"></div>
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <img id="fotoPreview" src="<?= !empty($program['foto']) ? base_url('assets/img/program/' . $program['foto']) : base_url('assets/img/program.png') ?>" alt="Preview Foto" class="img-fluid" style="max-width: 100%; max-height: 100%;">
            </div>
        </div>
        <div class="card" style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('program') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditprogram').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this); // Menggunakan FormData untuk mendukung file upload
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData, // Menggunakan formData untuk mendukung file upload
            contentType: false, // Menunjukkan tidak adanya konten
            processData: false, // Menunjukkan tidak adanya proses data
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                $('#tombolSimpan').prop('disabled', true);
            },

            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                $('#tombolSimpan').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_namaprogram) {
                        $('#namaprogram').addClass('is-invalid').removeClass('is-valid');
                        $('.error_namaprogram').html(err.error_namaprogram);
                    } else {
                        $('#namaprogram').removeClass('is-invalid').addClass('is-valid');
                        $('.error_namaprogram').html('');
                    }
                    
                    if (err.error_idkategori) {
                        $('#idkategori').addClass('is-invalid').removeClass('is-valid');
                        $('.error_idkategori').html(err.error_idkategori);
                    } else {
                        $('#idkategori').removeClass('is-invalid').addClass('is-valid');
                        $('.error_idkategori').html('');
                    }

                    if (err.error_deskripsi) {
                        $('#deskripsi').addClass('is-invalid').removeClass('is-valid');
                        $('.error_deskripsi').html(err.error_deskripsi);
                    } else {
                        $('#deskripsi').removeClass('is-invalid').addClass('is-valid');
                        $('.error_deskripsi').html('');
                    }

                    if (err.error_foto) {
                        $('#foto').addClass('is-invalid').removeClass('is-valid');
                        $('.error_foto').html(err.error_foto);
                    } else {
                        $('#foto').removeClass('is-invalid').addClass('is-valid');
                        $('.error_foto').html('');
                    }
                    if (err.error_tglmulai) {
                        $('#tglmulai').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tglmulai').html(err.error_tglmulai);
                    } else {
                        $('#tglmulai').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tglmulai').html('');
                    }   
                    if (err.error_tglselesai) {
                        $('#tglselesai').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tglselesai').html(err.error_tglselesai);
                    } else {
                        $('#tglselesai').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tglselesai').html('');
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = '<?= site_url('program') ?>';
                    }, 1500);
                }
            },

            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });

        return false;
    });
});

function previewFoto() {
    const foto = document.querySelector('#foto');
    const fotoPreview = document.querySelector('#fotoPreview');
    const fotoLabel = document.querySelector('label[for="foto"]');

    fotoPreview.style.display = 'block';
    const oFReader = new FileReader();
    oFReader.readAsDataURL(foto.files[0]);

    oFReader.onload = function(oFREvent) {
        fotoPreview.src = oFREvent.target.result;
    };

    fotoLabel.textContent = foto.files[0].name;
}
</script>
<?= $this->endSection() ?>