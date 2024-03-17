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
    <section class="comments">
        <h1 class="heading">User Comments</h1>
        <div class="show-comments">
            <?php include '../functions/comments_fxn.php'; ?>
        </div>
    </section>

    <script src="../js/admin_script.js"></script>
</body>
</html>
