<?php
include '../settings/connection.php';

$tutor_id = $_COOKIE['user_id'];
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
      <a href="dashboard.php" class="logo">Admin.</a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="Search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
            $select_profile_stmt->bind_param("s", $tutor_id);
            $select_profile_stmt->execute();
            $select_profile_result = $select_profile_stmt->get_result();
            if($select_profile_result->num_rows > 0){
               $fetch_profile = $select_profile_result->fetch_assoc();
         ?>
         <img src="../uploads/<?= $fetch_profile['image']; ?>" alt="image.png">
         <h3><?= $fetch_profile['fname']; ?></h3>
         <span><?= $fetch_profile['lname']; ?></span>
         <a href="profile.php" class="btn">View Profile</a>
         <?php
            }else{
         ?>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- Header section ends -->

<!-- Side bar section starts  -->

<div class="side-bar">
   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

         <div class="profile">
         <?php
            $select_profile_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ?");
            $select_profile_stmt->bind_param("s", $tutor_id);
            $select_profile_stmt->execute();
            $select_profile_result = $select_profile_stmt->get_result();
            if($select_profile_result->num_rows > 0){
               $fetch_profile = $select_profile_result->fetch_assoc();
         ?>
         <img src="../uploads/<?= $fetch_profile['image']; ?>" alt="image.png">
         <h3><?= $fetch_profile['fname']; ?></h3>
         <span><?= $fetch_profile['lname']; ?></span>
         <?php
            }else{
         ?>
         <?php
            }
         ?>
      </div>


   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="courses.php"><i class="fa-solid fa-bars-staggered"></i><span>Courses</span></a>
      <a href="contents.php"><i class="fas fa-graduation-cap"></i><span>Contents</span></a>
      <a href="comments.php"><i class="fas fa-comment"></i><span>Comments</span></a>
      <a href="../login/logout.php" onclick="return confirm('Logout from Learnfy?');"><i class="fas fa-right-from-bracket"></i><span>Logout</span></a>
   </nav>

</div>

<!-- Side bar section ends -->
