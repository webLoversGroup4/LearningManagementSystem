<?php

include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
}else{
   $tutor_id = '';
   header('location: ../login/login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:course.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Playlist Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../functions/admin_header_fxn.php'; ?>
   
<section class="playlist-details">

   <h1 class="heading">playlist details</h1>

   <?php
      $select_playlist_stmt = $conn->prepare("SELECT * FROM Course WHERE CourseID = ? AND InstructorID = ?");
      $select_playlist_stmt->bind_param("ss", $get_id, $tutor_id);
      $select_playlist_stmt->execute();
      $result = $select_playlist_stmt->get_result();
      if($result->num_rows > 0){
         while($fetch_playlist = $result->fetch_assoc()){
            $playlist_id = $fetch_playlist['CourseID'];
            $count_videos_stmt = $conn->prepare("SELECT * FROM content WHERE cid = ?");
            $count_videos_stmt->bind_param("s", $playlist_id);
            $count_videos_stmt->execute();
            $total_videos_result = $count_videos_stmt->get_result();
            $total_videos = $total_videos_result->num_rows;
   ?>
   <div class="row">
      <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="../uploads/<?= $fetch_playlist['image']; ?>" alt="">
      </div>
      <div class="details">
         <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         <div class="description"><?= $fetch_playlist['description']; ?></div>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no playlist found!</p>';
      }
   ?>

</section>

<section class="contents">

   <h1 class="heading">playlist videos</h1>

   <div class="box-container">

   <?php
      $select_videos_stmt = $conn->prepare("SELECT * FROM content WHERE tutor_id = ? AND cid = ?");
      $select_videos_stmt->bind_param("ss", $tutor_id, $playlist_id);
      $select_videos_stmt->execute();
      $videos_result = $select_videos_stmt->get_result();
      if($videos_result->num_rows > 0){
         while($fecth_videos = $videos_result->fetch_assoc()){ 
            $video_id = $fecth_videos['id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fecth_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fecth_videos['date']; ?></span></div>
         </div>
         <img src="../uploads/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fecth_videos['title']; ?></h3>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">watch video</a>
      </div>
   <?php
         }
      }else{
         echo '<p class="empty">no videos added yet! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
