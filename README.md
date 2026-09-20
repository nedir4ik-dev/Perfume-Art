# Perfume-Art Collection Online Shop

A modern Laravel-based e-commerce platform for selling perfume and cosmetic products online. This project allows customers to browse products, add items to a cart, complete orders, and receive confirmations by email and Telegram. It also includes an admin area for managing orders and stock.

## Overview

This application is designed for online retail operations and focuses on a simple shopping flow:

- Customers browse the catalog
- They add products to the shopping cart
- They place an order using a checkout form
- The system sends an order notification to the admin
- The customer receives a confirmation email
- Admin can update order status and reduce inventory automatically

## How the project works

### Customer flow

1. A user opens the website and views available products.
2. They add products to the cart.
3. They update quantities or remove items if needed.
4. They proceed to checkout.
5. They enter required customer details.
6. The order is submitted and saved in the database.
7. The system sends:
   - a Telegram message to the admin
   - an email to the customer
8. The order appears in the admin panel for review and status updates.

### Admin flow

1. The admin logs in to the admin panel.
2. They view all incoming orders.
3. They can change the order status, such as:
   - Pending
   - Confirmed
4. Once the order is confirmed, the product quantity is reduced from stock automatically.
5. The admin can manage orders effectively without manual stock tracking.

## Main features

- Shopping cart system
  - add products
  - update quantity
  - remove items
- Checkout process
  - customer details form
  - order creation
- Telegram integration
  - automatic notifications when a new order arrives
- Email notifications
  - confirmation email after order submission
- Admin panel
  - view orders
  - update status
- Inventory management
  - automatic stock reduction after confirmation
- Multi-language support
  - English
  - Russian
  - Turkmen

## Tech stack

- Backend: Laravel 10.x
- Frontend: Blade templates, Bootstrap 5, JavaScript
- Database: MySQL
- Notifications:
  - Telegram Bot API
  - Laravel Mail

## Project structure

This project follows the standard Laravel structure:

- app/ — application logic
- routes/ — web routes
- resources/views/ — Blade templates
- database/migrations/ — database schema
- public/ — public assets
- .env — environment configuration

## How users can use this project

### For customers

1. Open the app in the browser.
2. Browse perfume products.
3. Select a product and add it to cart.
4. Review the cart and adjust quantities.
5. Go to checkout.
6. Fill in the required form fields.
7. Submit the order.
8. Wait for confirmation via email and/or Telegram notification.

### For administrators

1. Access the admin panel.
2. Review all customer orders.
3. Check order details and customer information.
4. Change order status.
5. Confirm the order to reduce stock automatically.
6. Manage sales and order workflow efficiently.

## Installation

Follow the steps below to run the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/username/perfume-art.git
cd perfume-art
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
npm run dev
```

### 4. Configure environment variables

Copy the example environment file:

```bash
cp .env.example .env
```

Then update the following values in `.env`:

- database connection
- mail configuration
- Telegram bot token
- app URL

Example configuration should include:

```env
APP_NAME=PerfumeArt
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perfume_art
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Perfume Art"

TELEGRAM_BOT_TOKEN=your_bot_token
```

### 5. Run database migrations and seed data

```bash
php artisan migrate --seed
```

### 6. Start the application

```bash
php artisan serve
```

Then open:

```bash
http://localhost:8000
```

## Environment requirements

Before starting the project, make sure your system has:

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL database
- Laravel 10.x compatible environment

## Notes for production

For a live deployment, make sure to:

- set `APP_ENV=production`
- disable debug mode
- configure secure mail credentials
- use a valid Telegram bot token
- set correct database credentials
- configure a trusted domain and HTTPS

## License

This project is open-source and distributed under the MIT License.

---

Developed with ❤️ by Nedir# perfume-art
