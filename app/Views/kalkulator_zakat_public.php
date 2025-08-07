<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Zakat - Sistem Manajemen Zakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981',
                        secondary: '#F3F4F6'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="<?= base_url('/') ?>" class="flex items-center">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="h-8 w-8 mr-3">
                        <span class="text-xl font-bold text-gray-900">Zakat Center</span>
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

    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-primary bg-opacity-10 rounded-full text-primary font-medium text-sm mb-4">
                        <i class="fas fa-calculator mr-2"></i>
                        Kalkulator Zakat
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Kalkulator Zakat Lengkap</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Hitung zakat Anda sesuai ketentuan syariah berdasarkan standar BAZNAS. 
                        Kalkulator ini dapat digunakan oleh siapa saja untuk mengetahui kewajiban zakat.
                    </p>
                </div>
            </div>

            <!-- Zakat Calculator Tabs -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Tab Headers -->
                <div class="flex border-b">
                    <button onclick="showTab('penghasilan')" 
                            class="tab-button flex-1 px-6 py-4 text-center font-semibold transition-colors active"
                            id="tab-penghasilan">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Zakat Penghasilan
                    </button>
                    <button onclick="showTab('emas')" 
                            class="tab-button flex-1 px-6 py-4 text-center font-semibold transition-colors"
                            id="tab-emas">
                        <i class="fas fa-coins mr-2"></i>
                        Zakat Emas
                    </button>
                    <button onclick="showTab('perdagangan')" 
                            class="tab-button flex-1 px-6 py-4 text-center font-semibold transition-colors"
                            id="tab-perdagangan">
                        <i class="fas fa-store mr-2"></i>
                        Zakat Perdagangan
                    </button>
                </div>

                <!-- Zakat Penghasilan Calculator -->
                <div id="penghasilan-calculator" class="tab-content p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">Kalkulator Zakat Penghasilan/Profesi</h2>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                            <p class="text-blue-800 text-sm">
                                <strong>Ketentuan:</strong> Nishab zakat penghasilan sebesar 85 gram emas per tahun (setara Rp 85.685.972 per tahun atau Rp 7.140.498 per bulan). 
                                Kadar zakat 2,5% dari penghasilan yang melebihi nishab.
                            </p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gaji per Bulan (Rp)</label>
                                <input type="number" id="gaji" placeholder="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                       oninput="hitungPenghasilan()">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Lain per Bulan (Rp)</label>
                                <input type="number" id="penghasilan_lain" placeholder="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                       oninput="hitungPenghasilan()">
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-800 mb-3">Penghasilan Cepat</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="setPenghasilan(5000000)" class="bg-primary text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors">5 Juta</button>
                                    <button onclick="setPenghasilan(10000000)" class="bg-primary text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors">10 Juta</button>
                                    <button onclick="setPenghasilan(15000000)" class="bg-primary text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors">15 Juta</button>
                                    <button onclick="setPenghasilan(20000000)" class="bg-primary text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors">20 Juta</button>
                                </div>
                            </div>

                            <button onclick="resetPenghasilan()" class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                        </div>

                        <div class="bg-gradient-to-br from-primary to-green-600 text-white p-6 rounded-xl">
                            <h3 class="text-xl font-bold mb-4">Hasil Perhitungan</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Total Penghasilan/Bulan:</span>
                                    <span class="font-semibold" id="total_penghasilan">Rp 0</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Nishab per Bulan:</span>
                                    <span class="font-semibold">Rp 7.140.498</span>
                                </div>
                                
                                <hr class="border-green-400">
                                
                                <div class="flex justify-between text-lg">
                                    <span>Zakat Wajib (2,5%):</span>
                                    <span class="font-bold text-xl" id="zakat_penghasilan">Rp 0</span>
                                </div>
                                
                                <div id="status_penghasilan" class="text-center text-sm mt-4 p-2 bg-green-500 rounded">
                                    Masukkan penghasilan untuk menghitung zakat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zakat Emas Calculator -->
                <div id="emas-calculator" class="tab-content p-8 hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">Kalkulator Zakat Emas</h2>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="text-yellow-800 text-sm">
                                <strong>Ketentuan:</strong> Nishab zakat emas sebesar 85 gram emas (setara Rp 85.685.972). 
                                Kadar zakat 2,5% dari nilai emas yang dimiliki jika melebihi nishab.
                            </p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Emas yang Dimiliki (Rp)</label>
                                <input type="number" id="nilai_emas" placeholder="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                       oninput="hitungEmas()">
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-800 mb-3">Nilai Emas Cepat</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="setEmas(50000000)" class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition-colors">50 Juta</button>
                                    <button onclick="setEmas(100000000)" class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition-colors">100 Juta</button>
                                    <button onclick="setEmas(150000000)" class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition-colors">150 Juta</button>
                                    <button onclick="setEmas(200000000)" class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition-colors">200 Juta</button>
                                </div>
                            </div>

                            <button onclick="resetEmas()" class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                        </div>

                        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl">
                            <h3 class="text-xl font-bold mb-4">Hasil Perhitungan</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Nilai Emas:</span>
                                    <span class="font-semibold" id="total_emas">Rp 0</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Nishab (85 gram):</span>
                                    <span class="font-semibold">Rp 85.685.972</span>
                                </div>
                                
                                <hr class="border-yellow-400">
                                
                                <div class="flex justify-between text-lg">
                                    <span>Zakat Wajib (2,5%):</span>
                                    <span class="font-bold text-xl" id="zakat_emas">Rp 0</span>
                                </div>
                                
                                <div id="status_emas" class="text-center text-sm mt-4 p-2 bg-yellow-500 rounded">
                                    Masukkan nilai emas untuk menghitung zakat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zakat Perdagangan Calculator -->
                <div id="perdagangan-calculator" class="tab-content p-8 hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">Kalkulator Zakat Perdagangan</h2>
                        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded">
                            <p class="text-purple-800 text-sm">
                                <strong>Ketentuan:</strong> Zakat perdagangan dihitung dari (Aset Lancar - Kewajiban Lancar). 
                                Nishab setara 85 gram emas. Kadar zakat 2,5%.
                            </p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Aset Lancar (Rp)</label>
                                <input type="number" id="aset_lancar" placeholder="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                       oninput="hitungPerdagangan()">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kewajiban Lancar (Rp)</label>
                                <input type="number" id="kewajiban_lancar" placeholder="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                       oninput="hitungPerdagangan()">
                            </div>

                            <button onclick="resetPerdagangan()" class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                        </div>

                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl">
                            <h3 class="text-xl font-bold mb-4">Hasil Perhitungan</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Aset Lancar:</span>
                                    <span class="font-semibold" id="total_aset">Rp 0</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Kewajiban Lancar:</span>
                                    <span class="font-semibold" id="total_kewajiban">Rp 0</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Nishab:</span>
                                    <span class="font-semibold">Rp 85.685.972</span>
                                </div>
                                
                                <hr class="border-purple-400">
                                
                                <div class="flex justify-between text-lg">
                                    <span>Zakat Wajib (2,5%):</span>
                                    <span class="font-bold text-xl" id="zakat_perdagangan">Rp 0</span>
                                </div>
                                
                                <div id="status_perdagangan" class="text-center text-sm mt-4 p-2 bg-purple-500 rounded">
                                    Masukkan data untuk menghitung zakat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    Informasi Penting
                </h3>
                <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Nishab Zakat 2025</h4>
                        <ul class="space-y-1">
                            <li>• Penghasilan: Rp 85.685.972/tahun</li>
                            <li>• Per Bulan: Rp 7.140.498</li>
                            <li>• Emas: 85 gram (≈ Rp 85.685.972)</li>
                            <li>• Perdagangan: Setara 85 gram emas</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Kadar Zakat</h4>
                        <ul class="space-y-1">
                            <li>• Semua jenis zakat maal: 2,5%</li>
                            <li>• <strong>Wajib</strong>: Jika mencapai nishab</li>
                            <li>• <strong>Sedekah</strong>: Jika belum mencapai nishab</li>
                            <li>• Berdasarkan SK BAZNAS No. 13 Tahun 2025</li>
                        </ul>
                        <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
                            <strong>Catatan:</strong> Kalkulator tetap menghitung 2,5% meski belum mencapai nishab, sebagai panduan sedekah.
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-8 bg-gradient-to-r from-primary to-green-600 text-white rounded-2xl p-8 text-center">
                <h3 class="text-2xl font-bold mb-4">Sudah Tahu Berapa Zakat Anda?</h3>
                <p class="text-green-100 mb-6">
                    Daftar sekarang untuk mulai menunaikan zakat dan donasi dengan mudah melalui platform kami
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= base_url('register') ?>" 
                       class="inline-flex items-center px-6 py-3 bg-white text-primary rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="<?= base_url('/') ?>" 
                       class="inline-flex items-center px-6 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 Sistem Manajemen Zakat. Semua hak dilindungi.</p>
            <p class="text-gray-400 text-sm mt-2">Berdasarkan standar BAZNAS dan ketentuan syariah Islam</p>
        </div>
    </footer>

    <script>
        // Konstanta nishab berdasarkan BAZNAS 2025
        const NISHAB_TAHUNAN = 85685972; // Rp 85.685.972 (sesuai SK BAZNAS No. 13 tahun 2025)
        const NISHAB_BULANAN = 7140498; // Rp 7.140.498 (sesuai SK BAZNAS No. 13 tahun 2025)
        const KADAR_ZAKAT = 0.025; // 2.5%

        // Tab functionality
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'bg-primary', 'text-white');
                btn.classList.add('text-gray-600', 'hover:text-primary');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-calculator').classList.remove('hidden');
            
            // Add active class to selected button
            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('active', 'bg-primary', 'text-white');
            activeBtn.classList.remove('text-gray-600', 'hover:text-primary');
        }

        // Format rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Zakat Penghasilan Calculator
        function hitungPenghasilan() {
            const gaji = parseFloat(document.getElementById('gaji').value) || 0;
            const penghasilanLain = parseFloat(document.getElementById('penghasilan_lain').value) || 0;
            const totalPenghasilan = gaji + penghasilanLain;
            
            document.getElementById('total_penghasilan').textContent = formatRupiah(totalPenghasilan);
            
            let zakatWajib = 0;
            let status = '';
            
            // Selalu hitung 2.5% dari total penghasilan (seperti di BAZNAS)
            zakatWajib = totalPenghasilan * KADAR_ZAKAT;
            
            if (totalPenghasilan >= NISHAB_BULANAN) {
                status = 'Penghasilan Anda wajib zakat!';
                document.getElementById('status_penghasilan').className = 'text-center text-sm mt-4 p-2 bg-green-500 rounded';
            } else if (totalPenghasilan > 0) {
                status = 'Penghasilan belum mencapai nishab, silakan sedekah';
                document.getElementById('status_penghasilan').className = 'text-center text-sm mt-4 p-2 bg-orange-500 rounded';
            } else {
                zakatWajib = 0;
                status = 'Masukkan penghasilan untuk menghitung zakat';
                document.getElementById('status_penghasilan').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
            }
            
            document.getElementById('zakat_penghasilan').textContent = formatRupiah(zakatWajib);
            document.getElementById('status_penghasilan').textContent = status;
        }

        function setPenghasilan(nilai) {
            document.getElementById('gaji').value = nilai;
            document.getElementById('penghasilan_lain').value = 0;
            hitungPenghasilan();
        }

        function resetPenghasilan() {
            document.getElementById('gaji').value = '';
            document.getElementById('penghasilan_lain').value = '';
            document.getElementById('total_penghasilan').textContent = 'Rp 0';
            document.getElementById('zakat_penghasilan').textContent = 'Rp 0';
            document.getElementById('status_penghasilan').textContent = 'Masukkan penghasilan untuk menghitung zakat';
            document.getElementById('status_penghasilan').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
        }

        // Zakat Emas Calculator
        function hitungEmas() {
            const nilaiEmas = parseFloat(document.getElementById('nilai_emas').value) || 0;
            
            document.getElementById('total_emas').textContent = formatRupiah(nilaiEmas);
            
            let zakatWajib = 0;
            let status = '';
            
            // Selalu hitung 2.5% dari nilai emas (seperti di BAZNAS)
            zakatWajib = nilaiEmas * KADAR_ZAKAT;
            
            if (nilaiEmas >= NISHAB_TAHUNAN) {
                status = 'Emas Anda wajib zakat!';
                document.getElementById('status_emas').className = 'text-center text-sm mt-4 p-2 bg-yellow-500 rounded';
            } else if (nilaiEmas > 0) {
                status = 'Emas belum mencapai nishab, silakan sedekah';
                document.getElementById('status_emas').className = 'text-center text-sm mt-4 p-2 bg-orange-500 rounded';
            } else {
                zakatWajib = 0;
                status = 'Masukkan nilai emas untuk menghitung zakat';
                document.getElementById('status_emas').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
            }
            
            document.getElementById('zakat_emas').textContent = formatRupiah(zakatWajib);
            document.getElementById('status_emas').textContent = status;
        }

        function setEmas(nilai) {
            document.getElementById('nilai_emas').value = nilai;
            hitungEmas();
        }

        function resetEmas() {
            document.getElementById('nilai_emas').value = '';
            document.getElementById('total_emas').textContent = 'Rp 0';
            document.getElementById('zakat_emas').textContent = 'Rp 0';
            document.getElementById('status_emas').textContent = 'Masukkan nilai emas untuk menghitung zakat';
            document.getElementById('status_emas').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
        }

        // Zakat Perdagangan Calculator
        function hitungPerdagangan() {
            const asetLancar = parseFloat(document.getElementById('aset_lancar').value) || 0;
            const kewajibanLancar = parseFloat(document.getElementById('kewajiban_lancar').value) || 0;
            const totalBersih = asetLancar - kewajibanLancar;
            
            document.getElementById('total_aset').textContent = formatRupiah(asetLancar);
            document.getElementById('total_kewajiban').textContent = formatRupiah(kewajibanLancar);
            
            let zakatWajib = 0;
            let status = '';
            
            // Selalu hitung 2.5% dari aset bersih jika positif (seperti di BAZNAS)
            if (totalBersih > 0) {
                zakatWajib = totalBersih * KADAR_ZAKAT;
                
                if (totalBersih >= NISHAB_TAHUNAN) {
                    status = 'Usaha Anda wajib zakat!';
                    document.getElementById('status_perdagangan').className = 'text-center text-sm mt-4 p-2 bg-purple-500 rounded';
                } else {
                    status = 'Aset bersih belum mencapai nishab, silakan sedekah';
                    document.getElementById('status_perdagangan').className = 'text-center text-sm mt-4 p-2 bg-orange-500 rounded';
                }
            } else {
                zakatWajib = 0;
                status = 'Masukkan data untuk menghitung zakat';
                document.getElementById('status_perdagangan').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
            }
            
            document.getElementById('zakat_perdagangan').textContent = formatRupiah(zakatWajib);
            document.getElementById('status_perdagangan').textContent = status;
        }

        function resetPerdagangan() {
            document.getElementById('aset_lancar').value = '';
            document.getElementById('kewajiban_lancar').value = '';
            document.getElementById('total_aset').textContent = 'Rp 0';
            document.getElementById('total_kewajiban').textContent = 'Rp 0';
            document.getElementById('zakat_perdagangan').textContent = 'Rp 0';
            document.getElementById('status_perdagangan').textContent = 'Masukkan data untuk menghitung zakat';
            document.getElementById('status_perdagangan').className = 'text-center text-sm mt-4 p-2 bg-gray-500 rounded';
        }

        // Initialize with first tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('penghasilan');
        });

        // Add styles for active tab
        const style = document.createElement('style');
        style.textContent = `
            .tab-button {
                transition: all 0.3s ease;
            }
            .tab-button:not(.active) {
                @apply text-gray-600 hover:text-primary;
            }
            .tab-button.active {
                @apply bg-primary text-white;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
