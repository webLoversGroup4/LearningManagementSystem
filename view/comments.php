<?php
include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
   exit; 
}

$message = array(); 

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
   $verify_comment->bind_param("i", $delete_id);
   $verify_comment->execute();
   $verify_comment->store_result(); // Store result set
   $num_rows = $verify_comment->num_rows;

   if($num_rows > 0){
      $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
      $delete_comment->bind_param("i", $delete_id);
      $delete_comment->execute();
      $message[] = 'Comment deleted successfully!';
   } else {
      $message[] = 'Comment already deleted!';
   }
}

if(isset($_POST['update_now'])){

   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ? ORDER BY date DESC");
   $verify_comment->bind_param("is", $update_id, $update_box);
   $verify_comment->execute();
   $verify_comment->store_result(); // Store result set
   $num_rows = $verify_comment->num_rows;

   if($num_rows > 0){
      $message[] = 'Comment already added!';
   } else {
      $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
      $update_comment->bind_param("si", $update_box, $update_id);
      $update_comment->execute();
      $message[] = 'Comment edited successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Comments</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>

<?php
if(isset($_POST['edit_comment'])){
   $edit_id = $_POST['comment_id'];
   $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? LIMIT 1");
   $verify_comment->bind_param("i", $edit_id);
   $verify_comment->execute();
   $verify_comment->store_result(); // Store result set
   $num_rows = $verify_comment->num_rows;

   if($num_rows > 0){
      $fetch_edit_comment = $verify_comment->get_result()->fetch_assoc();
?>
<section class="edit-comment">
   <h1 class="heading">Edit Comment</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
      <textarea name="update_box" class="box" maxlength="1000" required placeholder="Please enter your comment" cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
      <div class="flex">
         <a href="comments.php" class="inline-option-btn">Cancel Edit</a>
         <input type="submit" value="Update Now" name="update_now" class="inline-btn">
      </div>
   </form>
</section>
<?php
   } else {
      $message[] = 'Comment was not found!';
   }
}
?>

<section class="comments">

   <h1 class="heading">Your Comments</h1>

   <div class="show-comments">
      <?php
         $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
         $select_comments->bind_param("i", $user_id);
         $select_comments->execute();
         $result = $select_comments->get_result();
         if($result->num_rows > 0){
            while($fetch_comment = $result->fetch_assoc()){
               $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
               $select_content->bind_param("i", $fetch_comment['content_id']);
               $select_content->execute();
               $fetch_content = $select_content->get_result()->fetch_assoc();
      ?>
      <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
         <div class="content"><span><?= $fetch_comment['date']; ?></span><p> - <?= $fetch_content['title']; ?> - </p><a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>">View Content</a></div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <?php
            if($fetch_comment['user_id'] == $user_id){ 
         ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">Edit Comment</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete this comment?');">Delete Comment</button>
         </form>
         <?php
         }
         ?>
      </div>
      <?php
       }
      } else {
         echo '<p class="empty">No comments added yet!</p>';
      }
      ?>
   </div>
   
</section>

<!-- Comments section ends -->


<!-- Custom JS file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
