<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
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
else{
    if(auth_check($conn)) {
        if (isset($_POST['blog_id'])) {
            $uid = $_SESSION['user_id'];
            $blog_id = sanitize_data($_POST['blog_id']);
            $delete_blog_query = "DELETE `bl` FROM `blog list` AS `bl` WHERE '$blog_id' = bl.ID AND '$uid'= bl.User_ID";
            $delete_blog = mysqli_query($conn, $delete_blog_query);
            if (mysqli_affected_rows($conn) > 0) {
                $output['success'] = true;
                $output['data']['id'] = $blog_id;
                print(json_encode($output));
            } else {
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "Failed to Delete Blog";
                $error = json_encode($output);
                print($error);
                die();
            }
        } else {
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "Cannot Find which Blog to Delete";
            $error = json_encode($output);
            print($error);
            die();
        }
    }
    else{
        $output['success'] = false;
        $output['data'][] = '';
        $output['errors'] = "You Do Not have Rights to do this";
        $error = json_encode($output);
        print($error);
        die();
    }
    }
?>


