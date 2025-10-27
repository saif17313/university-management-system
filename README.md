# 🎓 University Management System (UMS)

A complete PHP + MySQL web-based application to manage university departments, teachers, courses, books, and students.  
Built using concepts from Oracle Database Labs (DDL, DML, Constraints, Joins, Views, etc.).

---

## 🚀 Features

- **Authentication System**
  - Admin / Teacher / Student roles with secure login (SHA-256 password hashing)
  - Session-based authentication with role-based access control
  
- **Admin Panel**
  - CRUD operations for Departments, Teachers, Courses, Books, Students
  - Safe delete with referential integrity checks
  - Server-side validation (regex patterns, data type checks)
  - Analytical Reports (SQL Views, Aggregations, JOIN queries)
  
- **Teacher Dashboard**
  - View personal profile and department information
  - List of advised students with details
  - Average CGPA calculation of advised students
  
- **Student Dashboard**
  - View own profile (name, CGPA, department)
  - See assigned academic advisor
  - Browse department courses
  
- **Database Relations**
  - Full foreign key constraints and cascade behavior
  - Prepared statements for SQL injection prevention
  - 5 analytical SQL views for reporting
  
- **Modern UI**
  - Responsive navigation bar across all pages
  - Consistent design with custom CSS
  - Delete confirmations and user-friendly alerts

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

## 🗂️ Folder Structure

```
university-management-system/
├── public/
│   ├── index.php                    # Landing page
│   ├── login.php                    # Login form (role-based redirect)
│   ├── logout.php                   # Logout handler
│   ├── admin/
│   │   ├── dashboard.php            # Admin dashboard
│   │   ├── reports.php              # Analytics & reports
│   │   ├── departments_list.php     # List all departments
│   │   ├── departments_add.php      # Add new department
│   │   ├── departments_edit.php     # Edit department
│   │   ├── departments_delete.php   # Delete department (safe)
│   │   ├── teachers_*.php           # Teacher CRUD operations
│   │   ├── students_*.php           # Student CRUD operations
│   │   ├── courses_*.php            # Course CRUD operations
│   │   └── books_*.php              # Book CRUD operations
│   ├── teacher/
│   │   └── dashboard.php            # Teacher personalized dashboard
│   └── student/
│       └── dashboard.php            # Student personalized dashboard
├── src/
│   ├── db.php                       # Database connection (MySQLi)
│   └── auth.php                     # Authentication functions
├── css/
│   └── style.css                    # Global stylesheet
├── sql/
│   ├── 001_create_database.sql      # Database creation
│   ├── 002_create_tables.sql        # Table schemas with constraints
│   ├── 003_insert_sample_data.sql   # Sample data for testing
│   ├── 007_create_users.sql         # Users table for authentication
│   ├── 008_create_reports_views.sql # Analytical SQL views
│   ├── 009_fix_user_references.sql  # Fix user ref_id mappings
│   └── university_db.sql            # Complete database dump
└── README.md                        # This file
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
1. Start XAMPP (Apache + MySQL)
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Click **"New"** to create database or use SQL tab
4. Import the database file:
   - **Option A:** Import `sql/university_db.sql` (full dump)
   - **Option B:** Run SQL files in order (001, 002, 003, 007, 008, 009)
5. Database `university_db` should be created with all tables and sample data

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

## 🔐 Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Teacher | `teacher1` | `teacher123` |
| Student | `student1` | `student123` |

> **Note:** After first login, it's recommended to change passwords for security.

---

## 📊 Database Schema

### Tables

1. **departments**
   - `dept_id` (PK)
   - `dept_name`, `location`

2. **teachers**
   - `t_id` (PK)
   - `t_name`, `faculty`, `salary`, `dept_id` (FK)

3. **students**
   - `s_id` (PK)
   - `s_name`, `cgpa`, `dept_id` (FK), `advisor_id` (FK → teachers)

4. **courses**
   - `course_id` (PK)
   - `course_name`, `course_code`, `credits`, `dept_id` (FK)

5. **books**
   - `book_id` (PK)
   - `book_name`, `author`, `publication_year`

6. **book_refs**
   - `ref_id` (PK)
   - `book_id` (FK), `course_id` (FK)

7. **users**
   - `user_id` (PK)
   - `username`, `password_hash`, `role`, `ref_id`

### Analytical Views

1. **students_per_department** - Count students by department
2. **teachers_per_faculty** - Count teachers by faculty
3. **high_salary_teachers** - Teachers earning > 50,000
4. **top_students** - Students with CGPA > 3.5
5. **books_per_course** - Count books referenced per course

---

## 🛠️ Key Features Implementation

### 1. Safe Delete Logic
Before deleting any record, the system checks for foreign key references:
- **Departments:** Check if any teachers/students/courses exist
- **Teachers:** Check if any students are advised by this teacher
- **Courses:** Check if any book references exist
- **Books:** Check if any course references exist

### 2. Server-Side Validation
- **Names:** Regex pattern for valid characters
- **Course Codes:** Format validation (e.g., CSE101)
- **CGPA:** Range check (0.00 - 4.00)
- **Salary:** Numeric validation with min/max limits
- **Email:** Valid email format (if implemented)

### 3. Authentication Flow
1. User submits login form
2. System validates credentials (username + SHA-256 hashed password)
3. Session created with `user_id`, `role`, and `ref_id`
4. Redirect based on role:
   - `admin` → Admin Dashboard
   - `teacher` → Teacher Dashboard
   - `student` → Student Dashboard
5. Each page checks authentication with `require_login($role)`

### 4. Role-Based Dashboards
- **Admin:** Full system overview with navigation to all CRUD modules
- **Teacher:** Personalized view of advised students and statistics
- **Student:** Personal profile, advisor info, and course catalog

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

### Issue: "Student data not found" on Student Dashboard
**Cause:** User's `ref_id` doesn't match actual student `s_id` in database.

**Fix:**
```sql
-- Check current mapping
SELECT * FROM users WHERE username = 'student1';
SELECT * FROM students;

-- Update ref_id to match an actual student
UPDATE users SET ref_id = [actual_student_id] WHERE username = 'student1';
```

### Issue: Database connection failed
**Check:**
1. XAMPP MySQL is running
2. Database `university_db` exists
3. Credentials in `src/db.php` are correct
4. Port 3306 is not blocked

### Issue: Pages show blank/white screen
**Check:**
1. PHP error reporting in `php.ini`
2. Check Apache error logs
3. Verify file permissions
4. Check for syntax errors in PHP files

---

## 🔄 Future Enhancements

- [ ] Password reset functionality
- [ ] Email notifications
- [ ] Student course enrollment system
- [ ] Grade management
- [ ] Attendance tracking
- [ ] Export reports to PDF/Excel
- [ ] Advanced search and filtering
- [ ] User profile picture uploads
- [ ] Multi-semester support
- [ ] RESTful API for mobile apps

---

## 👨‍💻 Developer

**Saif**  
GitHub: [@saif17313](https://github.com/saif17313)

---

## 📄 License

This project is created for educational purposes as part of database management coursework.  
Feel free to use and modify for learning purposes.

---

## 🙏 Acknowledgments

- Oracle Database Labs concepts
- XAMPP Development Environment
- PHP MySQLi Documentation
- GitHub Community

---

## 📞 Support

For issues, questions, or suggestions:
- Open an issue on [GitHub](https://github.com/saif17313/university-management-system/issues)
- Contact: [Your contact information]

---

**⭐ If you find this project helpful, please star the repository!**
