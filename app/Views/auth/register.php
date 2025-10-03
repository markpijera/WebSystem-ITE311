<?= $this->extend('working_template') ?>

<?= $this->section('content') ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow mt-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus fa-3x text-primary"></i>
                            <h2 class="mt-3">Create Account</h2>
                            <p class="text-muted">Please fill in your information to register</p>
                        </div>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/register" method="post" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input type="text" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('email')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input type="password" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirm" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <input type="password" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('password_confirm')) ? 'is-invalid' : '' ?>" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password_confirm') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">Already have an account? 
                                <a href="<?= base_url('/login') ?>" class="text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-1"></i>Sign In
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
<?= $this->endSection() ?>
