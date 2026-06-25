# Facturo 🧾

A modern invoicing and inventory management web application built with **Laravel 13**, **Tailwind CSS 4**, and **Alpine.js**. Designed for small to medium-sized businesses to manage clients, products, stock movements, and PDF invoices — all from a clean, fast interface.

---

## ✨ Features

### 📋 Dashboard
- Real-time overview of key business metrics
- Total invoices, clients, and revenue at a glance
- Low stock alerts with quick navigation

### 👥 Client Management
- Create, edit, and delete clients
- Store name, phone, and address information
- View invoice history per client
- Search clients by name or phone (AJAX-powered)
- Prevent deletion of clients with existing invoices

### 📦 Product & Inventory Management
- Create products with category, name, size, price, and image
- Track stock quantity with a configurable minimum stock threshold
- Manual stock adjustments (add stock entries with reason)
- Visual stock status indicators: `In Stock`, `Low Stock`, `Out of Stock`
- Product images stored and served securely

### 🧾 Invoice Management
- Create invoices linked to a specific client
- Add multiple products (line items) per invoice with automatic subtotal calculation
- Automatic stock deduction on invoice creation
- Stock restoration on invoice deletion
- View invoice details with full line-item breakdown
- Paginated invoice listing (10 per page)

### 📄 PDF Export
- Download any invoice as a professionally formatted PDF
- Powered by `barryvdh/laravel-dompdf`

### 📊 Stock Movements
- Automatic tracking of every stock change (sales & manual entries)
- Movement history with type (`sortie` / `entrée`), quantity, and reason
- Linked to the triggering invoice for traceability

### 🔐 Authentication
- Secure login / registration system powered by **Laravel Breeze**
- All routes are protected behind authentication middleware

---

## 🛠️ Tech Stack

| Layer        | Technology                          |
|--------------|--------------------------------------|
| Backend      | PHP 8.3, Laravel 13                 |
| Frontend     | Blade Templates, Tailwind CSS 4, Alpine.js |
| Build Tool   | Vite 8                              |
| Database     | MySQL                               |
| PDF Engine   | barryvdh/laravel-dompdf             |
| Auth         | Laravel Breeze                      |
| HTTP Client  | Axios                               |
| Navigation   | Hotwire Turbo                       |

---

## 📁 Project Structure

```
facturo/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── ClientController.php
│   │   ├── ProductController.php
│   │   ├── InvoiceController.php
│   ├── Models/
│   │   ├── Client.php
│   │   ├── Product.php
│   │   ├── Invoice.php
│   │   ├── InvoiceItem.php
│   │   ├── StockMovement.php
│   │   └── User.php
├── resources/views/
│   ├── dashboard.blade.php
│   ├── clients/
│   ├── products/
│   ├── invoices/
│   ├── stock/
│   └── layouts/
├── database/migrations/
├── routes/
│   └── web.php
└── public/
```

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.3
- Composer
- Node.js >= 18 & npm
- MySQL

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/mohamed-elhamdaoui/facturo.git
cd facturo
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install Node dependencies**
```bash
npm install
```

**4. Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Set up your database** in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=facturo
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**6. Run migrations**
```bash
php artisan migrate
```

**7. Create storage symlink** (for product images)
```bash
php artisan storage:link
```

**8. Build frontend assets**
```bash
npm run build
```

**9. Start the development server**
```bash
composer run dev
```

> This command starts Laravel, Queue, Log watcher, and Vite concurrently.

The application will be available at: **http://localhost:8000**

---

## ⚡ Quick Setup (One Command)

```bash
composer run setup
```

This will automatically: install dependencies, generate app key, run migrations, and build frontend assets.

---

## 🌐 Deployment (DockHosting CLI)

This project is configured for deployment via **DockHosting** using the `dock` CLI.

```bash
# Install the CLI
npm install -g dockhosting-cli

# Login to your account
dock login

# Deploy from local directory
dock deploy
```

The project configuration is stored in [`.dock/dock.json`](.dock/dock.json).

---

## 🗺️ Routes Overview

| Method | URI | Action |
|--------|-----|--------|
| GET | `/` | Dashboard |
| GET/POST | `/clients` | List / Create clients |
| GET | `/clients/search` | AJAX client search |
| GET/PUT/DELETE | `/clients/{id}` | View / Edit / Delete client |
| GET/POST | `/products` | List / Create products |
| GET/PUT/DELETE | `/products/{id}` | View / Edit / Delete product |
| POST | `/products/{id}/add-stock` | Add stock manually |
| GET/POST | `/invoices` | List / Create invoices |
| GET | `/invoices/{id}` | View invoice |
| DELETE | `/invoices/{id}` | Delete invoice (restores stock) |
| GET | `/invoices/{id}/download` | Download invoice as PDF |

---

## 📸 Screenshots

> _Coming soon_

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 👤 Author

**Mohamed El Hamdaoui**
- GitHub: [@mohamed-elhamdaoui](https://github.com/mohamed-elhamdaoui)
- Email: mhamdaouiyy@gmail.com
