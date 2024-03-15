<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/css/style.css">

</head>
<body>

<header class="header">
   
   <section class="flex">

      <a href="/view/home.html" class="logo">Learnfy.</a>

      <form action="search.html" method="post" class="search-form">
         <input type="text" name="search_box" required placeholder="search courses..." maxlength="100">
         <button type="submit" class="fas fa-search"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <img src="/images/stud1.jpg" class="image" alt="">
         <h3 class="name">Abena Otoo</h3>
         <p class="role">Student</p>
         <a href="/view/profile.html" class="btn">view profile</a>
         <div class="flex-btn">
            <a href="/view/login.html" class="option-btn">Log In</a>
            <a href="/view/register.html" class="option-btn">Register</a>
         </div>
      </div>

   </section>

</header>   

<div class="side-bar">

   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <img src="/images/stud1.jpg" class="image" alt="">
      <h3 class="name">Abena Otoo</h3>
      <p class="role">Student</p>
      <a href="/view/profile.html" class="btn">View Profile</a>
   </div>

   <nav class="navbar">
      <a href="/view/home.html"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="/view/about.html"><i class="fas fa-question"></i><span>About</span></a>
      <a href="/view/courses.html"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
      <a href="/view/quizpage.html"><i class="fas fa-chalkboard-user"></i><span>Quizzes</span></a>
      <a href="/view/discussions.html"><i class="fas fa-envelope"></i><span>Discussion</span></a>
   </nav>

</div>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Update Profile</h3>
      <p>Update Name</p>
      <input type="text" name="name" placeholder="Adwoa A" maxlength="50" class="box">
      <p>Update Email</p>
      <input type="email" name="email" placeholder="shaikh@gmail.com" maxlength="50" class="box">
      <p>Previous Password</p>
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20" class="box">
      <p>New Password</p>
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20" class="box">
      <p>Confirm Password</p>
      <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="20" class="box">
      <p>Update Picture</p>
      <input type="file" accept="image/*" class="box">
      <input type="submit" value="update profile" name="submit" class="btn">
   </form>

</section>















<footer class="footer">

   &copy; copyright @ 2024 by <span>Learnify</span>

</footer>

<!-- custom js file link  -->
<script src="/js/script.js"></script>

   
</body>
</html>