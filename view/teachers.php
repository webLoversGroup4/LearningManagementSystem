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
   <title>teachers</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../functions/user_header_fxn.php'; ?>

<!-- teachers section starts  -->

<section class="teachers">

   <h1 class="heading">expert tutors</h1>

   <form action="search_tutor.php" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="search tutor..." required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">
      <?php
         $select_tutors = $conn->query("SELECT * FROM Users");
         if($select_tutors->num_rows > 0){
            while($fetch_tutor = $select_tutors->fetch_assoc()){

               $tutor_id = $fetch_tutor['id'];

               $count_playlists = $conn->query("SELECT * FROM Course WHERE InstructorID = '$tutor_id'");
               $total_playlists = $count_playlists->num_rows;

               $count_contents = $conn->query("SELECT * FROM `content` WHERE tutor_id = '$tutor_id'");
               $total_contents = $count_contents->num_rows;

               $count_likes = $conn->query("SELECT * FROM `likes` WHERE tutor_id = '$tutor_id'");
               $total_likes = $count_likes->num_rows;

               $count_comments = $conn->query("SELECT * FROM `comments` WHERE tutor_id = '$tutor_id'");
               $total_comments = $count_comments->num_rows;
      ?>
      <div class="box">
         <div class="tutor">
            <img src="../uploads/<?=$fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['fname']; ?></h3>
               <span><?= $fetch_tutor['lname']; ?></span>
            </div>
         </div>
         <p>playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents ?></span></p>
         <p>total likes : <span><?= $total_likes ?></span></p>
         <p>total comments : <span><?= $total_comments ?></span></p>
         <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" value="view profile" name="tutor_fetch" class="inline-btn">
         </form>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">no tutors found!</p>';
         }
      ?>

   </div>

</section>

<!-- teachers section ends -->
   

<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
