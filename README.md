# 🎓 University Management System (UMS)

A comprehensive PHP + MySQL web-based application designed to streamline university operations including department management, faculty administration, student records, course catalogs, and academic resources.

**Based on:** Khulna University of Engineering & Technology (KUET) structure  
**Built with:** Database management concepts (DDL, DML, Constraints, JOINs, Views, Aggregations)

---

## 🚀 Features

### **Authentication & Authorization**
- **3 User Roles:** Admin, Teacher, Student with distinct privileges
- **Secure Login:** SHA-256 password hashing (never stores plain text)
- **Session Management:** Persistent user state with role-based access control
- **Access Protection:** Each page validates authentication and authorization

### **Admin Panel (Full System Access)**
- **CRUD Operations:** Complete Create, Read, Update, Delete for all entities
  - Departments (17 KUET departments with faculty mapping)
  - Teachers (31 faculty members with salary tracking)
  - Students (48 students with CGPA and advisor mapping)
  - Courses (44 courses across departments)
  - Books (44 academic references)
  - Book References (Course-Book associations)
- **Safe Delete Logic:** Prevents deletion with foreign key dependencies
- **Server-Side Validation:** Regex patterns, data type checks, range validation
- **Analytical Reports:** 5 SQL views with aggregate functions and multi-table JOINs
- **Unified Navigation:** Consistent menu across all admin pages

### **Teacher Dashboard (Personalized View)**
- **Personal Profile:** Name, gender, salary, department, faculty
- **Advised Students:** Complete list with CGPA tracking
- **Advanced Filtering:** All students | High performers (≥3.5) | Medium (2.5-3.5) | Low (<2.5)
- **Sorting Options:** By name, CGPA ascending, CGPA descending
- **Aggregate Statistics:** Total count, Average CGPA, Max/Min CGPA, High performer count
- **Department Analysis:** Students by department with filtering capabilities

### **Student Dashboard (Personal View)**
- **Profile Information:** Name, CGPA, department, faculty
- **Academic Advisor:** Assigned teacher with contact details
- **Course Catalog:** Department-specific course list with credits

### **Database Architecture**
- **7 Normalized Tables:** 3NF compliance for data integrity
- **Foreign Key Constraints:** Referential integrity with CASCADE/SET NULL actions
- **Check Constraints:** CGPA (0-4), Salary (≥0), Credits (0-4)
- **Unique Constraints:** Username uniqueness in users table
- **Prepared Statements:** 100% SQL injection prevention
- **5 Analytical Views:** Reusable complex queries for reporting

### **Modern Professional UI**
- **Gradient Theme:** Purple-blue gradient design throughout
- **Google Fonts:** Inter and Poppins for professional typography
- **CSS Variables:** Centralized color scheme management
- **Responsive Navigation:** Unified admin navigation component
- **User Feedback:** Success messages, error alerts, delete confirmations
- **Professional Landing Page:** Feature showcase without demo credentials

---

## 🧩 Tech Stack

| Layer | Technology |
|-------|-------------|
| Frontend | HTML5, CSS3, JavaScript (Vanilla) |
| Backend | PHP 7.4+ with MySQLi |
| Database | MySQL 8.0 / MariaDB (phpMyAdmin / XAMPP) |
| Server | Apache (XAMPP) |
| Version Control | Git + GitHub |

---

## 🗂️ Project Structure

