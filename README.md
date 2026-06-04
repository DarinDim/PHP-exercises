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

#### Basic Docker Commands

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View active containers
docker compose ps

# View logs
docker compose logs -f

# Logs for specific service
docker compose logs -f web
docker compose logs -f mysql

# Access PHP container
docker compose exec web bash

# Access MySQL container
docker compose exec mysql mysql -u catalog_user -pcatalog_password catalog_db

# Full cleanup (including database)
docker compose down -v

# Rebuild images
docker compose build --no-cache

# Restart services
docker compose restart
```

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
```

#### Data Persistence

- **MySQL data**: Stored in `mysql_data` Docker volume
- **Uploaded files**: `catalog/uploads/` - mounted in container
- **All files**: Synchronized between host and container

#### Troubleshooting

**Problem: "Port 8080 already in use"**
```bash
# Find what's using the port
netstat -ano | findstr :8080

# Or change port number in compose.yml
# Edit: ports: - "8090:80"
```

**Problem: "Cannot connect to Docker daemon"**
- Ensure Docker Desktop is running
- On Linux, use: `sudo usermod -aG docker $USER`

**Problem: Database not initializing**
```bash
# Delete old data and restart
docker compose down -v
docker compose up -d
```

**Problem: PHP files not updating in container**
```bash
# Rebuild images
docker compose build --no-cache
docker compose up -d
```

---

### Option 2: Local Server (XAMPP/Local)

#### Requirements

- PHP 7.4+
- MySQL 5.7+
- XAMPP or other local server

#### Installation

1. **Clone the repository**
```bash
git clone https://github.com/DarinDim/PHP-exercises.git
cd PHP-exercises
```

2. **Copy files to XAMPP**
```bash
cp -r exercises /path/to/xampp/htdocs/
cp -r catalog /path/to/xampp/htdocs/
```

3. **Configure database**
- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Import `catalog/seed.sql`
- Configure `catalog/db.php`

4. **Start**
- Exercises: `http://localhost/exercises/`
- Catalog: `http://localhost/catalog/`
- Admin panel: `http://localhost/catalog/admin/`

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

### Dockerfile Analysis

The multi-stage architecture of the Dockerfile has the following objectives:

```
Stage 1: Builder
- Install dependencies
- Compile PHP extensions
- Copy application
- Configure Apache

Stage 2: Production
- Minimal image (runtime only)
- Copy extensions from Builder
- Copy application
- Optimized for size
```

**Advantages:**
- Reduced image size
- Faster execution
- Fewer vulnerabilities
- Better performance

### Docker Compose Network

All containers are connected via a bridge network `php_network`:

```
Host Machine
  Port 8080 -> Web
  Port 3306 -> MySQL
  Port 8081 -> phpMyAdmin

Docker Network (php_network)
  - web (http, localhost)
  - mysql (tcp, localhost)
  - phpmyadmin
```

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

### Environment Variables

In Docker Compose, set via `environment` section:

```yaml
environment:
  - DB_HOST=mysql
  - DB_NAME=catalog_db
  - DB_USER=catalog_user
  - DB_PASS=catalog_password
```

Read in PHP via `getenv()` or `$_ENV`:

```php
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('DB_NAME') ?: 'catalog_db';
```

### Health Checks

Each service has health check for status control:

```yaml
# Web Service Health Check
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost/"]
  interval: 30s
  timeout: 10s
  retries: 3

# MySQL Health Check
healthcheck:
  test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
  interval: 10s
  timeout: 5s
```

---

## Security

The project demonstrates best practices:
- PDO for SQL injection prevention - parameterized queries
- htmlspecialchars() for XSS prevention - special characters are encoded
- CSRF tokens - protection from cross-site requests
- Input validation - all data is validated
- Secure sessions - proper session handling
- password_hash() and password_verify() - cryptographic password hashing
- Docker Security - unprivileged execution (www-data user)


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

---

## Monitoring and Debugging

### View Logs

```bash
# Logs of all services
docker compose logs -f

# Logs of specific service
docker compose logs -f web
docker compose logs -f mysql
docker compose logs -f phpmyadmin

# Last 100 lines
docker compose logs --tail=100 web

# Real-time logs with timestamps
docker compose logs --timestamps web
```

### Access Containers

```bash
# Shell access to PHP container
docker compose exec web bash
docker compose exec web sh

# Direct command execution
docker compose exec web ls -la /var/www/html

# MySQL CLI
docker compose exec mysql mysql -u catalog_user -pcatalog_password catalog_db

# PHP CLI
docker compose exec web php --version
docker compose exec web php -r "phpinfo();"
```

### Resource Monitoring

```bash
# View containers
docker compose ps

# Detailed information
docker compose ps --all

# Service statistics
docker stats
```

---

## Development and Testing

### Working with Files

All host files are automatically synchronized with the container via volumes:

```yaml
volumes:
  - ./:/var/www/html
  - ./catalog/uploads:/var/www/html/catalog/uploads
```

### Adding New Dependencies

If you need new PHP extensions or packages:

1. **Edit Dockerfile**
2. **Rebuild image**
```bash
docker compose build --no-cache
```

3. **Restart containers**
```bash
docker compose down
docker compose up -d
```

### Testing in Container

```bash
# Copy file to container
docker compose cp test.php web:/var/www/html/test.php

# Copy from container
docker compose cp web:/var/www/html/test.txt ./test.txt

# Execute PHP script
docker compose exec web php /var/www/html/test.php
```

---

## Deployment to Docker Hub

### Preparation

1. **Create Docker Hub account**: https://hub.docker.com/

2. **Login to Docker**
```bash
docker login
```

3. **Build image with correct name**
```bash
# Format: username/repository:tag
docker build -t yourusername/php-exercises:latest .
docker build -t yourusername/php-exercises:1.0 .
```

### Push to Docker Hub

```bash
# Push image
docker push yourusername/php-exercises:latest
docker push yourusername/php-exercises:1.0

# Check on Docker Hub
# https://hub.docker.com/r/yourusername/php-exercises
```

### Use Image from Docker Hub

```bash
# Pull image
docker pull yourusername/php-exercises:latest

# Start container
docker run -p 8080:80 -e DB_HOST=mysql yourusername/php-exercises:latest
```

---

## Exercise Documentation

Each exercise includes:
- `index.php` - main code
- Inline comments
- Getting started instructions
- Error handling
- README with description

See the `exercises/` folder for details on each exercise.


## License

This project is licensed under the MIT License - see `LICENSE` file for details.



**Last Updated:** June 2026
**Version:** 2.0 (Docker Compose Support)
