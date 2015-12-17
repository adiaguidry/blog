<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
session_start();
require_once('mysql_conn.php');
require_once('auth_check.php');
if(isset($conn)) {
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['auth_token'])) {
            $output['success'] = false;
            $output['data'][] = '';
            $output['errors'] = "You are not logged in";
            $error = json_encode($output);
            print($error);
        } else {
            if (auth_check($conn)) {
                $logout_query = "UPDATE `login creds` AS `lc` SET `is logged in` = '0' WHERE '{$_SESSION['user_id']}'= lc.ID";
                $logout = mysqli_query($conn, $logout_query);
                if (mysqli_affected_rows($conn) > 0) {
                    $delete_session_query = "DELETE `session` FROM `session` WHERE '{$_SESSION['user_id']}'= session.User_ID";
                    $delete_session = mysqli_query($conn, $delete_session_query);
                    if (mysqli_affected_rows($conn) > 0) {
                        unset($_SESSION['user_id']);
                        unset($_SESSION['auth_token']);
                        $output['success'] = true;
                        $output['data'] = NULL;
                        $success = json_encode($output);
                        print($success);
                        die();
                    }
                } else {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['errors'] = "Failed to Logout";
                    $error = json_encode($output);
                    print($error);
                }
            }
            else{
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "Failed to Logout!";
                $error = json_encode($output);
                print($error);
            }
        }
}
?>