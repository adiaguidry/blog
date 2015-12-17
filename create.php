<?php
require('connect.php');
//Variables for Blog List Table
$title=$_POST['Title'];
$summary=$_POST['Summary'];
$username=$_POST['user_ID'];
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
$lastLogin=$_POST['Last Login'];
$isLoggedIn=$_POST['is logged in'];
$profileImage=$_POST['User Profile Image'];
$query = "INSERT INTO `Blog List`(`Title`, `Summary`,`user_ID`,`Date Created`, `Last Edited`) VALUES ('$title','$summary','$username','$dateCreated','$lastEdited')";
$query= "INSERT INTO `Login Creds`(`Username`, `Encrypted Password`, `Email`, `Date Created`, `Soft Delete`, `Last Login`, `is logged in`) VALUES ('$username','$pass','$email', '$dateCreated','$softDelete','$lastLogin','$isLoggedIn')";
$query="INSERT INTO `User Profile`(`User_ID`, `Name`, `Email`, `User Profile Image`, `File Name`, `File Type`, `Recent Posts`) VALUES ('$username','$name','$email','$profileImage','$fileName','$fileType','$recentPosts')";

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
