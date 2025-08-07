<style>
/* Navbar sinkron dengan footer */
.main-header.navbar {
    background: linear-gradient(135deg, #28A745 0%, #218838 50%, #34CE57 100%) !important;
    color: rgba(255,255,255,0.9) !important;
    border-bottom: 3px solid rgba(255,255,255,0.2) !important;
    box-shadow: 0 5px 20px rgba(40,167,69,0.15) !important;
    padding: 0.5rem 1rem !important;
    backdrop-filter: blur(10px) !important;
    position: relative !important;
    z-index: 1000;
}

.main-header .navbar-nav .nav-link,
.main-header .navbar-nav .dropdown-toggle {
    color: #FFD700 !important;
    font-weight: 600 !important;
    transition: color 0.3s;
    border-radius: 8px;
    padding: 8px 14px;
    position: relative;
}

.main-header .navbar-nav .nav-link:hover,
.main-header .navbar-nav .dropdown-toggle:hover {
    color: #fff !important;
    background: rgba(255,215,0,0.15) !important;
    text-shadow: 0 0 8px rgba(255,215,0,0.3);
}

.main-header .navbar-nav .dropdown-menu {
    background: rgba(40,167,69,0.98) !important;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.15);
    box-shadow: 0 8px 24px rgba(40,167,69,0.18);
    min-width: 220px;
    margin-top: 10px;
    padding: 0.5rem 0;
}

.main-header .navbar-nav .dropdown-item {
    color: #FFD700 !important;
    font-weight: 500;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s;
    padding: 10px 20px;
    position: relative;
}

.main-header .navbar-nav .dropdown-item:hover,
.main-header .navbar-nav .dropdown-item:focus {
    background: rgba(255,215,0,0.18) !important;
    color: #fff !important;
}

.main-header .navbar-nav .dropdown-header {
    color: #fff !important;
    font-weight: 700;
    font-size: 1rem;
    background: none;
    padding-bottom: 0.5rem;
}

.main-header .navbar-nav .dropdown-divider {
    border-top: 1px solid rgba(255,255,255,0.15);
}

.main-header .navbar-nav .btnLogout {
    color: #ff4d4f !important;
    font-weight: bold;
    background: none !important;
    transition: color 0.2s;
}

.main-header .navbar-nav .btnLogout:hover {
    color: #fff !important;
    background: #ff4d4f !important;
}

.main-header .navbar-nav .img-circle {
    border: 2px solid #FFD700;
    box-shadow: 0 0 10px rgba(255,215,0,0.3);
    transition: border-color 0.3s, box-shadow 0.3s;
}

.main-header .navbar-nav .img-circle:hover {
    border-color: #fff;
    box-shadow: 0 0 18px rgba(255,255,255,0.4);
}

@media (max-width: 768px) {
    .main-header.navbar {
        padding: 0.5rem 0.5rem !important;
    }
    .main-header .navbar-nav .nav-link {
        padding: 8px 8px;
    }
}
</style>

<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Menu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button" title="Cari">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Cari..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url() ?>assets/img/logo.png" class="img-circle elevation-2 mr-2"
                        alt="User Image" width="32" height="32">
                    <span class="d-none d-md-inline" style="color:#FFD700;font-weight:600;">
                        <?= session()->get('username') ?? 'User' ?>
                    </span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Hallo, <?= session()->get('username') ?? 'User' ?></span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profil Saya
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer btnLogout">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>