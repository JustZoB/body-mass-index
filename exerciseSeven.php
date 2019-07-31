<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Index body mass</title>
</head>
<body>
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        Upload a File: <input type="file" name="uploadedFile" /> <br />
        <input type="submit" name="uploadBtn" value="Upload" />
    </form>
<?php
if (isset($_SESSION['message']) && $_SESSION['message'])
{
    printf('<b>%s</b>', $_SESSION['message']);
    unset($_SESSION['message']);
}
?>

</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="script.js"></script>
</html>