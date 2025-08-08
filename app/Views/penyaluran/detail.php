<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->

<?php if ($penyaluran['jenisdana'] == 'zakat') : ?>
    <!-- Template untuk Faktur Penerima Manfaat (Zakat) -->
    <div class="invoice p-3 mb-3" style="background-color: white; color: #333; border: 1px solid #ddd;">
        <!-- Header -->
        <div class="row">
            <div class="col-4">
                <div style="display: flex; align-items: center;">
                    <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo MPZ" style="width: 80px; height: 80px; margin-right: 15px;">
                    <div>
                        <h4 style="margin: 0; font-weight: bold;">MPZ</h4>
                        <p style="margin: 0; font-size: 12px;">YAYASAN</p>
                        <p style="margin: 0; font-size: 10px; color: #666;">ALUMNI FK UNAND</p>
                    </div>
                </div>
            </div>
            <div class="col-8 text-right">
                <h3 style="margin: 0; font-weight: bold;">FAKTUR PENERIMA MANFAAT</h3>
                <p style="margin: 5px 0; font-size: 12px;">Lembaga Mitra Pengelola Zakat Alumni FK Unand</p>
                <hr style="margin: 10px 0;">
                <p style="margin: 0; font-size: 11px;">Jl. Aloe No. 123, Kota Padang</p>
                <p style="margin: 0; font-size: 11px;">Telepon : (0751) 123456 | Email : info@lembagampz.org</p>
            </div>
        </div>

        <br>

        <!-- Info Penerima -->
        <div class="row">
            <div class="col-6">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 40%; padding: 3px 0;"><strong>Nama Penerima</strong></td>
                        <td style="padding: 3px 0;">: <?= $penyaluran['nama_mustahik'] ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 0;"><strong>ID Transaksi</strong></td>
                        <td style="padding: 3px 0;">: TRX-<?= str_pad($penyaluran['id'], 8, '0', STR_PAD_LEFT) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 0;"><strong>Tanggal</strong></td>
                        <td style="padding: 3px 0;">: <?= date('d F Y', strtotime($penyaluran['tglpenyaluran'])) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 0;"><strong>Program Sosial</strong></td>
                        <td style="padding: 3px 0;">: <?= $penyaluran['jenisbantuan'] ?? 'Bantuan Zakat' ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 0;"><strong>Deskripsi Program</strong></td>
                        <td style="padding: 3px 0;">: <?= $penyaluran['deskripsi'] ?? 'Bantuan untuk mustahik' ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <br>

        <!-- Tabel Detail -->
        <div class="row">
            <div class="col-12">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Deskripsi</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">Santunan Tunai</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rp. <?= number_format($penyaluran['nominal'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">Paket Sekolah (Tas, Buku, Alat Tulis)</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">1 Paket</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <!-- Footer -->
        <div class="row">
            <div class="col-4 text-left">
                <p style="margin: 10px 0; font-size: 12px;">Diterima Oleh :</p>
                <p style="margin: 5px 0; font-weight: bold;">Nama Penerima</p>
                <br>
                <br>
                <p style="margin: 5px 0; font-weight: bold;">TTD</p>
            </div>
            <div class="col-8 text-right">
                <p style="margin: 10px 0; font-size: 12px;">Disalurkan Oleh :</p>
                <p style="margin: 5px 0; font-weight: bold;">Ketua Lembaga MPZ</p>
                <br>
                <br>
                <p style="margin: 5px 0; font-weight: bold;">TTD</p>
            </div>
        </div>

        <br>

        <div class="text-center" style="color: #999; font-size: 11px;">
            <p>Terimakasih Telah Mendukung Program Sosial Kami</p>
            <br>
            <p>Faktur ini dihasilkan secara otomatis dan sah tanpa tanda tangan manual</p>
        </div>
    </div>

