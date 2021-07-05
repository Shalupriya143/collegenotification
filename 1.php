<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName     = "codexworld";
// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upload Image</title>
</head>
<body>
  <form action="upload.php" method="post" enctype="multipart/form-data">
        Select Image File to Upload:
      <input type="file" name="file">
      <input type="submit" name="submit" value="Upload">
  </form>
  <hr>

  <?php
  // Include the database configuration file
  include 'config.php';

  // Get images from the database
  $query = $db->query("SELECT file_name FROM images ORDER BY uploaded_on DESC");

  if($query->num_rows > 0){
      while($row = $query->fetch_assoc()){
          $imageURL = 'uploads/'.$row["file_name"];
  ?>
      <img src="<?= $imageURL; ?>" />
  <?php }} ?>
</body>
</html>
<?php
// Include the database configuration file
include 'config.php';
$statusMsg = '';
$backlink = ' <a href="./">Go back</a>';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if (!file_exists($targetFilePath)) {
        if(in_array($fileType, $allowTypes)){
                // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                if($insert){
                    $statusMsg = "The file <b>".$fileName. "</b> has been uploaded successfully." . $backlink;
                }else{
                    $statusMsg = "File upload failed, please try again." . $backlink;
                } 
            }else{
                $statusMsg = "Sorry, there was an error uploading your file." . $backlink;
            }
        }else{
            $statusMsg = "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload." . $backlink;
        }
    }else{
            $statusMsg = "The file <b>".$fileName. "</b> is already exist." . $backlink;
        }
}else{
    $statusMsg = 'Please select a file to upload.' . $backlink;
}

// Display status message
echo $statusMsg;
?>