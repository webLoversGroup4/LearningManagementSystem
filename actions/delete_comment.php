<?php
include '../settings/connection.php';

// Redirect to login page if user is not logged in
if (!isset($_COOKIE['user_id'])) {
    header('Location: ../login/login.php');
    exit(); 
}

$tutor_id = $_COOKIE['user_id'];

// Initialize message array
$message = [];

// Delete comment if requested
if (isset($_POST['delete_comment'])) {
    $delete_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_STRING);

    // Verify if the comment exists
    $verify_comment = $conn->prepare("SELECT * FROM comments WHERE id = ?");
    $verify_comment->bind_param("s", $delete_id);
    $verify_comment->execute();
    $result = $verify_comment->get_result();

    if ($result->num_rows > 0) {
        $delete_comment = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $delete_comment->bind_param("s", $delete_id);
        $delete_comment->execute();

        $message[] = 'Comment deleted successfully!';
        header('Location: ../admin/comments.php');
        exit();
    } else {
        $message[] = 'Comment not found or already deleted!';
        header('Location: ../admin/comments.php');
        exit();
    }
}
?>
