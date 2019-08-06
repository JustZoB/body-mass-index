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

exportSql();

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
                    exportSql();
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
            exportSql();
            $(`<a href="${ JSON.parse(result).shift() }" download>Download csv source</a><br />`).appendTo($(".content"));
        }
    });
    
    $('#csv')[0].reset();
});

function exportSql() {
    $(".content").html("");
    $.ajax({
        type: 'POST',
        url: 'exportSql.php',
        contentType: false,
        processData: false,
        success: function( result ){
            if (result[0] !== "<") {
                result = JSON.parse(result);
                let file_path = result.shift();
                createTable(result);
                $(`<a class="csv_result" href="${ file_path }" download>Download csv result</a><br />`).appendTo($(".content"));
            }
        }
    });
}

function createTable(array) {
    if(!$("div").is("table")){
        $(` <table class="table" border="1">
                <caption class="table__head">Index Body Mass</caption>
            </table>`).appendTo($(".content"));
        createTableHead(array[0]);
    }

    let heads = array.shift();
    createTableContent(heads, array);
}

function createTableHead(heads) {
    $(`<tr class="table__headColumns"></tr>`).appendTo($(".table"));
    for (let i = 0; i < heads.length; i++) {
        $(`<th class="table__headColumn">${ heads[i] }</th>`).appendTo($(".table__headColumns"));
    }
}
function createTableContent(heads, array) {
    for (let i = 0; i < array.length; i++) {
        $(`<tr></tr>`).appendTo($(".table"));
        for (let j = 0; j < heads.length; j++) {
            $(`<td>${ array[i][heads[j]] }</td>`).appendTo($("tr").last());
        }
    }
}
