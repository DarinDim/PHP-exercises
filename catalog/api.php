// catalog/api.php - Simple API to return products from database
// This file connects to the database, retrieves all products, and returns them as JSON.
// Zadacha 5 vtori srok
<?php
// api.php - Simple API to return products from database

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests if needed

require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT id, name, description, price, category, stock FROM products ORDER BY id");
    $products = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'data' => $products,
        'count' => count($products)
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>