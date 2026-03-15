# Foodie Point - Digital Menu Board

A lightweight, "dead-simple" digital menu solution designed for small restaurants. This application solves the problem of updating daily physical chalkboards by allowing owners to manage menu items from their phone and letting customers view them instantly via a QR code.

## 📖 Overview

-   **For the Owner**: A mobile-friendly admin interface to add, edit, and toggle menu items (Name, Price, Meal Period) in seconds.
-   **For the Customer**: A read-only view of today's menu item accessed by scanning a QR code. No login, app download, or complex ordering flow required.

## ✨ Features

-   **Daily Menu Management**: Organize items by date and meal period (Breakfast, Lunch, Dinner).
-   **Instant Updates**: Changes made by the owner appear immediately for customers.
-   **Quick Availability Toggle**: Mark items as "Sold Out" with a single tap during service without deleting them.
-   **Copy Previous Menus**: "Copy from Date" feature to quickly replicate a past menu (e.g., "Same as last Friday").
-   **QR Code Generation**: Built-in tool to generate and download the static QR code for restaurant tables.
-   **Duplicate Prevention**: Smart validation prevents accidental double-entry of menu items.

## 🛠️ Tech Stack

-   **Framework**: Laravel
-   **Frontend**: Blade Templates (Server-side rendered for speed and simplicity)
-   **Database**: MySQL

## 🚀 Installation & Configuration

### Prerequisites
-   PHP >= 8.1
-   Composer

### Steps

Follow these steps to set up the project locally.

```bash
# 1. Clone the repository 
git clone <repository-url>
cd Foodie-Point

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
# Edit .env — set OWNER_NAME, OWNER_EMAIL, OWNER_PASSWORD, RESTAURANT_NAME, APP_URL

# 4. Generate app key
php artisan key:generate

# 5. Run migrations and seed
php artisan migrate --seed

# 6. Serve
php artisan serve
```

**Owner login:** Visit `/admin` and sign in with the credentials you set in `.env`.

**Print the QR code:** Go to `/admin/qr`, download the SVG, print at 3×3 inches, laminate, place on each table. Never reprint it — the URL is permanent.

## Owner password reset (if forgotten)

```bash
php artisan owner:reset-password
```