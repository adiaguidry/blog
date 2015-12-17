<?php
require('connect.php');
//print_r($_POST);
if(!empty($_POST)) {
    $delete_id=$_POST['ID'];
//print($name);
//print_r($_POST);
//$course = $_POST['course'];
//$grade = $_POST['grade'];
    $query = "DELETE FROM `Blog List` WHERE `ID`='$delete_id'";
    mysqli_query($conn, $query);
} else{
    print_r('POST IS EMPTY');
}
if(mysqli_affected_rows($conn)>0){
    $output['success'] = true;
    $result=json_encode($output);
    print_r($result);
} else{
    print('Operation Failed');
}

?>