```
university-management-system/
├── public/                          # Web-accessible directory
│   ├── index.php                    # Landing page (features showcase)
│   ├── login.php                    # Authentication page
│   ├── logout.php                   # Session destroy & redirect
│   │
│   ├── admin/                       # Admin panel (Full CRUD access)
│   │   ├── dashboard.php            # Admin overview
│   │   ├── reports.php              # 5 analytical SQL views
│   │   │
│   │   ├── departments_list.php     # List all departments
│   │   ├── departments_add.php      # Add new department
│   │   ├── departments_edit.php     # Edit department
│   │   ├── departments_delete.php   # Safe delete with dependency check
│   │   │
│   │   ├── teachers_list.php        # List teachers with JOIN (dept name)
│   │   ├── teachers_add.php         # Add teacher with dept dropdown
│   │   ├── teachers_edit.php        # Edit teacher
│   │   ├── teachers_delete.php      # Safe delete (check advised students)
│   │   │
│   │   ├── students_list.php        # List students (3-table JOIN)
│   │   ├── students_add.php         # Add student with advisor selection
│   │   ├── students_edit.php        # Edit student
│   │   ├── students_delete.php      # Delete student
│   │   │
│   │   ├── courses_list.php         # List courses with dept info
│   │   ├── courses_add.php          # Add course
│   │   ├── courses_edit.php         # Edit course
│   │   ├── courses_delete.php       # Safe delete (check book refs)
│   │   │
│   │   ├── books_list.php           # List books with reference count
│   │   ├── books_add.php            # Add book
│   │   ├── books_edit.php           # Edit book
│   │   ├── books_delete.php         # Safe delete (check course refs)
│   │   │
│   │   ├── bookrefs_list.php        # List book-course associations (3-table JOIN)
│   │   ├── bookrefs_add.php         # Add book reference
│   │   └── bookrefs_delete.php      # Delete reference
│   │
│   ├── teacher/                     # Teacher interface
│   │   └── dashboard.php            # Personalized dashboard with:
│   │                                #   - Personal info
│   │                                #   - Advised students list
│   │                                #   - CGPA filtering & sorting
│   │                                #   - Aggregate statistics
│   │
│   └── student/                     # Student interface
│       └── dashboard.php            # Personal dashboard with:
│                                    #   - Profile (name, CGPA)
│                                    #   - Department info
│                                    #   - Advisor details
│                                    #   - Course catalog
│
├── src/                             # Backend PHP logic
│   ├── db.php                       # MySQLi database connection
│   ├── auth.php                     # Authentication functions
│   │                                #   - require_login()
│   │                                #   - Session validation
│   │                                #   - Role checking
│   ├── helpers.php                  # Utility functions (validation, sanitization)
│   └── admin_nav.php                # Unified navigation component for admin
│
├── assets/                          # Static assets
│   └── css/
│       └── style.css                # Main stylesheet (gradients, typography)
│
├── sql/                             # Database scripts
│   ├── university_db.sql            # Complete database dump (408 lines)
│   │                                #   - CREATE DATABASE
│   │                                #   - CREATE TABLES (7 tables)
│   │                                #   - ALTER TABLE constraints
│   │                                #   - CREATE VIEWS (5 views)
│   │                                #   - Sample data
│   │
│   ├── kuet_seed_data.sql           # Realistic KUET data (417 lines)
│   │                                #   - 17 departments
│   │                                #   - 31 teachers
│   │                                #   - 48 students
│   │                                #   - 44 courses
│   │                                #   - 44 books
│   │                                #   - 44 book references
│   │                                #   - 11 user accounts
│   │
│   ├── 002_create_departments.sql   # Departments table DDL
│   ├── 003_create_teachers.sql      # Teachers table DDL
│   ├── 004_create_courses_books.sql # Courses, Books, Book_refs tables
│   ├── 005_create_students.sql      # Students table DDL
│   ├── 007_create_users.sql         # Users table for authentication
│   └── 008_create_reports_views.sql # 5 analytical views
│
├── PROJECT_REPORT.md                # Comprehensive project documentation
├── README.md                        # This file
└── .gitignore                       # Git ignore rules
```

---

## 📦 Installation & Setup

### Prerequisites
- XAMPP (or LAMP/WAMP/MAMP) with:
  - Apache Server
  - MySQL 8.0+
  - PHP 7.4+
- Git (optional, for cloning)

### Step 1: Clone/Download the Project
```bash
# Clone via Git
git clone https://github.com/saif17313/university-management-system.git

# Or download ZIP and extract to:
C:\xampp\htdocs\university-management-system
```

### Step 2: Import Database

**Option A: Import Complete Database (Recommended)**
1. Start XAMPP (Apache + MySQL)
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Click **"Import"** tab
4. Choose file: `sql/university_db.sql`
5. Click **"Go"** to import

