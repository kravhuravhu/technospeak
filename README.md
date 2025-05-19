<div align="center">
  <p>
    <a href="https://technospeak.com" target="_blank">
      <img src="public/images/default-no-logo.png" width="400" alt="Technospeak Logo">
    </a>
  </p>
</div>

<h2>About Technospeak</h2>

<p>Technospeak is an interactive tech education platform that empowers <strong>users to master digital tools, cybersecurity, and productivity</strong> through simple, engaging tutorials. Designed for students, entrepreneurs, and professionals, we bridge the gap between confusion and confidence in tech.</p>

<p>Our mission is to bridge the digital literacy gap with:</p>
<ul>
  <li><strong>Practical, bite-sized tutorials</strong> that solve real-world problems</li>
  <li><strong>Tiered learning paths</strong> for all skill levels</li>
  <li><strong>Personalized coaching</strong> for accelerated growth</li>
  <li><strong>Enterprise-ready training</strong> solutions</li>
</ul>

<h2>✨ Core Features</h2>

<h3>🎓 Learning Management System</h3>
<table>
  <tr>
    <th>Feature</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>Adaptive Learning</td>
    <td>AI-driven course recommendations</td>
  </tr>
  <tr>
    <td>Progress Tracking</td>
    <td>Visualize your learning journey</td>
  </tr>
  <tr>
    <td>Skill Assessments</td>
    <td>Validate your knowledge</td>
  </tr>
  <tr>
    <td>Certification</td>
    <td>Shareable course completions</td>
  </tr>
</table>

<h3>💼 Subscription Tiers</h3>
<pre><code class="language-php">$user->subscriptions()->create([
    'plan_id' => Plan::DIGITAL_PRODUCTIVITY,
    'price' => 30000, // in cents
    'interval' => 'yearly'
]);</code></pre>

  <h2>🗂️ Database Structure</h2>
  <p>This database is designed to power a complete e-learning e-commerce platform. It manages clients, subscriptions, courses, enrollments, payments, admin users, and more.</p>
  
  <div class="subsection">
    <h3>📋 Table Overview</h3>
    <table>
      <tr>
        <th>Table</th>
        <th>Purpose</th>
        <th>Key Columns</th>
      </tr>
      <tr>
        <td>course_categories</td>
        <td>Organizes courses into categories</td>
        <td>id (PK), name (unique)</td>
      </tr>
      <tr>
        <td>subscriptions_plan</td>
        <td>Defines subscription plans</td>
        <td>id (PK), name, description, price, duration_in_days</td>
      </tr>
      <tr>
        <td>courses</td>
        <td>Stores course details</td>
        <td>id (PK), title, description, price, category_id (FK), created_by_admin_id (FK)</td>
      </tr>
      <tr>
        <td>clients</td>
        <td>Stores client account data</td>
        <td>id (PK), full_name, email, password, subscription_id (FK), preferred_category_id (FK)</td>
      </tr>
      <tr>
        <td>admin_users</td>
        <td>Admin account management</td>
        <td>id (PK), username, email, password</td>
      </tr>
      <tr>
        <td>enrollments</td>
        <td>Links clients with courses</td>
        <td>id (PK), client_id (FK), course_id (FK), progress_percent</td>
      </tr>
      <tr>
        <td>payments</td>
        <td>Tracks financial transactions</td>
        <td>id (PK), client_id (FK), amount, payment_method, status, enrollment_id (FK), subscription_id (FK)</td>
      </tr>
      <tr>
        <td>refunds</td>
        <td>Handles refunds for payments</td>
        <td>id (PK), payment_id (FK), amount, reason</td>
      </tr>
      <tr>
        <td>certificates</td>
        <td>Issues certificates for completed courses</td>
        <td>id (PK), enrollment_id (FK), certificate_url</td>
      </tr>
      <tr>
        <td>comments</td>
        <td>Stores client reviews for courses</td>
        <td>id (PK), client_id (FK), course_id (FK), comment, rating</td>
      </tr>
    </table>
  </div>

  <div class="subsection">
    <h3>🔗 Key Relationships</h3>
    <ul>
      <li>Clients ↔ Subscriptions (many-to-one)</li>
      <li>Clients ↔ Course Categories (preferred category)</li>
      <li>Courses ↔ Course Categories (many-to-one)</li>
      <li>Admins ↔ Courses (created by)</li>
      <li>Clients ↔ Courses via Enrollments (many-to-many)</li>
      <li>Payments ↔ Enrollments/Subscriptions (linked by foreign keys)</li>
      <li>Enrollments ↔ Certificates (one-to-one)</li>
      <li>Courses ↔ Comments ← Clients (many-to-many with reviews)</li>
    </ul>
  </div>

  <div class="subsection">
    <h3>✅ Integrity & Constraints</h3>
    <ul>
      <li>All foreign keys are enforced</li>
      <li>Ratings are restricted from 1 to 5</li>
      <li>Unique constraints on emails, usernames, and category names</li>
      <li>Timestamp tracking for creation times</li>
    </ul>
  </div>
