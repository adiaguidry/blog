<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
session_start();
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('auth_check.php');

if(isset($conn)) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['auth_token'])) {
        if (auth_check($conn)) {
            if (!empty($_POST['uid'])) {
                $selected_user = sanitize_data($_POST['uid']);
                $get_info_query = "SELECT "
            }
            else {
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "You Did not select a user";
                $error = json_encode($output);
                print($error);
                die();
            }
        } else {
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "You do not have rights to do this";
            $error = json_encode($output);
            print($error);
            die();
        }
    }
}
else{
    $output['success'] = false;
    $output['data'][] = '';
    $output['errors'] = "Failed to Connect to DB";
    $error = json_encode($output);
    print($error);
    die();
}

?>