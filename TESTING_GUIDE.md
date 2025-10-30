# Comprehensive Testing Guide - Role-Based Access Control System

## Overview
This document provides detailed testing procedures for the ITE311-PIJERA Role-Based Access Control (RBAC) system implementation.

---

## Pre-Testing Setup

### 1. Database Setup
Ensure your database is properly configured:
```bash
# Run migrations
php spark migrate

# Seed test users
php spark db:seed TestUsersSeeder
```

### 2. Test User Accounts
The following test accounts are available:

| Role    | Email              | Password    |
|---------|-------------------|-------------|
| Admin   | admin@test.com    | admin123    |
| Teacher | teacher@test.com  | teacher123  |
| Student | student@test.com  | student123  |

### 3. Server Setup
Start your local server:
```bash
# Using PHP built-in server
php spark serve

# Or using XAMPP
# Ensure Apache and MySQL are running
# Access: http://localhost/ITE311-PIJERA/public
```

---

## Functional Testing

### Test 1: User Registration
**Objective**: Verify new user registration with proper validation

**Steps**:
1. Navigate to: `http://localhost:8080/register`
2. Test with invalid data:
   - Empty fields → Should show validation errors
   - Invalid email format → Should show "valid email" error
   - Password < 6 characters → Should show "minimum 6 characters" error
   - Mismatched passwords → Should show "passwords do not match" error
3. Test with valid data:
   - Name: "Test User"
   - Email: "testuser@example.com"
   - Password: "password123"
   - Confirm Password: "password123"
4. Submit form

**Expected Results**:
- ✅ Validation errors display correctly
- ✅ Success message: "Registration successful! Please login."
- ✅ Redirect to login page
- ✅ User created in database with role "student"
- ✅ Password is hashed (not plain text)

---

### Test 2: User Login - Valid Credentials
**Objective**: Verify successful login process

**Steps**:
1. Navigate to: `http://localhost:8080/login`
2. Enter valid credentials:
   - Email: student@test.com
   - Password: student123
3. Click "Login"

**Expected Results**:
- ✅ Success message: "Welcome back, [Name]!"
- ✅ Redirect to `/dashboard`
- ✅ Session created with user data
- ✅ Role stored in session

---

### Test 3: User Login - Invalid Credentials
**Objective**: Verify security measures for failed login attempts

**Steps**:
1. Navigate to: `http://localhost:8080/login`
2. Enter invalid credentials (5 times):
   - Email: student@test.com
   - Password: wrongpassword
3. Try 6th attempt

**Expected Results**:
- ✅ Error message: "Invalid email or password" (generic message)
- ✅ After 5 failed attempts: "Account temporarily locked"
- ✅ Account locked for 15 minutes
- ✅ No user enumeration (same error for non-existent users)

---

### Test 4: Admin Dashboard Access
**Objective**: Verify admin-specific dashboard features

**Steps**:
1. Login as admin (admin@test.com / admin123)
2. Navigate to `/dashboard`
3. Observe dashboard content

**Expected Results**:
- ✅ Welcome message with admin name
- ✅ Role badge displays "Admin" (red color)
- ✅ Statistics cards show:
  - Total Users count
  - Total Students count
  - Total Teachers count
  - Total Admins count
- ✅ Recent Users table displays last 5 users
- ✅ Admin action buttons visible:
  - Add New User
  - View Reports
  - System Settings
- ✅ Navigation bar shows "Admin" dropdown menu

---

### Test 5: Teacher Dashboard Access
**Objective**: Verify teacher-specific dashboard features

**Steps**:
1. Logout from admin account
2. Login as teacher (teacher@test.com / teacher123)
3. Navigate to `/dashboard`

**Expected Results**:
- ✅ Welcome message with teacher name
- ✅ Role badge displays "Teacher" (cyan color)
- ✅ Statistics cards show:
  - My Classes count
  - Total Students count
  - Pending Assignments count
- ✅ Teacher action buttons visible:
  - Create Assignment
  - View Students
  - Grade Submissions
- ✅ Navigation bar shows "Teaching" dropdown menu

---

### Test 6: Student Dashboard Access
**Objective**: Verify student-specific dashboard features

**Steps**:
1. Logout from teacher account
2. Login as student (student@test.com / student123)
3. Navigate to `/dashboard`

**Expected Results**:
- ✅ Welcome message with student name
- ✅ Role badge displays "Student" (green color)
- ✅ Statistics cards show:
  - Enrolled Courses count
  - Completed Assignments count
  - Pending Assignments count
- ✅ Student action buttons visible:
  - View My Courses
  - View Assignments
  - Check Grades
- ✅ Navigation bar shows student menu items (no dropdown)

---

### Test 7: Authorization - Unauthenticated Access
**Objective**: Verify protection of dashboard from unauthenticated users

**Steps**:
1. Ensure you are logged out
2. Navigate directly to: `http://localhost:8080/dashboard`

