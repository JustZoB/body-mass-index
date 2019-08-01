<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Index body mass</title>
</head>
<body>
<select id="importSelect">
  <option value="form">Form</option>
  <option value="csv">Csv</option>
</select>

<form method="post" id="form">
    Your mass: <input type="text" name="mass" id="mass"/><br/>
    Your height: <input type="text" name="height" id="height"/><br/>
    Your chest circumference: <input type="text" name="chest" id="chest"/><br/>
    <input type="submit" id="submitFormData" onclick="SubmitFormData();"/>
</form>
<br/>
<form method="post" action="upload.php" enctype="multipart/form-data" id="csv">
    Upload a File: <input type="file" name="uploadedFile"/> <br/>
    <input type="submit" name="uploadBtn" value="Upload"/>
</form>

<?php if (isset($_POST['mass'], $_POST['height'], $_POST['chest'])) : ?>
    <p>Mass <?= $_POST['mass'] ?></p>
    <p>Height <?= $_POST['height'] ?></p>
    <p>Chest circumference <?= $_POST['chest'] ?></p>
<?php endif ?>

</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="scriptExport.js"></script>
</html>