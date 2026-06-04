# Architecture and API Documentation

This is detailed documentation of the architecture of the PHP-exercises project and API endpoints.

## System Architecture

### Three-Layer Architecture

```
┌─────────────────────────────────────────────┐
│         Presentation Layer (UI)             │
│  HTML5, CSS3, JavaScript, Bootstrap         │
│  Views: Catalog, Admin, Customer Dashboard  │
└─────────────────┬───────────────────────────┘
                  │ HTTP Request/Response
                  ▼
┌─────────────────────────────────────────────┐
│       Application Layer (Business Logic)    │
│  PHP files, API endpoints, Controllers      │
│  Product management, Orders, Users          │
└─────────────────┬───────────────────────────┘
                  │ PDO / SQL Queries
                  ▼
┌─────────────────────────────────────────────┐
│         Data Layer (Database)               │
│  MySQL 8.0, Tables, Stored Procedures       │
│  Products, Users, Orders, OrderItems        │
└─────────────────────────────────────────────┘
```

### Components

#### 1. **Frontend (Views)**
- `catalog/index.php` - Home page with products
- `catalog/cart.php` - Shopping cart
- `catalog/checkout.php` - Checkout process
- `catalog/login.php` - Login
- `catalog/register.php` - Registration

#### 2. **Backend (Controllers)**
- `catalog/api.php` - REST API endpoints
- `catalog/auth.php` - Session management and authorization
- `catalog/db.php` - Database configuration

#### 3. **Admin Panel**
- `catalog/admin/dashboard.php` - Main panel
- `catalog/admin/products.php` - Product management
- `catalog/admin/add-product.php` - Add product
- `catalog/admin/edit-product.php` - Edit product
- `catalog/admin/delete-product.php` - Delete product
- `catalog/admin/orders.php` - View orders
- `catalog/admin/categories.php` - Manage categories

#### 4. **Database Layer**
- Tables: `products`, `users`, `orders`, `order_items`
- Relationships and Foreign Keys

---

## REST API Documentation

### Base URL
```
http://localhost:8080/catalog/api.php
```

### API Endpoints

#### 1. Products API

##### Get All Products
```http
GET /api.php?action=get_products
```

**Response:**
```json
{
  "status": "success",
  "products": [
    {
      "id": 1,
      "name": "Coffee",
      "description": "Hot espresso",
      "price": "2.50",
      "category": "Beverages",
      "image": "https://example.com/coffee.jpg",
      "stock": 50
    }
  ]
}
```

##### Get Product by ID
```http
GET /api.php?action=get_product&id=1
```

**Response:**
```json
{
  "status": "success",
  "product": {
    "id": 1,
    "name": "Coffee",
    "description": "Hot espresso",
    "price": "2.50",
    "category": "Beverages",
    "image": "https://example.com/coffee.jpg",
    "stock": 50
  }
}
```

##### Get Products by Category
```http
GET /api.php?action=get_by_category&category=Beverages
```

**Response:**
```json
{
  "status": "success",
  "products": [
    { ... product data ... }
  ]
}
```

#### 2. User Authentication API

##### Register User
```http
POST /api.php
Content-Type: application/json

{
  "action": "register",
  "username": "user123",
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "User registered successfully",
  "user_id": 3
}
```

