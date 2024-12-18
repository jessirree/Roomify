<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // Redirect to login page
    header('Location: login.html');
    exit();
}

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout_duration'])) {
    // If the session has expired, destroy it and redirect
    session_unset();
    session_destroy();
    header('Location: login.html?timeout=true');
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

