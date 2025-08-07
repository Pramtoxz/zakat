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
                            <a href="<?= base_url('dashboard/donatur/donasi') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-heart mr-2"></i>Donasi Saya
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
                            <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h1 class="text-2xl font-bold text-gray-900">Detail Donasi</h1>
                            <p class="text-sm text-gray-600">ID: <?= $donasi['iddonasi'] ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <?php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'diterima' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800'
                        ];
                        $statusClass = $statusClasses[$donasi['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                            <?= ucfirst($donasi['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Donasi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Program</label>
                        <p class="mt-1 text-sm text-gray-900 font-semibold"><?= $donasi['namaprogram'] ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nominal</label>
                        <p class="mt-1 text-lg font-bold text-primary">Rp <?= number_format($donasi['nominal'], 0, ',', '.') ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Transfer</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= $donasi['tgltransfer'] ? date('d F Y, H:i', strtotime($donasi['tgltransfer'])) : '-' ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= date('d F Y, H:i', strtotime($donasi['created_at'])) ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipe Pembayaran</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                <?= $donasi['online'] == 1 ? 'Online' : 'Offline' ?>
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                <?= ucfirst($donasi['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>

                <?php if (!empty($donasi['deskripsi_program'])): ?>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-500">Deskripsi Program</label>
                    <p class="mt-1 text-sm text-gray-900"><?= nl2br(htmlspecialchars($donasi['deskripsi_program'])) ?></p>
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
                
                <?php if (!empty($donasi['buktibayar'])): ?>
                    <div class="text-center">
                        <img src="<?= base_url('uploads/donasi/' . $donasi['buktibayar']) ?>" 
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
                    switch($donasi['status']) {
                        case 'pending': echo 'bg-yellow-50 border border-yellow-200 text-yellow-800'; break;
                        case 'diterima': echo 'bg-green-50 border border-green-200 text-green-800'; break;
                        case 'ditolak': echo 'bg-red-50 border border-red-200 text-red-800'; break;
                        default: echo 'bg-gray-50 border border-gray-200 text-gray-800';
                    }
                ?> p-4 rounded-lg">
                    <?php switch($donasi['status']): 
                        case 'pending': ?>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-3 text-yellow-500"></i>
                                <div>
                                    <h4 class="font-semibold">Menunggu Verifikasi</h4>
                                    <p class="text-sm">Donasi Anda sedang dalam proses verifikasi oleh tim kami. Terima kasih atas kesabaran Anda.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php case 'diterima': ?>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                                <div>
                                    <h4 class="font-semibold">Donasi Diterima</h4>
                                    <p class="text-sm">Alhamdulillah, donasi Anda telah berhasil diverifikasi dan diterima. Semoga menjadi amal jariyah yang berkah.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php case 'ditolak': ?>
                            <div class="flex items-center">
                                <i class="fas fa-times-circle mr-3 text-red-500"></i>
                                <div>
                                    <h4 class="font-semibold">Donasi Ditolak</h4>
                                    <p class="text-sm">Mohon maaf, donasi Anda tidak dapat diverifikasi. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php default: ?>
                            <div class="flex items-center">
                                <i class="fas fa-question-circle mr-3 text-gray-500"></i>
                                <div>
                                    <h4 class="font-semibold">Status Tidak Diketahui</h4>
                                    <p class="text-sm">Status donasi tidak diketahui. Silakan hubungi admin.</p>
                                </div>
                            </div>
                    <?php endswitch; ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="<?= base_url('dashboard/donatur/donasi') ?>" 
               class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Donasi
            </a>
            
            <div class="flex space-x-3">
                <a href="<?= base_url('dashboard/donatur/donasi/form') ?>" 
                   class="px-6 py-3 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Donasi Lagi
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
