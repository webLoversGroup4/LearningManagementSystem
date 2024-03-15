<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Courses</title>
   <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cabin:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Russo+One&family=Yellowtail&display=swap" rel="stylesheet">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/css/style.css">

   <!-- Link to favicon  -->
   <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
   <link rel="manifest" href="/site.webmanifest">
   

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
         <p class="role">student</p>
         <a href="/view/profile.html" class="btn">view profile</a>
         <div class="flex-btn">
            <a href="/view/login.html" class="option-btn">login</a>
            <a href="/view/register.html" class="option-btn">register</a>
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
      <a href="/view/profile.html" class="btn">View profile</a>
   </div>

   <nav class="navbar">
      <a href="/view/home.html"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="/view/about.html"><i class="fas fa-question"></i><span>About</span></a>
      <a href="/view/courses.html"><i class="fas fa-book"></i><span>Courses</span></a>
      <a href="/view/quizpage.html"><i class="fas fa-chalkboard-user"></i><span>Quizzes</span></a>
      <a href="/view/discussions.html"><i class="fas fa-envelope"></i><span>Discussions</span></a>
   </nav>

</div>

<section class="courses">

   <h1 class="heading">Your courses</h1>

   <div class="box-container">

      <div class="box">
         <div class="tutor">
            <img src="/images/man3.jpg" alt="">
            <div class="info">
               <h3>Philip</h3>
               <span>30-08-2024</span>
            </div>
         </div>
         <div class="thumb">
            <img src="/images/thumb-1.png" alt="">
            <span>10 lessons</span>
         </div>
         <h3 class="title">HTML tutorial</h3>
       <!--  <a href="#" class="inline-btn">Enroll</a>-->
      </div> 

      <div class="box">
         <div class="tutor">
            <img src="/images/woman.jpg" alt="">
            <div class="info">
               <h3>Esther</h3>
               <span>15-05-2024</span>
            </div>
         </div>
         <div class="thumb">
            <img src="/images/business com.jpg" alt="">
            <span>10 lessons</span>
         </div>
         <h3 class="title">Communication in Business</h3>
        <!-- <a href="#" class="inline-btn">Enroll</a>--> 
      </div>


      <div class="box">
         <div class="tutor">
            <img src="/images/man2.jpg" alt="">
            <div class="info">
               <h3>Joel</h3>
               <span>21-10-2024</span>
            </div>
         </div>
         <div class="thumb">
            <img src="/images/php.png" alt="">
            <span>10 lessons</span>
         </div>
         <h3 class="title">PHP tutorial</h3>
        <!--<a href="#" class="inline-btn">Enroll</a> --> 
      </div>

      <div class="box">
         <div class="tutor">
            <img src="/images/techman.jpg" alt="">
            <div class="info">
               <h3>Raymond</h3>
               <span>01-09-2024</span>
            </div>
         </div>
         <div class="thumb">
            <img src="/images/sql logo.jpg" alt="">
            <span>10 lessons</span>
         </div>
         <h3 class="title">MySQL tutorial</h3>
         <!--<a href="#" class="inline-btn">Enroll</a>-->
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