# API Microservice

NodeJS REST API microservice for the PHP E-commerce Catalog.

## Features

- Health check endpoint
- Get all products
- Get product by ID
- Get all orders
- Get order items by order ID
- CORS enabled
- MySQL connection pool

## Environment Variables

```bash
DB_HOST=mysql
DB_NAME=catalog_db
DB_USER=catalog_user
DB_PASS=catalog_password
PORT=3000
```

## Running Locally

```bash
npm install
npm start
```

## API Endpoints

- `GET /health` - Health check
- `GET /api/products` - All products
- `GET /api/products/:id` - Product by ID
- `GET /api/orders` - All orders
- `GET /api/orders/:orderId/items` - Order items
