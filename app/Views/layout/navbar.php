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
                <a href="#" class="dropdown-item" onclick="showProfileModal()">
                    <i class="fas fa-user mr-2"></i> Profil Saya
                </a>
                <a href="#" class="dropdown-item" onclick="showPasswordModal()">
                    <i class="fas fa-cog mr-2"></i> Pengaturan Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('logout') ?>" class="dropdown-item dropdown-footer btnLogout">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<script>
// Fungsi untuk menampilkan modal profile
function showProfileModal() {
    // Ambil data user dari session
    const username = '<?= session()->get('username') ?? 'User' ?>';
    const email = '<?= session()->get('email') ?? 'user@example.com' ?>';
    const role = '<?= session()->get('role') ?? 'user' ?>';
    const roleText = role === 'donatur' ? 'Donatur' : role === 'mustahik' ? 'Mustahik' : 'Admin';
    
    Swal.fire({
        title: '<i class="fas fa-user-circle text-primary"></i> Profil Saya',
        html: `
            <div class="text-left">
                <div class="row mb-3">
                    <div class="col-4"><strong>Username:</strong></div>
                    <div class="col-8">${username}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Email:</strong></div>
                    <div class="col-8">${email}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Role:</strong></div>
                    <div class="col-8">
                        <span class="badge badge-${
                            role === 'admin' ? 'danger' :
                            role === 'program' ? 'primary' :
                            role === 'keuangan' ? 'info' :
                            role === 'ketua' ? 'success' :
                            'secondary'
                        }">
                            ${
                                role === 'admin' ? 'Admin' :
                                role === 'program' ? 'Program' :
                                role === 'keuangan' ? 'Keuangan' :
                                role === 'ketua' ? 'Ketua' :
                                'User'
                            }
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8">
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                    </div>
                </div>
            </div>
        `,
        width: '500px',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-edit"></i> Edit Profil',
        cancelButtonText: '<i class="fas fa-times"></i> Tutup',
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#6c757d',
        customClass: {
            popup: 'swal2-popup-profile',
            title: 'swal2-title-profile',
            htmlContainer: 'swal2-html-container-profile'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke halaman edit profile
            window.location.href = '<?= site_url('profile/edit') ?>';
        }
    });
}

// Fungsi untuk menampilkan modal pengaturan password
function showPasswordModal() {
    Swal.fire({
        title: '<i class="fas fa-key text-warning"></i> Ubah Password',
        html: `
            <form id="passwordForm">
                <div class="form-group text-left">
                    <label for="currentPassword" class="font-weight-bold">
                        <i class="fas fa-lock text-primary"></i> Password Lama
                    </label>
                    <input type="password" id="currentPassword" class="form-control" 
                           placeholder="Masukkan password lama" required>
                </div>
                <div class="form-group text-left">
                    <label for="newPassword" class="font-weight-bold">
                        <i class="fas fa-key text-success"></i> Password Baru
                    </label>
                    <input type="password" id="newPassword" class="form-control" 
                           placeholder="Masukkan password baru" required minlength="6">
                </div>
                <div class="form-group text-left">
                    <label for="confirmPassword" class="font-weight-bold">
                        <i class="fas fa-shield-alt text-info"></i> Konfirmasi Password
                    </label>
                    <input type="password" id="confirmPassword" class="form-control" 
                           placeholder="Konfirmasi password baru" required minlength="6">
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <small>Password minimal 6 karakter</small>
                </div>
            </form>
        `,
        width: '450px',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save"></i> Simpan',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#6c757d',
        preConfirm: () => {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Validasi
            if (!currentPassword) {
                Swal.showValidationMessage('Password lama harus diisi');
                return false;
            }
            if (!newPassword) {
                Swal.showValidationMessage('Password baru harus diisi');
                return false;
            }
            if (newPassword.length < 6) {
                Swal.showValidationMessage('Password baru minimal 6 karakter');
                return false;
            }
            if (newPassword !== confirmPassword) {
                Swal.showValidationMessage('Konfirmasi password tidak cocok');
                return false;
            }
            if (currentPassword === newPassword) {
                Swal.showValidationMessage('Password baru harus berbeda dengan password lama');
                return false;
            }
            
            return {
                currentPassword: currentPassword,
                newPassword: newPassword
            };
        },
        customClass: {
            popup: 'swal2-popup-password',
            title: 'swal2-title-password',
            htmlContainer: 'swal2-html-container-password'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim data ke server
            updatePassword(result.value);
        }
    });
}

// Fungsi untuk update password
function updatePassword(data) {
    // Tampilkan loading
    Swal.fire({
        title: 'Mengubah Password...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Kirim AJAX request
    fetch('<?= site_url('auth/change-password') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan saat mengubah password'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat mengubah password'
        });
    });
}

// CSS untuk styling modal
const style = document.createElement('style');
style.textContent = `
    .swal2-popup-profile, .swal2-popup-password {
        border-radius: 15px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    
    .swal2-title-profile, .swal2-title-password {
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    
    .swal2-html-container-profile, .swal2-html-container-password {
        margin: 1rem 0 !important;
    }
    
    .swal2-popup-password .form-control {
        border-radius: 8px !important;
        border: 2px solid #e9ecef !important;
        padding: 0.75rem !important;
        transition: border-color 0.3s !important;
    }
    
    .swal2-popup-password .form-control:focus {
        border-color: #28A745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }
    
    .swal2-popup-password .form-group {
        margin-bottom: 1rem !important;
    }
    
    .swal2-popup-password .alert {
        border-radius: 8px !important;
        font-size: 0.875rem !important;
    }
`;
document.head.appendChild(style);
</script>