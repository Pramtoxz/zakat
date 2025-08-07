<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MPZ Alumni FK Unand Padang</title>
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
        
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
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

    <!-- Back to Login Button -->
    <div class="absolute top-8 left-8 z-20">
        <a href="<?= site_url('auth') ?>" class="flex items-center space-x-2 text-white/90 hover:text-white transition-colors group">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-white/30 transition-all">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            <span class="font-medium">Kembali ke Login</span>
        </a>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md animate-fadeInUp">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-3 mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl font-bold text-white">Password Baru</h1>
                        <p class="text-white/80 text-sm">MPZ Alumni FK Unand</p>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Buat Password Baru</h2>
                <p class="text-white/80">Silakan buat password yang kuat dan mudah diingat</p>
            </div>

            <!-- Reset Password Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <form action="<?= site_url('auth/reset-password') ?>" method="POST" class="space-y-6">
                    <!-- Hidden email field -->
                    <input type="hidden" name="email" value="<?= $email ?>">
                    
                    <!-- Alert Messages -->
                    <?php if(isset($validation)): ?>
                        <?php if($validation->hasError('password')): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <p><?= $validation->getError('password') ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($validation->hasError('password_confirm')): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <p><?= $validation->getError('password_confirm') ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Success Message -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-green-800">Email Terverifikasi</h4>
                                <p class="text-sm text-green-700 mt-1">
                                    Email Anda telah berhasil diverifikasi. Sekarang Anda dapat membuat password baru.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email Info -->
                    <div class="text-center">
                        <div class="inline-flex items-center space-x-2 bg-gray-50 px-4 py-2 rounded-full border border-gray-200">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="text-gray-700 font-medium text-sm"><?= $email ?></span>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-lock mr-2 text-primary"></i>Password Baru
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 bg-white/80"
                                placeholder="Minimal 6 karakter"
                                required
                                autofocus
                            />
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors"
                            >
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="password-strength bg-gray-200" id="strength-bar"></div>
                            <p class="text-xs text-gray-500 mt-1" id="strength-text">Ketik password untuk melihat kekuatan</p>
                        </div>
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
                                placeholder="Ulangi password baru"
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
                        
                        <!-- Password Match Indicator -->
                        <div class="mt-2">
                            <div class="flex items-center space-x-2" id="match-indicator" style="display: none;">
                                <i id="match-icon" class="text-sm"></i>
                                <span id="match-text" class="text-xs"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">Syarat Password:</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-xs" id="req-length" style="color: #cbd5e0;"></i>
                                <span>Minimal 6 karakter</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-xs" id="req-number" style="color: #cbd5e0;"></i>
                                <span>Mengandung angka</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-xs" id="req-letter" style="color: #cbd5e0;"></i>
                                <span>Mengandung huruf</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            id="reset-btn"
                            class="w-full bg-gradient-to-r from-primary to-primary-dark text-white py-3 px-6 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            <i class="fas fa-save"></i>
                            <span>Simpan Password Baru</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                let text = '';
                let color = '';
                
                if (password.length >= 6) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[a-z]/)) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
                
                switch(strength) {
                    case 0:
                    case 1:
                        text = 'Sangat Lemah';
                        color = '#ef4444';
                        break;
                    case 2:
                        text = 'Lemah';
                        color = '#f59e0b';
                        break;
                    case 3:
                        text = 'Sedang';
                        color = '#eab308';
                        break;
                    case 4:
                        text = 'Kuat';
                        color = '#22c55e';
                        break;
                    case 5:
                        text = 'Sangat Kuat';
                        color = '#16a34a';
                        break;
                }
                
                return { strength, text, color };
            }
            
            // Update password requirements
            function updateRequirements(password) {
                const length = password.length >= 6;
                const hasNumber = /[0-9]/.test(password);
                const hasLetter = /[a-zA-Z]/.test(password);
                
                $('#req-length').css('color', length ? '#22c55e' : '#cbd5e0');
                $('#req-number').css('color', hasNumber ? '#22c55e' : '#cbd5e0');
                $('#req-letter').css('color', hasLetter ? '#22c55e' : '#cbd5e0');
                
                return length && hasNumber && hasLetter;
            }
            
            // Password input handler
            $('#password').on('input', function() {
                const password = $(this).val();
                const { strength, text, color } = checkPasswordStrength(password);
                const isValid = updateRequirements(password);
                
                // Update strength bar
                const width = password ? (strength / 5) * 100 : 0;
                $('#strength-bar').css({
                    'width': width + '%',
                    'background-color': color
                });
                $('#strength-text').text(password ? text : 'Ketik password untuk melihat kekuatan');
                
                checkFormValid();
            });
            
            // Confirm password handler
            $('#password_confirm').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();
                
                if (confirmPassword) {
                    const matches = password === confirmPassword;
                    $('#match-indicator').show();
                    
                    if (matches) {
                        $('#match-icon').removeClass('fa-times text-red-500').addClass('fa-check text-green-500');
                        $('#match-text').removeClass('text-red-600').addClass('text-green-600').text('Password cocok');
                    } else {
                        $('#match-icon').removeClass('fa-check text-green-500').addClass('fa-times text-red-500');
                        $('#match-text').removeClass('text-green-600').addClass('text-red-600').text('Password tidak cocok');
                    }
                } else {
                    $('#match-indicator').hide();
                }
                
                checkFormValid();
            });
            
            // Check if form is valid
            function checkFormValid() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirm').val();
                const isValid = updateRequirements(password);
                const matches = password === confirmPassword;
                
                $('#reset-btn').prop('disabled', !(isValid && matches && confirmPassword));
            }
            
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
        });
    </script>
</body>
</html>