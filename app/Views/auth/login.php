<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MPZ Alumni FK Unand Padang</title>
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
    </style>
</head>
<body class="min-h-screen hero-gradient relative overflow-hidden">
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
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md animate-fadeInUp">
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
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang Kembali</h2>
                <p class="text-white/80">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <form id="formAuthentication" class="space-y-6">
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <div id="alert-message" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 hidden" role="alert">
                        <!-- Error message will be displayed here -->
                    </div>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('message'); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Username/Email Field -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-user mr-2 text-primary"></i>Email atau Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                            placeholder="Masukkan email atau username Anda"
                            required
                            autofocus
                        />
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
                                placeholder="••••••••"
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
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                            />
                            <label for="remember" class="ml-3 block text-sm text-gray-700 font-medium">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="<?= site_url('auth/forgot-password') ?>" class="text-sm text-primary hover:text-primary-dark font-medium transition-colors">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button
                            type="submit"
                            id="login-btn"
                            class="w-full bg-gradient-to-r from-primary to-primary-dark text-white py-3 px-6 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
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
                        Belum memiliki akun?
                        <a href="<?= site_url('auth/register') ?>" class="font-semibold text-primary hover:text-primary-dark transition-colors">
                            Daftar disini
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

            // Form submission
            $('#formAuthentication').on('submit', function(e) {
                e.preventDefault();
                
                const username = $('#username').val();
                const password = $('#password').val();
                const remember = $('#remember').is(':checked') ? 'on' : 'off';
                
                // Hide previous alert if exists
                $('#alert-message').addClass('hidden');
                
                $.ajax({
                    url: '<?= site_url('auth/login') ?>',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password,
                        remember: remember
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        } else {
                            $('#alert-message').removeClass('hidden').text(response.message);
                        }
                    },
                    error: function() {
                        $('#alert-message').removeClass('hidden').text('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>
</html> 