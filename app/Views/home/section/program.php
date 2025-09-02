<!-- Regular Programs Section -->
<section id="program" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Program Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Berbagai program berkelanjutan yang kami jalankan untuk membantu masyarakat yang membutuhkan.
            </p>
        </div>
        
        <?php if (empty($programBiasa)): ?>
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Program</h3>
                <p class="text-gray-500">Program akan segera hadir untuk membantu masyarakat.</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($programBiasa as $program): ?>
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100" data-program-id="<?= $program['idprogram'] ?>">
                        <div class="relative">
                            <img src="<?= base_url('assets/img/program/' . $program['foto']) ?>" 
                                 alt="<?= $program['namaprogram'] ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4">
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?= $program['namakategori'] ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $program['namaprogram'] ?></h3>
                            <p class="text-gray-600 mb-6 line-clamp-3"><?= substr($program['deskripsi'], 0, 120) ?>...</p>
                            
                            <div class="flex space-x-2">
                                <button type="button" class="btn-detail flex-1 bg-gradient-to-r from-primary to-primary-dark text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300" data-id="<?= $program['idprogram'] ?>">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Detail
                                </button>
                                <a href="<?= base_url('dashboard/donatur/donasi/form/' . $program['idprogram']) ?>" 
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                    <i class="fas fa-heart mr-2"></i>
                                    Donasi
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?= base_url('programs') ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-primary to-primary-dark text-white px-8 py-4 rounded-full font-semibold hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-plus-circle"></i>
                    <span>Lihat Semua Program</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