<?php else : ?>
    <!-- Template untuk Faktur Penerimaan Donasi -->
    <div class="invoice p-3 mb-3" style="background-color: white; color: #333; border: 1px solid #ddd;">
        <!-- Header -->
        <div class="row">
            <div class="col-4">
                <div style="display: flex; align-items: center;">
                    <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo MPZ" style="width: 80px; height: 80px; margin-right: 15px;">
                    <div>
                        <h4 style="margin: 0; font-weight: bold;">MPZ</h4>
                        <p style="margin: 0; font-size: 12px;">YAYASAN</p>
                        <p style="margin: 0; font-size: 10px; color: #666;">ALUMNI FK UNAND</p>
                    </div>
                </div>
            </div>
            <div class="col-8 text-right">
                <h3 style="margin: 0; font-weight: bold;">FAKTUR PENERIMAAN DONASI</h3>
                <p style="margin: 5px 0; font-size: 12px;">Lembaga Mitra Pengelola Zakat Alumni FK Unand</p>
                <hr style="margin: 10px 0;">
                <p style="margin: 0; font-size: 11px;">Jl. Aloe No. 123, Kota Padang</p>
                <p style="margin: 0; font-size: 11px;">Telepon : (0751) 123456 | Email : info@lembagampz.org</p>
                <p style="margin: 0; font-size: 11px;">Nomor Code : 001-000-099-9</p>
            </div>
        </div>

        <br>

        <!-- Informasi Penerima Donasi -->
        <div style="background-color: #f8f9fa; padding: 15px; margin-bottom: 20px;">
            <h5 style="margin: 0; font-weight: bold;">Informasi Penerima Donasi</h5>
            <br>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="width: 20%; padding: 3px 0;"><strong>Nama Penerima</strong></td>
                    <td style="padding: 3px 0;">: <?= $penyaluran['nama_mustahik'] ?></td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Kode Penyaluran</strong></td>
                    <td style="padding: 3px 0;">: DNR-<?= str_pad($penyaluran['id'], 8, '0', STR_PAD_LEFT) ?></td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Program Donasi</strong></td>
                    <td style="padding: 3px 0;">: <?= $penyaluran['namaprogram'] ?? 'Program Donasi' ?></td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Kategori</strong></td>
                    <td style="padding: 3px 0;">: <?= $penyaluran['namakategori'] ?? 'Bantuan Sosial' ?></td>
                </tr>
            </table>
        </div>

        <!-- Detail Penyaluran Donasi -->
        <div style="margin-bottom: 20px;">
            <h5 style="margin: 0 0 15px 0; font-weight: bold;">Detail Penyaluran</h5>
            
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 5%;">No</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 25%;">Tanggal Penyaluran</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 25%;">Program Donasi</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 25%;">Nominal</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 20%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">1</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?= date('d-m-Y', strtotime($penyaluran['tglpenyaluran'])) ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= $penyaluran['namaprogram'] ?? 'Program Donasi' ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rp <?= number_format($penyaluran['nominal'], 0, ',', '.') ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?= $penyaluran['deskripsi'] ?? '-' ?></td>
                    </tr>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: center;">Total</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rp <?= number_format($penyaluran['nominal'], 0, ',', '.') ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>

        <div class="text-center" style="margin: 20px 0; font-size: 12px;">
            <p>Penyaluran donasi ini dilakukan sesuai dengan program yang telah ditetapkan oleh organisasi.</p>
            <p>Terimakasih atas dukungan Anda dalam mensukseskan program sosial kami.</p>
        </div>

        <br>

        <!-- Footer -->
        <div class="row">
            <div class="col-4 text-left">
                <p style="margin: 10px 0; font-size: 12px;">Diterima Oleh :</p>
                <p style="margin: 5px 0; font-weight: bold;">Nama Penerima</p>
                <br>
                <br>
                <p style="margin: 5px 0; font-weight: bold;">TTD</p>
            </div>
            <div class="col-8 text-right">
                <p style="margin: 10px 0; font-size: 12px;">Disalurkan Oleh :</p>
                <p style="margin: 5px 0; font-weight: bold;">Ketua Lembaga MPZ</p>
                <br>
                <br>
                <p style="margin: 5px 0; font-weight: bold;">TTD</p>
            </div>
        </div>

        <br>

        <div class="text-center" style="color: #999; font-size: 11px;">
            <p>Faktur ini adalah bukti penyaluran donasi resmi. Simpan faktur ini sebagai bukti transaksi</p>
        </div>
    </div>

<?php endif; ?>

<!-- Tombol Print dan Kembali -->
<div class="row no-print">
    <div class="col-12">
        <a href="#" onclick="window.print();" class="btn btn-default" style="background-color: #4a5c68; color: white;">
            <i class="fas fa-print"></i> Print
        </a>
        <a href="<?= base_url() ?>/penyaluran" class="btn btn-primary float-right" style="margin-right: 5px; background-color: #2a3f54; border-color: #2a3f54;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- Script tambahan jika ada -->
<?= $this->endSection() ?>