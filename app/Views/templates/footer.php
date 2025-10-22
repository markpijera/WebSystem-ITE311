    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ITE311 - Web System Development</h5>
                    <p class="mb-0">Role-Based Access Control System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 All rights reserved.</p>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <small>Logged in as: <?= session()->get('name') ?> (<?= ucfirst(session()->get('role')) ?>)</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
