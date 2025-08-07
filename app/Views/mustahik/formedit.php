<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Mustahik</h3>
            </div>

            <div class="card-body">
                <?= form_open('mustahik/updatedata/'.$mustahik['id_mustahik'], ['id' => 'formeditmustahik', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_mustahik">Kode mustahik</label>
                            <input type="text" id="id_mustahik" name="id_mustahik" class="form-control"
                                value="<?= $mustahik['id_mustahik'] ?>" readonly>
                            <div class="invalid-feedback error_id_mustahik"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama mustahik</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $mustahik['nama'] ?>" >
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $mustahik['alamat'] ?>" ></input>
                            <div class="invalid-feedback error_alamat"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control" value="<?= $mustahik['nohp'] ?>" ></input>
                            <div class="invalid-feedback error_nohp"></div>
                        </div>
                    </div>
                </div>
              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jenkel">Jenkel</label>
                            <select id="jenkel" name="jenkel" class="form-control">
                                <option value="L" <?= $mustahik['jenkel'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $mustahik['jenkel'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback error_jenkel"></div>
                        </div>
                    </div>
                </div>
 
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tgllahir">Tanggal Lahir</label>
                            <input type="date" id="tgllahir" name="tgllahir" class="form-control" value="<?= $mustahik['tgllahir'] ?>" ></input>
                            <div class="invalid-feedback error_tgllahir"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Preview -->
    <div class="col-md-4">
        <div class="card bg-teal" style="padding-left: 10px; padding-right: 10px; height: 362px;">
            <div class="card-header ">
                <h3 class="card-title">Foto Mustahik</h3>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cover" name="cover" accept="image/*"
                        onchange="previewCover()">
                    <label class="custom-file-label" for="cover"><?= !empty($mustahik['foto']) ? $mustahik['foto'] : 'Pilih foto' ?></label>
                    <div class="invalid-feedback error_cover"></div>
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                  <img id="coverPreview" src="<?= !empty($mustahik['foto']) ? base_url('assets/img/mustahik/' . $mustahik['foto']) : base_url('assets/img/mustahik.png') ?>" alt="Preview Cover" class="img-fluid"
                    style="max-width: 100%; max-height: 100%;">
            </div>
        </div>
        <div class="card"
            style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('mustahik') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditmustahik').submit(function(e) {
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

                    if (err.error_id_mustahik) {
                        $('#id_mustahik').addClass('is-invalid').removeClass('is-valid');
                        $('.error_id_mustahik').html(err.error_id_mustahik);
                    } else {
                        $('#id_mustahik').removeClass('is-invalid').addClass('is-valid');
                        $('.error_id_mustahik').html('');
                    }
                    if (err.error_nama) {
                        $('#nama').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nama').html(err.error_nama);
                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nama').html('');
                    }



                    if (err.error_nohp) {
                        $('#nohp').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nohp').html(err.error_nohp);
                    } else {
                        $('#nohp').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nohp').html('');
                    }

                    if (err.error_jenkel) {
                        $('#jenkel').addClass('is-invalid').removeClass('is-valid');
                        $('.error_jenkel').html(err.error_jenkel);
                    } else {
                        $('#jenkel').removeClass('is-invalid').addClass('is-valid');
                        $('.error_jenkel').html('');
                    }

                    if (err.error_tgllahir) {
                        $('#tgllahir').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tgllahir').html(err.error_tgllahir);
                    } else {
                        $('#tgllahir').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tgllahir').html('');
                    }

                    if (err.error_cover) {
                        $('#cover').addClass('is-invalid').removeClass('is-valid');
                        $('.error_cover').html(err.error_cover);
                    } else {
                        $('#cover').removeClass('is-invalid').addClass('is-valid');
                        $('.error_cover').html('');
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
                        window.location.href = '<?= site_url('mustahik') ?>';
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

function previewCover() {
    const cover = document.querySelector('#cover');
    const coverPreview = document.querySelector('#coverPreview');
    const coverLabel = document.querySelector('label[for="cover"]');

    coverPreview.style.display = 'block';
    const oFReader = new FileReader();
    oFReader.readAsDataURL(cover.files[0]);

    oFReader.onload = function(oFREvent) {
        coverPreview.src = oFREvent.target.result;
    };

    coverLabel.textContent = cover.files[0].name;
}
</script>
<?= $this->endSection() ?>