**Option B: Import KUET Seed Data (Realistic Data)**
1. First create database:
   ```sql
   CREATE DATABASE university_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Select `university_db` database
3. Import `sql/university_db.sql` (creates tables and views)
4. Import `sql/kuet_seed_data.sql` (inserts realistic KUET data)

**Result:** Database with:
- 7 tables (departments, teachers, students, courses, books, book_refs, users)
- 5 analytical views
- 17 departments, 31 teachers, 48 students, 44 courses, 44 books
- 11 user accounts (1 admin, 5 teachers, 5 students)

### Step 3: Configure Database Connection
Edit `src/db.php` if your MySQL credentials differ:
```php
$host = "localhost";
$user = "root";
$pass = "";  // Default XAMPP password is empty
$db = "university_db";
```

### Step 4: Access the Application
1. Open browser and navigate to:
   ```
   http://localhost/university-management-system/public/
   ```
2. Click **"Login"** to access the system

---

## 🔐 Login Credentials

### Admin Account
| Username | Password | Access Level |
|----------|----------|--------------|
| `admin` | `admin` | Full system access (all CRUD operations, reports) |

### Teacher Accounts (password: teacher123)
| Username | Department | Teacher Name |
|----------|------------|--------------|
| `rezaul.karim` | Computer Science & Engineering | Dr. Md. Rezaul Karim |
| `sakib.cse` | Computer Science & Engineering | Dr. Kazi Sakib |
| `salam.eee` | Electrical & Electronic Engineering | Dr. Muhammad Abdus Salam |
| `ali.me` | Mechanical Engineering | Dr. Mohammad Ali |
| `alamgir.ce` | Civil Engineering | Dr. Muhammed Alamgir |

### Student Accounts (password: student123)
| Student ID | Department | Student Name | CGPA |
|------------|------------|--------------|------|
| `1805001` | Computer Science & Engineering | Md. Fahim Rahman | 3.78 |
| `1805002` | Computer Science & Engineering | Tasnia Islam | 3.92 |
| `1705021` | Electrical & Electronic Engineering | Md. Arif Hossain | 3.75 |
| `1605031` | Mechanical Engineering | Md. Mahmudul Hasan | 3.56 |
| `1805051` | Civil Engineering | Md. Saif Rahman | 3.68 |

> **Security Note:** All passwords are hashed using SHA-256. Never stored as plain text in database.

---

## 📊 Database Schema

### Entity Relationship Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                  University Management System Schema                    │
│                                                                         │
│  ┌──────────────┐            ref_id → s_id (if role='student')         │
│  │    Users     │◄─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┐      │
│  ├──────────────┤                                                │      │
│  │ user_id (PK) │                                                ▼      │
│  │ username     │          ref_id → t_id (if role='teacher')  ┌─────────┐
│  │password_hash │◄─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┐          │Students │
│  │ role (ENUM)  │                                  │          ├─────────┤
│  │ ref_id (FK)  │          ┌──────────┐            │          │s_id (PK)│
│  └──────────────┘          │ Teachers │            │          │ s_name  │
│         │                  ├──────────┤            │          │ cgpa    │
│         │ dept_id→dept_id  │ t_id(PK) │            │          │dept_id  │
│         │                  │ t_name   │────────────┘          │  (FK)   │
│         ▼                  │ gender   │  t_id → advisor_id    │advisor  │
│  ┌──────────────┐          │ salary   │◄──────────────────────┤_id (FK) │
│  │ Departments  │          │dept_id   │                       └────┬────┘
│  ├──────────────┤          │   (FK)   │                            │
│  │dept_id (PK)  │          └────┬─────┘                            │
│  │ dept_name    │◄──────────────┘                                  │
│  │ faculty      │              dept_id → dept_id                   │
│  │no_of_students│◄─────────────────────────────────────────────────┘
│  └──────┬───────┘           dept_id → dept_id
│         │
│         │ dept_id → d_id
│         │
│         │          ┌──────────┐              book_no → book_no
│         │          │  Books   │                      ┌───────────┐
│         │          ├──────────┤                      │ Book_Refs │
│         │          │book_no   │◄─────────────────────┤───────────┤
│         │          │  (PK)    │                      │book_no    │
│         │          │book_name │                      │ (FK,PK)   │
│         │          │ author   │                      │course_no  │
│         │          │ edition  │                      │ (FK,PK)   │
│         │          └──────────┘                      └─────┬─────┘
│         │                                                  │
│         │          ┌──────────┐                            │
│         └─────────►│ Courses  │◄───────────────────────────┘
│                    ├──────────┤      course_no → course_no
│                    │course_no │
│                    │  (PK)    │
│                    │course    │
│                    │ _name    │
│                    │ credit   │
│                    │ d_id(FK) │
│                    └──────────┘
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Table Structures

#### 1. **departments**
```sql
dept_id INT PRIMARY KEY AUTO_INCREMENT
dept_name VARCHAR(50) NOT NULL
faculty VARCHAR(50) NOT NULL
no_of_students INT DEFAULT 0 CHECK (no_of_students >= 0)
```
**Purpose:** Stores department information grouped by faculty  
**Constraints:** Check constraint ensures non-negative student count

#### 2. **teachers**
```sql
t_id INT PRIMARY KEY AUTO_INCREMENT
t_name VARCHAR(100) NOT NULL
gender ENUM('Male','Female') DEFAULT 'Male'
salary DECIMAL(10,2) CHECK (salary >= 0)
dept_id INT FOREIGN KEY → departments(dept_id)
```
**Purpose:** Faculty/teacher records with department association  
**Constraints:** Salary must be non-negative, CASCADE on update, SET NULL on delete

#### 3. **students**
```sql
s_id INT PRIMARY KEY AUTO_INCREMENT
s_name VARCHAR(100) NOT NULL
cgpa DECIMAL(3,2) CHECK (cgpa BETWEEN 0 AND 4)
dept_id INT FOREIGN KEY → departments(dept_id)
advisor_id INT FOREIGN KEY → teachers(t_id)
```
**Purpose:** Student records with CGPA and advisor mapping  
**Constraints:** CGPA range 0.00-4.00, two foreign keys with CASCADE

#### 4. **courses**
```sql
course_no VARCHAR(10) PRIMARY KEY
course_name VARCHAR(100) NOT NULL
credit DECIMAL(3,1) CHECK (credit > 0 AND credit <= 4)
d_id INT FOREIGN KEY → departments(dept_id)
```
**Purpose:** Course catalog with credit hours  
**Constraints:** Credits between 0.5 and 4.0

#### 5. **books**
```sql
book_no INT PRIMARY KEY AUTO_INCREMENT
book_name VARCHAR(150) NOT NULL
author VARCHAR(100)
edition INT
```
**Purpose:** Academic books and references

#### 6. **book_refs** (Junction Table)
```sql
book_no INT FOREIGN KEY → books(book_no)
course_no VARCHAR(10) FOREIGN KEY → courses(course_no)
PRIMARY KEY (book_no, course_no)
```
**Purpose:** Many-to-many relationship between books and courses  
**Constraints:** Composite primary key, CASCADE delete on both FKs

#### 7. **users**
```sql
user_id INT PRIMARY KEY AUTO_INCREMENT
username VARCHAR(50) UNIQUE NOT NULL
password_hash VARCHAR(255) NOT NULL
role ENUM('admin','teacher','student') NOT NULL
ref_id INT
```
**Purpose:** Authentication and authorization  
**Constraints:** Unique username, ref_id maps to t_id or s_id based on role

### Analytical Views (Reports)

#### 1. **students_per_department**
```sql
SELECT d.dept_name, d.faculty, COUNT(s.s_id) as student_count
FROM departments d
LEFT JOIN students s ON d.dept_id = s.dept_id
GROUP BY d.dept_id
ORDER BY student_count DESC;
```
**Used in:** Reports page - Distribution of students across departments

#### 2. **teachers_per_department**
```sql
SELECT d.dept_name, d.faculty, COUNT(t.t_id) as teacher_count
FROM departments d
LEFT JOIN teachers t ON d.dept_id = t.dept_id
GROUP BY d.dept_id
ORDER BY teacher_count DESC;
```
**Used in:** Reports page - Faculty distribution

#### 3. **high_performers**
```sql
SELECT s.s_name, s.cgpa, d.dept_name, t.t_name as advisor
FROM students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
LEFT JOIN teachers t ON s.advisor_id = t.t_id
WHERE s.cgpa > 3.5
ORDER BY s.cgpa DESC;
```
**Used in:** Reports page - Academic excellence tracking

#### 4. **dept_salary_stats**
```sql
SELECT d.dept_name,
       COUNT(t.t_id) as total_teachers,
       AVG(t.salary) as avg_salary,
       MAX(t.salary) as max_salary,
       MIN(t.salary) as min_salary
