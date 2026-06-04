<?php
/**
 * Database Configuration
 * Supports both local development and Docker environments
 * 
 * Environment Variables (for Docker):
 * - DB_HOST: MySQL host (default: 127.0.0.1)
 * - DB_PORT: MySQL port (default: 3306)
 * - DB_NAME: Database name (default: catalog_db)
 * - DB_USER: Database user (default: root)
 * - DB_PASS: Database password (default: '')
 */

// Get configuration from environment variables or use defaults
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_PORT = getenv('DB_PORT') ?: '3306';
$DB_NAME = getenv('DB_NAME') ?: 'catalog_db';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';

// Construct DSN (Data Source Name)
$dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Attempt to reconnect if connection is lost
        PDO::ATTR_TIMEOUT => 5,
    ]);
} catch (PDOException $e) {
    echo "<h2>🚨 Database connection failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<hr>";
    echo "<h3>Debugging Information:</h3>";
    echo "<ul>";
    echo "<li><strong>Host:</strong> {$DB_HOST}:{$DB_PORT}</li>";
    echo "<li><strong>Database:</strong> {$DB_NAME}</li>";
    echo "<li><strong>User:</strong> {$DB_USER}</li>";
    echo "</ul>";
    echo "<p>If using Docker, ensure containers are running: <code>docker compose ps</code></p>";
    exit;
}
