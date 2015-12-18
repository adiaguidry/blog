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
            if (!empty($_SESSION['user_id'])) {
                $selected_user = sanitize_data($_SESSION['user_id']);
                $get_info_query = "SELECT lc.ID, bl.id AS `blog_id` ,`username`,`email`,`last login`,`is logged in` FROM `login creds` AS `lc` INNER JOIN `blog list` AS `bl` ON '$selected_user' = bl.User_ID WHERE '$selected_user' = lc.id";
                $get_info = mysqli_query($conn,$get_info_query);
                if(mysqli_num_rows($get_info) > 0){
                    while($results = mysqli_fetch_assoc($get_info)){
                        $output['success'] = true;
                        $blog_id[]=$results['blog_id'];
                        $output['data']['uid'] = $results['ID'];
                        $output['data']['name'] = $results['username'];
                        $output['data']['email'] = $results['email'];
                        $output['data']['last_login'] = date("Y-m-d\ T H:i:s ", $results['last login']);
                        $output['data']['is_logged_in'] = $results['is logged in'];
                        $output['data']['recent_posts'] = $blog_id;
                    }
                    print(json_encode($output));
                }
                else{
                    $output['success'] = false;
                    $output['data'][] = '';
                    $output['errors'] = "No Results Found";
                    $error = json_encode($output);
                    print($error);
                    die();
                }

            }
            else {
                $output['success'] = false;
                $output['data'][] = "";
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