<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cabin:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Russo+One&family=Yellowtail&display=swap" rel="stylesheet">
   <title>Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/css/style.css">

</head>
<body>

<header class="header">
   
   <section class="flex">

      <a href="/view/home.html" class="logo">Learnify</a>

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
         <a href="/view/profile.html" class="btn">View Profile</a>
         <div class="flex-btn">
            <a href="/view/login.html" class="option-btn">Log in</a>
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
      <p class="role">student</p>
      <a href="/view/profile.html" class="btn">View Profile</a>
   </div>

   <nav class="navbar">
      <a href="/view/home.html"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="/view/about.html"><i class="fas fa-question"></i><span>About</span></a>
      <a href="/view/courses.html"><i class="fas fa-book"></i><span>Courses</span></a>
      <a href="/view/quizpage.html"><i class="fas fa-chalkboard-user"></i><span>Quizzes</span></a>
      <a href="/view/discussions.html"><i class="fas fa-envelope"></i></i><span>Discussion</span></a>
   </nav>

</div>

<section class="user-profile">

   <h1 class="heading">your profile</h1>

   <div class="info">

      <div class="user">
         <img src="/images/stud1.jpg" alt="">
         <h3>Abena Otoo</h3>
         <p>student</p>
         <a href="/view/update.html" class="inline-btn">Update profile</a>
      </div>
   
      <div class="box-container">
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-check-circle"></i>
               <div>
                  <span>15</span>
                  <p>Completed Courses</p>
               </div>
            </div>
            <a href="/view/courses.html" class="inline-btn">Courses</a>
         </div>
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <span>12</span>
                  <p>Discussions started</p>
               </div>
            </div>
            <a href="/view/discussions.html" class="inline-btn">View discussions</a>
         </div>
   
      </div>
   </div>

</section>














<footer class="footer">
   &copy; copyright @ 2024 by <span>Learnify</span>
</footer>

<!-- custom js file link  -->
<script src="/js/script.js"></script>

   
</body>
</html>