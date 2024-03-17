<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Log In</title>
   <link rel="stylesheet" href="../css/loginCSS.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cabin:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Russo+One&family=Yellowtail&display=swap" rel="stylesheet">

<!-- Link to favicon  -->
<link rel="apple-touch-icon" sizes="180x180" href="../images/learnfy.ico">
<link rel="icon" type="image/png" sizes="32x32" href="../images/learnfy.ico">
<link rel="icon" type="image/png" sizes="16x16" href="../images/learnfy.ico">
<link rel="manifest" href="/site.webmanifest">
</head>

<body>
<img style="display: block; margin: 0 auto;" src="../images/learnfy.ico">

   <form action="../actions/login_action.php" method="post" enctype="multipart/form-data">
      <section class="form-container">
      <h1>Log In</h1>
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <input type="password" name="password" placeholder="Enter your password" required maxlength="20" class="box">
      <input type="submit" value="Log In" name="submit" class="button">

      </section>

      <section class="form-container">
      <b>Don't have an account? <a href="register.php">Register</a></b>
      </section>
   </form>



<footer class="footer">
   <span> &copy; copyright @ 2024 by  Learnify</span>
</footer>

<!-- custom js file link  -->
<script src="js/script.js"></script>
 
</body>
</html>