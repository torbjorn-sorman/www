<?php

function path_microtime($path){
    list($usec, $sec) = explode(" ", microtime());
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    return './uploads/' . $sec . $usec . '.' . $ext;
}

if(isset($_POST['submit'])) {
    if (empty($_FILES['fileToUpload']['name'])) {
        echo file_get_contents("./views/error.php");
        exit();
    }
    $target_dir = 'uploads/';
    $target_file = path_microtime($_FILES['fileToUpload']['name']);    
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST['submit'])) {
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        $uploadOk = ($check !== false);
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES['fileToUpload']['size'] > 10000000) {
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' ) {        
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1 && move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
        echo file_get_contents("./views/success.php");
    } else {
        echo file_get_contents("./views/error.php");
    }
} else {
    echo file_get_contents("./views/main.php");
}