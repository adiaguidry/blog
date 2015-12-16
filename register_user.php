<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
    require_once('mysql_conn.php');
    require_once('data_sanitize.php');
    if(isset($conn)){
        if(isset($_POST['display_name']) && isset($_POST['email']) && isset($_POST['password'])) {
            $display_name = $_POST['display_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user_info = ['name' => ['form' => $display_name, 'method' => 'addslash'], 'email' => ['form' => $email, 'method' => 'addslash'], 'password' => ['form' => $password, 'method' => 'addslash']];
            foreach ($user_info as $key => $value) {
                $user_info[$key]['form'] = sanitize_data($user_info[$key]['form']);
            }
            $check_duplicates_query = "SELECT `email` FROM `login creds` AS `lc` WHERE '{$user_info['email']['form']}' = lc.email";
            $check_duplicates = mysqli_query($conn, $check_duplicates_query);
            if (mysqli_num_rows($check_duplicates) > 0) {
                $output['success'] = false;
                $output['data'][] = '';
                $output['error'] = "Sorry that Email was already used";
                $error = json_encode($output);
                print($error);
            }
            else {
                $encrypted_password = password_hash($user_info['password']['form'], PASSWORD_BCRYPT);
                if (gettype($encrypted_password) == 'boolean') {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['error'] = "User Creation Failed! Try Again";
                    $error = json_encode($output);
                    print($error);
                }
                $register_user = "INSERT INTO `login creds`(`username`,`encrypted password`,`email`,`date created`,`soft delete`) VALUES('{$user_info['name']['form']}','{$encrypted_password}','{$user_info['email']['form']}',NOW(),'0')";
                mysqli_query($conn, $register_user);
                if (mysqli_affected_rows($conn) > 0) {
                    $newid = mysqli_insert_id($conn);
                    $output['success'] = true;
                    $output['data']['uid'] = $newid;
                    $output['data']['email'] = $email;
                    $output['data']['display_name'] = $display_name;
                    $success = json_encode($output);
                    print($success);
                } else {
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['error'] = "User Creation Failed! Try Again";
                    $error = json_encode($output);
                    print($error);
                }
            }
        }
        else {
            $output['success'] = false;
            $output['error'] = "No Post Variables Set";
            $error = json_encode($output);
            print($error);
        }
    }
    else{
        $output['success'] = false;
        $output['error'] = "failed to connect to DB";
        $error = json_encode($output);
        print($error);
    }
?>