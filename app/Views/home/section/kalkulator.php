<!-- Kalkulator Zakat Section -->
<section id="kalkulator" class="py-20 bg-gradient-to-br from-green-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-primary bg-opacity-10 rounded-full text-primary font-medium text-sm mb-4">
                <i class="fas fa-calculator mr-2"></i>
                Kalkulator Zakat
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                Hitung Zakat Anda
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Gunakan kalkulator zakat sesuai standar BAZNAS untuk menghitung kewajiban zakat penghasilan, emas, dan perdagangan Anda
            </p>
        </div>

        <!-- Quick Calculator Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Zakat Penghasilan Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Zakat Penghasilan</h3>
                    <p class="text-gray-600 text-sm">Hitung zakat dari gaji dan penghasilan bulanan Anda</p>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan per Bulan (Rp)</label>
                        <input type="number" id="penghasilan_quick" placeholder="0" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               oninput="hitungQuickPenghasilan()">
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Nishab per bulan:</span>
                            <span>Rp 7.140.498</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Zakat (2,5%):</span>
                            <span class="font-bold text-green-600" id="hasil_quick_penghasilan">Rp 0</span>
                        </div>
                        <div class="mt-2 text-xs" id="status_quick_penghasilan">
                            Masukkan penghasilan untuk menghitung
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zakat Emas Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Zakat Emas</h3>
                    <p class="text-gray-600 text-sm">Hitung zakat dari nilai emas yang Anda miliki</p>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Emas (Rp)</label>
                        <input type="number" id="emas_quick" placeholder="0" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               oninput="hitungQuickEmas()">
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Nishab (85 gram):</span>
                            <span>Rp 85.685.972</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Zakat (2,5%):</span>
                            <span class="font-bold text-yellow-600" id="hasil_quick_emas">Rp 0</span>
                        </div>
                        <div class="mt-2 text-xs" id="status_quick_emas">
                            Masukkan nilai emas untuk menghitung
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zakat Perdagangan Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-store text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Zakat Perdagangan</h3>
                    <p class="text-gray-600 text-sm">Hitung zakat dari usaha atau bisnis Anda</p>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aset Bersih (Rp)</label>
                        <input type="number" id="perdagangan_quick" placeholder="0" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               oninput="hitungQuickPerdagangan()">
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Nishab:</span>
                            <span>Rp 85.685.972</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Zakat (2,5%):</span>
                            <span class="font-bold text-purple-600" id="hasil_quick_perdagangan">Rp 0</span>
                        </div>
                        <div class="mt-2 text-xs" id="status_quick_perdagangan">
                            Masukkan aset bersih untuk menghitung
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Calculator Button -->
        <div class="text-center">
            <a href="<?= base_url('kalkulator-zakat') ?>" 
               class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-xl font-semibold hover:bg-green-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-calculator mr-3"></i>
                Buka Kalkulator Lengkap
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
            <p class="text-gray-500 text-sm mt-3">
                Akses kalkulator lengkap dengan fitur lebih detail dan panduan perhitungan
            </p>
        </div>

        <!-- Info Banner -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Informasi Zakat 2025</h3>
                    <div class="grid md:grid-cols-2 gap-6 text-blue-100">
                        <div>
                            <p class="font-medium mb-1">📊 Nishab Zakat Penghasilan</p>
                            <p>Rp 85.685.972/tahun (Rp 7.140.498/bulan)</p>
                        </div>
                        <div>
                            <p class="font-medium mb-1">🥇 Nishab Zakat Emas</p>
                            <p>85 gram emas (≈ Rp 85.685.972)</p>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-info-circle text-6xl opacity-20"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-blue-200">
                <i class="fas fa-check-circle mr-2"></i>
                Berdasarkan SK Ketua BAZNAS No. 13 Tahun 2025
            </div>
        </div>
    </div>
</section>

<script>
    // Konstanta nishab untuk quick calculator
    const NISHAB_TAHUNAN_QUICK = 85685972;
    const NISHAB_BULANAN_QUICK = 7140498;
    const KADAR_ZAKAT_QUICK = 0.025;

    // Format rupiah untuk quick calculator
    function formatRupiahQuick(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Quick Penghasilan Calculator
    function hitungQuickPenghasilan() {
        const penghasilan = parseFloat(document.getElementById('penghasilan_quick').value) || 0;
        const zakatWajib = penghasilan * KADAR_ZAKAT_QUICK;
        
        document.getElementById('hasil_quick_penghasilan').textContent = formatRupiahQuick(zakatWajib);
        
        let status = '';
        if (penghasilan >= NISHAB_BULANAN_QUICK) {
            status = '✅ Wajib zakat';
            document.getElementById('status_quick_penghasilan').className = 'mt-2 text-xs text-green-700 font-medium';
        } else if (penghasilan > 0) {
            status = '💝 Belum wajib, bisa sedekah';
            document.getElementById('status_quick_penghasilan').className = 'mt-2 text-xs text-orange-600';
        } else {
            status = 'Masukkan penghasilan untuk menghitung';
            document.getElementById('status_quick_penghasilan').className = 'mt-2 text-xs text-gray-500';
        }
        
        document.getElementById('status_quick_penghasilan').textContent = status;
    }

    // Quick Emas Calculator
    function hitungQuickEmas() {
        const emas = parseFloat(document.getElementById('emas_quick').value) || 0;
        const zakatWajib = emas * KADAR_ZAKAT_QUICK;
        
        document.getElementById('hasil_quick_emas').textContent = formatRupiahQuick(zakatWajib);
        
        let status = '';
        if (emas >= NISHAB_TAHUNAN_QUICK) {
            status = '✅ Wajib zakat';
            document.getElementById('status_quick_emas').className = 'mt-2 text-xs text-green-700 font-medium';
        } else if (emas > 0) {
            status = '💝 Belum wajib, bisa sedekah';
            document.getElementById('status_quick_emas').className = 'mt-2 text-xs text-orange-600';
        } else {
            status = 'Masukkan nilai emas untuk menghitung';
            document.getElementById('status_quick_emas').className = 'mt-2 text-xs text-gray-500';
        }
        
        document.getElementById('status_quick_emas').textContent = status;
    }

    // Quick Perdagangan Calculator
    function hitungQuickPerdagangan() {
        const perdagangan = parseFloat(document.getElementById('perdagangan_quick').value) || 0;
        const zakatWajib = perdagangan * KADAR_ZAKAT_QUICK;
        
        document.getElementById('hasil_quick_perdagangan').textContent = formatRupiahQuick(zakatWajib);
        
        let status = '';
        if (perdagangan >= NISHAB_TAHUNAN_QUICK) {
            status = '✅ Wajib zakat';
            document.getElementById('status_quick_perdagangan').className = 'mt-2 text-xs text-green-700 font-medium';
        } else if (perdagangan > 0) {
            status = '💝 Belum wajib, bisa sedekah';
            document.getElementById('status_quick_perdagangan').className = 'mt-2 text-xs text-orange-600';
        } else {
            status = 'Masukkan aset bersih untuk menghitung';
            document.getElementById('status_quick_perdagangan').className = 'mt-2 text-xs text-gray-500';
        }
        
        document.getElementById('status_quick_perdagangan').textContent = status;
    }
</script>
