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
   <section class="contents">
      <h1 class="heading">Your Uploads</h1>
      <div class="box-container">
         <div class="box" style="text-align: center;">
            <h3 class="title" style="margin-bottom: .5rem;">Create New Content</h3>
            <a href="add_content.php" class="btn">Add Content</a>
         </div>
         <?php include_once('../functions/fetch_content.php'); ?>
      </div>
   </section>

   <script src="../js/admin_script.js"></script>
</body>
</html>

