<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
if(isset($conn)) {
    if (!empty($_POST)) {
        $new_username = sanitize_data($_POST['username']);
        if (check_email($_POST['email'])) {
            $new_email = sanitize_data($_POST['email']);
        } else {
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "Sorry that Email is Invalid";
            $error = json_encode($output);
            print($error);
            return;
        }
        $update_profile_query = "UPDATE `login creds` SET `username`"


    }
}
else{
    $output['success'] = false;
    $output['data'][] = NULL;
    $output['errors'] = "Failed to Connect to DB";
    $error = json_encode($output);
    print($error);
}

?>