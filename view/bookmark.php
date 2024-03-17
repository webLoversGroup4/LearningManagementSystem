<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Enrolled Courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include '../functions/user_header_fxn.php'; ?>
<section class="courses">

   <h1 class="heading">Enrolled Course playlists</h1>

   <div class="box-container">

      <?php
         $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
         $select_bookmark->bind_param("i", $user_id);
         $select_bookmark->execute();
         $result_bookmark = $select_bookmark->get_result();
         if($result_bookmark->num_rows > 0){
            while($fetch_bookmark = $result_bookmark->fetch_assoc()){
               $select_courses = $conn->prepare("SELECT * FROM `Course` WHERE CourseID = ? AND cstatus = ? ORDER BY date DESC");
               $select_courses->bind_param("is", $fetch_bookmark['playlist_id'], 'active');
               $select_courses->execute();
               $result_courses = $select_courses->get_result();
               if($result_courses->num_rows > 0){
                  while($fetch_course = $result_courses->fetch_assoc()){

                     $course_id = $fetch_course['id'];

                     $select_tutor = $conn->prepare("SELECT * FROM `Users` WHERE sid = ?");
                     $select_tutor->bind_param("i", $fetch_course['tutor_id']);
                     $select_tutor->execute();
                     $fetch_tutor = $select_tutor->get_result()->fetch_assoc();
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploads/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploads/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view course playlist</a>
      </div>
      <?php
                  }
               }else{
                  echo '<p class="empty">no courses found!</p>';
               }
            }
         }else{
            echo '<p class="empty">nothing bookmarked yet!</p>';
         }
      ?>

   </div>

</section>


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
