<?php
// src/auth.php
require_once __DIR__ . '/db.php';

function login($username, $password) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && hash('sha256', $password) === $user['password_hash']) {
        $_SESSION['user'] = [
            'id' => $user['user_id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'ref_id' => $user['ref_id']
        ];
        return true;
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();
}

function require_login($role = null) {
    if (empty($_SESSION['user'])) {
        header("Location: ../login.php");
        exit;
    }
    if ($role && $_SESSION['user']['role'] !== $role) {
        die("Access denied for this user role.");
    }
}
