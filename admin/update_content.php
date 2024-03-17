<?php

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
}else{
   $tutor_id = '';
   header('location:../login/login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
}

if(isset($_POST['update'])){

   $video_id = $_POST['video_id'];
   $video_id = filter_var($video_id, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $playlist = $_POST['playlist'];
   $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

   $update_content_stmt = $conn->prepare("UPDATE `content` SET title = ?, description = ?, status = ? WHERE id = ?");
   $update_content_stmt->bind_param("ssss", $title, $description, $status, $video_id);
   $update_content_stmt->execute();

   if(!empty($playlist)){
      $update_playlist_stmt = $conn->prepare("UPDATE `content` SET cid = ? WHERE id = ?");
      $update_playlist_stmt->bind_param("ss", $playlist, $video_id);
      $update_playlist_stmt->execute();
   }

   $old_thumb = $_POST['old_thumb'];
   $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
   $thumb = $_FILES['thumb']['name'];
   $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = unique_id().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploads/'.$rename_thumb;

   if(!empty($thumb)){
      if($thumb_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_thumb_stmt = $conn->prepare("UPDATE `content` SET thumb = ? WHERE id = ?");
         $update_thumb_stmt->bind_param("ss", $rename_thumb, $video_id);
         $update_thumb_stmt->execute();
         move_uploaded_file($thumb_tmp_name, $thumb_folder);
         if($old_thumb != '' AND $old_thumb != $rename_thumb){
            unlink('../uploads/'.$old_thumb);
         }
      }
   }

   $old_video = $_POST['old_video'];
   $old_video = filter_var($old_video, FILTER_SANITIZE_STRING);
   $video = $_FILES['video']['name'];
   $video = filter_var($video, FILTER_SANITIZE_STRING);
   $video_ext = pathinfo($video, PATHINFO_EXTENSION);
   $rename_video = unique_id().'.'.$video_ext;
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../uploads/'.$rename_video;

   if(!empty($video)){
      $update_video_stmt = $conn->prepare("UPDATE `content` SET video = ? WHERE id = ?");
      $update_video_stmt->bind_param("ss", $rename_video, $video_id);
      $update_video_stmt->execute();
      move_uploaded_file($video_tmp_name, $video_folder);
      if($old_video != '' AND $old_video != $rename_video){
         unlink('../uploads/'.$old_video);
      }
   }

   $message[] = 'content updated!';

}

if(isset($_POST['delete_video'])){

   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $delete_video_thumb_stmt = $conn->prepare("SELECT thumb, video FROM `content` WHERE id = ? LIMIT 1");
   $delete_video_thumb_stmt->bind_param("s", $delete_id);
   $delete_video_thumb_stmt->execute();
   $result = $delete_video_thumb_stmt->get_result();
   if($result->num_rows > 0) {
      $fetch_data = $result->fetch_assoc();
      unlink('../uploads/'.$fetch_data['thumb']);
      unlink('../uploads/'.$fetch_data['video']);

      $delete_likes_stmt = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
      $delete_likes_stmt->bind_param("s", $delete_id);
      $delete_likes_stmt->execute();

      $delete_comments_stmt = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
      $delete_comments_stmt->bind_param("s", $delete_id);
      $delete_comments_stmt->execute();

      $delete_content_stmt = $conn->prepare("DELETE FROM `content` WHERE id = ?");
      $delete_content_stmt->bind_param("s", $delete_id);
      $delete_content_stmt->execute();
      header('location:contents.php');
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update video</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

 <?php include '../functions/admin_header_fxn.php'; ?>
   
<section class="video-form">

   <h1 class="heading">update content</h1>

   <?php
      $select_videos_stmt = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND tutor_id = ?");
      $select_videos_stmt->bind_param("ss", $get_id, $tutor_id);
      $select_videos_stmt->execute();
      $videos_result = $select_videos_stmt->get_result();
      if($videos_result->num_rows > 0){
         while($fecth_videos = $videos_result->fetch_assoc()){ 
            $video_id = $fecth_videos['id'];
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="video_id" value="<?= $fecth_videos['id']; ?>">
      <input type="hidden" name="old_thumb" value="<?= $fecth_videos['thumb']; ?>">
      <input type="hidden" name="old_video" value="<?= $fecth_videos['video']; ?>">
      <p>update status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="<?= $fecth_videos['status']; ?>" selected><?= $fecth_videos['status']; ?></option>
         <option value="active">active</option>
         <option value="deactive">deactive</option>
      </select>
      <p>update title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter video title" class="box" value="<?= $fecth_videos['title']; ?>">
      <p>update description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10"><?= $fecth_videos['description']; ?></textarea>
      <p>update playlist</p>
      <select name="playlist" class="box">
         <option value="<?= $fecth_videos['playlist_id']; ?>" selected>--select playlist</option>
         <?php
         $select_playlists_stmt = $conn->prepare("SELECT * FROM Course WHERE InstructorID = ?");
         $select_playlists_stmt->bind_param("s", $tutor_id);
         $select_playlists_stmt->execute();
         $playlists_result = $select_playlists_stmt->get_result();
         if($playlists_result->num_rows > 0){
            while($fetch_playlist = $playlists_result->fetch_assoc()){
         ?>
         <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['CourseName']; ?></option>
         <?php
            }
         ?>
         <?php
         }else{
            echo '<option value="" disabled>no Video playlist created yet!</option>';
         }
         ?>
      </select>
      <img src="../uploads/<?= $fecth_videos['thumb']; ?>" alt="">
      <p>update thumbnail</p>
      <input type="file" name="thumb" accept="image/*" class="box">
      <video src="../uploads/<?= $fecth_videos['video']; ?>" controls></video>
      <p>update video</p>
      <input type="file" name="video" accept="video/*" class="box">
      <input type="submit" value="update content" name="update" class="btn">
      <div class="flex-btn">
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="option-btn">view content</a>
         <input type="submit" value="delete content" name="delete_video" class="delete-btn">
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">video not found! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
