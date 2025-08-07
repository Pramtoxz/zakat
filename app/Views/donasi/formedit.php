<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12   ">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Edit Data Donasi</h3>
            </div>
            <div class="card-body">
            <?= form_open('donasi/updatedata/' . $donasi['iddonasi'], ['id' => 'formeditdonasi']) ?>
            <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="iddonasi">Kode Donasi</label>
                            <input type="text" id="iddonasi" name="iddonasi" class="form-control"
                                value="<?= $donasi['iddonasi'] ?>" readonly>
                            <div class="invalid-feedback error_iddonasi"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="id_donatur">Donatur</label>
                            <select id="id_donatur" name="id_donatur" class="form-control">
                                <option value="">Pilih Donatur</option>
                                <?php foreach ($donaturs as $donatur): ?>
                                    <option value="<?= $donatur['id_donatur'] ?>" <?= $donasi['id_donatur'] == $donatur['id_donatur'] ? 'selected' : '' ?>>
                                        <?= $donatur['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_id_donatur"></div>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal (Rp)</label>
                            <input type="number" id="nominal" name="nominal" class="form-control" placeholder="Masukkan nominal donasi" value="<?= $donasi['nominal'] ?>">
                            <div class="invalid-feedback error_nominal"></div>
                        </div>

                        <div class="form-group">
                            <label for="idprogram">Program</label>
                            <select id="idprogram" name="idprogram" class="form-control">
                                <option value="">Pilih Program</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['idprogram'] ?>" <?= $donasi['idprogram'] == $program['idprogram'] ? 'selected' : '' ?>>
                                        <?= $program['namaprogram'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_idprogram"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('donasi') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $('#formeditdonasi').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
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
                    if (err.error_nominal) {
                        $('#nominal').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nominal').html(err.error_nominal);
                    } else {
                        $('#nominal').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nominal').html('');
                    }
                    if (err.error_idprogram) {
                        $('#idprogram').addClass('is-invalid').removeClass('is-valid');
                        $('.error_idprogram').html(err.error_idprogram);
                    } else {
                        $('#idprogram').removeClass('is-invalid').addClass('is-valid');
                        $('.error_idprogram').html('');
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
                        window.location.href = '<?= site_url('donasi') ?>';
                    }, 1500);
                }
            },

            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });

        return false;
    });
</script>
<?= $this->endSection() ?>