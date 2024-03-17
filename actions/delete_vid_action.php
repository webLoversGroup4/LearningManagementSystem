<?php

include '../settings/connection.php';

if (!isset($_COOKIE['user_id'])) {
    header('Location: ../login/login.php');
    exit(); 
}

$tutor_id = $_COOKIE['user_id'];

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $verify_video = $conn->prepare("SELECT * FROM content WHERE id = ? AND tutor_id = ? LIMIT 1");
   $verify_video->bind_param("ss", $delete_id, $tutor_id); 
   $verify_video->execute(); 
   $result = $verify_video->get_result();

   if($result->num_rows > 0){
      $fetch_thumb = $result->fetch_assoc(); 
      unlink('../uploads/'.$fetch_thumb['thumb']);

      $delete_video = $conn->prepare("DELETE FROM content WHERE id = ?");
      $delete_video->bind_param("s", $delete_id); 
      $delete_video->execute();
      
      $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
      $delete_likes->bind_param("s", $delete_id); 
      $delete_likes->execute();

      $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
      $delete_comments->bind_param("s", $delete_id); 
      $delete_comments->execute();
      $message[] = 'Video deleted!';
      header('Location: ../admin/contents.php');
   }else{
      $message[] = 'Video not found or you do not have permission to delete!';
      header('Location: ../admin/contents.php');
   }
}
?>
