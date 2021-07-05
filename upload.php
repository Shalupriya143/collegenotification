<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "collegenotification";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>

<?php
// Include the database configuration file

$statusMsg = "";

// File upload 
$targetDir = "upload/";
$fileName = $_FILES["file"]["name"];
$file_temp_loc = $_FILES["file"]["tmp_name"];
$targetFilePath = $targetDir . $fileName;
$upload  = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($fileName)){
    $allowTypes = array('jpg','png','jpeg','gif','pdf','php');
    if(in_array($fileType, $allowTypes)){
        if($upload){
            $insert = $db->query("INSERT into notificationsheet (fileName) VALUES ('".$fileName."')");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>
