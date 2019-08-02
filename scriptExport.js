let select = $("#importSelect");
select.change(function() {
    if (select.val() === "form") {
        $("#csv").css("display", "none");
        $("#form").css("display", "block");
    } else if (select.val() === "csv") {
        $("#csv").css("display", "block");
        $("#form").css("display", "none");
    }
});

$(function(){
    $('#form').on('submit', function(e){
        e.preventDefault();
        let mass = $("#mass").val(),
            height = $("#height").val(),
            chest = $("#chest").val();
        if (mass < 0 || height < 0 || chest < 0 || !$.isNumeric(mass) || !$.isNumeric(height) || !$.isNumeric(chest)) {
            alert("Enter nonzero positive numbers.");
        } else {
            $.ajax({
                type: 'POST',
                url: 'submit.php',
                data: {mass: mass, height: height, chest: chest},
                dataType: 'json',
                success: function( result ) {
                    console.log(result[0]);
                    result.shift();
                    console.log(result);
                }
            });
            $('#form')[0].reset();
        }
    });
});

$('#csv').on('submit', function(e){
    e.preventDefault();
    formData = new FormData();
    formData.append('file', file.files[0]); 
    $.ajax({
        type: 'POST',
        url: 'importCsv.php',
        contentType: false,
        processData: false,
        data: formData,
        success: function( result ){
            result = JSON.parse(result);
            console.log(result[0]);
            result.shift();
            console.log(result);
        }
    });
});




