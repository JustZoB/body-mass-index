<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Index body mass</title>
</head>
<body>
<form method="post">
    Your mass: <input type="text" name="mass" id="mass"/><br/>
    Your height: <input type="text" name="height" id="height"/><br/>
    Your chest circumference: <input type="text" name="chest" id="chest"/><br/>
    Select a file: <input type="file" name="file" id="file"><br/>
    <input type="submit" id="submitFormData" onclick="SubmitFormData();"/>
</form>

<?php if (isset($_POST['mass'], $_POST['height'], $_POST['chest'])) : ?>
    <p>Mass <?=$_POST['mass'] ?></p>
    <p>Height <?=$_POST['height'] ?></p>
    <p>Chest circumference <?=$_POST['chest'] ?></p>
<?php endif ?>

</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="script.js"></script>
</html>