</div>

<h2>📊 Dashboard Components</h2>

<h3>🎯 Learning Hub</h3>
<ul>
  <li><strong>Active Courses</strong> - Track current enrollments with progress indicators</li>
  <li><strong>Recommended Content</strong> - AI-powered suggestions</li>
  <li><strong>Achievement Badges</strong> - Earn verifiable credentials</li>
  <li><strong>Learning Calendar</strong> - Schedule study sessions</li>
</ul>

<h3>🗃️ Resource Center</h3>
<ul>
  <li><strong>Cheat Sheets Library</strong>
    <ul>
      <li>Downloadable PDF guides</li>
      <li>Editable templates</li>
      <li>Version-controlled updates</li>
    </ul>
  </li>
  <li><strong>Project Templates</strong>
    <ul>
      <li>Ready-to-use starter kits</li>
      <li>Industry-specific boilerplates</li>
    </ul>
  </li>
  <li><strong>Code Snippets</strong>
    <ul>
      <li>Searchable repository</li>
    </ul>
  </li>
</ul>

<h3>⚙️ Admin Panel</h3>
<table>
  <tr>
    <th>Feature</th>
    <th>Description</th>
    <th>Access</th>
  </tr>
  <tr>
    <td>User Management</td>
    <td>CRUD user accounts</td>
    <td>Admin</td>
  </tr>
  <tr>
    <td>Content Moderation</td>
    <td>Approve/reject content</td>
    <td>Moderator+</td>
  </tr>
  <tr>
    <td>Analytics</td>
    <td>Engagement metrics</td>
    <td>Admin</td>
  </tr>
</table>

<h2>🔔 Notification Center</h2>
<ul>
    <li><strong>Learning Reminders</strong> - Course deadlines and events</li>
    <li><strong>System Alerts</strong> - Important platform updates</li>
    <li><strong>Community Interactions</strong> - Replies to your questions</li>
    <li><strong>Achievement Unlocks</strong> - Badge award notifications</li>
</ul>
 
<h2>🛠️ Quick Access Tools</h2>
<ul>
    <li><strong>Instant Search</strong> - Find any resource in 2 clicks</li>
    <li><strong>Progress Tracker</strong> - Visualize your learning journey</li>
    <li><strong>Help Widget</strong> - Context-sensitive assistance</li>
</ul>

<h2>🚀 Getting Started</h2>

<h3>Requirements</h3>
<ul>
  <li>PHP 8.2+</li>
  <li>MySQL 8.0+</li>
  <li>Composer 2.2+</li>
  <li>Node.js 18+</li>
</ul>

<h3>Installation</h3>
<pre><code class="language-bash"># Clone repo
git clone https://github.com/kravhuravhu/technospeak.git
cd technospeak

# Install dependencies
composer install
npm install

# Configure
cp .env.example .env
php artisan key:generate

# Migrate
php artisan migrate --seed</code></pre>

<h2>🛠️ Tech Stack</h2>
<ul>
  <li><strong>Backend</strong>: Laravel 10 + NodeJs</li>
  <li><strong>Frontend</strong>: Laravel 10</li>
  <li><strong>Database</strong>: MySQL</li>
  <li><strong>Auth</strong>: Laravel Sanctum</li>
</ul>

<h2>🛠️ Payment Gateway</h2>
<ul>
  <li><strong>Too be added</strong> soon</li>
</ul>

<h2>📜 License</h2>
<p><i>under</i><strong> Velisa Africa Academy</strong></p>

<div align="center">
  <p>"Empowering digital confidence"<br>
  📍 <i>Johannesburg, South Africa</li></p>
</div>