<?php
session_start();

$fname = $_SESSION['fileName'];

if (isset($_FILES["audiovideo"])) {
    // Define a name for the file
    $fileName = $fname.".webm";
    
    // In this case the current directory of the PHP script
    $uploadDirectory = 'video/' . $fileName;
    move_uploaded_file($_FILES["audiovideo"]["tmp_name"], $uploadDirectory);
    // Move the file to your server
    // if (!move_uploaded_file($_FILES["audiovideo"]["tmp_name"], $uploadDirectory)) {
    //     echo ("Couldn't upload video !");
    // } else {
    //     echo ("File Moved");
    // }
} 

if (isset($_FILES["audio"])) {
    // Define a name for the file
    $fileName = $fname.".mp3";
    
    // In this case the current directory of the PHP script
    $uploadDirectory = 'audio/' . $fileName;
    move_uploaded_file($_FILES["audio"]["tmp_name"], $uploadDirectory);
    // Move the file to your server
    // if (!move_uploaded_file($_FILES["audio"]["tmp_name"], $uploadDirectory)) {
    //     echo ("Couldn't upload video !");
    // } else {
    //     echo ("File Moved");
    // }
} 
