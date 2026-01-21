<?php
// generate_hash.php - Run this once to get the hash for "admin123"
// Then copy the output to seed.sql
echo "Hash for 'admin123': " . password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]);
?>
