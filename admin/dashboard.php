<?php
include '../actions/dashboard_display_action.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../functions/admin_header_fxn.php'; ?>

<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Welcome!</h3>
         <!-- Fetch and display user's name -->
         <b style="font-weight: bold; color: black;"><p><?= $user_name ?></p></b>
         <a href="profile.php" class="btn">View Profile</a>
      </div>

      <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>Total Contents</p>
         <a href="add_content.php" class="btn">Add New Content</a>
      </div>

      <div class="box">
         <h3><?= $total_courses; ?></h3>
         <p>Total Courses</p>
         <a href="add_course.php" class="btn">Add New Courses</a>
      </div>

      <div class="box">
         <h3><?= $total_likes; ?></h3>
         <p>Total Likes</p>
         <a href="contents.php" class="btn">View Contents</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>Total Comments</p>
         <a href="comments.php" class="btn">View Comments</a>
      </div>

      <div class="box">
         <h3><?= $total_q; ?></h3>
         <p>Total Quizzes</p>
         <a href="comments.php" class="btn">View Quizes</a>
      </div>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
