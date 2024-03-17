<?php
// fetch_content.php
include '../settings/connection.php';

if(isset($_COOKIE['user_id'])){
    $tutor_id = $_COOKIE['user_id'];
} else {
    $tutor_id = '';
    header('location:../login/login.php');
    exit();
}

$select_videos = $conn->prepare("SELECT * FROM content WHERE tutor_id = ? ORDER BY date DESC");
$select_videos->bind_param("s", $tutor_id);
$select_videos->execute();
$result = $select_videos->get_result();

if ($result->num_rows > 0){
    while ($fec_videos = $result->fetch_assoc()){
        $video_id = $fec_videos['id']; 
?>
        <div class="box">
            <div class="flex">
                <div><i class="fas fa-dot-circle" style="<?php if($fec_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fec_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fec_videos['status']; ?></span></div>
                <div><i class="fas fa-calendar"></i><span><?= $fec_videos['date']; ?></span></div>
            </div>
            <img src="../uploads/<?= $fec_videos['thumb']; ?>" class="thumb" alt="">
            <h3 class="title"><?= $fec_videos['title']; ?></h3>
            <form action="../actions/delete_vid_action.php" method="post" class="flex-btn">
                <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
                <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
            </form>
            <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a>
        </div>
<?php
    }
}else{
    echo '<p class="empty">no contents added yet!</p>';
}
?>

</div>
