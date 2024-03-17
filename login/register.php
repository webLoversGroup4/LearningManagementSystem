<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="apple-touch-icon" sizes="180x180" href="../images/learnfy.ico">
   <link rel="icon" type="image/png" sizes="32x32" href="../images/learnfy.ico">
   <link rel="icon" type="image/png" sizes="16x16" href="../images/learnfy.ico">
   <link rel="manifest" href="/site.webmanifest">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cabin:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Russo+One&family=Yellowtail&display=swap" rel="stylesheet">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/loginCSS.css">

</head>
<body>

<img style="display: block; margin: 0 auto;" src="../images/learnfy.ico">
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   <form id="registrationForm" action="../actions/register_action.php" method="post" enctype="multipart/form-data" onsubmit="return validateRegistrationForm()">
     <section class="form-container">
      <h1>Register</h1>
       <p>Please fill in this form to create an account.</p>
       <hr>
      <b>First Name<span>*</span></b>
      <input type="text" id="fname" name="fname" placeholder="enter your first name" required maxlength="50" class="box">
      <b>Last Name<span>*</span></b>
      <input type="text" id="lname" name="lname" placeholder="enter your last name" required maxlength="50" class="box">
      <b> School email<span>*</span></b>
      <input type="email" id="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <b>Institution name<span>*</span></b>
      <input type="text" id="institutionName" name="institutionName" placeholder="enter institution name" required class="box">
      <b>Select your role <span>*</span></b>
            <?php include "../functions/select_role_fxn.php";?>
      <b>Password <span>*</span></b>
      <input type="password" id="password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
      <div id="message">
        <b>Password must contain the following:</b>
        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
        <p id="number" class="invalid">A <b>number</b></p>
        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
      </div>
      <b>Confirm password<span>*</span></b>
      <input type="password" id="confirmPassword" name="c_pass" placeholder="confirm your password" required maxlength="20" class="box">
      <b>Select profile <span>*</span></b>
      <input type="file" name="image" accept="image/*" required class="box">
     
     <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
     
      <input type="submit" value="register now" name="submit" class="button">
      </section>
      <section class="form-container">
      <b>Already have an account? <a href="login.php">Log In</a></b>
       </section>
      
   </form>

<footer class="footer">
   <span> &copy; copyright @ 2024 by  Learnify</span>
</footer>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
function validateRegistrationForm() {
    var fname = document.getElementById('fname').value;
    var lname = document.getElementById('lname').value;
    var email = document.getElementById('email').value;
    var institutionName = document.getElementById('institutionName').value;
    var role = document.getElementById('role').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Name validation
    var fnameRegex = /^[A-Za-z\s]{3,}$/;
    if (!fnameRegex.test(fname)) {
        alert("Please enter a valid first name (minimum 3 characters and only alphabets).");
        return false;
    }

    // Last Name validation
    var lnameRegex = /^[A-Za-z\s]{3,}$/;
    if (!lnameRegex.test(lname)) {
        alert("Please enter a valid last name (minimum 3 characters and only alphabets).");
        return false;
    }

    // Email validation 
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Institution name validation
    var institutionNameRegex = /^[A-Za-z\s]{3,}$/;
    if (!institutionNameRegex.test(institutionName)) {
        alert("Please enter a valid institution name (minimum 3 characters and only alphabets).");
        return false;
    }

    // Role selection validation
    if (role === "") {
        alert("Please select your role.");
        return false;
    }

    // Password validation
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!passwordRegex.test(password)) {
        alert("Password must contain at least one lowercase letter, one uppercase letter, one number, and minimum 8 characters.");
        return false;
    }

    // Confirm password validation
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
</body>
</html>
