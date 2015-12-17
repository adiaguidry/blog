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
    $output['errors'] = "Failed to Connect to DB";
    $error = json_encode($output);
    print($error);
    die();
}
else{
    if(auth_check($conn)){
        if(!isset($_POST['public'])){
            $_POST['public'] = false;
        }
        if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['tags'])){
            $uid = $_SESSION['user_id'];
            $public = sanitize_data($_POST['public']);
            $blog_id = sanitize_data($_POST['id']);
            $title = sanitize_data($_POST['title']);
            $text = sanitize_data($_POST['text']);
            $tags = sanitize_data($_POST['tags']);
            $update_blog_query = "UPDATE `blog list` AS `bl` SET `title` = '$title', `text` = '$text', `tags`='$tags', `last edited`=UNIX_TIMESTAMP(), `public`='$public' WHERE '$blog_id'=bl.ID AND '$uid'=bl.User_ID";
            $update_blog = mysqli_query($conn,$update_blog_query);
            if(mysqli_affected_rows($conn) > 0){
                $output['success'] = true;
                $output['data']['id'] = $blog_id;
                print(json_encode($output));
            }
            else{
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "Failed to Update to Blog";
                $error = json_encode($output);
                print($error);
                die();
            }
        }
        else{
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "Cannot Find Blog to Update";
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
