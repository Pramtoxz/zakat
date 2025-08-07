<style>
/* Modern Sidebar Styles dengan warna utama #28A745 */
.main-sidebar {
    background: linear-gradient(135deg, #28A745 0%, #43c06d 50%, #17692e 100%) !important;
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2) !important;
}

.brand-link {
    background: linear-gradient(135deg, #17692e 0%, #28A745 100%) !important;
    border-bottom: 3px solid rgba(255, 255, 255, 0.2) !important;
    padding: 20px 15px !important;
    transition: all 0.3s ease !important;
}

.brand-link:hover {
    background: linear-gradient(135deg, #28A745 0%, #43c06d 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
}

.brand-image {
    border: 3px solid rgba(255, 255, 255, 0.8) !important;
    transition: all 0.3s ease !important;
}

.brand-link:hover .brand-image {
    border-color: #FFD700 !important;
    transform: scale(1.1);
}

.brand-text {
    color: white !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
}

.sidebar .form-inline .input-group {
    background: rgba(255, 255, 255, 0.1) !important;
    border-radius: 25px !important;
    margin: 15px 10px !important;
    backdrop-filter: blur(10px) !important;
}

.form-control-sidebar {
    background: transparent !important;
    border: none !important;
    color: white !important;
    padding-left: 20px !important;
}

.form-control-sidebar::placeholder {
    color: rgba(255, 255, 255, 0.7) !important;
}

.btn-sidebar {
    background: transparent !important;
    border: none !important;
    color: white !important;
}

.nav-header {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    margin-top: 25px !important;
    margin-bottom: 10px !important;
    padding: 10px 20px !important;
    background: rgba(255, 255, 255, 0.1) !important;
    border-radius: 10px !important;
    margin-left: 10px !important;
    margin-right: 10px !important;
}

.nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    padding: 12px 20px !important;
    margin: 5px 10px !important;
    border-radius: 12px !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    overflow: hidden !important;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.nav-link:hover::before {
    left: 100%;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.15) !important;
    color: #FFD700 !important;
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.nav-link.active {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 215, 0, 0.3) 100%) !important;
    color: #FFD700 !important;
    font-weight: 600 !important;
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
    border-left: 4px solid #FFD700 !important;
}

.nav-icon {
    margin-right: 12px !important;
    font-size: 16px !important;
    width: 20px !important;
    text-align: center !important;
}

.nav-link p {
    margin: 0 !important;
    font-weight: 500 !important;
    font-size: 14px !important;
}

.sidebar-mini.sidebar-collapse .main-sidebar:hover {
    width: 250px !important;
}

/* Scrollbar Styling */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>

<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('/dashboard') ?>" class="brand-link">
        <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo Zakat" class="brand-image img-circle elevation-3" height="40" width="40">
        <span class="brand-text">Zakat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Menu untuk Admin -->
                <?php if(session()->get('role') == 'admin'): ?>
                    <li class="nav-header">Master</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/mustahik') ?>" class="nav-link <?= (current_url() == base_url('/mustahik')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>Mustahik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/donatur') ?>" class="nav-link <?= (current_url() == base_url('/donatur')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>Donatur</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/user') ?>" class="nav-link <?= (current_url() == base_url('/user')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan-users/mustahik') ?>" class="nav-link <?= (current_url() == base_url('/laporan-users/mustahik')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Mustahik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan-users/donatur') ?>" class="nav-link <?= (current_url() == base_url('/laporan-users/donatur')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Donatur</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu untuk Program -->
                <?php if(session()->get('role') == 'program'): ?>
                    <li class="nav-header">Program</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/kategori') ?>" class="nav-link <?= (current_url() == base_url('/kategori')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/permohonan') ?>" class="nav-link <?= (current_url() == base_url('/permohonan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Permohonan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/program') ?>" class="nav-link <?= (current_url() == base_url('/program')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>Program</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu untuk Keuangan -->
                <?php if(session()->get('role') == 'keuangan'): ?>
                    <li class="nav-header">Keuangan</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/zakat') ?>" class="nav-link <?= (current_url() == base_url('/zakat')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Zakat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/donasi') ?>" class="nav-link <?= (current_url() == base_url('/donasi')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Donasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/penyaluran') ?>" class="nav-link <?= (current_url() == base_url('/penyaluran')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Penyaluran</p>
                        </a>
                    </li>
                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/zakat') ?>" class="nav-link <?= (current_url() == base_url('/laporan/zakat')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Zakat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/donasi') ?>" class="nav-link <?= (current_url() == base_url('/laporan/donasi')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Donasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/penyaluran') ?>" class="nav-link <?= (current_url() == base_url('/laporan/penyaluran')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Penyaluran</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu untuk ketua: Bisa melihat seluruh laporan -->
                <?php if(session()->get('role') == 'ketua'): ?>
                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/zakat') ?>" class="nav-link <?= (current_url() == base_url('/laporan/zakat')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Zakat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/donasi') ?>" class="nav-link <?= (current_url() == base_url('/laporan/donasi')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Donasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan/penyaluran') ?>" class="nav-link <?= (current_url() == base_url('/laporan/penyaluran')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Penyaluran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan-users/mustahik') ?>" class="nav-link <?= (current_url() == base_url('/laporan-users/mustahik')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Mustahik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/laporan-users/donatur') ?>" class="nav-link <?= (current_url() == base_url('/laporan-users/donatur')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Donatur</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>