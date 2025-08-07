<style>
/* Modern Footer Styles */
.main-footer {
    background: linear-gradient(135deg, #28A745 0%, #218838 50%, #34CE57 100%) !important;
    color: rgba(255, 255, 255, 0.9) !important;
    border-top: 3px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 -5px 20px rgba(40, 167, 69, 0.3) !important;
    padding: 20px 15px !important;
    backdrop-filter: blur(10px) !important;
    position: relative !important;
    overflow: hidden !important;
}

.main-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.main-footer .float-right {
    background: rgba(255, 255, 255, 0.1) !important;
    padding: 8px 15px !important;
    border-radius: 20px !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(5px) !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    z-index: 1 !important;
}

.main-footer .float-right:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.main-footer strong {
    font-weight: 600 !important;
    color: white !important;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
    position: relative !important;
    z-index: 1 !important;
}

.main-footer a {
    color: #FFD700 !important;
    text-decoration: none !important;
    font-weight: 700 !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    padding: 2px 8px !important;
    border-radius: 5px !important;
}

.main-footer a::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
    transform: translateX(-100%);
    transition: transform 0.5s;
    border-radius: 5px;
}

.main-footer a:hover::before {
    transform: translateX(100%);
}

.main-footer a:hover {
    color: white !important;
    background: rgba(255, 215, 0, 0.2) !important;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

/* Footer Content Layout */
.footer-content {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 15px !important;
    position: relative !important;
    z-index: 1 !important;
}

.footer-info {
    display: flex !important;
    align-items: center !important;
    gap: 15px !important;
}

.footer-logo {
    width: 40px !important;
    height: 40px !important;
    border-radius: 50% !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    transition: all 0.3s ease !important;
}

.footer-logo:hover {
    border-color: #FFD700 !important;
    transform: scale(1.1) rotate(360deg);
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
}

.footer-text {
    font-size: 14px !important;
    line-height: 1.5 !important;
}

.footer-version {
    background: rgba(255, 255, 255, 0.1) !important;
    padding: 8px 15px !important;
    border-radius: 20px !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(5px) !important;
    transition: all 0.3s ease !important;
    font-size: 13px !important;
}

.footer-version:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.footer-version b {
    color: #FFD700 !important;
    margin-right: 5px !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column !important;
        text-align: center !important;
        gap: 10px !important;
    }
    
    .footer-info {
        flex-direction: column !important;
        gap: 10px !important;
    }
    
    .footer-text {
        font-size: 13px !important;
    }
    
    .footer-version {
        margin-top: 10px !important;
    }
}

/* Animation for footer load */
@keyframes footerSlideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.main-footer {
    animation: footerSlideUp 0.6s ease-out !important;
}
</style>

<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-info">
            <img src="<?= base_url() ?>assets/img/logo.png" alt="Logo" class="footer-logo">
            <div class="footer-text">
                <strong>
                    Copyright © <?= date('Y') ?> 
                    <a href="<?= base_url('/') ?>" target="_blank">
                    Lembaga Mitra Pengelola Zakat (MPZ) Alumni FK Unand Padang
                    </a>.
                </strong>
                <div style="margin-top: 5px; font-size: 12px; opacity: 0.8;">
                    Semua hak dilindungi undang-undang.
                </div>
            </div>
        </div>
    </div>
</footer>