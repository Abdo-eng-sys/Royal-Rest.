# Royal Rest. - Restaurant Website

A full-stack restaurant website built with **React JS** frontend and **PHP Laravel** API backend.

## Project Structure

```
restaurant-app/
├── frontend/          # React JS Application
│   ├── src/
│   │   ├── components/    # Reusable components
│   │   ├── pages/         # Page components
│   │   ├── context/       # React Context (Auth, Cart)
│   │   ├── hooks/         # Custom hooks
│   │   └── utils/         # API utilities
│   └── public/          # Static assets
│
└── backend/           # Laravel API
    ├── app/
    │   ├── Http/Controllers/Api/  # API Controllers
    │   └── Models/                # Eloquent Models
    ├── database/
    │   ├── migrations/            # Database migrations
    │   └── seeders/               # Database seeders
    └── routes/                    # API Routes
```

## Features

### Frontend (React)
- **Responsive Design** - Mobile-first, fully responsive layout
- **Modern UI** - Tailwind CSS with custom animations
- **Authentication** - Login/Register with JWT tokens
- **Menu System** - Browse dishes by category, search, filter
- **Shopping Cart** - Add items, update quantities, checkout
- **Reservations** - Table booking system
- **Dashboard** - User profile and reservation management
- **Animations** - Framer Motion page transitions

### Backend (Laravel)
- **RESTful API** - Clean API architecture
- **Authentication** - Laravel Sanctum token-based auth
- **Database** - MySQL with proper relationships
- **CRUD Operations** - Full CRUD for menu, reservations, orders
- **Validation** - Request validation with error handling
- **Seeding** - Demo data for categories and menu items

## Prerequisites

- **PHP** >= 8.1
- **Composer** (PHP package manager)
- **Node.js** >= 16
- **npm** or **yarn**
- **MySQL** or **MariaDB**
- **VS Code** with Database Client extension

## Setup Instructions

### 1. Backend Setup (Laravel)

```bash
cd backend

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file:
# DB_DATABASE=savory_haven
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed demo data
php artisan db:seed

# Start Laravel server
php artisan serve
```

The API will be available at: `http://localhost:8000`

### 2. Frontend Setup (React)

```bash
cd frontend

# Install dependencies
npm install

# Start development server
npm start
```

The frontend will be available at: `http://localhost:3000`

### 3. VS Code Database Client Setup

1. Install the **"Database Client"** extension in VS Code
2. Click the database icon in the sidebar
3. Add a new MySQL connection:
   - **Host**: localhost
   - **Port**: 3306
   - **Username**: root
   - **Password**: your_password
   - **Database**: savory_haven
4. Click "Connect" to view and manage your database tables

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login
- `POST /api/logout` - User logout (auth required)
- `GET /api/user` - Get current user (auth required)

### Categories
- `GET /api/categories` - List all categories
- `GET /api/categories/{id}` - Get category details

### Menu Items
- `GET /api/menu-items` - List all menu items (with filters)
- `GET /api/menu-items/featured` - Get featured items
- `GET /api/menu-items/{id}` - Get item details

### Reservations (Auth Required)
- `GET /api/reservations` - List user reservations
- `POST /api/reservations` - Create reservation
- `GET /api/reservations/{id}` - Get reservation
- `PUT /api/reservations/{id}` - Update reservation
- `DELETE /api/reservations/{id}` - Cancel reservation

### Orders (Auth Required)
- `GET /api/orders` - List user orders
- `POST /api/orders` - Create order
- `GET /api/orders/{id}` - Get order details

## Pages

| Page | Route | Description |
|------|-------|-------------|
| Home | `/` | Landing page with hero, features, popular dishes |
| Menu | `/menu` | Full menu with search, filters, categories |
| Reservations | `/reservations` | Table booking form |
| Cart | `/cart` | Shopping cart with checkout |
| Login | `/login` | User login |
| Register | `/register` | User registration |
| Dashboard | `/dashboard` | User profile & reservations |
| About | `/about` | Restaurant story & team |
| Contact | `/contact` | Contact form & info |

## Technologies Used

### Frontend
- React 18
- React Router DOM
- Tailwind CSS
- Framer Motion
- React Icons
- Axios
- React Hot Toast

### Backend
- Laravel 10
- Laravel Sanctum (Authentication)
- MySQL Database
- Eloquent ORM
- RESTful API

## License

MIT License - feel free to use for personal or commercial projects.
