<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('mysql_conn.php');
require_once('data_sanitize.php');
require_once('email_regex_check.php');
require_once('auth_check.php');
session_start();
if(isset($conn)) {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
        if (isset($_SESSION['auth_token']) && isset($_SESSION['user_id'])) {
            if (auth_check($conn)) {
                $uid = $_SESSION['user_id'];
                $new_username = sanitize_data($_POST['username']);
                $new_password = sanitize_data($_POST['password']);
                $encrypted_password = password_hash($new_password, PASSWORD_BCRYPT);
                if (gettype($encrypted_password) == 'boolean') {
                    $output['success'] = false;
                    $output['data'] = NULL;
                    $output['errors'] = "Profile Update Failed! Try Again";
                    $error = json_encode($output);
                    print($error);
                }
                if (check_email($_POST['email'])) {
                    $new_email = sanitize_data($_POST['email']);
                } else {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['errors'] = "Sorry that Email is Invalid";
                    $error = json_encode($output);
                    print($error);
                    die();
                }
                $update_profile_query = "UPDATE `login creds` AS `lc` SET `Username`='$new_username',`email`='$new_email',`encrypted password`='$encrypted_password' WHERE '$uid'= lc.ID ";
                $update_profile = mysqli_query($conn, $update_profile_query);
                if (mysqli_affected_rows($conn) > 0) {
                    $update_id = mysqli_insert_id($conn);
                    $update_check_query = "SELECT `ID`,`Username`,`Email`,`Last Login`,`is logged in` FROM `login creds` AS `lc` WHERE '$uid'=lc.ID ";
                    $update_check = mysqli_query($conn, $update_check_query);
                    if (mysqli_num_rows($update_check) > 0) {
                        while ($results = mysqli_fetch_assoc($update_check)) {
                            $output['data']['uid'] = $results['ID'];
                            $output['data']['username'] = $results['Username'];
                            $output['data']['email'] = $results['Email'];
                            $output['data']['Last Login'] = date("Y-m-d\ T H:i:s ", $results['Last Login']);
                            if ($results['is logged in']) {
                                $output['data']['Is Logged In'] = true;
                            } else {
                                $output['data']['Is Logged In'] = false;
                            }
                        }
                    }
                    $output['success'] = true;
                    $success = json_encode($output);
                    print($success);
                    die();
                } else {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['errors'] = "Sorry Failed to Update Profile";
                    $error = json_encode($output);
                    print($error);
                    die();
                }
            } else {
                $output['success'] = false;
                $output['data'] = NULL;
                $output['errors'] = "You do not have the rights to edit this profile";
                $error = json_encode($output);
                print($error);
            }
        }
        else {
            $output['success'] = false;
            $output['data'] = NULL;
            $output['errors'] = "You do not have the rights to edit this profile";
            $error = json_encode($output);
            print($error);
        }
    }
    else{
        $output['success'] = false;
        $output['data'] = NULL;
        $output['errors'] = "Error handling your request";
        $error = json_encode($output);
        print($error);
    }
}
else{
    $output['success'] = false;
    $output['data'] = NULL;
    $output['errors'] = "Failed to Connect to DB";
    $error = json_encode($output);
    print($error);
}

?>