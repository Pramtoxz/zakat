<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12   ">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Zakat</h3>
            </div>
            <div class="card-body">
                <?= form_open('zakat/save', ['id' => 'formtambahzakat', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="idzakat">Kode Zakat</label>
                            <input type="text" id="idzakat" name="idzakat" class="form-control"
                                value="<?= $next_number ?>" readonly>
                            <div class="invalid-feedback error_idzakat"></div>
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
                                    <option value="<?= $donatur['id_donatur'] ?>"><?= $donatur['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_id_donatur"></div>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal (Rp)</label>
                            <input type="number" id="nominal" name="nominal" class="form-control" placeholder="Masukkan nominal zakat">
                            <div class="invalid-feedback error_nominal"></div>
                        </div>

                        <div class="form-group">
                            <label for="jeniszakat">Program Zakat</label>
                            <select id="jeniszakat" name="jeniszakat" class="form-control">
                                <option value="">Pilih Program Zakat</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['idprogram'] ?>"><?= $program['namaprogram'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_jeniszakat"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('zakat') ?>" class="btn btn-secondary">
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
    $('#formtambahzakat').submit(function(e) {
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
                    if (err.error_jeniszakat) {
                        $('#jeniszakat').addClass('is-invalid').removeClass('is-valid');
                        $('.error_jeniszakat').html(err.error_jeniszakat);
                    } else {
                        $('#jeniszakat').removeClass('is-invalid').addClass('is-valid');
                        $('.error_jeniszakat').html('');
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
                        window.location.href = '<?= site_url('zakat') ?>';
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