FROM departments d
LEFT JOIN teachers t ON d.dept_id = t.dept_id
GROUP BY d.dept_id
HAVING COUNT(t.t_id) > 0;
```
**Used in:** Reports page - Salary analytics

#### 5. **view_books_per_course**
```sql
SELECT c.course_no, c.course_name, COUNT(br.book_no) as total_books
FROM courses c
LEFT JOIN book_refs br ON c.course_no = br.course_no
GROUP BY c.course_no
ORDER BY total_books DESC;
```
**Used in:** Reports page - Course resources tracking

### Database Normalization

**Third Normal Form (3NF) Compliance:**
- **1NF:** All attributes are atomic (no multi-valued or composite attributes)
- **2NF:** No partial dependencies (all non-key attributes fully depend on primary key)
- **3NF:** No transitive dependencies (no non-key attribute depends on another non-key attribute)

**Example:** Students table doesn't store `dept_name` directly (would create transitive dependency through `dept_id`). Instead, `dept_id` foreign key links to departments table, eliminating redundancy.

---

## 🛠️ Key SQL Queries & Implementation

### Authentication Queries

**Login Validation** (`public/login.php`)
```sql
SELECT user_id, username, role, ref_id 
FROM users 
WHERE username = ? AND password_hash = ?
```

### CRUD Operations

**Departments with Student Count** (`public/admin/departments_list.php`)
```sql
SELECT dept_id, dept_name, faculty, no_of_students 
FROM departments 
ORDER BY dept_name
```

**Teachers with Department JOIN** (`public/admin/teachers_list.php`)
```sql
SELECT t.t_id, t.t_name, t.gender, t.salary, d.dept_name, d.faculty
FROM teachers t
LEFT JOIN departments d ON t.dept_id = d.dept_id
ORDER BY t.t_name
```

**Students with Multiple JOINs** (`public/admin/students_list.php`)
```sql
SELECT s.s_id, s.s_name, s.cgpa, d.dept_name, t.t_name as advisor_name
FROM students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
LEFT JOIN teachers t ON s.advisor_id = t.t_id
ORDER BY s.s_name
```

**Books with Aggregate Count** (`public/admin/books_list.php`)
```sql
SELECT b.book_no, b.book_name, b.author, b.edition,
       COUNT(br.course_no) as course_count
