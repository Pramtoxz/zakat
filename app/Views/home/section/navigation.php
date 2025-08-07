<!-- Navigation -->
<nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">MPZ Alumni FK</h1>
                    <p class="text-xs text-gray-600">Unand Padang</p>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="#hero" class="text-gray-700 hover:text-primary transition-colors">Beranda</a>
                <a href="#about" class="text-gray-700 hover:text-primary transition-colors">Tentang</a>
                <a href="#urgent" class="text-gray-700 hover:text-primary transition-colors">Program Urgent</a>
                <a href="#program" class="text-gray-700 hover:text-primary transition-colors">Program</a>
                <a href="<?= base_url('auth') ?>" class="bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-2 rounded-full hover:shadow-lg transition-all duration-300">
                    Masuk Sistem
                </a>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-700 hover:text-primary">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
