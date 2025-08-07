<!-- Urgent Programs Section -->
<section id="urgent" class="py-20 bg-gradient-to-br from-red-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center space-x-2 bg-red-100 text-red-600 px-4 py-2 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="font-medium">Program Urgent</span>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Bantuan Mendesak</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Program-program yang membutuhkan bantuan segera. Mari berpartisipasi untuk membantu saudara kita yang membutuhkan.
            </p>
        </div>
        
        <?php if (empty($programUrgent)): ?>
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Tidak Ada Program Urgent</h3>
                <p class="text-gray-500">Saat ini tidak ada program yang memerlukan bantuan mendesak.</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($programUrgent as $program): ?>
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <div class="relative">
                            <img src="<?= base_url('assets/img/program/' . $program['foto']) ?>" 
                                 alt="<?= $program['namaprogram'] ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Urgent
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?= $program['namakategori'] ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $program['namaprogram'] ?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-3"><?= substr($program['deskripsi'], 0, 100) ?>...</p>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                    <span>Mulai: <?= date('d M Y', strtotime($program['tglmulai'])) ?></span>
                                </div>
                                <div class="flex items-center text-sm text-red-600 font-medium">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>Berakhir: <?= date('d M Y', strtotime($program['tglselesai'])) ?></span>
                                </div>
                            </div>
                            
                            <button class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-hand-holding-heart mr-2"></i>
                                Bantu Sekarang
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
