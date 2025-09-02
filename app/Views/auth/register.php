<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MPZ Alumni FK Unand Padang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #28A745 0%, #34D399 50%, #10B981 100%);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Memastikan konten bisa scroll */
        body {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }
        
        /* Responsive untuk layar kecil */
        @media (max-height: 800px) {
            .min-h-screen {
                min-height: auto !important;
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
        }
        
        @media (max-height: 600px) {
            .min-h-screen {
                min-height: auto !important;
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
            
            .mb-8 {
                margin-bottom: 1rem !important;
            }
            
            .space-y-6 > * + * {
                margin-top: 1rem !important;
            }
        }
    </style>
</head>
<body class="min-h-screen hero-gradient relative">
    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute bottom-40 right-20 w-24 h-24 bg-yellow-300/20 rounded-full animate-float delay-1000"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/15 rounded-full animate-float delay-500"></div>
        <div class="absolute top-32 right-1/3 w-12 h-12 bg-emerald-300/20 rounded-full animate-float delay-700"></div>
    </div>

    <!-- Back to Home Button -->
    <div class="absolute top-8 left-8 z-20">
        <a href="<?= base_url('/') ?>" class="flex items-center space-x-2 text-white/90 hover:text-white transition-colors group">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-white/30 transition-all">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            <span class="font-medium">Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-start justify-center p-4 relative z-10 py-8 pb-16">
        <div class="w-full max-w-lg animate-fadeInUp my-8">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-3 mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                        <i class="fas fa-mosque text-white text-2xl"></i>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl font-bold text-white">MPZ Alumni FK</h1>
                        <p class="text-white/80 text-sm">Unand Padang</p>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Buat Akun Baru</h2>
                <p class="text-white/80">Bergabunglah bersama kami dalam kebaikan</p>
            </div>

            <!-- Register Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <form id="formRegister" class="space-y-6" action="<?= site_url('auth/register') ?>" method="POST">
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <p><?= session()->getFlashdata('error'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p><?= session()->getFlashdata('message'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-user-tag mr-2 text-primary"></i>Daftar Sebagai
                        </label>
                        <select
                            id="role"
                            name="role"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                            required
                        >
                            <option value="">-- Pilih Role --</option>
                            <option value="donatur" <?= old('role') == 'donatur' ? 'selected' : '' ?>>
                                <i class="fas fa-hand-holding-heart"></i> Donatur (Pemberi Donasi)
                            </option>
                            <option value="mustahik" <?= old('role') == 'mustahik' ? 'selected' : '' ?>>
                                <i class="fas fa-hands"></i> Mustahik (Penerima Zakat)
                            </option>
                        </select>
                        <?php if(isset($validation) && $validation->hasError('role')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('role') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-user mr-2 text-primary"></i>Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                            placeholder="Masukkan username unik"
                            value="<?= old('username') ?>"
                            required
                            autofocus
                        />
                        <?php if(isset($validation) && $validation->hasError('username')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('username') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-envelope mr-2 text-primary"></i>Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                            placeholder="Masukkan alamat email"
                            value="<?= old('email') ?>"
                            required
                        />
                        <?php if(isset($validation) && $validation->hasError('email')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('email') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-lock mr-2 text-primary"></i>Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                                placeholder="Minimal 6 karakter"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors"
                            >
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('password') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirm" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-shield-alt mr-2 text-primary"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirm"
                                name="password_confirm"
                                class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                                placeholder="Ulangi password"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-confirm-password" 
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors"
                            >
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('password_confirm')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('password_confirm') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Role Info Box -->
                    <div id="roleInfo" class="p-4 rounded-xl border-l-4 hidden">
                        <div class="flex items-start space-x-3">
                            <i id="roleIcon" class="text-2xl mt-1"></i>
                            <div>
                                <h4 id="roleTitle" class="font-semibold text-gray-800"></h4>
                                <p id="roleDescription" class="text-sm text-gray-600 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-primary to-primary-dark text-white py-3 px-6 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <i class="fas fa-user-plus"></i>
                            <span>Daftar Sekarang</span>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white/80 text-gray-500 font-medium">atau</span>
                        </div>
                    </div>
                    <p class="mt-6 text-sm text-gray-700">
                        Sudah memiliki akun?
                        <a href="<?= site_url('auth') ?>" class="font-semibold text-primary hover:text-primary-dark transition-colors">
                            Login disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Role selection info
            const roleInfo = {
                donatur: {
                    icon: 'fas fa-hand-holding-heart text-blue-500',
                    title: 'Donatur',
                    description: 'Sebagai donatur, Anda dapat memberikan donasi untuk berbagai program kebaikan dan membantu sesama yang membutuhkan.',
                    color: 'border-blue-500 bg-blue-50'
                },
                mustahik: {
                    icon: 'fas fa-hands text-green-500',
                    title: 'Mustahik',
                    description: 'Sebagai mustahik, Anda dapat mengajukan permohonan bantuan zakat dan berpartisipasi dalam program yang tersedia.',
                    color: 'border-green-500 bg-green-50'
                }
            };

            // Handle role selection
            $('#role').on('change', function() {
                const selectedRole = $(this).val();
                const $roleInfo = $('#roleInfo');
                
                if (selectedRole && roleInfo[selectedRole]) {
                    const info = roleInfo[selectedRole];
                    $('#roleIcon').attr('class', info.icon);
                    $('#roleTitle').text(info.title);
                    $('#roleDescription').text(info.description);
                    $roleInfo.attr('class', `p-4 rounded-xl border-l-4 ${info.color} block`);
                    $roleInfo.show();
                } else {
                    $roleInfo.hide();
                }
            });

            // Toggle password visibility
            $('#toggle-password').on('click', function() {
                const $input = $('#password');
                const $icon = $(this).find('i');
                
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toggle confirm password visibility
            $('#toggle-confirm-password').on('click', function() {
                const $input = $('#password_confirm');
                const $icon = $(this).find('i');
                
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Trigger role info if there's old value
            const oldRole = $('#role').val();
            if (oldRole) {
                $('#role').trigger('change');
            }
        });
    </script>
</body>
</html>