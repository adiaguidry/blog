<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
require_once('auth_check.php');
session_start();
//print_r($_SESSION);
print_r(auth_check($conn));
print_r($_POST['title']);

/*$update_check_query = "SELECT lc.ID, bl.id AS `blog_id` ,`username`,`email`,`last login`,`is logged in` FROM `login creds` AS `lc` JOIN `blog list` AS `bl` ON '2' = bl.User_ID WHERE '2' = lc.id";
$update_check = mysqli_query($conn,$update_check_query);
if(mysqli_num_rows($update_check) > 0){
    $output['success'] = true;
    while($results = mysqli_fetch_assoc($update_check)){
        $blog_id[]=$results['blog_id'];
        $output['data']['username'] = $results['username'];
        $output['data']['email'] = $results['email'];
        $output['data']['last login'] = date("Y-m-d\ T H:i:s ", $results['last login']);
        $output['data']['is logged in'] = $results['is logged in'];
        $output['data']['recent posts'] = $blog_id;
    }
    print_r($output);
    //print_r($blog_id);
}*/
?>