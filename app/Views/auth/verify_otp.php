<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - MPZ Alumni FK Unand Padang</title>
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
        
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2.4); opacity: 0; }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-pulse-ring { animation: pulse-ring 1.5s ease-out infinite; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .otp-input {
            width: 3.5rem;
            height: 4rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .otp-input:focus {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
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

    <!-- Back Button -->
    <div class="absolute top-8 left-8 z-20">
        <a href="<?= site_url('auth') ?>" class="flex items-center space-x-2 text-white/90 hover:text-white transition-colors group">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-white/30 transition-all">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md animate-fadeInUp">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center mb-6">
                    <div class="relative">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                            <i class="fas fa-shield-alt text-white text-3xl"></i>
                        </div>
                        <div class="absolute inset-0 rounded-full bg-white/20 animate-pulse-ring"></div>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Verifikasi OTP</h2>
                <p class="text-white/80">Kode telah dikirim ke email Anda</p>
                <div class="mt-2 inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30">
                    <i class="fas fa-envelope text-yellow-300"></i>
                    <span class="text-white font-medium text-sm"><?= $email ?></span>
                </div>
            </div>

            <!-- OTP Verification Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <form action="<?= site_url($action) ?>" method="POST" class="space-y-8">

                    <!-- Hidden fields -->
                    <input type="hidden" name="email" value="<?= $email ?>">
                    
                    <!-- Alert Messages -->
                    <?php if(isset($error)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <p><?= $error ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Info Message -->
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Masukkan Kode OTP</h3>
                        <p class="text-sm text-gray-600">
                            Kami telah mengirim kode 6 digit ke email Anda. 
                            <br>Periksa juga folder spam jika tidak ditemukan.
                        </p>
                    </div>

                    <!-- OTP Input Fields -->
                    <div class="flex justify-center space-x-3">
                        <?php for($i = 0; $i < 6; $i++): ?>
                        <input
                            type="text"
                            name="otp[]"
                            maxlength="1"
                            class="otp-input border-2 border-gray-200 focus:border-primary focus:outline-none bg-white/80"
                            data-index="<?= $i ?>"
                            <?= $i === 0 ? 'autofocus' : '' ?>
                        />
                        <?php endfor; ?>
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-center space-x-2 text-gray-600">
                                <i class="fas fa-clock"></i>
                                <span class="text-sm">Kode akan kedaluarsa dalam:</span>
                                <span id="timer" class="font-bold text-primary">05:00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            id="verify-btn"
                            class="w-full bg-gradient-to-r from-primary to-primary-dark text-white py-3 px-6 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <i class="fas fa-check-circle"></i>
                            <span>Verifikasi Kode</span>
                        </button>
                    </div>

                    <!-- Resend OTP -->
                    <div class="text-center">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white/80 text-gray-500 font-medium">atau</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button
                                type="button"
                                id="resend-btn"
                                class="text-primary hover:text-primary-dark font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled
                            >
                                <i class="fas fa-redo mr-2"></i>
                                <span id="resend-text">Kirim Ulang Kode</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Timer countdown
            let timeLeft = 300; // 5 minutes
            
            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                $('#timer').text(`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
                
                if (timeLeft <= 0) {
                    $('#timer').text('00:00').addClass('text-red-500');
                    $('#resend-btn').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                    return;
                }
                
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
            
            updateTimer();

            // OTP Input handling
            $('.otp-input').on('input', function() {
                const $this = $(this);
                const value = $this.val();
                
                // Only allow numbers
                if (!/^\d$/.test(value)) {
                    $this.val('');
                    return;
                }
                
                // Move to next input
                const index = parseInt($this.data('index'));
                if (value && index < 5) {
                    $(`.otp-input[data-index="${index + 1}"]`).focus();
                }
                
                // Enable submit button when all fields are filled
                const allFilled = $('.otp-input').toArray().every(input => $(input).val() !== '');
                if (allFilled) {
                    $('#verify-btn').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                } else {
                    $('#verify-btn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                }
            });

            // Handle backspace
            $('.otp-input').on('keydown', function(e) {
                const $this = $(this);
                const index = parseInt($this.data('index'));
                
                if (e.key === 'Backspace' && !$this.val() && index > 0) {
                    $(`.otp-input[data-index="${index - 1}"]`).focus();
                }
            });

            // Paste handling
            $('.otp-input').on('paste', function(e) {
                e.preventDefault();
                const paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').slice(0, 6);
                
                digits.split('').forEach((digit, index) => {
                    $(`.otp-input[data-index="${index}"]`).val(digit);
                });
                
                if (digits.length === 6) {
                    setTimeout(() => {
                        $('form').submit();
                    }, 500);
                }
            });

            // Resend OTP
            $('#resend-btn').on('click', function() {
                if ($(this).prop('disabled')) return;
                
                $.ajax({
                    url: '<?= site_url('auth/resend-otp') ?>',
                    type: 'POST',
                    data: {
                        email: '<?= $email ?>',
                        type: '<?= $type ?>'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Reset timer
                            timeLeft = 300;
                            $('#timer').removeClass('text-red-500');
                            $('#resend-btn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                            updateTimer();
                            
                            // Show success message
                            const successMsg = `
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <p>${response.message}</p>
                                    </div>
                                </div>
                            `;
                            $('form').prepend(successMsg);
                            
                            // Remove message after 5 seconds
                            setTimeout(() => {
                                $('.bg-green-100').fadeOut();
                            }, 5000);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>
</html>