FROM books b
LEFT JOIN book_refs br ON b.book_no = br.book_no
GROUP BY b.book_no
ORDER BY b.book_name
```

**Book References Triple JOIN** (`public/admin/bookrefs_list.php`)
```sql
SELECT br.book_no, br.course_no, b.book_name, b.author,
       c.course_name, d.dept_name
FROM book_refs br
INNER JOIN books b ON br.book_no = b.book_no
INNER JOIN courses c ON br.course_no = c.course_no
LEFT JOIN departments d ON c.d_id = d.dept_id
ORDER BY b.book_name, c.course_name
```

### Safe Delete Logic

**Check Dependencies Before Delete** (`public/admin/departments_delete.php`)
```sql
-- Check for dependencies
SELECT COUNT(*) as teacher_count FROM teachers WHERE dept_id = ?;
SELECT COUNT(*) as student_count FROM students WHERE dept_id = ?;
SELECT COUNT(*) as course_count FROM courses WHERE d_id = ?;

-- Delete only if all counts = 0
DELETE FROM departments WHERE dept_id = ?;
```

### Teacher Dashboard Queries

**Personal Profile** (`public/teacher/dashboard.php`)
```sql
SELECT t.*, d.dept_name, d.faculty
FROM teachers t
LEFT JOIN departments d ON t.dept_id = d.dept_id
WHERE t.t_id = ?
```

**Advised Students with Filtering** (`public/teacher/dashboard.php`)
```sql
SELECT s.s_id, s.s_name, s.cgpa, d.dept_name
FROM students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
WHERE s.advisor_id = ?
  AND (? = 'all' OR 
       (? = 'high' AND s.cgpa >= 3.5) OR
       (? = 'medium' AND s.cgpa >= 2.5 AND s.cgpa < 3.5) OR
       (? = 'low' AND s.cgpa < 2.5))
