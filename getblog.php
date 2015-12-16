<?php
require('connect.php');
$query="SELECT * FROM `Blog List`";
$query="SELECT * FROM `User Profile`";


$result=mysqli_query($conn, $query);
//print_r($result);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        $output[]=$row;
    }
    print(json_encode($output));
}
