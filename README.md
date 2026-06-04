# PHP Exercises

This is a collection of **PHP exercises** and a **complete e-commerce catalog**, organized by complexity and sections.

## Contents

### Exercises

17 different PHP tasks covering basic and advanced concepts:

1. **Numbers - Even and Odd** - Loops and conditions
2. **Square with For Loops** - Nested loops
3. **Random Numbers** - Arrays
4. **Div with Colors** - HTML/CSS integration
5. **Array with Session** - PHP $_SESSION
6. **Fruit Class** - Basic classes
7. **Registration Form** - Forms and design
8. **Photo Gallery** - Upload and management
9. **Database Writing** - PDO and database
10. **Count Occurrences** - SQL analysis
11. **Product Catalog** - E-commerce system
12. **Admin Panel** - CRUD operations
13. **Responsive Grid** - Bootstrap Grid + Responsive design
14. **Bootstrap Page** - Navbar, Carousel, and Cards demo
15. **Regex Form** - Well-designed form with two fields and regex validation
16. **PHPMailer** - Email sending via SMTP
17. **Calculator** - Expression input and file writing

### Catalog

Complete e-commerce system with:
- Product management
- Category management
- Shopping cart
- User registration and login
- Admin panel

## Getting Started

### Option 1: Docker Compose (Recommended)

#### Requirements

