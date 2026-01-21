<?php
// auth.php - Session and login helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isCustomer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        header('Location: ../index.php');
        exit;
    }
}

function requireCustomer() {
    if (!isLoggedIn() || !isCustomer()) {
        header('Location: ../login.php');
        exit;
    }
}

function logout() {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

function verifyPassword($plaintext, $hash) {
    return password_verify($plaintext, $hash);
}

function hashPassword($plaintext) {
    return password_hash($plaintext, PASSWORD_BCRYPT, ['cost' => 10]);
}
