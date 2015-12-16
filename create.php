<?php
require('connect.php');
//Variables for Blog List Table
$title=$_POST['Title'];
$summary=$_POST['Summary'];
$username=$_POST['Username'];
$recentPosts=$_POST['Recent Posts'];
$fileName=$_POST['File Name'];
$fileSize=$_POST['File Size'];
$fileType=$_POST['File Type'];
$file=$_POST['File'];
$dateCreated=$_POST['Date Created'];
$lastEdited=$_POST['Last Edited'];
//Variables for Login Creds Table
$userName=$_POST['Username'];
$pass=$_POST['Encrypted Password'];
$softDelete=$_POST['Soft Delete'];
//Variables for User Profile
$name=$_POST['name'];
$email=$_POST['Email'];
$profileImage=$_POST['User Profile Image'];
$query = "INSERT INTO `Blog List`(`Title`, `Summary`, `Username`, `Recent Posts`, `File Name`, `File Size`, `File Type`, `File`, `Date Created`, `Last Edited`) VALUES ('$title','$summary','$username','$recentPosts','$fileName','$fileSize','$fileType','$file',$dateCreated,$lastEdited)";
$query= "INSERT INTO `Login Creds`(`Username`, `Encrypted Password`, `Date Created`, `Soft Delete`) VALUES ('$username','$pass',$dateCreated, '$softDelete')";
$query="INSERT INTO `User Profile`(`Name`, `Email`, `User Profile Image`) VALUES ('$name','$email','$')";

    $create_blog=mysqli_query($conn, $query);



if(mysqli_affected_rows($conn)>0){
    $output['success'] = true;
    $output['data']['id'] = mysqli_insert_id($create_blog);
    $output['data']['ts']=date_timestamp_set();
    print(json_encode($output));
} else{
    $output['success'] = false;
    $output['errors']= 'Oh no, success failed';
    print(json_encode($output));
}
