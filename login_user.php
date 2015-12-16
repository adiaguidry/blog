<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
if(isset($conn)) {
    if (!empty($_POST)) {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $output['success'] = false;
            $output['data'][] = '';
            $output['error'] = "Already Logged In";
            $error = json_encode($output);
            print($error);
        }
        else {
            $email = sanitize_data($_POST['email']);
            $password = sanitize_data($_POST['password']);
            $login_check = "SELECT `encrypted password`,`id` FROM `login creds` AS `lc` WHERE '$email'= lc.email";
            $login = mysqli_query($conn, $login_check);
            if (mysqli_num_rows($login) > 0) {
                while ($results = mysqli_fetch_assoc($login)) {
                    $hash = $results['encrypted password'];
                    $id = $results['id'];
                }
                if (password_verify($password, $hash)) {
                    $login_query = "UPDATE `login creds` AS `lc` SET `last login` = UNIX_TIMESTAMP(), `is logged in` = '1' WHERE '$id'= lc.ID";
                    $log_in = mysqli_query($conn, $login_query);
                    if (mysqli_affected_rows($conn) > 0) {
                        $get_info_query = "SELECT `username` FROM `login creds` AS `lc` WHERE '$id' = lc.ID";
                        $get_info = mysqli_query($conn, $get_info_query);
                        if (mysqli_num_rows($get_info) > 0) {
                            $output['success'] = true;
                            while ($info = mysqli_fetch_assoc($get_info)) {
                                $output['data']['username'] = $info['username'];
                                $output['data']['uid'] = $id;
                            }
                            $auth = bin2hex(openssl_random_pseudo_bytes(16));
                            $_SESSION['user_id'] = $id;
                            $_SESSION['auth_token'] = $auth;
                            $output['data']['auth_token'] = $auth;
                            $success = json_encode($output);
                            print($success);
                        }
                    }
                    else {
                        $output['success'] = false;
                        $output['data'][] = '';
                        $output['errors'] = "Failed to Login User";
                        $error = json_encode($output);
                        print($error);
                    }
                }
                else {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['errors'] = "Invalid Username or Password";
                    $error = json_encode($output);
                    print($error);
                }
            }
            else {
                $output['success'] = false;
                $output['data'][] = '';
                $output['errors'] = "Invalid Username or Password";
                $error = json_encode($output);
                print($error);
            }
        }
    }
}

?>