<?php

include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">all courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM Course WHERE cstatus = ? ORDER BY date DESC");
         $status = 'active';
         $select_courses->bind_param("s", $status);
         $select_courses->execute();
         $result_courses = $select_courses->get_result();
         if($result_courses->num_rows > 0){
            while($fetch_course = $result_courses->fetch_assoc()){
               $course_id = $fetch_course['CourseID'];

               $select_tutor = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
               $select_tutor->bind_param("s", $fetch_course['InstructorID']);
               $select_tutor->execute();
               $fetch_tutor = $select_tutor->get_result()->fetch_assoc();
      ?>
      <div class="box">
         <div class="tutor">
            <div class="thumb">
            <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt=""></div>
            <div>
               <h3><?= $fetch_tutor['fname']." ".$fetch_tutor['lname']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <div class="thumb">
         <img src="../uploads/<?= $fetch_course['image']; ?>" class="thumb" alt="">
         </div>
         <h3 class="title"><?= $fetch_course['CourseName']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view course playlist</a>
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
