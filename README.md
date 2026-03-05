# 📱 NFC Invoice Claiming System

A modern Laravel-based backend for managing digital invoices and claiming them via NFC tags. This project streamlines the POS (Point of Sale) to Customer transition by digitizing physical receipts.

---

## 🚀 Key Features

- **POS Integration**: Specialized API endpoints for POS systems to push invoices.
- **NFC Tag Management**: Link unique NFC tags to specific invoices for quick claiming.
- **Smart Claiming**: Customers can claim invoices to their accounts with a single scan.
- **Full ERD Compliance**: Database architecture includes Stores, Branches, Products, and detailed Invoice Items.
- **Eager Loading**: Optimized database queries for high performance.

---

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL (XAMPP Compatible)
- **Authentication**: Laravel Sanctum
- **Roles/Permissions**: Spatie Laravel-Permission
- **ID Strategy**: UUIDs for secure public-facing identifiers.

---

## 📊 Database Architecture (ERD)

The project follows a robust Entity-Relationship Diagram:
- **Stores**: Global store entities.
- **Branches**: Multiple locations per store.
- **Products**: Catalog of items available per store.
- **Invoices**: Digital records of transactions.
- **Invoice Items**: Detailed breakdown of products, quantities, and prices.
- **NFC Tags**: Physical identifiers mapped to invoices.

---

## ⚙️ Installation & Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd NFC_Project
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Update your `.env` with your XAMPP/MySQL socket and credentials.*

4. **Initialize Database**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start the API Server**
   ```bash
   php artisan serve
   ```

---

## 📡 API Endpoints

### **POS Flow**
- `POST /api/invoices`: Create a new invoice with multiple items.

### **NFC Flow**
- `POST /api/nfc/claim`: Claim an invoice using its UUID.

### **Customer Flow**
- `GET /api/my-invoices`: Retrieve all invoices claimed by the authenticated user.
- `GET /api/invoices/{uuid}`: Get detailed view of a specific invoice with its products.

---

## 🧪 Testing

You can use the built-in seeder to populate the database with test data:
```bash
php artisan db:seed
```
This will create a test store, branch, products, and a sample invoice linked to a test user (`test@example.com`).

---

## 📄 License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
