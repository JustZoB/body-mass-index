<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Индекс массы тела</title>
</head>
<body>
<form method="post">
    Ваш вес: <input type="text" name="mass" id="mass"/><br/>
    Ваш рост: <input type="text" name="height" id="height"/><br/>
    Ваша окружнось грудной клетки: <input type="text" name="chest" id="chest"/><br/>
    <input type="submit" id="submitFormData" onclick="SubmitFormData();"/>
</form> 

<?php if (isset($_POST['mass']) && isset($_POST['height']) && isset($_POST['chest'])) : ?>
    <?= '<p>Вес ' . htmlspecialchars($_POST['mass']) . '<br />' ?>
    <?= 'Рост ' . htmlspecialchars($_POST['height']) . '<br />' ?>
    <?= 'Окружнось грудной клетки ' . htmlspecialchars($_POST['chest']) . '</p>' ?>

<?php endif ?>
<div id="results"></div>
</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    function SubmitFormData() {
        let mass = $("#mass").val();
        let height = $("#height").val();
        let chest = $("#chest").val();
        $.post("submit.php", {mass: mass, height: height, chest: chest},
        function(data) {
            //alert(data);
        });
    }
</script>
</html>