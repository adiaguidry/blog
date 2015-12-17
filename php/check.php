<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
session_start();
print_r($_SESSION);

$update_check_query = "SELECT `ID`,`username`,`email`,`last login`,`is logged in` FROM `login creds` AS `lc` WHERE '1'=lc.ID ";
$update_check = mysqli_query($conn,$update_check_query);
if(mysqli_num_rows($update_check) > 0){
    while($results = mysqli_fetch_assoc($update_check)){
        $output['data']['uid']=$results['ID'];
        $output['data']['username']=$results['username'];
        $output['data']['email']=$results['email'];
        $output['data']['Last Login'];
    }
    print_r($output);
}
?>