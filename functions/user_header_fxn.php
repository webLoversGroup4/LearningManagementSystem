<?php
include '../settings/connection.php';

$user_id = $_COOKIE['user_id'];

if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Student.</a>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
            $select_profile->bind_param("s", $user_id);
            $select_profile->execute();
            $result = $select_profile->get_result();
            if($result->num_rows > 0){
               $fetch_profile = $result->fetch_assoc();
         ?>
         <div class="tutor">
         <img src="../uploads/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['fname']." ".$fetch_profile['lname']; ?></h3>
         <span>student</span>
      </div>
         <a href="profile.php" class="btn">view profile</a>
         <a href="../login/logout.php" onclick="return confirm('logout from Learnfy?');" class="delete-btn">logout</a>
         </div>
         <?php
            }else{
         ?>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">
   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
            $select_profile->bind_param("s", $user_id);
            $select_profile->execute();
            $result = $select_profile->get_result();
            if($result->num_rows > 0){
               $fetch_profile = $result->fetch_assoc();
         ?>
         <img src="../uploads/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['fname']." ".$fetch_profile['lname']; ?></h3>
         <span>student</span>
         <?php
            }else{
         ?>
         <?php
            }
         ?>
      </div>


   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="about.php"><i class="fas fa-question"></i><span>about us</span></a>
      <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
      <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
      <a href="quizpage.php"><i class="fas fa-question-circle"></i><span>Quiz</span></a>
   </nav>
</div>

<!-- side bar section ends -->
