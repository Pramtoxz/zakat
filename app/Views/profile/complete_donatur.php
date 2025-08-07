<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - MPZ Alumni FK Unand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #28A745 0%, #20c997 50%, #17a2b8 100%);
        }
    </style>
</head>
<body class="hero-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mb-6">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-plus text-3xl text-green-600"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Lengkapi Profile Donatur</h1>
            <p class="text-green-100">Silakan lengkapi data profile Anda untuk melanjutkan</p>
        </div>

        <!-- Form Card -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8">
            <!-- Alert Messages -->
            <?php if(session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <p><?= session()->getFlashdata('error') ?></p>
                </div>
            </div>
            <?php endif; ?>

            <form action="<?= site_url('profile/save/donatur') ?>" method="POST" class="space-y-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        value="<?= old('nama', isset($old_input) ? $old_input['nama'] ?? '' : '') ?>"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
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
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                        placeholder="Masukkan alamat lengkap Anda"
                        required><?= old('alamat', isset($old_input) ? $old_input['alamat'] ?? '' : '') ?></textarea>
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
                        value="<?= old('nohp', isset($old_input) ? $old_input['nohp'] ?? '' : '') ?>"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
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
                                <?= old('jenkel', isset($old_input) ? $old_input['jenkel'] ?? '' : '') === 'L' ? 'checked' : '' ?>
                                class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                required>
                            <span class="text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input 
                                type="radio" 
                                name="jenkel" 
                                value="P" 
                                <?= old('jenkel', isset($old_input) ? $old_input['jenkel'] ?? '' : '') === 'P' ? 'checked' : '' ?>
                                class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
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
                        value="<?= old('tgllahir', isset($old_input) ? $old_input['tgllahir'] ?? '' : '') ?>"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                        required>
                    <?php if (isset($validation) && $validation->getError('tgllahir')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('tgllahir') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col space-y-4">
                    <button 
                        type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Profile
                    </button>
                    
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Data yang Anda masukkan akan digunakan untuk keperluan administrasi zakat
                        </p>
                    </div>
                </div>
            </form>
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
