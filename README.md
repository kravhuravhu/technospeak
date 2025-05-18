<p align="center"><a href="https://technospeak.com" target="_blank"><img src="public/images/white-no-logo.png" width="400" alt="Technospeak Logo"></a></p>

<p align="center">
<a href="https://github.com/technospeak/technospeak/actions/workflows/tests.yml"><img src="https://github.com/technospeak/technospeak/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/technospeak/core"><img src="https://img.shields.io/packagist/dt/technospeak/core" alt="Total Downloads"></a>
<a href="https://github.com/technospeak/technospeak/releases"><img src="https://img.shields.io/github/v/release/technospeak/technospeak" alt="Latest Release"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License"></a>
</p>

## About Technospeak

Technospeak is an interactive tech education platform that empowers **users to master digital tools, cybersecurity, and productivity** through simple, engaging tutorials. Designed for students, entrepreneurs, and professionals, we bridge the gap between confusion and confidence in tech. Our mission is to bridge the digital literacy gap with:

- **Practical, bite-sized tutorials** that solve real-world problems
- **Tiered learning paths** for all skill levels
- **Personalized coaching** for accelerated growth
- **Enterprise-ready training** solutions

## ✨ Core Features

### 🎓 Learning Management System
| Feature | Description |
|---------|-------------|
| Adaptive Learning | AI-driven course recommendations |
| Progress Tracking | Visualize your learning journey |
| Skill Assessments | Validate your knowledge |
| Certification | Shareable course completions |

### 💼 Subscription Tiers
```php
// Example subscription logic
$user->subscriptions()->create([
    'plan_id' => Plan::DIGITAL_PRODUCTIVITY,
    'price' => 30000, // in cents
    'interval' => 'yearly'
]);
📊 Dashboard Components
Learning Hub

Active courses

Recommended content

Achievement badges

Resource Center

Downloadable cheat sheets

Project templates

Code snippets

Admin Panel

User management

Content moderation

Analytics dashboard

🚀 Getting Started
System Requirements
PHP 8.2+

MySQL 8.0+ / PostgreSQL 13+

Redis 6.2+

Node.js 18+

Installation
bash
# Clone repository
git clone https://github.com/kravhuravhu/technospeak.git
cd technospeak

# Install dependencies
composer install --optimize-autoloader
npm ci && npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Start queue worker (in separate terminal)
php artisan queue:work
Development
bash
# Hot-reload frontend assets
npm run dev

# Run tests
php artisan test

# Generate API docs
php artisan scribe:generate
🛠️ Technical Architecture
Backend Structure
app/
├── Console/
├── Events/           
├── Http/             
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/    
├── Policies/      
└── Services/ 
Frontend Components
Learning Portal: Vue 3 Composition API

Admin Dashboard: Inertia.js

Interactive Tutorials: Livewire 3

API Endpoints
Endpoint	Method	Description
/api/courses	GET	List available courses
/api/progress	POST	Update user progress
/api/checkout	POST	Initiate subscription
📈 Performance Metrics
⚡ Page load: <500ms (cached)

📜 License
Technospeak is open-source software licensed under the Velisa Africa Academy license.

<p align="center"> "Empowering digital confidence through simplified learning"<br> 📍 Johannesburg, South Africa </p>