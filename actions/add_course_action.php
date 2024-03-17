<?php

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

// Ensure user is logged in
if(isset($_COOKIE['user_id'])){
   $tutor_id = $_COOKIE['user_id'];
} else {
   $tutor_id = '';
   header('location:login.php');
   exit(); // Stop further execution
}

// Check if form is submitted
if(isset($_POST['submit'])){
   // Validate form fields
   $CourseName = $_POST['title'];
   $Description = $_POST['description'];
   $cstatus = $_POST['status'];
   $image = $_FILES['image']['name'];
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploads/'.$rename;

   // Validate uploaded file
   $allowed_extensions = array("jpg", "jpeg", "png", "gif");
   $max_file_size = 5 * 1024 * 1024; // 5 MB
   if(!in_array(strtolower($ext), $allowed_extensions) || $_FILES['image']['size'] > $max_file_size) {
      echo "<script>alert('Invalid file format or size. Please upload an image (jpg, jpeg, png, gif) with size less than 5MB.');</script>";
      header("Location: ../admin/add_course.php");
      exit();
   } else {
      $add_course = $conn->prepare("INSERT INTO `Course` (CourseName, Description, InstructorID, image, cstatus) VALUES (?, ?, ?, ?, ?)");
      $success = $add_course->execute([$CourseName, $Description, $tutor_id, $rename, $cstatus]);
      
      if($success) {
         move_uploaded_file($image_tmp_name, $image_folder);
         echo "<script>alert('New course created successfully!');</script>";
         header("Location: ../admin/dashboard.php");
      exit();
      } else {
         echo "<script>alert('Failed to create course. Please try again later.');</script>";
         header('location: ../admin/add_course.php');
            exit();
      }
   }
}
?>