**Expected Results**:
- ✅ Redirect to `/login`
- ✅ Error message: "Please login to access the dashboard"
- ✅ Cannot access dashboard without login

---

### Test 8: Session Management
**Objective**: Verify proper session handling

**Steps**:
1. Login as any user
2. Note the session data in browser dev tools
3. Click "Logout"

**Expected Results**:
- ✅ Session destroyed completely
- ✅ Success message: "You have been logged out successfully"
- ✅ Redirect to `/login`
- ✅ Cannot access dashboard after logout
- ✅ Session ID regenerated

---

### Test 9: Dynamic Navigation Bar
**Objective**: Verify role-based navigation menu

**Steps**:
1. Login as each role (admin, teacher, student)
2. Observe navigation bar changes

**Expected Results for Admin**:
- ✅ Dashboard link
- ✅ Admin dropdown with:
  - Manage Users
  - Manage Courses
  - Reports
  - System Settings
- ✅ Profile dropdown with name and role badge

**Expected Results for Teacher**:
- ✅ Dashboard link
- ✅ Teaching dropdown with:
  - My Courses
  - My Students
  - Assignments
  - Grades
- ✅ Profile dropdown with name and role badge

**Expected Results for Student**:
- ✅ Dashboard link
- ✅ My Courses link
- ✅ Assignments link
- ✅ Grades link
- ✅ Profile dropdown with name and role badge

---

## Security Testing

### Test 10: SQL Injection Prevention
**Objective**: Verify protection against SQL injection attacks

**Steps**:
1. Navigate to login page
2. Try SQL injection in email field:
   - `admin@test.com' OR '1'='1`
   - `admin@test.com'; DROP TABLE users; --`
3. Try in password field:
   - `' OR '1'='1`

**Expected Results**:
- ✅ Login fails (invalid credentials)
- ✅ No SQL errors displayed
- ✅ Database remains intact
- ✅ Query Builder prevents injection

---

### Test 11: XSS (Cross-Site Scripting) Prevention
**Objective**: Verify protection against XSS attacks

**Steps**:
1. Register with malicious name:
   - Name: `<script>alert('XSS')</script>`
   - Email: xsstest@test.com
   - Password: password123
2. Login and view dashboard

**Expected Results**:
- ✅ Script tags are escaped/sanitized
- ✅ No JavaScript execution
- ✅ Name displays as plain text: `&lt;script&gt;alert('XSS')&lt;/script&gt;`
- ✅ HTML entities properly encoded

---

### Test 12: CSRF Protection
**Objective**: Verify CSRF token validation

**Steps**:
1. Open login page
2. Inspect form and note CSRF token
3. Open browser console
4. Try submitting form without CSRF token:
```javascript
fetch('/login', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'email=test@test.com&password=test123'
});
```

**Expected Results**:
- ✅ Request blocked/rejected
- ✅ CSRF error message displayed
- ✅ Login fails without valid token

---

### Test 13: Password Security
**Objective**: Verify password hashing and security

**Steps**:
1. Register a new user
2. Check database directly:
```sql
SELECT id, name, email, password_hash FROM users WHERE email='newuser@test.com';
```

**Expected Results**:
- ✅ Password is hashed (not plain text)
- ✅ Hash starts with `$2y$` (bcrypt) or `$argon2id$` (Argon2ID)
- ✅ Hash is 60+ characters long
- ✅ Original password cannot be retrieved

---

### Test 14: Session Fixation Prevention
**Objective**: Verify session regeneration on login

**Steps**:
1. Visit login page (not logged in)
2. Note session ID in browser cookies
3. Login successfully
4. Check session ID again

**Expected Results**:
- ✅ Session ID changes after login
- ✅ Old session ID is invalidated
- ✅ New session ID generated
- ✅ Prevents session fixation attacks

---

### Test 15: Session Timeout
**Objective**: Verify automatic session expiration

**Steps**:
1. Login as any user
2. Note login time
3. Wait 24 hours (or modify timeout in AuthFilter.php for testing)
4. Try to access dashboard

**Expected Results**:
- ✅ Session expires after timeout period
- ✅ Redirect to login page
- ✅ Error message: "Session expired or invalid"
- ✅ Must login again

---

### Test 16: Input Validation
**Objective**: Verify comprehensive input validation

**Registration Form Tests**:
- Empty name → Error: "Name is required"
- Name < 3 chars → Error: "Name must be at least 3 characters"
- Name > 100 chars → Error: "Name cannot exceed 100 characters"
- Invalid email → Error: "Please provide a valid email address"
- Duplicate email → Error: "This email is already registered"
- Password < 6 chars → Error: "Password must be at least 6 characters"
- Mismatched passwords → Error: "Passwords do not match"

**Expected Results**:
- ✅ All validation rules enforced
- ✅ Server-side validation (not just client-side)
- ✅ Clear error messages
- ✅ Form retains valid input on error

---

### Test 17: Security Headers
**Objective**: Verify security headers are set