##### Login User
```http
POST /api.php
Content-Type: application/json

{
  "action": "login",
  "username": "admin",
  "password": "password"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Login successful",
  "user": {
    "id": 1,
    "username": "admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

##### Get Current User
```http
GET /api.php?action=get_user
```

**Response (if logged in):**
```json
{
  "status": "success",
  "user": {
    "id": 1,
    "username": "admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

#### 3. Orders API

##### Create Order
```http
POST /api.php
Content-Type: application/json

{
  "action": "create_order",
  "customer_name": "Ivan Petrov",
  "customer_email": "ivan@example.com",
  "customer_phone": "0888123456",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ]
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Order created",
  "order_id": 10,
  "total_price": "95.99"
}
```

##### Get User Orders
```http
GET /api.php?action=get_user_orders
```

**Response:**
```json
{
  "status": "success",
  "orders": [
    {
      "id": 10,
      "customer_name": "Ivan Petrov",
      "total_price": "95.99",
      "status": "new",
      "created_at": "2026-06-02 10:30:00",
      "items": [
        {
          "product_id": 1,
          "product_name": "Coffee",
          "quantity": 2,
          "price": "2.50"
        }
      ]
    }
  ]
}
```

##### Get All Orders (Admin)
```http
GET /api.php?action=get_all_orders
```

**Response:**
```json
{
  "status": "success",
  "orders": [...]
}
```

#### 4. Admin Operations API

##### Add Product
```http
POST /api.php
Content-Type: application/json

{
  "action": "add_product",
  "name": "New Product",
  "description": "Product description",
  "price": 99.99,
  "category": "Electronics",
  "image": "https://example.com/product.jpg",
  "stock": 20
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Product added",
  "product_id": 11
}
```

##### Update Product
```http
POST /api.php
Content-Type: application/json

{
  "action": "update_product",
  "id": 1,
  "name": "Updated Name",
  "description": "Updated description",
  "price": 3.00,
  "category": "Beverages",
  "image": "https://example.com/new.jpg",
  "stock": 100
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Product updated"
}
```

##### Delete Product
```http
POST /api.php
Content-Type: application/json

{
  "action": "delete_product",
  "id": 1
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Product deleted"
}
```

---

## Database Schema

### Products Table
```sql
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(100),
  image VARCHAR(255),
  stock INT DEFAULT 10,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Users Table
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','customer') DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Orders Table
```sql
CREATE TABLE orders (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_id INT,
  customer_name VARCHAR(255) NOT NULL,
  customer_email VARCHAR(100),
  customer_phone VARCHAR(20),
  total_price DECIMAL(10,2) NOT NULL,
  status VARCHAR(50) DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES users(id)
);
```

### Order Items Table
```sql
CREATE TABLE order_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);
```

---

## Authentication Flow

### Session Management

```
User Visits App
    |
Check $_SESSION['user_id']
    |
    +- Yes -> Load user data -> Show dashboard
    |
    +- No -> Redirect to login -> Show login form

User Submits Login
    |
Verify credentials (password_verify)
    |
    +- Correct -> Set $_SESSION['user_id'], ['username'], ['role']
    |
    +- Incorrect -> Show error message

User Performs Action
    |
Check $_SESSION['user_id'] exists
    |
Check $_SESSION['role'] == 'admin' (if admin action)
    |
    +- Allowed -> Perform action
    |
    +- Denied -> Redirect to error page
```

### Authorization Levels

| Role | Permissions |
|------|------------|
| **Guest** | View products, Add to cart, Login/Register |
| **Customer** | View own orders, Update profile |
| **Admin** | Manage all products, View all orders, User management |

---

## Shopping Cart Flow

```
┌──────────────┐
│ View Product │
└──────┬───────┘
       |
       v
┌──────────────────────┐
│ Click "Add to Cart"  │
│ (stored in SESSION)  │
└──────┬───────────────┘
       |
       v
┌──────────────────────┐
│ View Cart            │
│ (from $_SESSION)     │
└──────┬───────────────┘
       |
       +- Update quantity
       |
       +- Remove item
       |
       +- Proceed to checkout
           |
           v
       ┌──────────────────────┐
       │ Enter Details        │
       │ + Payment Info       │
       └──────┬───────────────┘
             |
             v
       ┌──────────────────────┐
       │ Create Order         │
       │ Save to database     │
       │ Clear cart           │
       └──────┬───────────────┘
             |
             v
       ┌──────────────────────┐
       │ Success Page         │
       │ Order confirmation   │
       └──────────────────────┘
```

---

## Error Handling

### Error Response Format

```json
{
  "status": "error",
  "message": "Descriptive error message",
  "code": "ERROR_CODE"
}
```

### Common Error Codes

| Code | Meaning |
|------|---------|
| `AUTH_REQUIRED` | User must be logged in |
| `ADMIN_REQUIRED` | Only admins can perform this action |
| `INVALID_INPUT` | Input validation failed |
| `NOT_FOUND` | Resource not found |
| `DATABASE_ERROR` | Database operation failed |
| `DUPLICATE_USER` | Username or email already exists |

---

## Security Measures

### SQL Injection Prevention
```php
// Safe - Parameterized query
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

// Unsafe - Direct concatenation
$result = $pdo->query("SELECT * FROM users WHERE username = '$username'");
```

### XSS Prevention
```php
// Safe - HTML encoding
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// Unsafe - Direct output
echo $user_input;
```

### Password Security
```php
// Safe - password_hash
$hash = password_hash($password, PASSWORD_BCRYPT);
if (password_verify($password, $hash)) { ... }

// Unsafe - Plain text or weak hashing
$hash = md5($password);
```

---

## Testing Examples

### cURL Examples

```bash
# Get all products
curl "http://localhost:8080/catalog/api.php?action=get_products"

# Login
curl -X POST "http://localhost:8080/catalog/api.php" \
  -H "Content-Type: application/json" \
  -d '{"action":"login","username":"admin","password":"password"}'

# Create order
curl -X POST "http://localhost:8080/catalog/api.php" \
  -H "Content-Type: application/json" \
  -d '{
    "action":"create_order",
    "customer_name":"Test User",
    "customer_email":"test@example.com",
    "items":[{"product_id":1,"quantity":2}]
  }'
```

### Postman Collection

See `postman_collection.json` for ready-made Postman collection with all API endpoints.

---

**Last Updated:** June 2026  
**Version:** 2.0
