<?= $this->extend('working_template') ?>

<?= $this->section('content') ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/dashboard') ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/about') ?>">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/contact') ?>">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i><?= $user['name'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-tachometer-alt me-2"></i>Welcome to Your Dashboard
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-user text-primary me-2"></i>User Information
                                        </h5>
                                        <hr>
                                        <p class="mb-2"><strong>Name:</strong> <?= $user['name'] ?></p>
                                        <p class="mb-2"><strong>Email:</strong> <?= $user['email'] ?></p>
                                        <p class="mb-0"><strong>Role:</strong> 
                                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'success' ?>">
                                                <?= ucfirst($user['role']) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-chart-bar text-success me-2"></i>Quick Actions
                                        </h5>
                                        <hr>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary" onclick="editProfile()">
                                                <i class="fas fa-edit me-2"></i>Edit Profile
                                            </button>
                                            <button class="btn btn-outline-secondary" onclick="openSettings()">
                                                <i class="fas fa-cog me-2"></i>Settings
                                            </button>
                                            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to logout?')">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-info me-2"></i>System Information
                        </h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="fas fa-server fa-2x text-primary mb-2"></i>
                                    <h6>Server Status</h6>
                                    <span class="badge bg-success">Online</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="fas fa-database fa-2x text-success mb-2"></i>
                                    <h6>Database</h6>
                                    <span class="badge bg-success">Connected</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="fas fa-shield-alt fa-2x text-warning mb-2"></i>
                                    <h6>Security</h6>
                                    <span class="badge bg-success">Protected</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                    <h6>Current Time</h6>
                                    <small class="text-muted" id="currentTime"><?= date('M d, Y H:i') ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dashboard functionality
        function editProfile() {
            alert('Profile editing feature coming soon!');
        }
        
        function openSettings() {
            alert('Settings panel coming soon!');
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
        
        // Add some interactivity to the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Update time every minute
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleDateString('en-US', {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                }) + ' ' + now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
                const timeElement = document.getElementById('currentTime');
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
            }
            
            // Update time immediately and then every minute
            updateTime();
            setInterval(updateTime, 60000);
        });
    </script>
<?= $this->endSection() ?>
