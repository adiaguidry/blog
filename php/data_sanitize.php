<?php
function sanitize_data($data){
    $sanitized_data = addslashes(trim($data));
    return $sanitized_data;
}
?>