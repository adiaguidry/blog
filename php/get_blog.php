<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
require_once('auth_check.php');
session_start();
if(!isset($conn)){
    $output['success'] = false;
    $output['data'][] = '';
    $output['errors'] = "Failed to Connect to DB";
    $error = json_encode($output);
    print($error);
    die();
}
else {
    if(auth_check($conn)){
        if(isset($_POST['tags'])) {
            $search = sanitize_data($_POST['tags']);
            $get_blog_query = "SELECT * FROM `blog list` WHERE `Tags` LIKE '%{$search}%'";
            $get_blog = mysqli_query($conn,$get_blog_query);
            if(mysqli_num_rows($get_blog) > 0){
                $output['success'] = true;
                while($results = mysqli_fetch_assoc($get_blog)){
                    $output['data']=$results;
                }
                $list = json_encode($output);
                print($list);
            }
            else{
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "No Results were found";
                $error = json_encode($output);
                print($error);
                die();
            }
            }
        else{
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "You Searched for Nothing";
            $error = json_encode($output);
            print($error);
            die();
        }
    }
    else{
        $output['success'] = false;
        $output['data'][] = '';
        $output['error'] = "You do not have rights to do this";
        $error = json_encode($output);
        print($error);
    }
}
?>