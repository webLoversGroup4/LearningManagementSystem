<?php

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

$message = []; 

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(!isset($_GET['get_id'])){
   header('location:home.php');
   exit();
}

$get_id = $_GET['get_id'];

if(isset($_POST['like_content'])){
   if($user_id != ''){
      $content_id = $_POST['content_id'];

      $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $select_content->bind_param("s", $content_id);
      $select_content->execute();
      $fetch_content = $select_content->get_result()->fetch_assoc();

      $tutor_id = $fetch_content['tutor_id'];

      $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
      $select_likes->bind_param("ss", $user_id, $content_id);
      $select_likes->execute();

      if($select_likes->get_result()->num_rows > 0){
         $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
         $remove_likes->bind_param("ss", $user_id, $content_id);
         $remove_likes->execute();
         $message[] = 'removed from likes!';
      }else{
         $insert_likes = $conn->prepare("INSERT INTO `likes`(user_id, tutor_id, content_id) VALUES(?,?,?)");
         $insert_likes->bind_param("sss", $user_id, $tutor_id, $content_id);
         $insert_likes->execute();
         $message[] = 'added to likes!';
      }

   }else{
      $message[] = 'please try again later!';
   }
}

if(isset($_POST['add_comment'])){

   if($user_id != ''){

      $comment_box = $_POST['comment_box'];
      $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
      $content_id = $_POST['content_id'];
      $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

      $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $select_content->bind_param("s", $content_id);
      $select_content->execute();
      $fetch_content = $select_content->get_result()->fetch_assoc();

      $tutor_id = $fetch_content['tutor_id'];

      if($select_content->get_result()->num_rows > 0){

         $select_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND user_id = ? AND tutor_id = ? AND comment = ?");
         $comment_box_param =  (string) $comment_box;
         $select_comment->bind_param("ssss", $content_id, $user_id, $tutor_id, $comment_box_param);
         $select_comment->execute();

         if($select_comment->get_result()->num_rows > 0){
            $message[] = 'comment already added!';
         }else{
            $insert_comment = $conn->prepare("INSERT INTO `comments`(content_id, user_id, tutor_id, comment) VALUES(?,?,?,?)");
            $insert_comment->bind_param("ssss", $content_id, $user_id, $tutor_id, $comment_box);
            $insert_comment->execute();
            $message[] = 'new comment added!';
         }

      }else{
         $message[] = 'something went wrong!';
      }

   }else{
      $message[] = 'please try again later!';
   }

}

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
   $verify_comment->bind_param("s", $delete_id);
   $verify_comment->execute();

   if($verify_comment->get_result()->num_rows > 0){
      $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
      $delete_comment->bind_param("s", $delete_id);
      $delete_comment->execute();
      $message[] = 'comment deleted successfully!';
   }else{
      $message[] = 'comment already deleted!';
   }

}

