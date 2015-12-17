<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
require_once('auth_check.php');
session_start();
$target_dir = 'uploads/';
$target_file = $target_dir.$_FILES['fileToUpload']['name'];
$upload_status = true;
$output = [];

if(isset($_POST['submit'])){
    if($_FILES['fileToUpload']['size'] > 5000000){
        $upload_status = false;
        $output['errors'][] = 'the selected file is too large';
    }
}
else{
    $upload_status = false;
    $output['errors'][] = 'No file to upload';
}
if($upload_status){
    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
        print_r($_FILES['fileToUpload']);
        $uid = $_SESSION['user_id'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileType = $_FILES['fileToUpload']['type'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $tmpName = $_FILES['fileToUpload']['tmp_name'];
        $fileName=sanitize_data($fileName);
        $upload_picture_query = "INSERT INTO `user profile`(`User_ID`,`File Name`,`File Type`,`File Path`) VALUES('$uid','$fileName','$fileType','$target_file')";
        $upload_picture = mysqli_query($conn,$upload_picture_query);
        if(mysqli_affected_rows($conn) > 0){
            $upload_id = mysqli_insert_id($conn);
            $output['success'] = true;
            $output['data']['filepath'] = stripslashes($target_file);
            $output['data']['uploadID'] = $upload_id;
        }
        else{
            $output['success'] = false;
            $output['errors'][] = "There was an error uploading your file.";
        }
    }
    else{
        $output['success'] = false;
        $output['errors'][] = "There was an error uploading your file.";
    }
}
print(json_encode($output));
?>
