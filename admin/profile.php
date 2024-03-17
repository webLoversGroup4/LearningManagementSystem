<?php
include '../settings/connection.php';
include '../actions/dashboard_display_action.php';

if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
}else{
   $tutor_id = '';
   header('location: ../login/login.php');
   exit(); 
}


// Prepare and execute statements to get profile details
$select_profile_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
$select_profile_stmt->bind_param("s", $tutor_id);
$select_profile_stmt->execute();
$fetch_profile_result = $select_profile_stmt->get_result();
$fetch_profile = $fetch_profile_result->fetch_assoc();

// Prepare and execute statements to get total playlists
$select_playlists_stmt = $conn->prepare("SELECT * FROM Course WHERE InstructorID = ?");
$select_playlists_stmt->bind_param("s", $tutor_id);
$select_playlists_stmt->execute();
$total_playlists = $select_playlists_stmt->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

 <?php include '../functions/admin_header_fxn.php'; ?>
   
<section class="tutor-profile" style="min-height: calc(100vh - 19rem);"> 

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="tutor">
         <img src="../uploads/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['fname']; ?></h3>
         <span><?= $fetch_profile['lname']; ?></span>
         <a href="update.php" class="inline-btn">update profile</a>
      </div>
      <div class="flex">
         <div class="box">
            <span><?= $total_playlists; ?></span>
            <p>total playlists</p>
            <a href="courses.php" class="btn">view playlists</a>
         </div>
         <div class="box">
            <span><?= $total_contents; ?></span>
            <p>total videos</p>
            <a href="contents.php" class="btn">view contents</a>
         </div>
         <div class="box">
            <span><?= $total_likes; ?></span>
            <p>total likes</p>
            <a href="contents.php" class="btn">view contents</a>
         </div>
         <div class="box">
            <span><?= $total_comments; ?></span>
            <p>total comments</p>
            <a href="comments.php" class="btn">view comments</a>
         </div>
      </div>
   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
