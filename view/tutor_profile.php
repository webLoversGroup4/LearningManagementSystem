<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['tutor_fetch'])){

   $tutor_email = $_POST['tutor_email'];
   $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);
   $select_tutor = $conn->prepare('SELECT * FROM Users WHERE email = ?');
   $select_tutor->bind_param('s',$tutor_email);
   $select_tutor->execute();
   $result = $select_tutor->get_result();

   $fetch_tutor = $result->fetch_assoc();
   $tutor_id = $fetch_tutor['sid'];

   $count_playlists = $conn->query("SELECT * FROM Course WHERE InstructorID = '$tutor_id'");
   $total_playlists = $count_playlists->num_rows;

   $count_contents = $conn->query("SELECT * FROM `content` WHERE tutor_id = '$tutor_id'");
   $total_contents = $count_contents->num_rows;

   $count_likes = $conn->query("SELECT * FROM `likes` WHERE tutor_id = '$tutor_id'");
   $total_likes = $count_likes->num_rows;

   $count_comments = $conn->query("SELECT * FROM `comments` WHERE tutor_id = '$tutor_id'");
   $total_comments = $count_comments->num_rows;

}else{
   header('location:teachers.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tutor's profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>

<!-- teachers profile section starts  -->

<section class="tutor-profile">

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="tutor">
         <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt="">
         <h3><?= $fetch_tutor['fname']." ".$fetch_tutor['lname'];; ?></h3>
      </div>
      <div class="flex">
         <p>total playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents; ?></span></p>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <p>total comments : <span><?= $total_comments; ?></span></p>
      </div>
   </div>

</section>

<!-- teachers profile section ends -->

<section class="courses">

   <h1 class="heading">latest courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->query("SELECT * FROM Course WHERE InstructorID = '$tutor_id' AND cstatus = 'active'");
         if($select_courses->num_rows > 0){
            while($fetch_course = $select_courses->fetch_assoc()){
               $course_id = $fetch_course['CourseID'];

               $select_tutor = $conn->query("SELECT * FROM Users WHERE sid = '{$fetch_course['InstructorID']}'");
               $fetch_tutor = $select_tutor->fetch_assoc();
      ?>
      <div class="box">
         <div class="tutor">
            <div>
               <h3><?= $fetch_tutor['fname']." ".$fetch_tutor['lname']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
              </div>
              <div class="thumb">
         <img src="../uploads/<?= $fetch_course['image']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['CourseName']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
         </div>
         </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->

<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
