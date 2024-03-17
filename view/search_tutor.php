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

<section class="teachers">

   <h1 class="heading">expert tutors</h1>

   <form action="" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="search tutor..." required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <?php
         if(isset($_POST['search_tutor']) or isset($_POST['search_tutor_btn'])){
            $search_tutor = $_POST['search_tutor'];
            $select_tutors = $conn->prepare("SELECT * FROM Users WHERE fname LIKE ? OR lname LIKE ?");
            $search_string = "%{$search_tutor}%";
            $select_tutors->bind_param("ss", $search_string, $search_string);
            $select_tutors->execute();
            $result_tutors = $select_tutors->get_result();
            if($result_tutors->num_rows > 0){
               while($fetch_tutor = $result_tutors->fetch_assoc()){

                  $tutor_id = $fetch_tutor['id'];

                  $count_playlists = $conn->prepare("SELECT * FROM Course WHERE tutor_id = ?");
                  $count_playlists->bind_param("i", $tutor_id);
                  $count_playlists->execute();
                  $result_playlists = $count_playlists->get_result();
                  $total_playlists = $result_playlists->num_rows;

                  $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
                  $count_contents->bind_param("i", $tutor_id);
                  $count_contents->execute();
                  $result_contents = $count_contents->get_result();
                  $total_contents = $result_contents->num_rows;

                  $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
                  $count_likes->bind_param("i", $tutor_id);
                  $count_likes->execute();
                  $result_likes = $count_likes->get_result();
                  $total_likes = $result_likes->num_rows;

                  $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
                  $count_comments->bind_param("i", $tutor_id);
                  $count_comments->execute();
                  $result_comments = $count_comments->get_result();
                  $total_comments = $result_comments->num_rows;
      ?>
      <div class="box">
         <div class="tutor">
            <img src="../uploads/<?= $fetch_tutor['image']; ?>" alt="">
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
               echo '<p class="empty">No results found!</p>';
            }
         }else{
            echo '<p class="empty">Please search something!</p>';
         }
      ?>

   </div>

</section>

<!-- teachers section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
