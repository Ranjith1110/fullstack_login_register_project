<?php

session_start();
require_once 'config.php'; // Include your database connection file

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("select email from users where email='$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = "Email already exists!";
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("insert into users (name, email, password, role) values ('$name', '$email', '$password', '$role')");
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("select * from users where email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = "Invalid email or password!";
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
