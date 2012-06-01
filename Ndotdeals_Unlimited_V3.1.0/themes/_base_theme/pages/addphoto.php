	
<form action="addphoto.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<?php
if($_POST)
{
$userid = $_SESSION['userid'];
echo($userid);
//$rename=$_SESSION["userid"];
//$filename = basename($_FILES['file']['name']);
//$ext = end(explode('.', $filename));

if ((($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/pjpeg"))&& ($_FILES["file"]["size"] < 200000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
	$newname =DOCROOT.'/uploads/Profileimage/'.$append;
   
		move_uploaded_file($_FILES['file']['tmp_name'],$newname);
		
    }
  }
else
  {
  echo "Invalid file";
  }
  }
?> 
	

