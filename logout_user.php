<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
session_start();
require_once('mysql_conn.php');
if(isset($conn)) {
    if (isset($_POST['auth_token'])) {
        $auth_token = $_POST['auth_token'];
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['auth_token'])) {
            $output['success'] = false;
            $output['data'][] = '';
            $output['error'] = "You are not logged in";
            $error = json_encode($output);
            print($error);
        } else {
            $logout_query = "UPDATE `login creds` AS `lc` SET `is logged in` = '0' WHERE '{$_SESSION['user_id']}'= lc.ID";
            $logout = mysqli_query($conn,$logout_query);
            if(mysqli_affected_rows($conn)>0){
                unset($_SESSION['user_id']);
                unset($_SESSION['auth_token']);
                $output['success'] = true;
                $output['data'] = NULL;
                $success = json_encode($output);
                print($success);
            }
            else {
                $output['success'] = false;
                $output['data'][] = '';
                $output['error'] = "Failed to Logout";
                $error = json_encode($output);
                print($error);
            }
        }
    }
}
?>