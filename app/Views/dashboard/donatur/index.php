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
                        <h1 class="text-lg font-bold text-gray-900">Dashboard Donatur</h1>
                        <p class="text-xs text-gray-600">MPZ Alumni FK Unand</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('/') ?>" class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="font-medium"><?= $user['username'] ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="text-sm font-medium text-gray-900 capitalize"><?= $user['role'] ?></p>
                            </div>
                            <a href="<?= base_url('dashboard/donatur/edit-profile') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profile
                            </a>
                            <hr class="my-1">
                            <a href="<?= base_url('logout') ?>" 
                               class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
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

        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Selamat datang,
                            </dt>
                            <dd class="text-lg font-medium text-gray-900">
                                <?= $donatur['nama'] ?>
                            </dd>
                            <dd class="text-sm text-gray-600">
                                Sebagai Donatur MPZ Alumni FK Unand Padang
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-user-circle mr-2"></i>Informasi Profile
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">ID Donatur</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $donatur['id_donatur'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $donatur['nama'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $user['email'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">No. HP</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $donatur['nohp'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $donatur['jenkel'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Lahir</label>
                        <p class="mt-1 text-sm text-gray-900"><?= date('d F Y', strtotime($donatur['tgllahir'])) ?></p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Alamat</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $donatur['alamat'] ?></p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="<?= base_url('dashboard/donatur/edit-profile') ?>" 
                       class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-bolt mr-2"></i>Menu Cepat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="<?= base_url('dashboard/donatur/zakat/form') ?>" class="group relative rounded-lg p-6 bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 transition duration-200">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-green-600 text-white">
                                <i class="fas fa-hands-helping text-xl"></i>
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Bayar Zakat
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Tunaikan kewajiban zakat Anda
                            </p>
                            <div class="mt-2">
                                <span class="inline-flex items-center text-xs bg-green-200 text-green-800 px-2 py-1 rounded-full">
                                    <i class="fas fa-calculator mr-1"></i>
                                    Dengan Kalkulator
                                </span>
                            </div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/donatur/donasi/form') ?>" class="group relative rounded-lg p-6 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 transition duration-200">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-blue-600 text-white">
                                <i class="fas fa-heart text-xl"></i>
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Donasi Program
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Berdonasi untuk program sosial
                            </p>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/donatur/donasi') ?>" class="group relative rounded-lg p-6 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 transition duration-200">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-purple-600 text-white">
                                <i class="fas fa-history text-xl"></i>
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Riwayat Transaksi
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Lihat riwayat donasi & zakat
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
