<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('Location: ../login/login.php');
   exit();
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('Location: home.php');
   exit();
}

$message = []; // Initialize an array to store messages.

if(isset($_POST['save_list'])){
   if($user_id != ''){
      $list_id = $_POST['list_id'];
      $list_id = filter_var($list_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $select_list_stmt = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
      $select_list_stmt->bind_param("ss", $user_id, $list_id);
      $select_list_stmt->execute();
      $select_list_result = $select_list_stmt->get_result();

      if($select_list_result->num_rows > 0){
         $remove_bookmark_stmt = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
         $remove_bookmark_stmt->bind_param("ss", $user_id, $list_id);
         $remove_bookmark_stmt->execute();
         $message[] = 'Course playlist removed!';
      }else{
         $insert_bookmark_stmt = $conn->prepare("INSERT INTO `bookmark`(user_id, playlist_id) VALUES(?,?)");
         $insert_bookmark_stmt->bind_param("ss", $user_id, $list_id);
         $insert_bookmark_stmt->execute();
         $message[] = 'Course playlist enrollment was successful!';
      }
   }else{
      $message[] = 'Please try again later.';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Course playlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>
<!-- playlist section starts  -->

<section class="playlist">

   <h1 class="heading">Course playlist details</h1>

   <div class="row">

      <?php
         $select_playlist_stmt = $conn->prepare("SELECT * FROM Course WHERE CourseID = ? AND cstatus = ? LIMIT 1");
         $select_content_status = 'active';
         $select_playlist_stmt->bind_param("ss", $get_id, $select_content_status);
         $select_playlist_stmt->execute();
         $select_playlist_result = $select_playlist_stmt->get_result();
         if($select_playlist_result->num_rows > 0){
            $fetch_playlist = $select_playlist_result->fetch_assoc();

            $playlist_id = $fetch_playlist['CourseID'];

            $count_videos_stmt = $conn->prepare("SELECT * FROM content WHERE cid = ?");
            $count_videos_stmt->bind_param("s", $playlist_id);
            $count_videos_stmt->execute();
            $count_videos_stmt->store_result(); 
            $total_videos = $count_videos_stmt->num_rows;


            $select_tutor_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ? LIMIT 1");
            $select_tutor_stmt->bind_param("s", $fetch_playlist['InstructorID']);
            $select_tutor_stmt->execute();
            $fetch_tutor = $select_tutor_stmt->get_result()->fetch_assoc();

            $select_bookmark_stmt = $conn->prepare("SELECT * FROM bookmark WHERE user_id = ? AND playlist_id = ?");
            $select_bookmark_stmt->bind_param("ss", $user_id, $playlist_id);
            $select_bookmark_stmt->execute();
            $bookmark_result = $select_bookmark_stmt->get_result();
            $is_bookmarked = $bookmark_result->num_rows > 0;

      ?>

      <div class="col">
         <form action="" method="post" class="save-list">
            <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
            <button type="submit" name="save_list">
               <?php if($is_bookmarked): ?>
                  <i class="fas fa-bookmark"></i><span>Enrolled</span>
               <?php else: ?>
                  <i class="far fa-bookmark"></i><span>Enroll in course playlist</span>
               <?php endif; ?>
            </button>
         </form>
            <span><?= $total_videos; ?> videos</span>
            <div class="thumb">
            <img src="../uploads/<?= $fetch_playlist['thumb']; ?>" alt="">
         </div>
      </div>

      <div class="col">
         <div class="tutor">
            <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['fname']." ".$fetch_tutor['lname']; ?></h3>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_playlist['CourseName']; ?></h3>
            <p><?= $fetch_playlist['Description']; ?></p>
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         </div>
      </div>

      <?php
         }else{
            echo '<p class="empty">This playlist was not found!</p>';
         }  
      ?>

   </div>

</section>

<!-- playlist section ends -->

<!-- videos container section starts  -->

<section class="videos-container">

   <h1 class="heading">Playlist videos</h1>

   <div class="box-container">

      <?php
         $select_content_stmt = $conn->prepare("SELECT * FROM `content` WHERE cid = ? AND status = ? ORDER BY date DESC");
         $select_content_status = 'active';
         $select_content_stmt->bind_param("ss", $get_id, $select_content_status);
         $select_content_stmt->execute();
         $select_content_result = $select_content_stmt->get_result();
         if($select_content_result->num_rows > 0){
            while($fetch_content = $select_content_result->fetch_assoc()){  
      ?>
      <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>" class="box">
         <i class="fas fa-play"></i>
         <img src="../uploads/<?= $fetch_content['thumb']; ?>" alt="">
         <h3><?= $fetch_content['title']; ?></h3>
      </a>
      <?php
            }
         }else{
            echo '<p class="empty">No videos added yet!</p>';
         }
      ?>

   </div>

</section>

<!-- videos container section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
