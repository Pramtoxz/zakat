
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#28A745',
                    'primary-dark': '#1e7e34',
                    'primary-light': '#34ce57'
                }
            }
        }
    }
</script>

<!-- Dashboard Content -->
<div class="container-fluid py-4">
            
            <?php if(session()->get('role') == 'admin'): ?>
                <!-- Admin Dashboard -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h2>
                    <p class="text-gray-600">Kelola seluruh sistem manajemen zakat</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-3xl text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Mustahik</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_mustahik ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-hand-holding-heart text-3xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Donatur</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_donatur ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users-cog text-3xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_users ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-3xl text-purple-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Permohonan Aktif</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_permohonan ?? 0 ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
                    <a href="<?= base_url('/mustahik') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-inbox text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Mustahik</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage data penerima zakat</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/donatur') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-inbox text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Donatur</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage data pemberi zakat</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/user') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-users text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                            <p class="text-gray-600 text-sm mt-2">Kelola pengguna sistem</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan-users/mustahik') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Mustahik</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan mustahik</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan-users/donatur') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Donatur</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan donatur</p>
                        </div>
                    </a>
                </div>

            <?php elseif(session()->get('role') == 'program'): ?>
                <!-- Program Dashboard -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Program</h2>
                    <p class="text-gray-600">Kelola program dan permohonan bantuan</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-list text-3xl text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_kategori ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-project-diagram text-3xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Program</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_program ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-3xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Permohonan Baru</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $permohonan_baru ?? 0 ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-3 gap-6">
                    <a href="<?= base_url('/kategori') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-inbox text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Kategori</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage kategori program</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/program') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-inbox text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Program</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage program zakat</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/permohonan') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Permohonan</h3>
                            <p class="text-gray-600 text-sm mt-2">Review permohonan bantuan</p>
                        </div>
                    </a>
                </div>

            <?php elseif(session()->get('role') == 'keuangan'): ?>
                <!-- Keuangan Dashboard -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Keuangan</h2>
                    <p class="text-gray-600">Kelola keuangan zakat dan donasi</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-hand-holding-usd text-3xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Zakat</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($total_zakat ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-heart text-3xl text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Donasi</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($total_donasi ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-share-alt text-3xl text-purple-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Penyaluran</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($total_penyaluran ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-wallet text-3xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Saldo</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($saldo ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-3 gap-6">
                    <a href="<?= base_url('/zakat') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-hand-holding-usd text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Zakat</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage data zakat masuk</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/donasi') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-hand-holding-usd text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Donasi</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage data donasi masuk</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/penyaluran') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-hand-holding-usd text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Kelola Penyaluran</h3>
                            <p class="text-gray-600 text-sm mt-2">Manage penyaluran dana</p>
                        </div>
                    </a>
                </div>

            <?php elseif(session()->get('role') == 'ketua'): ?>
                <!-- Ketua Dashboard -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Ketua</h2>
                    <p class="text-gray-600">Monitor dan analisa seluruh aktivitas sistem</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-3xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Dana Masuk</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($dana_masuk ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-share-alt text-3xl text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Dana Keluar</p>
                                <p class="text-lg font-bold text-gray-900">Rp <?= number_format($dana_keluar ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-3xl text-purple-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Beneficiary</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $total_beneficiary ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-chart-line text-3xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Efektivitas</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $efektivitas ?? 0 ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
                    <a href="<?= base_url('/laporan/zakat') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Zakat</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan zakat</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan/donasi') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Donasi</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan donasi</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan/penyaluran') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Penyaluran</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan penyaluran</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan-users/mustahik') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Mustahik</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan mustahik</p>
                        </div>
                    </a>

                    <a href="<?= base_url('/laporan-users/donatur') ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-4xl text-primary mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Laporan Donatur</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat laporan donatur</p>
                        </div>
                    </a>
                </div>

            <?php endif; ?>

</div>

<?= $this->endSection() ?>