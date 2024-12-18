<?php
// Set secure session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,             // 1-hour session
    'path' => '/',                  // Available throughout the website
    'domain' => '',                 // Default to current domain
    'secure' => true,               // Only send over HTTPS
    'httponly' => true,             // Prevent JavaScript access
    'samesite' => 'Strict'          // CSRF protection
]);

// Start the session
session_start();
// Establish database connection
$con = new mysqli("localhost:3306", "root", "", "hostel");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])), ENT_QUOTES, 'UTF-8');
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-pass'];

    // Validate password server-side
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if (!preg_match($passwordRegex, $password)) {
        die("Error: Password does not meet the required criteria.");
    }
    if ($password !== $confirmPassword) {
        die("Error: Passwords do not match.");
    }
    // List of common passwords
    $commonPasswords = [
        'password', '123456', '123456789', 'qwerty', 'abc123',
        'password1', '12345678', 'iloveyou', '111111', '123123'
    ];

    if (in_array(strtolower($password), $commonPasswords)) {
        die("Error: The password you entered is too common. Please choose a stronger password.");
    }
    // Hash the password    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists in the database
    $checkQuery = "SELECT * FROM admins WHERE username = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Error: Username already exists. Please choose a different username.");
    }
    // Insert into the database
    $query = "INSERT INTO admins (username, password, role) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Admin user registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
