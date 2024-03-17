<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

if(isset($_POST['remove'])){

   if($user_id != ''){
      $content_id = $_POST['content_id'];
      $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

      $verify_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
      $verify_likes->bind_param("ss", $user_id, $content_id);
      $verify_likes->execute();
      $result_likes = $verify_likes->get_result();

      if($result_likes->num_rows > 0){
         $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
         $remove_likes->bind_param("ss", $user_id, $content_id);
         $remove_likes->execute();
         $message[] = 'removed from likes!';
      }
   }else{
      $message[] = 'please try again later!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>liked videos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>

<!-- courses section starts  -->

<section class="liked-videos">

   <h1 class="heading">liked videos</h1>

   <div class="box-container">

   <?php
      $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
      $select_likes->bind_param("s", $user_id);
      $select_likes->execute();
      $result_likes = $select_likes->get_result();
      if($result_likes->num_rows > 0){
         while($fetch_likes = $result_likes->fetch_assoc()){

            $select_contents = $conn->prepare("SELECT * FROM `content` WHERE id = ? ORDER BY date DESC");
            $select_contents->bind_param("i", $fetch_likes['content_id']);
            $select_contents->execute();
            $result_contents = $select_contents->get_result();

            if($result_contents->num_rows > 0){
               while($fetch_contents = $result_contents->fetch_assoc()){

               $select_tutors = $conn->prepare("SELECT * FROM `Users` WHERE cid = ?");
               $select_tutors->bind_param("i", $fetch_contents['cid']);
               $select_tutors->execute();
               $fetch_tutor = $select_tutors->get_result()->fetch_assoc();
   ?>
   <div class="box">
      <div class="tutor">
         <img src="uploads/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_contents['date']; ?></span>
         </div>
      </div>
      <img src="uploads/<?= $fetch_contents['thumb']; ?>" alt="" class="thumb">
      <h3 class="title"><?= $fetch_contents['title']; ?></h3>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="content_id" value="<?= $fetch_contents['id']; ?>">
         <a href="watch_video.php?get_id=<?= $fetch_contents['id']; ?>" class="inline-btn">watch video</a>
         <input type="submit" value="remove" class="inline-delete-btn" name="remove">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p class="emtpy">content was not found!</p>';         
         }
      }
   }else{
      echo '<p class="empty">nothing added to likes yet!</p>';
   }
   ?>

   </div>

</section>


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
