<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Data Kategori</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('kategori/updatedata/'.$kategori['idkategori'], ['id' => 'formeditkategori']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="idkategori" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" id="idkategori" name="idkategori" value="<?= $kategori['idkategori'] ?>" readonly>
                                    <div class="invalid-feedback error_idkategori"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="namakategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="namakategori" name="namakategori" value="<?= $kategori['namakategori'] ?>" placeholder="Masukkan nama kategori">
                                    <div class="invalid-feedback error_namakategori"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('kategori') ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> KEMBALI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditkategori').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
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

                    if (err.error_namakategori) {
                        $('#namakategori').addClass('is-invalid').removeClass('is-valid');
                        $('.error_namakategori').html(err.error_namakategori);
                    } else {
                        $('#namakategori').removeClass('is-invalid').addClass('is-valid');
                        $('.error_namakategori').html('');
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
                        window.location.href = '<?= site_url('kategori') ?>';
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
</script>
<?= $this->endSection() ?> 