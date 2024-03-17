<?php

include '../settings/connection.php';

if (!isset($_COOKIE['user_id'])) {
    header('Location: ../login/login.php');
    exit(); 
}

$tutor_id = $_COOKIE['user_id'];

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:contents.php');
}

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $delete_video_thumb_stmt = $conn->prepare("SELECT thumb FROM content WHERE id = ? LIMIT 1");
   $delete_video_thumb_stmt->bind_param("s", $delete_id);
   $delete_video_thumb_stmt->execute();
   $delete_video_thumb_stmt->store_result();

   if($delete_video_thumb_stmt->num_rows > 0) {
       $delete_video_thumb_stmt->bind_result($thumb);
       $delete_video_thumb_stmt->fetch();
       unlink('../uploads/'.$thumb);
       $delete_video_thumb_stmt->close();
   }

   $delete_video_stmt = $conn->prepare("SELECT video FROM content WHERE id = ? LIMIT 1");
   $delete_video_stmt->bind_param("s", $delete_id);
   $delete_video_stmt->execute();
   $delete_video_stmt->store_result();

   if($delete_video_stmt->num_rows > 0) {
       $delete_video_stmt->bind_result($video);
       $delete_video_stmt->fetch();
       unlink('../uploads/'.$video);
       $delete_video_stmt->close();
   }

   $delete_likes_stmt = $conn->prepare("DELETE FROM likes WHERE content_id = ?");
   $delete_likes_stmt->bind_param("s", $delete_id);
   $delete_likes_stmt->execute();
   $delete_likes_stmt->close();

   $delete_comments_stmt = $conn->prepare("DELETE FROM comments WHERE content_id = ?");
   $delete_comments_stmt->bind_param("s", $delete_id);
   $delete_comments_stmt->execute();
   $delete_comments_stmt->close();

   $delete_content_stmt = $conn->prepare("DELETE FROM content WHERE id = ?");
   $delete_content_stmt->bind_param("s", $delete_id);
   $delete_content_stmt->execute();
   $delete_content_stmt->close();

   header('Location: contents.php');
   exit();  
}

if(isset($_POST['delete_comment'])){
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment_stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
   $verify_comment_stmt->bind_param("s", $delete_id);
   $verify_comment_stmt->execute();
   $verify_comment_stmt->store_result();

   if($verify_comment_stmt->num_rows > 0){
      $delete_comment_stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
      $delete_comment_stmt->bind_param("s", $delete_id);
      $delete_comment_stmt->execute();
      $message[] = 'Comment deleted successfully!';
      $delete_comment_stmt->close();
   }else{
      $message[] = 'Comment already deleted!';
   }
   $verify_comment_stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>view content</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../functions/admin_header_fxn.php'; ?>
<section class="view-content">

   <?php
      $select_content_stmt = $conn->prepare("SELECT * FROM content WHERE id = ? AND tutor_id = ?");
      $select_content_stmt->bind_param("ss", $get_id, $tutor_id);
      $select_content_stmt->execute();
      $result_content = $select_content_stmt->get_result();
      
      if($result_content->num_rows > 0){
         while($fetch_content = $result_content->fetch_assoc()){
            $video_id = $fetch_content['id'];

            $count_likes_stmt = $conn->prepare("SELECT * FROM likes WHERE tutor_id = ? AND content_id = ?");
            $count_likes_stmt->bind_param("ss", $tutor_id, $video_id);
            $count_likes_stmt->execute();
            $result_likes = $count_likes_stmt->get_result();
            $total_likes = $result_likes->num_rows;

            $count_comments_stmt = $conn->prepare("SELECT * FROM comments WHERE tutor_id = ? AND content_id = ?");
            $count_comments_stmt->bind_param("ss", $tutor_id, $video_id);
            $count_comments_stmt->execute();
            $result_comments = $count_comments_stmt->get_result();
            $total_comments = $result_comments->num_rows;
   ?>
   <div class="container">
      <video src="../uploads/<?= $fetch_content['video']; ?>" autoplay controls poster="../uploads/<?= $fetch_content['thumb']; ?>" class="video"></video>
      <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></div>
      <h3 class="title"><?= $fetch_content['title']; ?></h3>
      <div class="flex">
         <div><i class="fas fa-heart"></i><span><?= $total_likes; ?></span></div>
         <div><i class="fas fa-comment"></i><span><?= $total_comments; ?></span></div>
      </div>
      <div class="description"><?= $fetch_content['description']; ?></div>
      <form action="" method="post">
         <div class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </div>
      </form>
   </div>
   <?php
    }
   }else{
      echo '<p class="empty">no contents added yet! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
   }
      
   ?>

</section>

<section class="comments">

   <h1 class="heading">user comments</h1>

   
   <div class="show-comments">
      <?php
         $select_comments_stmt = $conn->prepare("SELECT * FROM comments WHERE content_id = ?");
         $select_comments_stmt->bind_param("s", $get_id);
         $select_comments_stmt->execute();
         $result_comments = $select_comments_stmt->get_result();
         if($result_comments->num_rows > 0){
            while($fetch_comment = $result_comments->fetch_assoc()){   
               $select_commentor_stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
               $select_commentor_stmt->bind_param("s", $fetch_comment['user_id']);
               $select_commentor_stmt->execute();
               $result_commentor = $select_commentor_stmt->get_result();
               $fetch_commentor = $result_commentor->fetch_assoc();
      ?>
      <div class="box">
         <div class="user">
            <img src="../uploads/<?= $fetch_commentor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_commentor['name']; ?></h3>
               <span><?= $fetch_comment['date']; ?></span>
            </div>
         </div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">delete comment</button>
         </form>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">no comments added yet!</p>';
      }
      ?>
      </div>
   
</section>



<script src="../js/admin_script.js"></script>

</body>
</html>
