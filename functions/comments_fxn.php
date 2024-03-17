<?php
include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
    $tutor_id = $_COOKIE['user_id'];
} else {
    $tutor_id = '';
    header('location:../login/login.php');
    exit();
}

$comments_html = '';

$select_comments = $conn->prepare("SELECT * FROM comments WHERE tutor_id = ?");
$select_comments->bind_param("s", $tutor_id);
$select_comments->execute();
$result = $select_comments->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $select_content = $conn->prepare("SELECT * FROM content WHERE id = ?");
        $id = $row['content_id'];
        $select_content->bind_param("s", $id);
        $select_content->execute();
        $content_result = $select_content->get_result();
        $fetch_content = $content_result->fetch_assoc();

        $comments_html .= '<div class="box" style="' . ($row['tutor_id'] == $tutor_id ? 'order:-1;' : '') . '">';
    
        $comments_html .= '<div class="content"><span>' . $row['date'] . '</span><p> - ' . htmlspecialchars($fetch_content['title']) . ' - </p><a href="view_content.php?get_id=' . $fetch_content['id'] . '">View Content</a></div>';
        $comments_html .= '<p class="text">' . htmlspecialchars($row['comment']) . '</p>';
        $comments_html .= '<form action="../actions/delete_comment.php" method="post">';
        $comments_html .= '<input type="hidden" name="comment_id" value="' . htmlspecialchars($row['id']) . '">';
        $comments_html .= '<button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm(\'Delete this comment?\');">Delete Comment</button>';
        $comments_html .= '</form>';
        $comments_html .= '</div>';
    }
} else {
    $comments_html = '<p class="empty">No comments added yet!</p>';
}

echo $comments_html;
?>
