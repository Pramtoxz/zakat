<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Program - MPZ Alumni FK Unand Padang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <style>
        .swal2-popup-custom {
            font-family: inherit;
        }
        .swal2-popup-custom .swal2-html-container {
            margin: 0;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Include Navigation -->
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="<?= base_url('/') ?>" class="flex items-center">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="h-8 w-8 mr-3">
                        <span class="text-xl font-bold text-gray-900">MPZ Alumni FK Unand</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('/') ?>" class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="<?= base_url('login') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="py-20 bg-gradient-to-br from-primary to-primary-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Semua Program</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Temukan berbagai program kebaikan yang kami jalankan untuk membantu masyarakat yang membutuhkan.
            </p>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (empty($programs)): ?>
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Program</h3>
                    <p class="text-gray-500">Program akan segera hadir untuk membantu masyarakat.</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($programs as $program): ?>
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100" data-program-id="<?= $program['idprogram'] ?>">
                            <div class="relative">
                                <img src="<?= base_url('assets/img/program/' . $program['foto']) ?>" 
                                     alt="<?= $program['namaprogram'] ?>" 
                                     class="w-full h-48 object-cover">
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 left-4">
                                    <?php if ($program['status'] == 'urgent'): ?>
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Urgent
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>Biasa
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="bg-white/90 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                        <?= $program['namakategori'] ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $program['namaprogram'] ?></h3>
                                <p class="text-gray-600 mb-4 line-clamp-3"><?= substr($program['deskripsi'], 0, 120) ?>...</p>
                                
                                <!-- Program Info -->
                                <div class="space-y-2 mb-6">
                                    <?php if ($program['tglmulai']): ?>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                        <span>Mulai: <?= date('d M Y', strtotime($program['tglmulai'])) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($program['tglselesai']): ?>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar-check mr-2 text-primary"></i>
                                        <span>Selesai: <?= date('d M Y', strtotime($program['tglselesai'])) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <button type="button" class="btn-detail flex-1 bg-gradient-to-r from-gray-500 to-gray-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300" data-id="<?= $program['idprogram'] ?>">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Detail
                                    </button>
                                    
                                    <?php if ($program['idkategori'] != 2): // Bukan program zakat ?>
                                    <a href="<?= base_url('dashboard/donatur/donasi/form/' . $program['idprogram']) ?>" 
                                       class="flex-1 bg-gradient-to-r from-primary to-primary-dark text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fas fa-heart mr-2"></i>
                                        Donasi
                                    </a>
                                    <?php else: ?>
                                    <a href="<?= base_url('dashboard/donatur/zakat/form') ?>" 
                                       class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fas fa-mosque mr-2"></i>
                                        Zakat
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Back to Home -->
                <div class="text-center mt-12">
                    <a href="<?= base_url('/') ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white px-8 py-4 rounded-full font-semibold hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Include Footer -->
    <?= $this->include('home/section/footer') ?>

    <!-- Scroll to top button -->
    <button id="scrollTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-primary to-primary-dark text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 invisible">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll to top button
        const scrollTopBtn = document.getElementById('scrollTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'invisible');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Navbar background on scroll
        const navbar = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                navbar.classList.add('bg-white/95');
                navbar.classList.remove('bg-white/90');
            } else {
                navbar.classList.remove('bg-white/95');
                navbar.classList.add('bg-white/90');
            }
        });

        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('dropdownToggle');
            const dropdownMenu = document.getElementById('dropdownMenu');
            
            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });

        // Event listener for detail buttons
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-detail').forEach(function(button) {
                button.addEventListener('click', function() {
                    const idprogram = this.getAttribute('data-id');
                    const programCard = document.querySelector(`[data-program-id="${idprogram}"]`);
                    
                    if (programCard) {
                        const title = programCard.querySelector('h3').textContent;
                        const description = programCard.querySelector('p').textContent;
                        const image = programCard.querySelector('img').src;
                        const statusBadge = programCard.querySelector('.absolute.top-4.left-4 span');
                        const categoryBadge = programCard.querySelector('.absolute.top-4.right-4 span');
                        const startDate = programCard.querySelector('.fa-calendar-alt')?.parentElement?.textContent?.replace('Mulai: ', '') || '-';
                        const endDate = programCard.querySelector('.fa-calendar-check')?.parentElement?.textContent?.replace('Selesai: ', '') || '-';
                        
                        const status = statusBadge.textContent.includes('Urgent') ? 'urgent' : 'biasa';
                        const statusColor = status === 'urgent' ? '#ef4444' : '#28A745';
                        const statusIcon = status === 'urgent' ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle';
                        
                        Swal.fire({
                            title: title,
                            html: `
                                <div class="text-left">
                                    <div class="mb-4">
                                        <img src="${image}" alt="${title}" class="w-full h-48 object-cover rounded-lg mb-3">
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-tag text-gray-500 mr-2"></i>
                                            <span class="font-medium">Kategori:</span>
                                            <span class="ml-2 px-2 py-1 bg-gray-100 rounded text-sm">${categoryBadge.textContent}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="${statusIcon} mr-2" style="color: ${statusColor}"></i>
                                            <span class="font-medium">Status:</span>
                                            <span class="ml-2 px-2 py-1 rounded text-sm text-white" style="background-color: ${statusColor}">${statusBadge.textContent}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-gray-500 mr-2"></i>
                                            <span class="font-medium">Mulai:</span>
                                            <span class="ml-2">${startDate}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-check text-gray-500 mr-2"></i>
                                            <span class="font-medium">Selesai:</span>
                                            <span class="ml-2">${endDate}</span>
                                        </div>
                                        <div class="mt-4">
                                            <span class="font-medium block mb-2">Deskripsi:</span>
                                            <p class="text-gray-600 text-sm leading-relaxed">${description}</p>
                                        </div>
                                    </div>
                                </div>
                            `,
                            width: '600px',
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#28A745',
                            customClass: {
                                popup: 'swal2-popup-custom'
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
