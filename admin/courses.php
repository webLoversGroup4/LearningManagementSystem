<?php
include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
} else {
   header('location:../login/login.php');
   exit(); 
}

// Handle deletion of playlist
if(isset($_POST['delete'])){
   $delete_id = filter_input(INPUT_POST, 'playlist_id', FILTER_SANITIZE_STRING);
   $verify_playlist_stmt = $conn->prepare("SELECT image FROM Course WHERE CourseID = ? AND InstructorID = ? LIMIT 1");
   $verify_playlist_stmt->bind_param("ss", $delete_id, $tutor_id);
   $verify_playlist_stmt->execute();
   $verify_playlist_result = $verify_playlist_stmt->get_result();

   if($verify_playlist_result->num_rows > 0){
      $fetch_thumb = $verify_playlist_result->fetch_assoc();
      $thumb_path = '../uploads/'.$fetch_thumb['image'];

      // Delete the thumb file associated with the playlist
      if(file_exists($thumb_path)) {
         unlink($thumb_path);
      }

      // Prepare and execute statements to delete the playlist and associated bookmarks
      $delete_bookmark_stmt = $conn->prepare("DELETE FROM bookmark WHERE playlist_id = ?");
      $delete_bookmark_stmt->bind_param("s", $delete_id);
      $delete_bookmark_stmt->execute();

      $delete_playlist_stmt = $conn->prepare("DELETE FROM Course WHERE CourseID = ?");
      $delete_playlist_stmt->bind_param("s", $delete_id);
      $delete_playlist_stmt->execute();

      $message[] = 'Course Playlist Successfully deleted!';
   } else {
      $message[] = 'Course Playlist already deleted!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

 <?php include '../functions/admin_header_fxn.php'; ?>

<section class="playlists">

   <h1 class="heading">Added Course Playlists</h1>

   <div class="box-container">
   
      <div class="box" style="text-align: center;">
         <h3 class="title" style="margin-bottom: .5rem;">Create New Course Playlist</h3>
         <a href="add_course.php" class="btn">Add Course Playlist</a>
      </div>

      <?php
         $select_playlist_stmt = $conn->prepare("SELECT * FROM Course WHERE InstructorID = ? ORDER BY date DESC");
         $select_playlist_stmt->bind_param("s", $tutor_id);
         $select_playlist_stmt->execute();
         $select_playlist_result = $select_playlist_stmt->get_result();
         if($select_playlist_result->num_rows > 0){
            while($fetch_playlist = $select_playlist_result->fetch_assoc()){
               $playlist_id = $fetch_playlist['CourseID'];

               $count_videos_stmt = $conn->prepare("SELECT * FROM content WHERE cid = ?");
               $count_videos_stmt->bind_param("s", $playlist_id);
               $count_videos_stmt->execute();
               $count_videos_result = $count_videos_stmt->get_result();
               $total_videos = $count_videos_result->num_rows;
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-circle-dot" style="<?php echo ($fetch_playlist['cstatus'] == 'active') ? 'color: limegreen' : 'color: red'; ?>"></i><span style="<?php echo ($fetch_playlist['cstatus'] == 'active') ? 'color: limegreen' : 'color: red'; ?>"><?= $fetch_playlist['cstatus']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         </div>
         <div class="thumb">
            <span><?= $total_videos; ?></span>
            <img src="../uploads/<?= $fetch_playlist['image']; ?>" alt="Course Playlist Image">
         </div>
         <h3 class="title"><?= $fetch_playlist['CourseName']; ?></h3>
         <p class="description"><?= $fetch_playlist['Description']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
            <input type="submit" value="Delete" class="delete-btn" onclick="return confirm('Delete this course playlist?');" name="delete">
         </form>
         <a href="view_course.php?get_id=<?= $playlist_id; ?>" class="btn">View Course Playlist</a>
      </div>
      <?php
         } 
      }else{
         echo '<p class="empty">No playlist added yet!</p>';
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
