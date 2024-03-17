<?php
session_start();

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

// initializing variables
$fname = "";
$lname = "";
$email = "";
$pid = "";
$institutionName = "";
$image = "";
$password = "";

// REGISTER USER
if (isset($_POST['submit'])) {
    // receive all input values from the form
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pid = mysqli_real_escape_string($conn, $_POST['role']);
    $institutionName = mysqli_real_escape_string($conn, $_POST['institutionName']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['psw']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['c_pass']);

    // validation
    if (empty($fname) || empty($lname) || empty($email) || empty($password_1) || empty($password_2)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
        exit();
    }

    if ($password_1 !== $password_2) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit();
    }

    // Checking if user already exists
    $user_check_query = "SELECT * FROM Users WHERE email=?";
    $stmt = $conn->prepare($user_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Email already taken! Register using a different email.');</script>";
        exit();
    }
    $stmt->close();

    // Hashing the password
    $hashedPassword = password_hash($password_1, PASSWORD_DEFAULT);

    // File upload handling
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = '../uploads/';
    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_path = $image_folder . $rename;

    // Move uploaded image to designated folder
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
        echo "<script>alert('Failed to upload image.');</script>";
        echo "<script>window.location.href = '../login/register.php';</script>";
        exit();
    }


    // Insert user into database
    $insert_user_query = "INSERT INTO `Users` (rid, pid, fname, lname, iname, email, password, image) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_user_query);
    $rid =1;
    $stmt->bind_param("ssssssss",$rid,$pid, $fname, $lname, $institutionName, $email, $hashedPassword, $rename);
    if (!$stmt->execute()) {
        echo "<script>alert('Failed to register user.');</script>";
        echo "<script>window.location.href = '../login/register.php';</script>";
        exit();
    }

    $stmt->close();

    // Registration successful
    echo "<script>alert('User successfully registered ✔');</script>";
    echo "<script>window.location.href = '../login/login.php';</script>";
}

mysqli_close($conn);
?>