- Docker Desktop (includes Docker and Docker Compose)
  - Windows: [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop)
  - Mac: [Docker Desktop for Mac](https://www.docker.com/products/docker-desktop)
  - Linux: [Docker Engine + Docker Compose](https://docs.docker.com/engine/install/)

#### Installation and Startup

1. **Clone the repository**
```bash
git clone https://github.com/DarinDim/PHP-exercises.git
cd PHP-exercises
```

2. **Start the containers**
```bash
docker compose up -d
```

3. **Wait for services to be ready** (usually 15-20 seconds)
```bash
docker compose ps
```

4. **Access the application**
   - Main page: http://localhost:8080
   - Exercises: http://localhost:8080/exercises/
   - Catalog: http://localhost:8080/catalog/
   - phpMyAdmin (database): http://localhost:8081

#### Application Endpoints

| Component | URL | Description |
|-----------|-----|-------------|
| Main page | http://localhost:8080 | Index page |
| Exercises | http://localhost:8080/exercises/ | All 17 exercises |
| Catalog | http://localhost:8080/catalog/ | E-commerce catalog |
| Shopping cart | http://localhost:8080/catalog/cart.php | Shopping cart |
| Login | http://localhost:8080/catalog/login.php | Login page |
| Registration | http://localhost:8080/catalog/register.php | New user registration |
| Admin Panel | http://localhost:8080/catalog/admin/dashboard.php | Admin dashboard |
| Customer Panel | http://localhost:8080/catalog/customer/dashboard.php | Customer dashboard |
| phpMyAdmin | http://localhost:8081 | Database management |

#### Example Accounts

| Account | Username | Password | Role |
|---------|----------|----------|------|
| Administrator | admin | password | admin |
| User | customer1 | password | customer |

#### Docker Container Structure

```
Docker Compose Network (php_network)

Web Service (Port 8080)
  - PHP 8.2 + Apache
  - Document Root: /var/www/html
  - Health Check: Enabled

MySQL Service (Port 3306)
  - MySQL 8.0
  - Database: catalog_db
  - Health Check: Enabled

phpMyAdmin (Port 8081)
  - Database GUI
  - Connected to MySQL

API Service
  - PHP REST API endpoints
  - Serves `catalog/api.php`
  - Connected to MySQL
  - Health Check: Enabled
```

#### Data Persistence

- **MySQL data**: Stored in `mysql_data` Docker volume
- **Uploaded files**: `catalog/uploads/` - mounted in container
- **All files**: Synchronized between host and container

---

## Docker Architecture

### System Components

**Web Service (PHP 8.2 + Apache)**
- Port: 8080
- Document Root: `/var/www/html`
- Image: Multi-stage Docker image based on `php:8.2-apache`
- Features:
  - PHP extensions: PDO, MySQL, GD, ZIP
  - Apache modules: rewrite, headers
  - Health checks
  - File volume binding

**MySQL Service**
- Port: 3306
- Version: MySQL 8.0
- Database: `catalog_db`
- User: `catalog_user` (password: `catalog_password`)
- Features:
  - Automatic initialization via `seed.sql`
  - Docker volume for persistence (`mysql_data`)
  - Health checks
  - Optimized configuration (mysql.cnf)

**phpMyAdmin Service**
- Port: 8081
- Features:
  - Database management interface
  - Connection to MySQL service
  - Useful for development and debugging


---

## Project Structure

```
PHP-exercises/
├── Dockerfile                    # Multi-stage Docker image
├── compose.yml                   # Docker Compose configuration
├── mysql.cnf                     # MySQL configuration
├── .dockerignore                 # Files to ignore during build
├── .env.example                  # Example environment variables
├── exercises/
│   ├── 01_numbers_even_odd/
│   ├── 02_square_with_loops/
│   ├── 03_arrays_random_numbers/
│   ├── 04_arrays_colors_divs/
│   ├── 05_arrays_session/
│   ├── 06_class_basic/
│   ├── 07_form_with_class/
│   ├── 08_gallery/
│   ├── 09_form_database/
│   ├── 10_database_table_count/
│   ├── 11_product_catalog/
│   ├── 12_admin_panel/
│   ├── 13_responsive_grid/
│   ├── 14_bootstrap/
│   │   ├── index.php
│   │   └── images/
│   ├── 15_regex_form/
│   │   ├── index.php
│   │   └── README.md
│   ├── 16_PHPMailer/
│   │   ├── index.php
│   │   ├── send_email.php
│   │   ├── composer.json
│   │   └── vendor/
│   ├── 17_Calculator/
│   │   ├── index.php
│   │   └── README.md
│   ├── index.php
│   └── README.md
├── catalog/
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── products.php
│   │   ├── orders.php
│   │   ├── categories.php
│   │   └── ...
│   ├── customer/
│   │   ├── dashboard.php
│   │   ├── orders.php
│   │   └── logout.php
│   ├── api.php                   # API endpoints
│   ├── auth.php                  # Authentication
│   ├── db.php                    # Database configuration
│   ├── cart.php                  # Shopping cart
│   ├── checkout.php              # Checkout process
│   ├── index.php                 # Catalog main page
│   ├── login.php                 # Login page
│   ├── register.php              # Registration
│   ├── seed.sql                  # Database initialization script
│   ├── style.css                 # Styles
│   └── uploads/                  # Uploaded files (dynamic)
└── README.md (this file)
```

### Key Components Explanation

#### Catalog (E-commerce System)

Main catalog modules:

| File | Description |
|------|-------------|
| `db.php` | PDO configuration for database connection |
| `auth.php` | Functions for login, registration, session check |
| `api.php` | REST API endpoints |
| `cart.php` | Shopping cart management |
| `checkout.php` | Order completion process |
| `index.php` | Product listing |

#### Admin Panel

| File | Functionality |
|------|-------------------|
| `dashboard.php` | View all products and orders |
| `products.php` | List products |
| `add-product.php` | Add new product |
| `edit-product.php` | Edit existing product |
| `delete-product.php` | Delete product |
| `orders.php` | View all orders |
| `categories.php` | Manage categories |

#### Customer Dashboard

| File | Functionality |
|------|-------------------|
| `dashboard.php` | Personal account |
| `orders.php` | Order history |
| `logout.php` | Logout |

#### Database (MySQL)

Main tables:

```sql
products
├── id (Primary Key)
├── name (VARCHAR)
├── description (TEXT)
├── price (DECIMAL)
├── category (VARCHAR)
├── image (VARCHAR - URL)
├── stock (INT)
└── created_at (TIMESTAMP)

users
├── id (Primary Key)
├── username (VARCHAR, UNIQUE)
├── email (VARCHAR, UNIQUE)
├── password_hash (VARCHAR)
├── role (ENUM: admin, customer)
└── created_at (TIMESTAMP)

orders
├── id (Primary Key)
├── customer_id (Foreign Key)
├── customer_name (VARCHAR)
├── customer_email (VARCHAR)
├── customer_phone (VARCHAR)
├── total_price (DECIMAL)
├── status (VARCHAR)
└── created_at (TIMESTAMP)

order_items
├── id (Primary Key)
├── order_id (Foreign Key)
├── product_id (Foreign Key)
├── quantity (INT)
└── price (DECIMAL)
```

## Communication Between Services

### Web MySQL Communication

```
PHP Application
    |
    +-> PDO Connection
        |
        +-> mysql://catalog_user:catalog_password@mysql:3306/catalog_db
            |
            +-> MySQL Service (Internal DNS: mysql)
```

**Key Points:**
1. **Hostname**: In Docker, service name (`mysql`) is used, not IP address
2. **Port**: 3306 is the default MySQL port (internal to network)
3. **Database**: `catalog_db` is created automatically via `seed.sql`
4. **User**: `catalog_user` with password `catalog_password`


## Technologies and Dependencies

### Backend
- **PHP 8.2** - Programming language
- **Apache 2.4** - Web server
- **PDO** - Database abstraction layer
- **GD** - Image processing
- **ZIP** - File compression

### Database
- **MySQL 8.0** - Relational database
- **InnoDB** - Storage engine

### Frontend
- **HTML5** - Markup
- **CSS3** - Styling
- **JavaScript** - Interactivity
- **Bootstrap** - CSS Framework

### DevOps
- **Docker** - Containerization
- **Docker Compose** - Container orchestration
- **phpMyAdmin** - Database management

### Resource Monitoring

```bash
# View containers
docker compose ps

# Detailed information
docker compose ps --all

# Service statistics
docker stats
```

## License

This project is licensed under the MIT License - see `LICENSE` file for details.



**Last Updated:** June 2026
**Version:** 2.0 (Docker Compose Support)
