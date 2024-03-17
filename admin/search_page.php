<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
}else{
   $tutor_id = '';
   header('location: ../login/login.php');
}

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_video_stmt = $conn->prepare("SELECT * FROM content WHERE id = ? LIMIT 1");
   $verify_video_stmt->bind_param("s", $delete_id);
   $verify_video_stmt->execute();
   $verify_video_result = $verify_video_stmt->get_result();

   if($verify_video_result->num_rows > 0){
      $fetch_thumb_stmt = $conn->prepare("SELECT thumb, video FROM content WHERE id = ? LIMIT 1");
      $fetch_thumb_stmt->bind_param("s", $delete_id);
      $fetch_thumb_stmt->execute();
      $fetch_thumb_result = $fetch_thumb_stmt->get_result();
      $fetch_thumb = $fetch_thumb_result->fetch_assoc();
      unlink('../uploads/'.$fetch_thumb['thumb']);
      unlink('../uploads/'.$fetch_thumb['video']);

      $delete_likes_stmt = $conn->prepare("DELETE FROM likes WHERE content_id = ?");
      $delete_likes_stmt->bind_param("s", $delete_id);
      $delete_likes_stmt->execute();

      $delete_comments_stmt = $conn->prepare("DELETE FROM comments WHERE content_id = ?");
      $delete_comments_stmt->bind_param("s", $delete_id);
      $delete_comments_stmt->execute();

      $delete_content_stmt = $conn->prepare("DELETE FROM content WHERE id = ?");
      $delete_content_stmt->bind_param("s", $delete_id);
      $delete_content_stmt->execute();

      $message[] = 'Video deleted!';
   }else{
      $message[] = 'Video already deleted!';
   }
}

if(isset($_POST['delete_playlist'])){
   $delete_id = $_POST['playlist_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_playlist_stmt = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ? LIMIT 1");
   $verify_playlist_stmt->bind_param("ss", $delete_id, $tutor_id);
   $verify_playlist_stmt->execute();
   $verify_playlist_result = $verify_playlist_stmt->get_result();

   if($verify_playlist_result->num_rows > 0){
      $fetch_thumb_stmt = $conn->prepare("SELECT thumb FROM Course WHERE CourseID = ? LIMIT 1");
      $fetch_thumb_stmt->bind_param("s", $delete_id);
      $fetch_thumb_stmt->execute();
      $fetch_thumb_result = $fetch_thumb_stmt->get_result();
      $fetch_thumb = $fetch_thumb_result->fetch_assoc();
      unlink('../uploads/'.$fetch_thumb['thumb']);

      $delete_bookmark_stmt = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
      $delete_bookmark_stmt->bind_param("s", $delete_id);
      $delete_bookmark_stmt->execute();

      $delete_playlist_stmt = $conn->prepare("DELETE FROM Course WHERE CourseID  = ?");
      $delete_playlist_stmt->bind_param("s", $delete_id);
      $delete_playlist_stmt->execute();

      $message[] = 'Playlist deleted!';
   }else{
      $message[] = 'Playlist already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../functions/admin_header_fxn.php'; ?>
   
<section class="contents">

   <h1 class="heading">contents</h1>

   <div class="box-container">

   <?php
      if(isset($_POST['search']) or isset($_POST['search_btn'])){
      $search = $_POST['search'];
      $select_videos_stmt = $conn->prepare("SELECT * FROM `content` WHERE title LIKE CONCAT('%',?,'%') AND tutor_id = ? ORDER BY date DESC");
      $select_videos_stmt->bind_param("ss", $search, $tutor_id);
      $select_videos_stmt->execute();
      $select_videos_result = $select_videos_stmt->get_result();
      if($select_videos_result->num_rows > 0){
         while($fecth_videos = $select_videos_result->fetch_assoc()){ 
            $video_id = $fecth_videos['id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fecth_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fecth_videos['date']; ?></span></div>
         </div>
         <img src="../uploads/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fecth_videos['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </form>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a>
      </div>
   <?php
         }
      }else{
         echo '<p class="empty">no contents founds!</p>';
      }
   }else{
      echo '<p class="empty">please search something!</p>';
   }
   ?>

   </div>

</section>

<section class="playlists">

   <h1 class="heading">playlists</h1>

   <div class="box-container">
   
      <?php
      if(isset($_POST['search']) or isset($_POST['search_btn'])){
         $search = $_POST['search'];
         $select_playlist_stmt = $conn->prepare("SELECT * FROM Course WHERE CourseName LIKE CONCAT('%',?,'%') AND InstructorID = ? ORDER BY date DESC");
         $select_playlist_stmt->bind_param("ss", $search, $tutor_id);
         $select_playlist_stmt->execute();
         $select_playlist_result = $select_playlist_stmt->get_result();
         if($select_playlist_result->num_rows > 0){
            while($fetch_playlist = $select_playlist_result->fetch_assoc()){
               $playlist_id = $fetch_playlist['id'];
               $count_videos_stmt = $conn->prepare("SELECT * FROM content WHERE playlist_id = ?");
               $count_videos_stmt->bind_param("s", $playlist_id);
               $count_videos_stmt->execute();
               $count_videos_result = $count_videos_stmt->get_result();
               $total_videos = $count_videos_result->num_rows;
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-circle-dot" style="<?php if($fetch_playlist['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_playlist['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_playlist['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         </div>
         <div class="thumb">
            <span><?= $total_videos; ?></span>
            <img src="../uploads/<?= $fetch_playlist['thumb']; ?>" alt="">
         </div>
         <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
         <p class="description"><?= $fetch_playlist['description']; ?></p>
         <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">view playlist</a>
      </div>
      <?php
         } 
      }else{
         echo '<p class="empty">no playlists found!</p>';
      }}else{
         echo '<p class="empty">please search something!</p>';
      }
      ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>
