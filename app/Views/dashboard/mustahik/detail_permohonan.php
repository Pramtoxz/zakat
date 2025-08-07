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
                        primary: '#10B981',
                        'primary-dark': '#059669',
                        'primary-light': '#34D399'
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
                        <h1 class="text-lg font-bold text-gray-900">MPZ Alumni FK</h1>
                        <p class="text-xs text-gray-600">Dashboard Mustahik</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard/mustahik/permohonan') ?>" class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold"><?= strtoupper(substr($mustahik['nama'], 0, 1)) ?></span>
                            </div>
                            <span class="hidden md:block"><?= $mustahik['nama'] ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-600">Sebagai</p>
                                <p class="text-sm font-medium text-gray-900">Mustahik</p>
                            </div>
                            <a href="<?= base_url('dashboard/mustahik/edit-profile') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-2"></i>Edit Profile
                            </a>
                            <a href="<?= base_url('logout') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Detail Permohonan</h1>
                        <p class="text-gray-600 mt-2">Informasi lengkap permohonan bantuan</p>
                    </div>
                    <div class="text-blue-500">
                        <i class="fas fa-file-alt text-4xl"></i>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                <?php
                $statusColors = [
                    'diproses' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                    'diterima' => 'bg-green-100 text-green-800 border-green-300',
                    'ditolak' => 'bg-red-100 text-red-800 border-red-300',
                    'selesai' => 'bg-blue-100 text-blue-800 border-blue-300'
                ];
                $statusIcons = [
                    'diproses' => 'fas fa-clock',
                    'diterima' => 'fas fa-check-circle',
                    'ditolak' => 'fas fa-times-circle',
                    'selesai' => 'fas fa-flag-checkered'
                ];
                $statusClass = $statusColors[$permohonan['status']] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                $statusIcon = $statusIcons[$permohonan['status']] ?? 'fas fa-question-circle';
                ?>
                <div class="inline-flex items-center px-4 py-2 rounded-full border <?= $statusClass ?>">
                    <i class="<?= $statusIcon ?> mr-2"></i>
                    <span class="font-semibold">Status: <?= ucfirst($permohonan['status']) ?></span>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">ID Permohonan</label>
                                <p class="text-lg font-semibold text-gray-900"><?= $permohonan['idpermohonan'] ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Kategori Asnaf</label>
                                <p class="text-lg text-gray-900"><?= ucfirst($permohonan['kategoriasnaf']) ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Bantuan</label>
                                <p class="text-lg text-gray-900"><?= $permohonan['jenisbantuan'] ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pengajuan</label>
                                <p class="text-lg text-gray-900">
                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                    <?= date('d F Y', strtotime($permohonan['tglpengajuan'])) ?>
                                </p>
                            </div>

                            <?php if (!empty($permohonan['tgldisetujui'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Disetujui</label>
                                <p class="text-lg text-gray-900">
                                    <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                    <?= date('d F Y', strtotime($permohonan['tgldisetujui'])) ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pemohon</label>
                                <p class="text-lg text-gray-900"><?= $permohonan['nama_mustahik'] ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                <p class="text-lg text-gray-900"><?= $permohonan['alamat'] ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">No. HP</label>
                                <p class="text-lg text-gray-900">
                                    <i class="fas fa-phone text-primary mr-2"></i>
                                    <?= $permohonan['nohp'] ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-500 mb-3">Alasan Permohonan</label>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 leading-relaxed"><?= nl2br(htmlspecialchars($permohonan['alasan'])) ?></p>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <?php if (!empty($permohonan['dokumen'])): ?>
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-500 mb-3">Dokumen Pendukung</label>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900"><?= $permohonan['dokumen'] ?></p>
                                        <p class="text-sm text-gray-500">Dokumen pendukung permohonan</p>
                                    </div>
                                </div>
                                <a href="<?= base_url('uploads/permohonan/' . $permohonan['dokumen']) ?>" 
                                   target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-download mr-2"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="<?= base_url('dashboard/mustahik/permohonan') ?>" 
                           class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        
                        <?php if ($permohonan['status'] === 'diproses'): ?>
                        <a href="<?= base_url('dashboard/mustahik/permohonan/edit/' . $permohonan['idpermohonan']) ?>" 
                           class="flex-1 bg-yellow-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-yellow-600 transition-colors text-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Permohonan
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>