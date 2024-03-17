<?php

include '../settings/connection.php';
include '../functions/unique_id_fxn.php';

if(isset($_COOKIE['user_id'])){
    $tutor_id = $_COOKIE['user_id'];
}else{
    $tutor_id = '';
    header('location: ../login/login.php');
}

if(isset($_POST['submit'])){

    $select_tutor_stmt = $conn->prepare("SELECT * FROM Users WHERE sid = ? LIMIT 1");
    $select_tutor_stmt->bind_param("s", $tutor_id);
    $select_tutor_stmt->execute();
    $fetch_tutor = $select_tutor_stmt->get_result()->fetch_assoc();

    $prev_image = $fetch_tutor['image'];


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploads/'.$rename;

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'Image size too large!';
        }else{
            $update_image_stmt = $conn->prepare("UPDATE Users SET `image` = ? WHERE sid = ?");
            $update_image_stmt->bind_param("ss", $rename, $tutor_id);
            $update_image_stmt->execute();
            move_uploaded_file($image_tmp_name, $image_folder);
            if($prev_image != '' AND $prev_image != $rename){
                unlink('../uploads/'.$prev_image);
            }
            $message[] = 'Image updated successfully!';
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
    <title>Update Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../functions/admin_header_fxn.php'; ?>

<!-- register section starts  -->

<section class="form-container" style="min-height: calc(100vh - 19rem);">

    <form class="register" action="" method="post" enctype="multipart/form-data">
        <h3>Update Profile Picture</h3>
        <p>Update Profile Picture :</p>
        <input type="file" name="image" accept="image/*"  class="box">
        <input type="submit" name="submit" value="Update Now" class="btn">
    </form>

</section>

<!-- register section ends -->

<script src="../js/admin_script.js"></script>

</body>
</html>
