<?php
$target_dir = 'uploads/';
$target_file = $target_dir.$_FILES['fileToUpload']['name'];
$upload_status = true;
$output = [];

if(isset($_POST['Upload File'])){
    if($_FILES['fileToUpload']['size'] > 5000000){
        $upload_status = false;
        $output['errors'][] = 'the selected file is too large';
    }
}
else{
    $upload_status = false;
    $output['errors'][] = 'No file to upload';
}
if($upload_status){
    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
        $output['success'] = true;
        $output['filepath'] = stripslashes($target_file);
        $output['success'] = "The Profile Picture was Successfully Uploaded";
    }
    else{
        $output['errors'][] = "There was an error uploaded your file.";
    }
}
print(json_encode($output));
?>
