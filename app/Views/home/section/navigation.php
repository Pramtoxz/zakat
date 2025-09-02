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
                <a href="#kalkulator" class="text-gray-700 hover:text-primary transition-colors">Kalkulator Zakat</a>
                <a href="#urgent" class="text-gray-700 hover:text-primary transition-colors">Program Urgent</a>
                <a href="#program" class="text-gray-700 hover:text-primary transition-colors">Program</a>
                
                <?php if (session()->get('logged_in')): ?>
                    <!-- User Dropdown -->
                    <div class="relative" id="userDropdown">
                        <button id="dropdownToggle" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="font-medium"><?= session()->get('username') ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 hidden">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-600">Sebagai</p>
                                <p class="text-sm font-medium text-gray-900 capitalize"><?= session()->get('role') ?></p>
                            </div>
                            <a href="<?= base_url('dashboard/' . strtolower(session()->get('role'))) ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="<?= base_url('profile/edit') ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profile
                            </a>
                            <hr class="my-1">
                            <a href="<?= base_url('logout') ?>" 
                               class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth') ?>" class="bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-2 rounded-full hover:shadow-lg transition-all duration-300">
                        Masuk Sistem
                    </a>
                <?php endif; ?>
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