ORDER BY 
  CASE WHEN ? = 'name' THEN s.s_name END ASC,
  CASE WHEN ? = 'cgpa_desc' THEN s.cgpa END DESC,
  CASE WHEN ? = 'cgpa_asc' THEN s.cgpa END ASC
```

**Aggregate Statistics** (`public/teacher/dashboard.php`)
```sql
SELECT 
  COUNT(*) as total_students,
  AVG(cgpa) as avg_cgpa,
  MAX(cgpa) as max_cgpa,
  MIN(cgpa) as min_cgpa,
  SUM(CASE WHEN cgpa >= 3.5 THEN 1 ELSE 0 END) as high_performers
FROM students
WHERE advisor_id = ?
```

### Student Dashboard Queries

**Complete Profile** (`public/student/dashboard.php`)
```sql
SELECT s.*, d.dept_name, d.faculty, t.t_name as advisor_name
FROM students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
LEFT JOIN teachers t ON s.advisor_id = t.t_id
WHERE s.s_id = ?
```

### Prepared Statement Example (Security)

```php
// Example from teachers_add.php
$stmt = $mysqli->prepare("INSERT INTO teachers (t_name, gender, salary, dept_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssdi", $name, $gender, $salary, $dept_id);
$stmt->execute();
```

**Benefits:**
- Prevents SQL injection attacks
- Automatic type checking and escaping
- Reusable for multiple executions

---

## 🎯 Features Implementation Details

### 1. Safe Delete Logic
**Implementation:** Check foreign key dependencies before deletion

**Files:**
- `public/admin/departments_delete.php` - Checks teachers, students, courses
- `public/admin/teachers_delete.php` - Checks advised students
- `public/admin/courses_delete.php` - Checks book references
- `public/admin/books_delete.php` - Checks course references

**Process:**
1. Query COUNT of dependent records
2. If count > 0, show error with details
3. If count = 0, proceed with DELETE
4. Show success message and redirect

### 2. Server-Side Validation
**Implementation:** PHP validation functions in `src/helpers.php`

**Validation Rules:**
- **Names:** 2-100 characters, letters and spaces only
- **CGPA:** Decimal between 0.00 and 4.00
- **Salary:** Positive decimal number
- **Course Codes:** Pattern matching (e.g., CSE2101)
- **Credits:** Decimal between 0.5 and 4.0

### 3. Authentication Flow
**Files:** `public/login.php`, `src/auth.php`

**Process:**
1. User submits login form
2. Hash password with SHA-256
3. Query users table with prepared statement
4. On success, create session variables
5. Redirect based on role:
   - admin → `/public/admin/dashboard.php`
   - teacher → `/public/teacher/dashboard.php`
   - student → `/public/student/dashboard.php`

### 4. Role-Based Access Control
**Implementation:** `require_login($role)` function in `src/auth.php`

```php
function require_login($allowed_role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }
    if ($allowed_role && $_SESSION['role'] !== $allowed_role) {
        die('Access denied: Insufficient permissions');
    }
}
```

**Usage in every protected page:**
```php
require_once '../../src/auth.php';
require_login('admin'); // Only admin can access
```

---

## 📈 Analytics & Reports

The Admin Reports page displays:

1. **Students Per Department** - Bar chart showing distribution
2. **Teachers Per Faculty** - Faculty-wise teacher count
3. **High Salary Teachers** - Teachers earning above threshold
4. **Top Performing Students** - Students with CGPA > 3.5
5. **Books Per Course** - Course reference statistics

All reports use SQL Views with JOIN operations and aggregate functions.

---

## 🧪 Testing Checklist

- [ ] Login with all three roles (admin, teacher, student)
- [ ] Admin: Add/Edit/Delete departments, teachers, students, courses, books
- [ ] Admin: Verify safe delete prevents deletion with dependencies
- [ ] Admin: View all 5 analytical reports
- [ ] Teacher: View dashboard with advised students list
- [ ] Student: View dashboard with profile and course list
- [ ] Navigation: All "Back to List" buttons work
- [ ] Validation: Try invalid inputs (empty fields, wrong formats)
- [ ] Logout: Session properly destroyed

---

## 🐛 Troubleshooting

### Common Issues & Solutions

#### Issue: Cannot login / Invalid credentials
**Causes:**
- Database not imported correctly
- Incorrect password hash

**Solutions:**
```sql
-- Verify users exist
SELECT username, role FROM users;

