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
    <input type="submit" name="submitFile"/>
</form>
<br/>
<form method="post" id="csv" style="display: none;" enctype="multipart/form-data">
    Upload a File: <input id="file" type="file" name="file"/> <br/>
    <input type="submit" name="submitFile"/>
</form>

<div class="files"></div>
<div class="content"></div>

</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="scriptExport.js"></script>
</html>
