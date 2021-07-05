<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://codepen.io/skjha5993/pen/bXqWpR.css">
    <link rel="stylesheet" type="text/css" href="css/reference.css">
    <title>Notification</title>
</head>
<body>
	
    <div class="container">
			<form action="" method="post" enctype="multipart/form-data">
            <h2 class="text-center">Description</h2>
        <div class="row jumbotron">
            <div class="col-sm-12 form-group">
                <label for="description">Description</label>
               <textarea id="description" name="description" rows="4" cols="50" placeholder="Enter your description." required></textarea>
            </div><br>
            <div class="col-sm-12 form-group">
   				 Select Image File to Upload:
   				 <input type="file" name="file">
            		</div>
            <div class="col-sm-12 form-group">
              <label for="notification">Notification</label>
              <select name="notification">
                <option value="Announcement">Announcement</option>
                <option value="News">News</option>
              </select>
            </div>
            <div class="col-sm-12 form-group mb-0">
               <button type="submit" name="submit">Submit</button>
            </div>
        </div>
        </form>
        </div>
</body>
</html>
<?php

$dbservername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="collegenotification";
$conn=mysqli_connect($dbservername,$dbusername,$dbpassword,$dbname);
if(!$conn)
{
	die("connection failed:". mysqli_connect_error());
}
if(isset($_POST['description']) && isset($_POST['notification']) && !empty($_POST['description']) && !empty($_POST['notification']))
{
$targetDir = "upload/";
$fileName = $_FILES["file"]["name"];
$file_temp_loc = $_FILES["file"]["tmp_name"];
$targetFilePath = "$fileName";
$upload  = move_uploaded_file($file_temp_loc,$targetFilePath);
$description=$_POST['description'];	
$notification = $_POST['notification'];

$sql="INSERT INTO notificationsheet (description,fileName,notification)
VALUES('".$description."','".$targetFilePath."','".$notification."')";

$sim=mysqli_query($conn,$sql);
if($sim)
{
	echo"insert";
}
else{
	echo"not insert";
}
}
?>
