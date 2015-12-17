<?php
function auth_check($conn)
{
    $auth_check_query = "SELECT `ID` FROM `session` AS `s` WHERE '{$_SESSION['auth_token']}'= s.auth_token";
    $auth_check = mysqli_query($conn, $auth_check_query);
    if (mysqli_num_rows($auth_check) > 0) {
        return true;
    } else {
        return false;
    }
}
?>