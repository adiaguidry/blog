<?php
function auth_check($conn){
    if(isset($_SESSION['auth_token']) && ISSET($_SESSION['user_id'])) {
        $auth_check_query = "SELECT `ID` FROM `session` AS `s` WHERE '{$_SESSION['auth_token']}'= s.auth_token AND '{$_SESSION['user_id']}'=s.User_ID";
        $auth_check = mysqli_query($conn, $auth_check_query);
        if (mysqli_num_rows($auth_check) > 0) {
            return true;
        } else {
            return false;
        }
    }
    else{
        return false;
    }
}
?>