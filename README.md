<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technospeak - Simplifying Technology</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 40px;
        }
        .badges {
            margin: 20px 0;
        }
        section {
            margin-bottom: 30px;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
        h3 {
            color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        code {
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 4px;
            font-family: monospace;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <header>
        <a href="https://technospeak.com" target="_blank">
            <img src="public/images/default-no-logo.png" width="400" alt="Technospeak Logo">
        </a>
        <div class="badges">
            <a href="https://github.com/technospeak/technospeak/actions/workflows/tests.yml">
                <img src="https://github.com/technospeak/technospeak/actions/workflows/tests.yml/badge.svg" alt="Build Status">
            </a>
            <a href="https://packagist.org/packages/technospeak/core">
                <img src="https://img.shields.io/packagist/dt/technospeak/core" alt="Total Downloads">
            </a>
            <a href="https://github.com/technospeak/technospeak/releases">
                <img src="https://img.shields.io/github/v/release/technospeak/technospeak" alt="Latest Release">
            </a>
            <a href="https://opensource.org/licenses/MIT">
                <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License">
            </a>
        </div>
    </header>

    <section id="about">
        <h2>About Technospeak</h2>
        <p>Technospeak is an interactive tech education platform that empowers <strong>users to master digital tools, cybersecurity, and productivity</strong> through simple, engaging tutorials. Designed for students, entrepreneurs, and professionals, we bridge the gap between confusion and confidence in tech.</p>
        
        <p>Our mission is to bridge the digital literacy gap with:</p>
        <ul>
            <li><strong>Practical, bite-sized tutorials</strong> that solve real-world problems</li>
            <li><strong>Tiered learning paths</strong> for all skill levels</li>
            <li><strong>Personalized coaching</strong> for accelerated growth</li>
            <li><strong>Enterprise-ready training</strong> solutions</li>
        </ul>
    </section>

    <section id="features">
        <h2>✨ Core Features</h2>
        
        <article class="feature">
            <h3>🎓 Learning Management System</h3>
            <table>
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </article>

        <article class="feature">
            <h3>💼 Subscription Tiers</h3>
            <pre><code class="language-php">$user->subscriptions()->create([
    'plan_id' => Plan::DIGITAL_PRODUCTIVITY,
    'price' => 30000, // in cents
    'interval' => 'yearly'
]);</code></pre>
        </article>
    </section>

    <section id="dashboard">
        <h2>📊 Dashboard Components</h2>
        
        <article class="component">
            <h3>🎯 Learning Hub</h3>
            <ul>
                <li><strong>Active Courses</strong> - Track current enrollments with progress indicators</li>
                <li><strong>Recommended Content</strong> - AI-powered suggestions</li>
                <li><strong>Achievement Badges</strong> - Earn verifiable credentials</li>
                <li><strong>Learning Calendar</strong> - Schedule study sessions</li>
            </ul>
        </article>

        <article class="component">
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
                        <li>Multi-language support</li>
                    </ul>
                </li>
            </ul>
        </article>

        <article class="component">
            <h3>⚙️ Admin Panel</h3>
            <table>
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Description</th>
                        <th>Access</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </article>
    </section>

    <section id="getting-started">
        <h2>🚀 Getting Started</h2>
        
        <article class="requirements">
            <h3>Requirements</h3>
            <ul>
                <li>PHP 8.2+</li>
                <li>MySQL 8.0+</li>
                <li>Composer 2.2+</li>
                <li>Node.js 18+</li>
            </ul>
        </article>

        <article class="installation">
            <h3>Installation</h3>
            <pre><code class="language-bash"># Clone repo
git clone https://github.com/technospeak/technospeak.git
cd technospeak

# Install dependencies
composer install
npm install

# Configure
cp .env.example .env
php artisan key:generate

# Migrate
php artisan migrate --seed</code></pre>
        </article>
    </section>

    <section id="tech-stack">
        <h2>🛠️ Tech Stack</h2>
        <ul>
            <li><strong>Backend</strong>: Laravel 10</li>
            <li><strong>Frontend</strong>: Vue 3 + Inertia.js</li>
            <li><strong>Database</strong>: MySQL</li>
            <li><strong>Auth</strong>: Laravel Sanctum</li>
        </ul>
    </section>

    <footer>
        <p>📜 MIT License</p>
        <p>"Empowering digital confidence"<br>📍 Johannesburg, South Africa</p>
    </footer>
</body>
</html>