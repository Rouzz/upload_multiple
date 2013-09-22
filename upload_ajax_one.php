<?php
#authorized files
$allowedExts = array("gif", "jpeg", "jpg", "png");

#here you have to get your folder name from your database
$dossier = 'dossier_image2';
if(!is_dir($dossier))
	mkdir($dossier, 0777); //test values

if(count($_FILES['filesToUpload']['name'])) {
    if ($_FILES['filesToUpload']["error"] > 0)
    {
        if($_FILES['filesToUpload']["error"] == "1")
            echo "The uploaded filesize exceeds the limit : ".ini_get('upload_max_filesize');
        else if($_FILES['filesToUpload']["error"] == "2")
            echo "The uploaded filesize exceeds the limit : ".$_POST['MAX_FILE_SIZE'];
        else
            echo "An error has occured";
        die();
    }
    
    if($_FILES['filesToUpload']['size'] > $_POST['MAX_FILE_SIZE']){
        echo "The uploaded filesize exceeds the limit : ".$_POST['MAX_FILE_SIZE'];
        die();
    }

    $extension = explode(".", $_FILES['filesToUpload']["name"]);
    $extension = $extension[count($extension)-1];
    if ((($_FILES['filesToUpload']["type"] == "image/gif") #we check file type
        || ($_FILES['filesToUpload']["type"] == "image/jpeg")
        || ($_FILES['filesToUpload']["type"] == "image/jpg")
        || ($_FILES['filesToUpload']["type"] == "image/pjpeg")
        || ($_FILES['filesToUpload']["type"] == "image/x-png")
        || ($_FILES['filesToUpload']["type"] == "image/png"))
        && in_array($extension, $allowedExts)) #we check file extension
    {
        $i = $_POST['count'];
        while(file_exists($dossier."/" . $i.".".$extension))
        {
            $i++;
        }
        $_FILES['filesToUpload']["name"] = $i.".".$extension; #rename file
        move_uploaded_file($_FILES['filesToUpload']["tmp_name"], $dossier."/" . $_FILES['filesToUpload']["name"]);
    }
}
?>