if(isset($_POST['update_now'])){

   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
   $verify_comment->bind_param("ss", $update_id, $update_box);
   $verify_comment->execute();

   if($verify_comment->get_result()->num_rows > 0){
      $message[] = 'comment already added!';
   }else{
      $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
      $update_comment->bind_param("ss", $update_box, $update_id);
      $update_comment->execute();
      $message[] = 'comment edited successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>watch video</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include '..functions/user_header_fxn.php'; ?>

<!-- Watch video section starts  -->
<section class="watch-video">
   <?php
   $get_id = mysqli_real_escape_string($conn, $get_id);
   $user_id = mysqli_real_escape_string($conn, $user_id);

   // Prepare statement to select content
   $select_content = $conn->prepare("SELECT * FROM content WHERE id = ? AND status = ?");
   $status = 'active'; 
   $select_content->bind_param("ss", $get_id, $status);

   // Execute statement
   if (!$select_content->execute()) {
       die('Error in executing statement: ' . $select_content->error);
   }

   // Get result
   $result = $select_content->get_result();

   // Check if any content exists
   if($result->num_rows > 0){
      while($fetch_content = $result->fetch_assoc()){
         $content_id = $fetch_content['id'];

         // Prepare statement to select likes
         $select_likes = $conn->prepare("SELECT * FROM likes WHERE content_id = ?");
         $select_likes->bind_param("s", $content_id);

         // Execute statement
         if (!$select_likes->execute()) {
             die('Error in executing statement: ' . $select_likes->error);
         }

         // Get total likes
         $total_likes = $select_likes->get_result()->num_rows;

         // Prepare statement to verify likes
         $verify_likes = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");
         $verify_likes->bind_param("ss", $user_id, $content_id);

         // Execute statement
         if (!$verify_likes->execute()) {
             die('Error in executing statement: ' . $verify_likes->error);
         }

         // Get tutor details
         $select_tutor = $conn->prepare("SELECT * FROM Users WHERE sid = ? LIMIT 1");
         $sid = $fetch_content['tutor_id'];
         $select_tutor->bind_param("s",$sid);

         // Execute statement
         if (!$select_tutor->execute()) {
             die('Error in executing statement: ' . $select_tutor->error);
         }

         $fetch_tutor = $select_tutor->get_result()->fetch_assoc();
   ?>
   <div class="video-details">
      <video src="../uploads/<?= $fetch_content['video']; ?>" class="video" poster="../uploads/<?= $fetch_content['thumb']; ?>" controls></video>
      <h3 class="title"><?= $fetch_content['title']; ?></h3>
      <div class="info">
         <p><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></p>
         <p><i class="fas fa-heart"></i><span><?= $total_likes; ?> likes</span></p>
      </div>
      <div class="tutor">
         <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['fname']; ?></h3>
            <span><?= $fetch_tutor['lname']; ?></span>
         </div>
      </div>
      <form action="" method="post" class="flex">
         <input type="hidden" name="content_id" value="<?= $content_id; ?>">
         <a href="playlist.php?get_id=<?= $fetch_content['cid']; ?>" class="inline-btn">view playlist</a>
         <?php
            // Check if user liked the content
            if($verify_likes->get_result()->num_rows > 0){
         ?>
         <button type="submit" name="like_content"> <i class="fas fa-heart"></i><span>liked</span></button>
         <?php
         }else{
         ?>
         <button type="submit" name="like_content"><i class="far fa-heart"></i><span>like</span></button>
         <?php
            }
         ?>
      </form>
      <div class="description"><p><?= $fetch_content['description']; ?></p></div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no videos added yet!</p>';
   }
   ?>
</section>
<!-- Watch video section ends -->


<!-- Comments section starts  -->
<section class="comments">
   <!-- Add a comment -->
   <h1 class="heading">Add a comment</h1>
   <form action="" method="post" class="add-comment">
      <input type="hidden" name="content_id" value="<?= $get_id; ?>">
      <textarea name="comment_box" required placeholder="Write your comment..." maxlength="1000" cols="30" rows="10"></textarea>
      <input type="submit" value="Add comment" name="add_comment" class="inline-btn">
   </form>

   <!-- Display user comments -->
   <h1 class="heading">User comments</h1>
   <div class="show-comments">
      <?php
      $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ?");
      $select_comments->bind_param("s", $get_id);
      $select_comments->execute();
      $result = $select_comments->get_result();
      if($result->num_rows > 0){
         while($fetch_comment = $result->fetch_assoc()){   
            $select_commentor = $conn->prepare("SELECT * FROM `Users` WHERE sid = ?");
            $select_commentor->bind_param("s", $fetch_comment['user_id']);
            $select_commentor->execute();
            $fetch_commentor = $select_commentor->get_result()->fetch_assoc();
      ?>
      <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
         <div class="user">
            <img src="../uploads/<?= $fetch_commentor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_commentor['fname']." ".$fetch_commentor['lname']; ?></h3>
               <span><?= $fetch_comment['date']; ?></span>
            </div>
         </div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <?php
            if($fetch_comment['user_id'] == $user_id){ 
         ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">Edit comment</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete this comment?');">Delete comment</button>
         </form>
         <?php
         }
         ?>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">No comments added yet!</p>';
      }
      ?>
   </div>
</section>
<!-- Comments section ends -->

<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
