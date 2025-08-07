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
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-5">
                        <h1 class="text-2xl font-bold text-gray-900">Form Zakat</h1>
                        <p class="text-sm text-gray-600">Tunaikan kewajiban zakat dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Rekening -->
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-green-400 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-green-800 font-medium mb-1">Informasi Transfer Zakat</h3>
                    <p class="text-green-700 text-sm mb-2">
                        Transfer zakat Anda ke rekening berikut:
                    </p>
                    <div class="bg-white p-3 rounded-md border border-green-200">
                        <p class="font-semibold text-gray-800">Bank Syariah Indonesia (BSI)</p>
                        <p class="text-gray-700">No. Rekening: <span class="font-mono font-bold">7123456789</span></p>
                        <p class="text-gray-700">Atas Nama: <span class="font-semibold">MPZ Alumni FK Unand</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Link to Full Kalkulator Zakat -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg rounded-lg mb-8">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">
                            <i class="fas fa-calculator mr-2"></i>Kalkulator Zakat Lengkap
                        </h3>
                        <p class="text-yellow-100">
                            Hitung zakat penghasilan, emas, dan perdagangan sesuai standar BAZNAS
                        </p>
                    </div>
                    <div class="ml-4">
                        <a href="<?= base_url('dashboard/donatur/zakat/kalkulator') ?>" 
                           class="inline-flex items-center px-6 py-3 bg-white text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors font-semibold">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Buka Kalkulator
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form id="formZakat" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Zakat Selection -->
                        <div class="md:col-span-2">
                            <label for="jeniszakat" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Jenis Zakat <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php if (!empty($programs)): ?>
                                    <?php foreach ($programs as $program): ?>
                                    <div class="zakat-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-primary transition-colors"
                                         data-zakat="<?= $program['idprogram'] ?>">
                                        <?php if (!empty($program['foto'])): ?>
                                            <img src="<?= base_url('assets/img/program/' . $program['foto']) ?>" 
                                                 alt="<?= $program['namaprogram'] ?>" 
                                                 class="w-full h-32 object-cover rounded-md mb-3">
                                        <?php else: ?>
                                            <div class="w-full h-32 bg-gray-200 rounded-md mb-3 flex items-center justify-center">
                                                <i class="fas fa-mosque text-gray-400 text-2xl"></i>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="font-semibold text-gray-900 mb-2"><?= $program['namaprogram'] ?></h3>
                                        <p class="text-sm text-gray-600"><?= !empty($program['deskripsi']) ? substr($program['deskripsi'], 0, 100) . '...' : 'Program zakat untuk kebaikan' ?></p>
                                        <div class="mt-3 text-center">
                                            <span class="zakat-check hidden text-primary">
                                                <i class="fas fa-check-circle"></i> Dipilih
                                            </span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-span-full text-center py-8">
                                        <i class="fas fa-exclamation-circle text-gray-400 text-4xl mb-3"></i>
                                        <p class="text-gray-500">Tidak ada program zakat yang tersedia saat ini</p>
                                        <p class="text-gray-400 text-sm">Silakan hubungi admin untuk informasi lebih lanjut</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" id="jeniszakat" name="jeniszakat" required>
                            <div id="error_jeniszakat" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Nominal -->
                        <div class="md:col-span-2">
                            <label for="nominal" class="block text-sm font-medium text-gray-700 mb-2">
                                Nominal Zakat <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="nominal" name="nominal" min="1" required
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="Masukkan nominal zakat">
                            </div>
                            <div id="error_nominal" class="text-red-500 text-sm mt-1 hidden"></div>
                            
                            <!-- Quick Amount Buttons -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <button type="button" class="quick-amount px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-primary hover:text-white transition-colors" data-amount="100000">100rb</button>
                                <button type="button" class="quick-amount px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-primary hover:text-white transition-colors" data-amount="250000">250rb</button>
                                <button type="button" class="quick-amount px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-primary hover:text-white transition-colors" data-amount="500000">500rb</button>
                                <button type="button" class="quick-amount px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-primary hover:text-white transition-colors" data-amount="1000000">1jt</button>
                                <button type="button" class="quick-amount px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-primary hover:text-white transition-colors" data-amount="2125000">2.1jt</button>
                                <button type="button" id="useCalculated" class="px-4 py-2 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">Gunakan Hasil Kalkulator</button>
                            </div>
                        </div>

                        <!-- Upload Bukti Bayar -->
                        <div class="md:col-span-2">
                            <label for="buktibayar" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Bukti Transfer <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary transition-colors">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="buktibayar" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span>Upload file</span>
                                            <input id="buktibayar" name="buktibayar" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 5MB</p>
                                </div>
                            </div>
                            <div id="error_buktibayar" class="text-red-500 text-sm mt-1 hidden"></div>
                            <div id="preview-container" class="mt-3 hidden">
                                <img id="preview-image" src="" alt="Preview" class="max-w-xs h-32 object-cover rounded-md">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="<?= base_url('dashboard/donatur/zakat') ?>" 
                           class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>Bayar Zakat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        let calculatedZakat = 0;

        // Zakat calculator
        $('#harta').on('input', function() {
            let harta = parseInt($(this).val()) || 0;
            let nisab = 85000000; // 85 juta
            
            if (harta >= nisab) {
                calculatedZakat = Math.floor(harta * 0.025); // 2.5%
                $('#zakatAmount').text('Rp ' + calculatedZakat.toLocaleString('id-ID'));
                $('#useCalculated').show();
            } else {
                calculatedZakat = 0;
                $('#zakatAmount').text('Rp 0');
                $('#useCalculated').hide();
            }
        });

        // Use calculated zakat amount
        $('#useCalculated').click(function() {
            if (calculatedZakat > 0) {
                $('#nominal').val(calculatedZakat);
                $('#error_nominal').addClass('hidden');
            }
        });

        // Zakat type selection
        $('.zakat-card').click(function() {
            $('.zakat-card').removeClass('border-primary bg-primary bg-opacity-10');
            $('.zakat-check').addClass('hidden');
            
            $(this).addClass('border-primary bg-primary bg-opacity-10');
            $(this).find('.zakat-check').removeClass('hidden');
            
            $('#jeniszakat').val($(this).data('zakat'));
            $('#error_jeniszakat').addClass('hidden');
        });

        // Quick amount buttons
        $('.quick-amount').click(function() {
            $('#nominal').val($(this).data('amount'));
            $('#error_nominal').addClass('hidden');
        });

        // File preview
        $('#buktibayar').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').removeClass('hidden');
                };
                reader.readAsDataURL(file);
                $('#error_buktibayar').addClass('hidden');
            }
        });

        // Format number input
        $('#nominal, #harta').on('input', function() {
            let value = $(this).val().replace(/[^\d]/g, '');
            $(this).val(value);
        });

        // Form submission
        $('#formZakat').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            // Clear previous errors
            $('.text-red-500').addClass('hidden');
            
            $.ajax({
                url: '<?= site_url('dashboard/donatur/zakat/save') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Alhamdulillah!',
                            text: response.sukses,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= site_url('dashboard/donatur/zakat') ?>';
                            }
                        });
                    } else if (response.error) {
                        // Show validation errors
                        if (typeof response.error === 'string') {
                            Swal.fire('Error!', response.error, 'error');
                        } else {
                            $.each(response.error, function(key, value) {
                                if (value) {
                                    $('#' + key).text(value).removeClass('hidden');
                                }
                            });
                            
                            Swal.fire('Error!', 'Silakan periksa form dan lengkapi data yang diperlukan', 'error');
                        }
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat mengirim zakat', 'error');
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-paper-plane mr-2"></i>Bayar Zakat');
                }
            });
        });
    });
    </script>
</body>
</html>
