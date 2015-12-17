<?php
require('connect.php');
//print_r($_POST);
if(!empty($_POST)) {
    $update=$_POST['ID'];

    $query = "UPDATE `User Profile` WHERE `ID`='$update'";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn)>0){
        $output['success'] = true;
        $result=json_encode($output);
        print_r($result);
    } else{
        $output['success']=false;
        $output['errors']= 'Operation Failed';
        print(json_encode($output));
    }
} else{

    $output['success']=false;
    $output['errors']= 'Operation Failed';
    print(json_encode($output));
}


?>
