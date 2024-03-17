<?php

include "../settings/connection.php";

$query = "SELECT * FROM profession_name";

$result = mysqli_query($conn, $query);


if ($result) {

       echo '  <select id="role" name="role" class="box" required>';
       echo  '<option value="" disabled selected>-- select your profession</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['pid'];
        $profession_name = $row['pname'];
        echo "<option value='$pid'><b>$profession_name</b></option>";
    }

    echo '</select>';
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>