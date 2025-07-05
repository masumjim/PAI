<?php

include("db.php");

function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars(stripslashes(trim($conn->real_escape_string($data))));
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (using MD5 as per your database)
        if (md5($password) == $user['password']) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to dashboard based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: dashboard.php");
                    break;
                case 'manager':
                    header("Location: manager/dashboard.php");
                    break;
                case 'accounts':
                    header("Location: accounts/dashboard.php");
                    break;
                case 'sales':
                    header("Location: sales/dashboard.php");
                    break;
                default:
                    header("Location: dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: index.php");
        exit();
    }
}

// Logout function
function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}