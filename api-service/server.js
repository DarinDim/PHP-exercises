const express = require('express');
const cors = require('cors');
const mysql = require('mysql2/promise');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json());

// MySQL Connection Pool
const pool = mysql.createPool({
  host: process.env.DB_HOST || 'mysql',
  user: process.env.DB_USER || 'catalog_user',
  password: process.env.DB_PASS || 'catalog_password',
  database: process.env.DB_NAME || 'catalog_db',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Health Check
app.get('/health', (req, res) => {
  res.json({ status: 'API Service is running', timestamp: new Date() });
});

// Get All Products
app.get('/api/products', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query('SELECT * FROM products');
    connection.release();
    res.json({ status: 'success', count: rows.length, products: rows });
  } catch (error) {
    res.status(500).json({ status: 'error', message: error.message });
  }
});

// Get Product by ID
app.get('/api/products/:id', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query('SELECT * FROM products WHERE id = ?', [req.params.id]);
    connection.release();
    
    if (rows.length === 0) {
      return res.status(404).json({ status: 'error', message: 'Product not found' });
    }
    res.json({ status: 'success', product: rows[0] });
  } catch (error) {
    res.status(500).json({ status: 'error', message: error.message });
  }
});

// Get Orders
app.get('/api/orders', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query('SELECT * FROM orders ORDER BY created_at DESC');
    connection.release();
    res.json({ status: 'success', count: rows.length, orders: rows });
  } catch (error) {
    res.status(500).json({ status: 'error', message: error.message });
  }
});

// Get Order Items
app.get('/api/orders/:orderId/items', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query(
      'SELECT oi.*, p.name, p.price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?',
      [req.params.orderId]
    );
    connection.release();
    res.json({ status: 'success', count: rows.length, items: rows });
  } catch (error) {
    res.status(500).json({ status: 'error', message: error.message });
  }
});

// Start Server
app.listen(PORT, () => {
  console.log(` API Service running on port ${PORT}`);
  console.log(` Health check: http://localhost:${PORT}/health`);
});
