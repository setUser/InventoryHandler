<?php
if(isset($_POST["submit"])) {
    $target_dir = "Lists/".$_POST["service"]."/";
    $target_file = $target_dir.basename($_POST["date"].".xls");
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        header('Location: lists.php?service='.$_POST["service"]);
    }
    else {
        require_once 'newlist.html';
        echo "</br>Sorry, there was an error uploading your file.";
    }
}
else {
    require_once 'newlist.html';
}
?>