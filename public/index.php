<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Management System - Home</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 3rem 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .feature-card {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .feature-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }
    .feature-card h3 {
      color: #1e40af;
      margin-bottom: 0.75rem;
      font-size: 1.5rem;
    }
    .feature-card p {
      color: #4b5563;
      line-height: 1.6;
    }
    .stats {
      background: linear-gradient(135deg, #1e3a8a, #1e40af);
      padding: 3rem 2rem;
      text-align: center;
      color: white;
      margin: 2rem 0;
    }
    .stats h2 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .stat-item {
      background: rgba(255,255,255,0.1);
      padding: 2rem;
      border-radius: 0.75rem;
      backdrop-filter: blur(10px);
    }
    .stat-number {
      font-size: 3rem;
      font-weight: 700;
      display: block;
      margin-bottom: 0.5rem;
    }
    .cta-section {
      text-align: center;
      padding: 4rem 2rem;
      background: white;
    }
    .cta-section h2 {
      font-size: 2.5rem;
      color: #1e40af;
      margin-bottom: 1rem;
    }
    .cta-section p {
      font-size: 1.25rem;
      color: #4b5563;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>University Management System</h1>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#about">About</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="hero">
      <h2>Welcome to University Management System</h2>
      <p>Complete Solution for Managing Students, Teachers, Courses, Departments & More</p>
      <a href="login.php" class="btn">🚀 Get Started - Login Here</a>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
      <div class="feature-card">
        <div class="feature-icon">👨‍💼</div>
        <h3>Admin Panel</h3>
        <p>Complete CRUD operations for Departments, Teachers, Students, Courses & Books with advanced analytics</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon">👨‍🏫</div>
        <h3>Teacher Dashboard</h3>
        <p>View advised students, track their performance, and monitor average CGPA statistics</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon">👨‍🎓</div>
        <h3>Student Portal</h3>
        <p>Access personal profile, view academic advisor, browse department courses and more</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Analytics & Reports</h3>
        <p>5 SQL view-based reports with aggregations, joins, and data visualization</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3>Secure Authentication</h3>
        <p>Role-based access control with SHA-256 password hashing and session management</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon">✅</div>
        <h3>Data Validation</h3>
        <p>Server-side validation with regex patterns and referential integrity checks</p>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="stats" id="about">
      <h2>Built with Modern Technologies</h2>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-number">🎯</span>
          <p>Role-Based Access</p>
        </div>
        <div class="stat-item">
          <span class="stat-number">💾</span>
          <p>MySQL Database</p>
        </div>
        <div class="stat-item">
          <span class="stat-number">🔐</span>
          <p>Secure Sessions</p>
        </div>
        <div class="stat-item">
          <span class="stat-number">📱</span>
          <p>Responsive Design</p>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <h2>Ready to Get Started?</h2>
      <p>Login to access your personalized dashboard</p>
      <a href="login.php" class="btn" style="font-size: 1.1rem; padding: 1rem 2.5rem;">Login Now</a>
      
      <div style="margin-top: 3rem; padding: 2rem; background: #f9fafb; border-radius: 0.75rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        <h3 style="color: #1e40af; margin-bottom: 1rem;">Demo Credentials</h3>
        <div style="text-align: left; display: inline-block;">
          <p style="margin: 0.5rem 0;"><strong>Admin:</strong> admin / admin123</p>
          <p style="margin: 0.5rem 0;"><strong>Teacher:</strong> teacher1 / teacher123</p>
          <p style="margin: 0.5rem 0;"><strong>Student:</strong> student1 / student123</p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    University Management System - Database Systems Project
  </footer>
</body>
</html>
