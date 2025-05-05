<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function login($username, $password) {
    // Simulação simples de autenticação
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['loggedin'] = true;
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
