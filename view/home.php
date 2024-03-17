<?php

include '../settings/connection.php';

// Check if user_id is set in cookies
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

// Prepare and execute query to get total likes
$select_likes_stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
$select_likes_stmt->bind_param("s", $user_id);
$select_likes_stmt->execute();
$select_likes_result = $select_likes_stmt->get_result();
$total_likes = $select_likes_result->num_rows;

// Prepare and execute query to get total comments
$select_comments_stmt = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
$select_comments_stmt->bind_param("s", $user_id);
$select_comments_stmt->execute();
$select_comments_result = $select_comments_stmt->get_result();
$total_comments = $select_comments_result->num_rows;

// Prepare and execute query to get total bookmarked items
$select_bookmark_stmt = $conn->prepare("SELECT * FROM bookmark WHERE user_id = ?");
$select_bookmark_stmt->bind_param("s", $user_id);
$select_bookmark_stmt->execute();
$select_bookmark_result = $select_bookmark_stmt->get_result();
$total_bookmarked = $select_bookmark_result->num_rows;

?>


<!DOCTYPE html>
<html lang="en">
<head>

   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Learnify - Home</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <!-- Link to favicon  -->
   <link rel="icon" sizes="180x180" href="../images/learnfy.ico">
   <link rel="icon" type="image/png" sizes="32x32" href="../images/learnfy.ico">
   <link rel="icon" type="image/png" sizes="16x16" href="../images/learnfy.ico">
   <link rel="manifest" href="/site.webmanifest">
</head>

<body>
<?php include '../functions/user_header_fxn.php'; ?>


<section class="quick-select">

   <h1 class="heading">Quick Options</h1>

   <div class="box-container">

            <div class="box">
         <h3 class="title">likes and comments</h3>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">view likes</a>
         <p>total comments : <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">view comments</a>
         <p>enrolled course playlist : <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">view enrolled courses</a>
      </div>

      <div class="box">

         <h3 class="title">Test Yourself</h3>
         <p class="description">Track your progress by taking quizzes. Stay motivated!</p>
         <a href="../view/quizpage.php" class="inline-btn">Track Progress</a>
      </div>


      <div class="box">
         <h3 class="title">Explore Courses</h3>
         <p class="description">Enroll in Courses and be able to learn from experts in various fields.</p>
         <a href="courses.php" class="inline-btn">Explore Courses</a>
      </div>

   </div>

</section>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">latest courses</h1>

   <div class="box-container">

      <?php
         $select_courses_stmt = $conn->prepare("SELECT * FROM Course WHERE cstatus = ? ORDER BY date DESC LIMIT 6");
         $status = 'active';
         $select_courses_stmt->bind_param("s", $status);
         $select_courses_stmt->execute();
         $select_courses_result = $select_courses_stmt->get_result();
         if($select_courses_result->num_rows > 0){
            while($fetch_course = $select_courses_result->fetch_assoc()){
               $course_id = $fetch_course['CourseID'];

               $select_tutor_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
               $select_tutor_stmt->bind_param("s", $fetch_course['InstructorID']);
               $select_tutor_stmt->execute();
               $select_tutor_result = $select_tutor_stmt->get_result();
               $fetch_tutor = $select_tutor_result->fetch_assoc();
      ?>
      <div class="box">
         <div class="tutor">
            <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['fname']." ".$fetch_tutor['lname']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <div class="thumb">
         <img src="../uploads/<?= $fetch_course['image']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['CourseName']; ?></h3>
         </div>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view course playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">view more</a>
   </div>

</section>

   <script src="../js/script.js"></script>

</body>

      
