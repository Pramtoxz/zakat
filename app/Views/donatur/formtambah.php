<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Donatur</h3>
            </div>

            <div class="card-body">
                <?= form_open('donatur/save', ['id' => 'formtambahdonatur', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_donatur">Kode Donatur</label>
                            <input type="text" id="id_donatur" name="id_donatur" class="form-control"
                                value="<?= $next_number ?>" readonly>
                            <div class="invalid-feedback error_id_donatur"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Donatur</label>
                            <input type="text" id="nama" name="nama" class="form-control">
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control"></input>
                            <div class="invalid-feedback error_alamat"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control"></input>
                            <div class="invalid-feedback error_nohp"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jenkel">Jenkel</label>
                            <select id="jenkel" name="jenkel" class="form-control">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback error_jenkel"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tgllahir">Tanggal Lahir</label>
                            <input type="date" id="tgllahir" name="tgllahir" class="form-control"></input>
                            <div class="invalid-feedback error_tgllahir"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Preview -->
    <div class="col-md-4">
        <div class="card bg-success" style="padding-left: 10px; padding-right: 10px; height: 362px;">
            <div class="card-header ">
                <h3 class="card-title">Foto Donatur</h3>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cover" name="cover" accept="image/*"
                        onchange="previewCover()">
                    <label class="custom-file-label" for="cover">Pilih File</label>
                    <div class="invalid-feedback error_cover"></div>
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <img id="coverPreview" src="#" alt="Preview Cover" class="img-fluid"
                    style="max-width: 100%; max-height: 100%; display: none;">
            </div>
        </div>
        <div class="card"
            style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('donatur') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formtambahdonatur').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this); // Menggunakan FormData untuk mendukung file upload
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
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

                    if (err.error_id_donatur) {
                        $('#id_donatur').addClass('is-invalid').removeClass('is-valid');
                        $('.error_id_donatur').html(err.error_id_donatur);
                    } else {
                        $('#id_donatur').removeClass('is-invalid').addClass('is-valid');
                        $('.error_id_donatur').html('');
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
                        window.location.href = '<?= site_url('donatur') ?>';
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