-- Reset admin password (password: admin)
UPDATE users 
SET password_hash = '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918' 
WHERE username = 'admin';

-- Reset teacher password (password: teacher123)
UPDATE users 
SET password_hash = 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64' 
WHERE role = 'teacher';
```

#### Issue: "Student/Teacher data not found" on dashboard
**Cause:** User's `ref_id` doesn't match actual record in students/teachers table

**Solution:**
```sql
-- Check mapping
SELECT u.username, u.role, u.ref_id, s.s_id, s.s_name
FROM users u
LEFT JOIN students s ON u.ref_id = s.s_id
WHERE u.role = 'student';

-- Fix ref_id (replace 123 with actual student s_id)
UPDATE users SET ref_id = 1 WHERE username = '1805001';
```

#### Issue: Database connection failed
**Check:**
1. XAMPP MySQL service is running (green in XAMPP Control Panel)
2. Database `university_db` exists in phpMyAdmin
3. Credentials in `src/db.php` match your MySQL setup:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";  // Default is empty for XAMPP
   $db = "university_db";
   ```
4. Port 3306 is not blocked by firewall

#### Issue: Blank/white pages
**Check:**
1. Enable PHP error display (add to top of page):
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```
2. Check Apache error logs: `xampp/apache/logs/error.log`
3. Verify all `require` paths are correct
4. Check file permissions (should be readable)

#### Issue: Foreign key constraint error when inserting
**Cause:** Referenced record doesn't exist

**Solution:**
```sql
-- Verify department exists before adding teacher
SELECT dept_id, dept_name FROM departments;

