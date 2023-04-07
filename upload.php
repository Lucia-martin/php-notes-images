<?php

if(isset($_POST['submit']) && isset($_FILES['image'])){
    $imgName = $_FILES['image']['name'];
    $imgSize = $_FILES['image']['size'];


} else {
    // echo "do nothin";
}

?>