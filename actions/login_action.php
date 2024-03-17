<?php
include "../settings/connection.php";

if (isset($_POST['submit'])) {
    // Validate and sanitize user input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Check if email is valid
    if (!$email) {
        echo "<script>alert('Invalid email format.');</script>";
        exit();
    }

    // Check if password is provided
    if (empty($password)) {
        echo "<script>alert('Password is required.');</script>";
        exit();
    }

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT sid, rid,lname,fname, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $user_id = $row['sid'];
        $user_role = $row['rid'];
        $user_fname = $row['fname'];
        $user_lname = $row['lname'];
        $user_name = $user_fname." ".$user_lname;

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Setting a cookie for user authentication
            setcookie("user_id", $user_id, time() + 600, "/"); 
            setcookie("user_role", $user_role, time() + 600, "/");
            setcookie("user_name", $user_name, time() + 600, "/");

            // Redirect based on user role
            // 1 - user and 2 - admin
            if ($user_role === 2) {
                // Redirect admin to the admin dashboard
                header("Location: ../admin/dashboard.php");
                exit();
            } 
            else {
                // Redirect regular user to the home page
                header("Location: ../view/home.php");
                exit();
            }
        } 
        else {
            // Incorrect password
            echo "<script>alert('Incorrect password.');</script>";
            header("Location: ../login/login.php");
            exit();
        }
    } 
    else {
        // No user found with the provided email
        echo "<script>alert('User with this email does not exist.');</script>";
        header("Location: ../login/login.php");
        exit();
    }
    $stmt->close();
}

mysqli_close($conn);
?>