-- Verify teacher exists before assigning as advisor
SELECT t_id, t_name FROM teachers WHERE dept_id = ?;
```

#### Issue: Can't delete department - "Has dependencies"
**Expected Behavior:** This is working correctly!

**Solution:** Remove dependencies first:
1. Delete or reassign students in that department
2. Delete or reassign teachers in that department
3. Delete or reassign courses in that department
4. Then delete the department

---

## � Documentation & Resources

### Project Documentation
- **📄 Complete Project Report:** See `PROJECT_REPORT.md` for:
  - Detailed architecture diagrams
  - All SQL queries with line references
  - Feature implementation details
  - Testing results
  - Future enhancements roadmap

### Database Schema
- **ERD Diagram:** See DATABASE SCHEMA section above
- **SQL Scripts:** All in `sql/` directory
- **Table Definitions:** `sql/university_db.sql` lines 30-180

### References Used
1. **PHP Documentation:** https://www.php.net/manual/en/book.mysqli.php
2. **MySQL Reference:** https://dev.mysql.com/doc/refman/8.0/en/
3. **KUET Official Site:** https://www.kuet.ac.bd/ (for realistic data)
4. **SQL Security:** OWASP SQL Injection Prevention Cheat Sheet
5. **Database Design:** Normalization principles (Codd's rules)

---

## 🔄 Future Enhancements

### Planned Features
- [ ] **Course Enrollment System** - Students can register for courses
- [ ] **Grade Management** - Teachers assign grades, generate transcripts
- [ ] **Attendance Tracking** - Daily attendance with reports
- [ ] **Email Notifications** - Alerts for grades, attendance
- [ ] **Password Reset** - Forgot password via email
- [ ] **File Uploads** - Profile pictures, course materials
- [ ] **Advanced Reports** - Charts with Chart.js, export to PDF/Excel
- [ ] **Search & Filter** - Advanced search across entities
- [ ] **RESTful API** - JSON API for mobile apps
- [ ] **Responsive Design** - Mobile-optimized interface
- [ ] **Real-time Notifications** - WebSocket for live updates

### Performance Optimizations
- [ ] Database indexing on frequently queried columns
- [ ] Query result caching
- [ ] Lazy loading for large datasets
- [ ] CDN for static assets

### Security Enhancements
- [ ] CSRF token protection
- [ ] Rate limiting on login attempts
- [ ] Two-factor authentication (2FA)
- [ ] Password strength requirements
- [ ] Activity logging and audit trails

---

## � Contact & Support

**Developer:** Saif  
**GitHub:** [@saif17313](https://github.com/saif17313)  
**Repository:** [university-management-system](https://github.com/saif17313/university-management-system)

### Get Help
- **Issues:** Open an issue on [GitHub Issues](https://github.com/saif17313/university-management-system/issues)
- **Documentation:** See `PROJECT_REPORT.md` for comprehensive details
- **Questions:** Use GitHub Discussions for community support

---

## 📄 License & Usage

This project is created for **educational purposes** as part of database management coursework.

**You are free to:**
- ✅ Use for learning and academic projects
- ✅ Modify and extend features
- ✅ Share with classmates and instructors
- ✅ Use as reference for your own projects

**Please:**
- 📝 Give credit if using substantial portions
- 🎓 Use for learning, not plagiarism
- 🌟 Star the repository if you find it helpful

---

## 🙏 Acknowledgments

- **KUET** - For realistic department and course structure
- **PHP Community** - For MySQLi documentation and best practices
- **XAMPP Team** - For excellent local development environment
- **GitHub** - For version control and collaboration platform
- **Database Course Instructors** - For foundational concepts

---

## � Project Statistics

| Metric | Count |
|--------|-------|
| **Database Tables** | 7 |
| **SQL Views** | 5 |
| **PHP Files** | 30+ |
| **Lines of SQL** | 800+ |
| **Lines of PHP** | 2500+ |
| **CRUD Operations** | 24 (6 entities × 4 operations) |
| **User Roles** | 3 |
| **Test Accounts** | 11 |
| **Git Commits** | 25+ |

---

## 🎯 Learning Outcomes

By studying this project, you will understand:

✅ **Database Design:**
- Normalization (1NF, 2NF, 3NF)
- Entity-Relationship modeling
- Foreign key constraints and referential integrity
- Check constraints and data validation
- Composite keys and junction tables

✅ **SQL Queries:**
- DDL (CREATE, ALTER, DROP)
- DML (INSERT, UPDATE, DELETE)
- DQL (SELECT with JOINs, GROUP BY, HAVING)
- Views and virtual tables
- Prepared statements for security
- Aggregate functions (COUNT, AVG, MAX, MIN, SUM)

✅ **PHP Development:**
- MySQLi procedural and OOP
- Session management and authentication
- Form handling and validation
- Secure coding practices
- Modular code organization
- Error handling

✅ **Web Security:**
- SQL injection prevention
- Password hashing (SHA-256)
- XSS prevention
- Session hijacking protection
- Input validation and sanitization

✅ **Software Engineering:**
- Version control with Git
- Project structure organization
- Code documentation
- Testing strategies
- Future-proof architecture

---

**⭐ If you find this project helpful, please star the repository!**

**🔧 Built with ❤️ for learning database management systems**

---

*Last Updated: October 27, 2025*  
*Project Version: 1.0*  
*Database Schema Version: 1.0*
