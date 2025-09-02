<div class="row">
    <div class="col-md-4">
        <div class="card shadow-lg h-100">
            <div class="card-body p-0 d-flex justify-content-center align-items-center" style="overflow: hidden; border-radius: 10px;">
                <img src="<?= !empty($donatur['foto']) ? base_url('assets/img/donatur/' . $donatur['foto']) : base_url('assets/img/defaultuser.png') ?>" alt="Gambar donatur"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-lg h-100">
            <div class="card-header bg-success text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i> Detail Donatur</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">ID Donatur</div>
                    <div class="col-md-8"><?= $donatur['id_donatur'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nama</div>
                    <div class="col-md-8"><?= $donatur['nama'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Jenis Kelamin</div>
                    <div class="col-md-8">
                        <span class="badge <?= $donatur['jenkel'] == 'L' ? 'badge-primary' : 'badge-danger' ?>">
                            <?= $donatur['jenkel'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Alamat</div>
                    <div class="col-md-8"><?= $donatur['alamat'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nomor Handphone</div>
                    <div class="col-md-8"><i class="fas fa-phone-alt mr-1"></i> <?= $donatur['nohp'] ?></div>
                </div>
                <div class="row">
                    <div class="col-md-4 font-weight-bold">Tanggal Lahir</div>
                    <div class="col-md-8"><i class="fas fa-calendar-alt mr-1"></i> <?= $donatur['tgllahir'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>