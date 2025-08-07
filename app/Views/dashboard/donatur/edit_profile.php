<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - MPZ Alumni FK Unand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Edit Profile Donatur</h1>
                        <p class="text-xs text-gray-600">MPZ Alumni FK Unand</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard/donatur') ?>" class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <a href="<?= base_url('/') ?>" class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        <?php if(session()->getFlashdata('message')): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= session()->getFlashdata('message') ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Edit Profile Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                    <i class="fas fa-user-edit mr-2"></i>Edit Profile Donatur
                </h3>

                <form action="<?= base_url('dashboard/donatur/update-profile') ?>" method="POST" class="space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="<?= old('nama', $donatur['nama']) ?>"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                            placeholder="Masukkan nama lengkap Anda"
                            required>
                        <?php if (isset($validation) && $validation->getError('nama')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('nama') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="3"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                            placeholder="Masukkan alamat lengkap Anda"
                            required><?= old('alamat', $donatur['alamat']) ?></textarea>
                        <?php if (isset($validation) && $validation->getError('alamat')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('alamat') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="nohp" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2"></i>Nomor HP/WhatsApp
                        </label>
                        <input 
                            type="tel" 
                            id="nohp" 
                            name="nohp" 
                            value="<?= old('nohp', $donatur['nohp']) ?>"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                            placeholder="Contoh: 08123456789"
                            required>
                        <?php if (isset($validation) && $validation->getError('nohp')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('nohp') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input 
                                    type="radio" 
                                    name="jenkel" 
                                    value="L" 
                                    <?= old('jenkel', $donatur['jenkel']) === 'L' ? 'checked' : '' ?>
                                    class="w-4 h-4 text-primary border-gray-300 focus:ring-primary"
                                    required>
                                <span class="text-gray-700">Laki-laki</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input 
                                    type="radio" 
                                    name="jenkel" 
                                    value="P" 
                                    <?= old('jenkel', $donatur['jenkel']) === 'P' ? 'checked' : '' ?>
                                    class="w-4 h-4 text-primary border-gray-300 focus:ring-primary"
                                    required>
                                <span class="text-gray-700">Perempuan</span>
                            </label>
                        </div>
                        <?php if (isset($validation) && $validation->getError('jenkel')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('jenkel') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tgllahir" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt mr-2"></i>Tanggal Lahir
                        </label>
                        <input 
                            type="date" 
                            id="tgllahir" 
                            name="tgllahir" 
                            value="<?= old('tgllahir', $donatur['tgllahir']) ?>"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                            required>
                        <?php if (isset($validation) && $validation->getError('tgllahir')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('tgllahir') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button 
                            type="submit" 
                            class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                        
                        <a href="<?= base_url('dashboard/donatur') ?>" 
                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-format nomor HP
        document.getElementById('nohp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            } else if (!value.startsWith('+62') && value.length > 0) {
                value = '+62' + value;
            }
            e.target.value = value;
        });

        // Set max date untuk tanggal lahir (minimal 17 tahun)
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 17, today.getMonth(), today.getDate());
            document.getElementById('tgllahir').setAttribute('max', maxDate.toISOString().split('T')[0]);
        });
    </script>
</body>
</html>
