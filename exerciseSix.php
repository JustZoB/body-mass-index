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
    <input type="submit" id="submitFormData" onclick="SubmitFormData();"/>
</form>

<?php if (isset($_POST['mass']) && isset($_POST['height']) && isset($_POST['chest'])) : ?>
    <?= '<p>Mass ' . htmlspecialchars($_POST['mass']) . '<br />' ?>
    <?= 'Height ' . htmlspecialchars($_POST['height']) . '<br />' ?>
    <?= 'Chest circumference ' . htmlspecialchars($_POST['chest']) . '</p>' ?>
<?php endif ?>

</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    function SubmitFormData() {
        let mass = $("#mass").val(),
            height = $("#height").val(),
            chest = $("#chest").val(),
            m = $.isNumeric(mass),
            h = $.isNumeric(height),
            c = $.isNumeric(chest);
        if (mass < 0 || height < 0 || chest < 0 || !m || !h || !c) {
            alert("Enter nonzero positive numbers.");
        } else {
            $.post("submit.php", {mass: mass, height: height, chest: chest});
        }
    }
</script>
</html>