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
                            <a href="<?= base_url('dashboard/donatur') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="<?= base_url('dashboard/donatur/zakat') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-hands-helping mr-2"></i>Zakat Saya
                            </a>
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
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-hands-helping text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h1 class="text-2xl font-bold text-gray-900">Detail Zakat</h1>
                            <p class="text-sm text-gray-600">ID: <?= $zakat['idzakat'] ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <?php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'diterima' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800'
                        ];
                        $statusClass = $statusClasses[$zakat['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                            <?= ucfirst($zakat['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Zakat
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Jenis Zakat</label>
                        <p class="mt-1 text-sm text-gray-900 font-semibold"><?= $zakat['namaprogram'] ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nominal</label>
                        <p class="mt-1 text-lg font-bold text-primary">Rp <?= number_format($zakat['nominal'], 0, ',', '.') ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Transfer</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= $zakat['tgltransfer'] ? date('d F Y, H:i', strtotime($zakat['tgltransfer'])) : '-' ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= date('d F Y, H:i', strtotime($zakat['created_at'])) ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipe Pembayaran</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                <?= $zakat['online'] == 1 ? 'Online' : 'Offline' ?>
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                <?= ucfirst($zakat['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>

                <?php if (!empty($zakat['deskripsi_program'])): ?>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-500">Deskripsi Program</label>
                    <p class="mt-1 text-sm text-gray-900"><?= nl2br(htmlspecialchars($zakat['deskripsi_program'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bukti Transfer -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-receipt mr-2"></i>Bukti Transfer
                </h3>
                
                <?php if (!empty($zakat['buktibayar'])): ?>
                    <div class="text-center">
                        <img src="<?= base_url('uploads/zakat/' . $zakat['buktibayar']) ?>" 
                             alt="Bukti Transfer" 
                             class="max-w-full h-auto max-h-96 mx-auto rounded-lg shadow-md cursor-pointer"
                             onclick="openImageModal(this.src)">
                        <p class="mt-2 text-sm text-gray-500">Klik gambar untuk memperbesar</p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-image text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada bukti transfer yang diupload</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Keterangan Status
                </h3>
                
                <div class="<?php 
                    switch($zakat['status']) {
                        case 'pending': echo 'bg-yellow-50 border border-yellow-200 text-yellow-800'; break;
                        case 'diterima': echo 'bg-green-50 border border-green-200 text-green-800'; break;
                        case 'ditolak': echo 'bg-red-50 border border-red-200 text-red-800'; break;
                        default: echo 'bg-gray-50 border border-gray-200 text-gray-800';
                    }
                ?> p-4 rounded-lg">
                    <?php switch($zakat['status']): 
                        case 'pending': ?>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-3 text-yellow-500"></i>
                                <div>
                                    <h4 class="font-semibold">Menunggu Verifikasi</h4>
                                    <p class="text-sm">Zakat Anda sedang dalam proses verifikasi oleh tim kami. Terima kasih atas kesabaran Anda.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php case 'diterima': ?>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                                <div>
                                    <h4 class="font-semibold">Zakat Diterima</h4>
                                    <p class="text-sm">Alhamdulillah, zakat Anda telah berhasil diverifikasi dan diterima. Semoga menjadi amal yang diterima Allah SWT.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php case 'ditolak': ?>
                            <div class="flex items-center">
                                <i class="fas fa-times-circle mr-3 text-red-500"></i>
                                <div>
                                    <h4 class="font-semibold">Zakat Ditolak</h4>
                                    <p class="text-sm">Mohon maaf, zakat Anda tidak dapat diverifikasi. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php default: ?>
                            <div class="flex items-center">
                                <i class="fas fa-question-circle mr-3 text-gray-500"></i>
                                <div>
                                    <h4 class="font-semibold">Status Tidak Diketahui</h4>
                                    <p class="text-sm">Status zakat tidak diketahui. Silakan hubungi admin.</p>
                                </div>
                            </div>
                    <?php endswitch; ?>
                </div>
            </div>
        </div>

        <!-- Hadits about Zakat -->
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg mb-6">
            <div class="flex items-start">
                <i class="fas fa-quote-right text-green-400 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-green-800 font-medium mb-1">Hadits tentang Zakat</h3>
                    <p class="text-green-700 text-sm italic">
                        "Barangsiapa yang Allah berikan kekayaan kepadanya, namun dia tidak menunaikan zakatnya, 
                        maka pada hari kiamat hartanya akan dijadikan seekor ular jantan yang gundul yang sangat beracun dengan dua bintik hitam di atas kedua matanya."
                    </p>
                    <p class="text-green-600 text-xs mt-2">- HR. Bukhari</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="<?= base_url('dashboard/donatur/zakat') ?>" 
               class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Zakat
            </a>
            
            <div class="flex space-x-3">
                <a href="<?= base_url('dashboard/donatur/zakat/form') ?>" 
                   class="px-6 py-3 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Bayar Zakat Lagi
                </a>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" 
                    class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-10">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Bukti Transfer" class="max-w-full max-h-full object-contain">
        </div>
    </div>

    <script>
    function openImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    </script>
</body>
</html>
