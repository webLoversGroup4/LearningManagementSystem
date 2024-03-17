<?php
include '../settings/connection.php';

// Checking if user_id is set in cookies
if (!isset($_COOKIE['user_id'])) {
    // Redirecting to login page if user_id is not set
    header('location:../login/login.php');
    exit();
}

// Retrieving user_id from cookies
$tid = $_COOKIE['user_id'];
$user_name = $_COOKIE['user_name'];

// Function to execute query and count rows
function countRows($conn, $query, $tid) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows;
}

// Count total contents
$total_contents = countRows($conn, "SELECT * FROM content WHERE tutor_id = ?", $tid);

// Count total courses
$total_courses = countRows($conn, "SELECT * FROM Course WHERE InstructorID = ?", $tid);

// Count total likes
$total_likes = countRows($conn, "SELECT * FROM likes WHERE tutor_id = ?", $tid);

// Count total comments
$total_comments = countRows($conn, "SELECT * FROM comments WHERE tutor_id = ?", $tid);

// Count total quizzes
$total_q = countRows($conn, "SELECT * FROM Quiz WHERE CourseID IN (SELECT CourseID FROM Course WHERE InstructorID = ?)", $tid);
?>