**Steps**:
1. Login and access dashboard
2. Open browser Developer Tools → Network tab
3. Click on dashboard request
4. Check Response Headers

**Expected Headers**:
- ✅ `X-Frame-Options: SAMEORIGIN` (prevents clickjacking)
- ✅ `X-Content-Type-Options: nosniff` (prevents MIME sniffing)
- ✅ `X-XSS-Protection: 1; mode=block` (XSS filtering)
- ✅ `Referrer-Policy: strict-origin-when-cross-origin`

---

### Test 18: Role-Based Access Control
**Objective**: Verify users can only access their authorized features

**Steps**:
1. Login as student
2. Try to access admin-only features (if implemented)
3. Observe restrictions

**Expected Results**:
- ✅ Students cannot access admin features
- ✅ Students cannot access teacher features
- ✅ Proper authorization checks in place
- ✅ Redirect to dashboard with error message

---

## Performance Testing

### Test 19: Database Query Optimization
**Objective**: Verify efficient database queries

**Steps**:
1. Enable CodeIgniter's Query Builder debugging
2. Login and access dashboard
3. Check number of queries executed

**Expected Results**:
- ✅ Minimal number of queries
- ✅ No N+1 query problems
- ✅ Proper use of Query Builder
- ✅ Fast page load times

---

## Browser Compatibility Testing

### Test 20: Cross-Browser Testing
**Objective**: Verify system works across different browsers

**Browsers to Test**:
- Chrome/Edge (Chromium)
- Firefox
- Safari (if available)

**Expected Results**:
- ✅ Consistent UI across browsers
- ✅ All features work properly
- ✅ No JavaScript errors
- ✅ Responsive design works

---

## Mobile Responsiveness Testing

### Test 21: Mobile Device Testing
**Objective**: Verify responsive design on mobile devices

**Steps**:
1. Open application in browser
2. Use Developer Tools → Device Toolbar
3. Test on different screen sizes:
   - iPhone SE (375px)
   - iPhone 12 Pro (390px)
   - iPad (768px)
   - Desktop (1920px)

**Expected Results**:
- ✅ Layout adapts to screen size
- ✅ Navigation menu collapses on mobile
- ✅ Cards stack properly
- ✅ Forms are usable on mobile
- ✅ No horizontal scrolling

---

## Regression Testing Checklist

After any code changes, verify:
- [ ] All test users can login
- [ ] Dashboard displays correctly for each role
- [ ] Navigation menu shows role-specific items
- [ ] Logout works properly
- [ ] Registration creates new users
- [ ] CSRF protection is active
- [ ] Session management works
- [ ] Input validation functions
- [ ] Security headers are present
- [ ] No console errors

---

## Known Issues & Limitations

### Current Limitations:
1. **Password Reset**: Not yet implemented
2. **Email Verification**: Not yet implemented
3. **Two-Factor Authentication**: Not yet implemented
4. **Remember Me**: Checkbox present but not functional
5. **Course/Assignment Management**: Placeholder data only

### Future Enhancements:
- Implement actual course management
- Add assignment submission functionality
- Create grade management system
- Add user profile editing
- Implement email notifications
- Add activity logging

---

## Bug Reporting

If you find any issues during testing:

1. **Document the bug**:
   - Steps to reproduce
   - Expected behavior
   - Actual behavior
   - Screenshots (if applicable)
   - Browser/environment details

2. **Check severity**:
   - Critical: Security vulnerability or system crash
   - High: Major feature broken
   - Medium: Feature partially broken
   - Low: Minor UI issue or enhancement

3. **Report to development team**

---

## Testing Completion Checklist

Mark each test as completed:
- [ ] Test 1: User Registration
- [ ] Test 2: Valid Login
- [ ] Test 3: Invalid Login & Brute Force Protection
- [ ] Test 4: Admin Dashboard
- [ ] Test 5: Teacher Dashboard
- [ ] Test 6: Student Dashboard
- [ ] Test 7: Unauthenticated Access
- [ ] Test 8: Session Management
- [ ] Test 9: Dynamic Navigation
- [ ] Test 10: SQL Injection Prevention
- [ ] Test 11: XSS Prevention
- [ ] Test 12: CSRF Protection
- [ ] Test 13: Password Security
- [ ] Test 14: Session Fixation Prevention
- [ ] Test 15: Session Timeout
- [ ] Test 16: Input Validation
- [ ] Test 17: Security Headers
- [ ] Test 18: Role-Based Access Control
- [ ] Test 19: Database Query Optimization
- [ ] Test 20: Cross-Browser Testing
- [ ] Test 21: Mobile Responsiveness

---

## Conclusion

This comprehensive testing guide ensures the Role-Based Access Control system is:
- ✅ Functionally complete
- ✅ Secure against common vulnerabilities
- ✅ User-friendly across devices
- ✅ Performance optimized
- ✅ Ready for production deployment

**Last Updated**: October 30, 2025  
**Version**: 1.0  
**Tested By**: [Your Name]
