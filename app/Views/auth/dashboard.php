<?= view('templates/header', ['title' => 'Dashboard']) ?>

<style>
    body {
        background: #f8f9fa;
    }
    .dashboard-header {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        border-left: 5px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-card.admin {
        border-left-color: #dc3545;
    }
    .stat-card.teacher {
        border-left-color: #0dcaf0;
    }
    .stat-card.student {
        border-left-color: #198754;
    }
    .stat-card .icon {
        font-size: 3rem;
        opacity: 0.8;
    }
    .user-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }
    .role-badge {
        font-size: 0.9rem;
        padding: 8px 16px;
    }
    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
</style>

<!-- Main Content -->
<div class="container">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="user-avatar">
                    <?= strtoupper(substr($userName, 0, 1)) ?>
                </div>
            </div>
            <div class="col">
                <h2 class="mb-1">Welcome, <?= esc($userName) ?>!</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-envelope"></i> <?= esc($userEmail) ?> | 
                    <span class="role-badge badge 
                        <?php if($role === 'admin'): ?>bg-danger
                        <?php elseif($role === 'teacher'): ?>bg-info
                        <?php else: ?>bg-success<?php endif; ?>">
                        <i class="bi bi-shield-check"></i> <?= ucfirst(esc($role)) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Role-Based Content -->
    <?php if ($role === 'admin'): ?>
        <!-- ADMIN DASHBOARD -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="stat-card admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h2 class="mb-0"><?= $totalUsers ?></h2>
                        </div>
                        <i class="bi bi-people-fill icon text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Students</h6>
                            <h2 class="mb-0"><?= $totalStudents ?></h2>
                        </div>
                        <i class="bi bi-mortarboard-fill icon text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Teachers</h6>
                            <h2 class="mb-0"><?= $totalTeachers ?></h2>
                        </div>
                        <i class="bi bi-person-video3 icon text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Admins</h6>
                            <h2 class="mb-0"><?= $totalAdmins ?></h2>
                        </div>
                        <i class="bi bi-shield-fill-check icon text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="table-card">
            <h4 class="mb-4"><i class="bi bi-clock-history"></i> Recent Users</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= esc($user['name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td>
                                <span class="badge 
                                    <?php if($user['role'] === 'admin'): ?>bg-danger
                                    <?php elseif($user['role'] === 'teacher'): ?>bg-info
                                    <?php else: ?>bg-success<?php endif; ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="row mt-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card admin text-center">
                    <i class="bi bi-person-plus-fill icon text-danger"></i>
                    <h5 class="mt-3">Add New User</h5>
                    <p class="text-muted">Create new user accounts</p>
                    <button class="btn btn-danger">Add User</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card admin text-center">
                    <i class="bi bi-bar-chart-fill icon text-danger"></i>
                    <h5 class="mt-3">View Reports</h5>
                    <p class="text-muted">System analytics and reports</p>
                    <button class="btn btn-danger">View Reports</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card admin text-center">
                    <i class="bi bi-gear-fill icon text-danger"></i>
                    <h5 class="mt-3">System Settings</h5>
                    <p class="text-muted">Configure system preferences</p>
                    <button class="btn btn-danger">Settings</button>
                </div>
            </div>
        </div>

    <?php elseif ($role === 'teacher'): ?>
        <!-- TEACHER DASHBOARD -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="stat-card teacher">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">My Classes</h6>
                            <h2 class="mb-0"><?= $myClasses ?></h2>
                        </div>
                        <i class="bi bi-book-fill icon text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card teacher">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Students</h6>
                            <h2 class="mb-0"><?= $totalStudents ?></h2>
                        </div>
                        <i class="bi bi-people-fill icon text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card teacher">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending Assignments</h6>
                            <h2 class="mb-0"><?= $pendingAssignments ?></h2>
                        </div>
                        <i class="bi bi-clipboard-check-fill icon text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Actions -->
        <div class="row mt-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card teacher text-center">
                    <i class="bi bi-journal-plus icon text-info"></i>
                    <h5 class="mt-3">Create Assignment</h5>
                    <p class="text-muted">Add new assignments for students</p>
                    <button class="btn btn-info">Create</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card teacher text-center">
                    <i class="bi bi-people icon text-info"></i>
                    <h5 class="mt-3">View Students</h5>
                    <p class="text-muted">Manage your students</p>
                    <button class="btn btn-info">View Students</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card teacher text-center">
                    <i class="bi bi-bar-chart icon text-info"></i>
                    <h5 class="mt-3">Grade Submissions</h5>
                    <p class="text-muted">Review and grade assignments</p>
                    <button class="btn btn-info">Grade</button>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- STUDENT DASHBOARD -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="stat-card student">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Enrolled Courses</h6>
                            <h2 class="mb-0"><?= $enrolledCourses ?></h2>
                        </div>
                        <i class="bi bi-book-fill icon text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card student">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Completed</h6>
                            <h2 class="mb-0"><?= $completedAssignments ?></h2>
                        </div>
                        <i class="bi bi-check-circle-fill icon text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card student">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending</h6>
                            <h2 class="mb-0"><?= $pendingAssignments ?></h2>
                        </div>
                        <i class="bi bi-clock-fill icon text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Actions -->
        <div class="row mt-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card student text-center">
                    <i class="bi bi-book icon text-success"></i>
                    <h5 class="mt-3">My Courses</h5>
                    <p class="text-muted">View enrolled courses</p>
                    <button class="btn btn-success">View Courses</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card student text-center">
                    <i class="bi bi-clipboard-check icon text-success"></i>
                    <h5 class="mt-3">Assignments</h5>
                    <p class="text-muted">View and submit assignments</p>
                    <button class="btn btn-success">View Assignments</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card student text-center">
                    <i class="bi bi-trophy icon text-success"></i>
                    <h5 class="mt-3">My Grades</h5>
                    <p class="text-muted">Check your performance</p>
                    <button class="btn btn-success">View Grades</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= view('templates/footer') ?>
