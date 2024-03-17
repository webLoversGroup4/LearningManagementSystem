<?php

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location: ../login/login.php');
}

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

if(isset($_POST['submit'])){

    $select_user = $conn->prepare("SELECT * FROM Users WHERE sid = ? LIMIT 1");
    $select_user->bind_param("s", $user_id);
    $select_user->execute();
    $result = $select_user->get_result();
    $fetch_user = $result->fetch_assoc();
    $prev_image = $fetch_user['image'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    if(!empty($name)){
        $update_name = $conn->prepare("UPDATE Users SET fname = ? WHERE sid = ?");
        $update_name->bind_param("ss", $name, $user_id);
        $update_name->execute();
        $message[] = 'username updated successfully!';
    }

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploads/'.$rename;

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'image size too large!';
        }else{
            $update_image = $conn->prepare("UPDATE Users SET `image` = ? WHERE sid = ?");
            $update_image->bind_param("ss", $rename, $user_id);
            $update_image->execute();
            move_uploaded_file($image_tmp_name, $image_folder);
            if($prev_image != '' AND $prev_image != $rename){
                unlink('../uploads/'.$prev_image);
            }
            $message[] = 'image updated successfully!';
            header('location: home.php');
            exit();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '..functions/user_header_fxn.php'; ?>

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <div class="flex">
         <div class="col">
            <p>your name</p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['fname']; ?>" maxlength="100" class="box">
            <p>update pic</p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="update profile" class="btn">
   </form>

</section>

<!-- update profile section ends -->

<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>