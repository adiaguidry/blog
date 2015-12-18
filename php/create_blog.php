<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('auth_check.php');
require_once('data_sanitize.php');
session_start();
if(!isset($conn)){
    $output['success'] = false;
    $output['data'][] = '';
    $output['error'] = "Failed Connection to Database";
    $error = json_encode($output);
    print($error);
}
else{
    if(auth_check($conn)){
        if(!isset($_POST['public'])){
            $_POST['public'] = false;
        }
        if(isset($_POST['title']) && isset($_POST['text'])){
            $title = sanitize_data($_POST['title']);
            $text = sanitize_data($_POST['text']);
            $tags = sanitize_data($_POST['tags']);
            $public = sanitize_data($_POST['public']);
            $uid = $_SESSION['user_id'];
            $create_blog_query = "INSERT INTO `blog list`(`title`,`text`,`user_ID`,`Date Created`,`Last Edited`,`public`) VALUES('$title','$text','$uid',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),'$public')";
            $create_blog = mysqli_query($conn,$create_blog_query);
            if(mysqli_affected_rows($conn) > 0){
                $blog_id = mysqli_insert_id($conn);
                $output['success'] = true;
                $output['data']['id'] = $blog_id;
                $get_timestamp_query = "SELECT `date created` FROM `blog list` WHERE '$blog_id' = `ID`";
                $get_timestamp = mysqli_query($conn, $get_timestamp_query);
                if(mysqli_num_rows($get_timestamp) > 0) {
                    while($ts = mysqli_fetch_assoc($get_timestamp)){
                        $output['data']['ts'] = $ts;
                    }
                }
                else{
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['error'] = "Failed to make stamp";
                    $error = json_encode($output);
                    print($error);
                }
                $success = json_encode($output);
                print($success);

            }
            else{
                $output['success'] = false;
                $output['data'][] = '';
                $output['error'] = "Failed to Create Blog Post";
                $error = json_encode($output);
                print($error);
            }
        }
        else{
            $output['success'] = false;
            $output['data'][] = '';
            $output['error'] = "Empty Fields";
            $error = json_encode($output);
            print($error);
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