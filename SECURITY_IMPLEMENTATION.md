# Security Implementation Documentation

## Role-Based Access Control (RBAC) Implementation

### Overview
This document outlines the security measures implemented in the ITE311-PIJERA project to protect against common web vulnerabilities and ensure secure role-based access control.

---

## 1. User Roles

The system supports three distinct user roles:

- **Admin**: Full system access, user management, system configuration
- **Teacher**: Course management, student oversight, assignment grading
- **Student**: Course enrollment, assignment submission, grade viewing

Default role for new registrations: **Student**

---

## 2. Security Features Implemented

### 2.1 Authentication Security

#### Password Security
- **Strong Hashing**: Uses `PASSWORD_ARGON2ID` algorithm with custom parameters
  - Memory cost: 2048 KB
  - Time cost: 4 iterations
  - Threads: 3
- **Password Requirements**: Minimum 6 characters (enforced via validation)

#### Session Security
- **Session Regeneration**: Session ID regenerated on login to prevent session fixation attacks
- **Session Timeout**: 24-hour automatic timeout
- **Session Validation**: Validates session integrity on each protected page access
- **Session Data**: Stores user ID, role, login time, IP address, and user agent

#### Brute Force Protection
- **Rate Limiting**: Maximum 5 failed login attempts
- **Account Lockout**: 15-minute lockout after exceeding max attempts
- **Attempt Tracking**: Failed attempts tracked per email address

### 2.2 Input Validation & Sanitization

#### Registration Form
- **Name**: Required, 3-100 characters, HTML entities escaped
- **Email**: Required, valid email format, unique in database, sanitized
- **Password**: Required, minimum 6 characters
- **Password Confirmation**: Must match password field

#### Login Form
- **Email**: Required, valid email format, sanitized
- **Password**: Required
- **Generic Error Messages**: Prevents user enumeration attacks

### 2.3 CSRF Protection
- **Global CSRF Protection**: Enabled for all POST requests
- **Token Validation**: CSRF tokens validated on form submissions
- **Automatic Token Generation**: CodeIgniter's built-in CSRF protection

### 2.4 XSS Prevention
- **Output Escaping**: All user-generated content escaped using `esc()` or `htmlspecialchars()`
- **Input Sanitization**: Strip tags and sanitize inputs before database storage
- **Content Security**: HTML special characters encoded

### 2.5 SQL Injection Prevention
- **Query Builder**: Uses CodeIgniter's Query Builder (prepared statements)
- **Parameterized Queries**: All database queries use parameter binding
- **Input Validation**: Server-side validation before database operations

### 2.6 Authorization & Access Control

#### Authentication Filter (`AuthFilter.php`)
- Validates user login status
- Checks session integrity
- Stores intended URL for post-login redirect
- Adds security headers to responses

#### Role Filter (`RoleFilter.php`)
- Validates user roles for specific routes
- Prevents unauthorized access to role-specific features
- Redirects unauthorized users to dashboard

#### Security Headers
- `X-Frame-Options: SAMEORIGIN` - Prevents clickjacking
- `X-Content-Type-Options: nosniff` - Prevents MIME sniffing
- `X-XSS-Protection: 1; mode=block` - Enables XSS filtering
- `Referrer-Policy: strict-origin-when-cross-origin` - Controls referrer information

---

## 3. Role-Based Dashboard Features

### Admin Dashboard
- View all users statistics (total, by role)
- Recent users list
- User management capabilities
- System reports and settings

### Teacher Dashboard
- Class management
- Student count
- Assignment tracking
- Grade management

### Student Dashboard
- Enrolled courses
- Assignment status (completed/pending)
- Grade viewing
- Course materials access

---

## 4. Protected Routes

### Authentication Required
- `/dashboard` - All authenticated users
- `/dashboard/*` - All dashboard sub-routes

### Role-Specific Access
Routes can be protected using the `role` filter with specific role requirements.

---

## 5. Security Best Practices Followed

1. **Principle of Least Privilege**: Users only have access to features required for their role
2. **Defense in Depth**: Multiple layers of security (validation, sanitization, filters)
3. **Secure by Default**: New users assigned least privileged role (student)
4. **Session Management**: Proper session lifecycle management
5. **Error Handling**: Generic error messages to prevent information disclosure
6. **Input Validation**: Both client-side and server-side validation
7. **Secure Password Storage**: Never store plain text passwords
8. **Regular Security Updates**: Using latest CodeIgniter security features

---

## 6. Vulnerability Mitigation

### Prevented Vulnerabilities

✅ **SQL Injection**: Query Builder with prepared statements  
✅ **XSS (Cross-Site Scripting)**: Output escaping and input sanitization  
✅ **CSRF (Cross-Site Request Forgery)**: CSRF tokens on all forms  
✅ **Session Fixation**: Session regeneration on login  
✅ **Brute Force Attacks**: Rate limiting and account lockout  
✅ **User Enumeration**: Generic error messages  
✅ **Clickjacking**: X-Frame-Options header  
✅ **MIME Sniffing**: X-Content-Type-Options header  
✅ **Insecure Direct Object References**: Role-based access control  
✅ **Session Hijacking**: Session validation and timeout  

---

## 7. Testing Recommendations

### Security Testing Checklist

- [ ] Test login with invalid credentials (verify lockout after 5 attempts)
- [ ] Test session timeout (wait 24 hours or modify timeout value)
- [ ] Test CSRF protection (submit form without token)
- [ ] Test role-based access (try accessing admin features as student)
- [ ] Test XSS prevention (submit malicious scripts in forms)
- [ ] Test SQL injection (submit SQL commands in input fields)
- [ ] Test password strength (try weak passwords)
- [ ] Test session fixation (use same session ID after login)
- [ ] Verify all user inputs are sanitized
- [ ] Verify all outputs are escaped

---

## 8. Configuration Files Modified

1. **app/Controllers/Auth.php** - Enhanced with security measures
2. **app/Filters/AuthFilter.php** - Created for authentication
3. **app/Filters/RoleFilter.php** - Created for role-based access
4. **app/Config/Filters.php** - Registered custom filters and enabled CSRF
5. **app/Views/auth/login.php** - CSRF token included
6. **app/Views/auth/register.php** - CSRF token included
7. **app/Views/auth/dashboard.php** - Role-based content display
8. **app/Views/templates/header.php** - Role-based navigation

---

## 9. Database Schema

### Users Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- name (VARCHAR 100)
- email (VARCHAR 191, UNIQUE)
- password_hash (VARCHAR 255)
- role (ENUM: 'student', 'teacher', 'admin')
- created_at (DATETIME)
- updated_at (DATETIME)
- deleted_at (DATETIME, nullable)
```

---

## 10. Future Security Enhancements

- [ ] Implement two-factor authentication (2FA)
- [ ] Add email verification for new registrations
- [ ] Implement password reset functionality
- [ ] Add audit logging for sensitive operations
- [ ] Implement password complexity requirements
- [ ] Add CAPTCHA for registration and login
- [ ] Implement account recovery mechanisms
- [ ] Add IP-based access restrictions
- [ ] Implement API rate limiting
- [ ] Add security event notifications

---

## 11. Maintenance

### Regular Security Tasks
1. Keep CodeIgniter framework updated
2. Review and update security configurations
3. Monitor failed login attempts
4. Review user access logs
5. Update password hashing algorithms as needed
6. Conduct regular security audits
7. Update dependencies regularly

---

## Contact & Support

For security concerns or vulnerability reports, please contact the system administrator.

**Last Updated**: October 22, 2025  
**Version**: 1.0  
**Author**: Mark Pijera
