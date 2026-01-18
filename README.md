# Apex Platform - Inventory Management System

A comprehensive inventory and stock management system built with Laravel 12, featuring Point of Sale (POS), product management, purchase tracking, and sales analytics.

## 🚀 Features

### Core Modules

- **Point of Sale (POS)**
  - Real-time product search and cart management
  - Barcode scanning support
  - Multiple payment methods (Cash, Card, Mobile Money)
  - Tax calculation and discount management
  - Customer selection and transaction history
  - Modern, intuitive POS interface

- **Product Management**
  - Categories, Brands, and Product Models
  - Full product catalog with images
  - SKU and barcode management
  - Stock tracking with reorder levels
  - Product specifications (dynamic key-value pairs)
  - Cost and selling price management

- **Inventory Management**
  - Real-time stock tracking
  - Low stock alerts
  - Stock adjustments through purchases and sales
  - Product availability monitoring

- **Purchase Management**
  - Supplier management
  - Purchase orders and invoices
  - Purchase items tracking
  - Automatic stock updates on purchase

- **Sales Management**
  - Complete sales history
  - Customer management
  - Sales reports and analytics
  - Payment method tracking
  - Transaction details

- **User & Security**
  - User management with roles and permissions (Spatie)
  - Security monitoring and logging
  - IP blocking capabilities
  - Activity tracking

- **Settings**
  - Tax rate configuration
  - Application-wide settings management

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Tailwind CSS 4.x, Alpine.js (via Livewire)
- **Authentication**: Laravel Jetstream (Sanctum)
- **Permissions**: Spatie Laravel Permission
- **Real-time**: Livewire 3.x
- **Build Tool**: Vite
- **PHP**: 8.2+

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and NPM
- MySQL/PostgreSQL/SQLite
- Web server (Apache/Nginx) or PHP built-in server

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd apex-platform
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=apex_platform
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   # Or for development:
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

   Or use the provided dev script:
   ```bash
   composer run dev
   ```

## 📦 Database Setup

The application includes seeders for:
- Default categories
- Sample brands
- Product models
- Sample products
- Suppliers and customers
- Initial tax settings (default: 0%)

## 🔐 Default Credentials

After running migrations and seeders, you'll need to create your first user. Use Laravel's registration page or create one via tinker:

```bash
php artisan tinker
```

Then create a user:
```php
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
```

## 📁 Project Structure

```
apex-platform/
├── app/
│   ├── Http/Controllers/Admin/
│   │   ├── POSController.php          # Point of Sale
│   │   ├── ProductController.php      # Products management
│   │   ├── SaleController.php         # Sales tracking
│   │   ├── PurchaseController.php     # Purchases management
│   │   └── ...
│   └── Models/
│       ├── Product.php
│       ├── Sale.php
│       ├── Purchase.php
│       └── ...
├── database/
│   ├── migrations/                    # Database migrations
│   └── seeders/                       # Database seeders
├── resources/
│   └── views/
│       └── backend/
│           ├── pos/                   # POS views
│           ├── products/              # Product views
│           ├── sales/                 # Sales views
│           └── ...
└── routes/
    └── web.php                        # Application routes
```

## 🎯 Key Features in Detail

### Point of Sale (POS)
- Search products by name, SKU, or barcode
- Add items to cart with quantity control
- Apply discounts and calculate tax automatically
- Select payment method (Cash, Card, Mobile Money)
- Assign sales to customers (optional)
- Real-time stock updates
- Print receipts capability (ready for integration)

### Product Management
- Multi-level categorization
- Brand and model associations
- Image uploads with preview
- Dynamic specifications field
- Stock level monitoring
- Cost and selling price tracking
- Barcode and SKU generation

### Inventory Tracking
- Automatic stock deduction on sales
- Automatic stock addition on purchases
- Low stock alerts
- Out of stock indicators
- Reorder level management

## 🔒 Security Features

- Laravel Sanctum authentication
- Role-based access control (RBAC)
- Security monitoring middleware
- IP blocking capabilities
- Activity logging
- CSRF protection

## 📊 Available Commands

```bash
# Development
composer run dev              # Start dev server with queue and vite
php artisan serve             # Start Laravel dev server
npm run dev                   # Start Vite dev server

# Database
php artisan migrate           # Run migrations
php artisan migrate:fresh     # Fresh migration with seeders
php artisan db:seed           # Run seeders

# Optimization
php artisan config:cache      # Cache configuration
php artisan route:cache       # Cache routes
php artisan view:cache        # Cache views

# Testing
composer run test             # Run tests
php artisan test              # Run Pest tests
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Development

### Code Style
This project uses Laravel Pint for code formatting:
```bash
./vendor/bin/pint
```

### Testing
Tests are written using Pest:
```bash
php artisan test
```

## 🐛 Troubleshooting

### Common Issues

1. **Assets not loading**
   ```bash
   npm run build
   php artisan view:clear
   ```

2. **Permission errors**
   ```bash
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache
   ```

3. **Cache issues**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

## 📧 Support

For issues, questions, or contributions, please open an issue on the repository.

---

Built with ❤️ using Laravel 12
