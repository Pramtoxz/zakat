<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - MPZ Alumni FK Unand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <h1 class="text-3xl font-bold text-gray-800">Tambah Permohonan Bantuan</h1>
                        <p class="text-gray-600 mt-2">Ajukan permohonan bantuan sesuai kebutuhan Anda</p>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-plus-circle text-4xl"></i>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <form id="formPermohonan" enctype="multipart/form-data">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- ID Permohonan -->
                            <div>
                                <label for="idpermohonan" class="block text-sm font-medium text-gray-700 mb-2">
                                    ID Permohonan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="idpermohonan" name="idpermohonan" 
                                       value="<?= $next_number ?>" readonly
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <!-- Kategori Asnaf -->
                            <div>
                                <label for="kategoriasnaf" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori Asnaf <span class="text-red-500">*</span>
                                </label>
                                <select id="kategoriasnaf" name="kategoriasnaf" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Pilih Kategori Asnaf</option>
                                    <?php foreach ($syarats as $syarat): ?>
                                        <option value="<?= $syarat['kategori_asnaf'] ?>"><?= ucfirst($syarat['kategori_asnaf']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-red-500 text-sm mt-1 hidden" id="error_kategoriasnaf"></span>
                            </div>

                            <!-- Jenis Bantuan -->
                            <div>
                                <label for="jenisbantuan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Bantuan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="jenisbantuan" name="jenisbantuan" 
                                       placeholder="Contoh: Bantuan Pendidikan, Bantuan Kesehatan"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <span class="text-red-500 text-sm mt-1 hidden" id="error_jenisbantuan"></span>
                            </div>

                            <!-- Tanggal Pengajuan -->
                            <div>
                                <label for="tglpengajuan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pengajuan <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tglpengajuan" name="tglpengajuan" 
                                       value="<?= date('Y-m-d') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <span class="text-red-500 text-sm mt-1 hidden" id="error_tglpengajuan"></span>
                            </div>
                        </div>

                        <!-- Alasan -->
                        <div class="mt-6">
                            <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Permohonan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alasan" name="alasan" rows="4" 
                                      placeholder="Jelaskan alasan mengapa Anda membutuhkan bantuan ini..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                            <span class="text-red-500 text-sm mt-1 hidden" id="error_alasan"></span>
                        </div>

                        <!-- Syarat Bantuan Info -->
                        <div id="syarat-info" class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                            <h3 class="font-semibold text-blue-800 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>Syarat yang Diperlukan
                            </h3>
                            <p id="syarat-text" class="text-blue-700 text-sm"></p>
                        </div>

                        <!-- Dokumen -->
                        <div class="mt-6">
                            <label for="dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Dokumen Pendukung
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                                <input type="file" id="dokumen" name="dokumen" accept=".pdf" class="hidden">
                                <label for="dokumen" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600 mb-2">Klik untuk upload dokumen (PDF)</p>
                                    <p class="text-sm text-gray-500">Maksimal 5MB</p>
                                </label>
                                <div id="file-preview" class="mt-3 hidden">
                                    <div class="flex items-center justify-center space-x-2">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <span id="file-name" class="text-sm text-gray-700"></span>
                                        <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <span class="text-red-500 text-sm mt-1 hidden" id="error_dokumen"></span>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Ajukan Permohonan
                            </button>
                            <a href="<?= base_url('dashboard/mustahik/permohonan') ?>" 
                               class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle kategori asnaf change
            $('#kategoriasnaf').change(function() {
                var kategori = $(this).val();
                if (kategori) {
                    $.ajax({
                        url: '<?= site_url('dashboard/mustahik/permohonan/syarat') ?>',
                        type: 'POST',
                        data: { kategori: kategori },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#syarat-text').text(response.data.isi_syarat);
                                $('#syarat-info').removeClass('hidden');
                            }
                        }
                    });
                } else {
                    $('#syarat-info').addClass('hidden');
                }
            });

            // Handle file upload preview
            $('#dokumen').change(function() {
                var file = this.files[0];
                if (file) {
                    $('#file-name').text(file.name);
                    $('#file-preview').removeClass('hidden');
                }
            });

            // Handle remove file
            $('#remove-file').click(function() {
                $('#dokumen').val('');
                $('#file-preview').addClass('hidden');
            });

            // Handle form submission
            $('#formPermohonan').submit(function(e) {
                e.preventDefault();
                
                // Clear previous errors
                $('.text-red-500').addClass('hidden');
                $('.border-red-500').removeClass('border-red-500');
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: '<?= site_url('dashboard/mustahik/permohonan/save') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.sukses,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '<?= site_url('dashboard/mustahik/permohonan') ?>';
                                }
                            });
                        } else if (response.error) {
                            // Show validation errors
                            $.each(response.error, function(field, message) {
                                if (message) {
                                    var fieldName = field.replace('error_', '');
                                    $('#error_' + fieldName).text(message).removeClass('hidden');
                                    $('#' + fieldName).addClass('border-red-500');
                                }
                            });
                            
                            Swal.fire({
                                title: 'Error!',
                                text: 'Silakan periksa kembali form Anda',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data',
                            icon: 'error'
                        });
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-paper-plane mr-2"></i>Ajukan Permohonan');
                    }
                });
            });
        });
    </script>
</body>
</html>
