#!/bin/bash

echo "========================================"
echo "  Savory Haven - Setup Script"
echo "========================================"
echo ""

# Check prerequisites
echo "Checking prerequisites..."

if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1+"
    exit 1
fi

if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer"
    exit 1
fi

if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 16+"
    exit 1
fi

if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install npm"
    exit 1
fi

echo "✅ All prerequisites found!"
echo ""

# Setup Backend
echo "========================================"
echo "  Setting up Backend (Laravel)"
echo "========================================"
echo ""

cd backend

echo "Installing PHP dependencies..."
composer install --no-interaction

echo "Creating .env file..."
cp .env.example .env

echo "Generating application key..."
php artisan key:generate

echo ""
echo "⚠️  Please update your database credentials in backend/.env"
echo "   DB_DATABASE=savory_haven"
echo "   DB_USERNAME=root"
echo "   DB_PASSWORD=your_password"
echo ""
read -p "Press Enter after updating .env file..."

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo ""
echo "✅ Backend setup complete!"
echo ""

# Setup Frontend
echo "========================================"
echo "  Setting up Frontend (React)"
echo "========================================"
echo ""

cd ../frontend

echo "Installing Node dependencies..."
npm install

echo ""
echo "✅ Frontend setup complete!"
echo ""

cd ..

# Instructions
echo "========================================"
echo "  Setup Complete!"
echo "========================================"
echo ""
echo "To start the application:"
echo ""
echo "1. Start the Backend:"
echo "   cd backend"
echo "   php artisan serve"
echo "   (API will run on http://localhost:8000)"
echo ""
echo "2. Start the Frontend (in a new terminal):"
echo "   cd frontend"
echo "   npm start"
echo "   (App will run on http://localhost:3000)"
echo ""
echo "3. VS Code Database Client:"
echo "   - Install 'Database Client' extension"
echo "   - Connection settings are in .vscode/settings.json"
echo ""
echo "Enjoy your restaurant website! 🍽️"
