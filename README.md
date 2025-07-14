# Task Management System

A comprehensive task management system built with Laravel (PHP) backend and Vue.js frontend, featuring role-based access control, email notifications, and real-time task updates.

## 🚀 Features

### Administrator Features
- ✅ User management (Create, Read, Update, Delete)
- ✅ Task assignment with deadlines
- ✅ Complete task oversight and management
- ✅ Role-based access control

### User Features
- ✅ View assigned tasks
- ✅ Update task status (Pending → In Progress → Completed)
- ✅ Dashboard with task statistics
- ✅ Email notifications for new task assignments

### Technical Features
- ✅ RESTful API with Laravel
- ✅ SPA frontend with Vue.js
- ✅ Authentication with Laravel Sanctum
- ✅ MySQL database with proper relationships
- ✅ Responsive design with Tailwind CSS
- ✅ Email notification system

## 🛠️ Tech Stack

**Backend:**
- PHP 8.1+
- Laravel 10.x
- Laravel Sanctum (API Authentication)
- MySQL 8.0+

**Frontend:**
- Vue.js 3.x
- Vue Router 4.x
- Axios (HTTP Client)
- Tailwind CSS

**Development Tools:**
- Vite (Build tool)
- Composer (PHP Package Manager)
- NPM (Node Package Manager)

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
- PHP 8.1+ with extensions: mbstring, xml, ctype, json, bcmath, pdo_mysql
- Composer
- Node.js 16+ and NPM
- MySQL 8.0+ or MariaDB
- Git

## 🚀 Installation

### 1. Clone the Repository
\`\`\`bash
git clone https://github.com/YOUR_USERNAME/task-management-system.git
cd task-management-system
\`\`\`

### 2. Backend Setup (Laravel)
\`\`\`bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env file
# Then run migrations and seeders
php artisan migrate
php artisan db:seed

# Install Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
\`\`\`

### 3. Frontend Setup (Vue.js)
\`\`\`bash
# Install Node.js dependencies
npm install

# Build assets for development
npm run dev
\`\`\`

### 4. Run the Application
\`\`\`bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev
\`\`\`

### 5. Access the Application
- **Application:** http://localhost:8000
- **API Documentation:** http://localhost:8000/api

## 👥 Demo Accounts

- **Administrator:** admin@example.com / password
- **Regular User:** user@example.com / password

## 📚 API Documentation

### Authentication Endpoints
- `POST /api/login` - User authentication
- `POST /api/logout` - User logout
- `GET /api/me` - Get current user info

### User Management (Admin Only)
- `GET /api/users` - List all users
- `POST /api/users` - Create new user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

### Task Management
- `GET /api/tasks` - List tasks (filtered by user role)
- `POST /api/tasks` - Create task (Admin only)
- `PUT /api/tasks/{id}` - Update task
- `DELETE /api/tasks/{id}` - Delete task (Admin only)
- `PATCH /api/tasks/{id}/status` - Update task status

## 🗂️ Project Structure

\`\`\`
task-management-system/
├── app/                     # Laravel application
│   ├── Http/Controllers/Api/ # API controllers
│   ├── Models/              # Eloquent models
│   ├── Notifications/       # Email notifications
│   └── Http/Middleware/     # Custom middleware
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── js/                 # Vue.js application
│   │   ├── components/     # Vue components
│   │   └── app.js         # Main Vue app
│   └── css/               # Stylesheets
├── routes/api.php          # API routes
└── public/                # Web server document root
\`\`\`

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🐛 Bug Reports & Feature Requests

Please use the [GitHub Issues](https://github.com/YOUR_USERNAME/task-management-system/issues) page to report bugs or request features.

## 📞 Support

If you have any questions or need help with setup, please [open an issue](https://github.com/YOUR_USERNAME/task-management-system/issues/new) or contact the maintainers.

## 🙏 Acknowledgments

- Laravel Framework
- Vue.js Framework
- Tailwind CSS
- All contributors and testers
