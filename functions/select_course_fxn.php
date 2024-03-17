<?php
   include '../settings/connection.php';
   include '../actions/add_content_action.php';

   $select_course_query = "SELECT * FROM `Course` WHERE InstructorID = $tutor_id";
   $result = mysqli_query($conn, $select_course_query);
   if($result){
      while($row = mysqli_fetch_assoc($result)){
         $courseID = $row['CourseID'];
         $courseName = $row['CourseName'];
         echo "<option value='$courseID'><b>$courseName</b></option>";
      }
      mysqli_free_result($result); 
      } else {
         echo '<option value="" disabled>No courses available</option>';
}
       