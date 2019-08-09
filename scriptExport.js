let select = $("#importSelect");
select.change(function () {
    if (select.val() === "form") {
        $("#csv").css("display", "none");
        $("#form").css("display", "block");
    } else if (select.val() === "csv") {
        $("#csv").css("display", "block");
        $("#form").css("display", "none");
    }
});

exportFiles();
exportIndexs();

$('#form').on('submit', function (e) {
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
            success: function () {
                exportIndexs();
                setDownloadLink(JSON.parse(result).pop(), 'source', 'content');
            },
            error: function (error) {
                alert('Error: ' + eval(error));
            }
        });
        $('#form')[0].reset();
    }
});

$('#csv').on('submit', function (e) {
    e.preventDefault();
    formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'importCsv.php',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formData,
        success: function (result) {
            setDownloadLink(result.pop(), 'source', 'files');
            setDownloadLink(result.pop(), 'result', 'files');
            exportIndexs();
        },
        error: function (error) {
            alert('Error: ' + eval(error));
        }
    });

    $('#csv')[0].reset();
});

function exportIndexs() {
    $(".content").html("");
    $.ajax({
        type: 'POST',
        url: 'exportSql.php',
        contentType: false,
        processData: false,
        success: function (result) {
            if (result[0] !== "<") {
                result = JSON.parse(result);
                let file_path = result.pop();
                createTable(result);
                setDownloadLink(file_path, 'result all database', 'content');
            }
        },
        error: function (error) {
            alert('Error: ' + eval(error));
        }
    });
}

function exportFiles() {
    $.ajax({
        type: 'POST',
        url: 'exportFiles.php',
        contentType: false,
        processData: false,
        success: function (result) {
            if ((result[0] !== "<") && (result != "")) {
                result = JSON.parse(result);
                let columnNames = result.shift();
                result.forEach(item => {
                    setLink(item[columnNames[0]], columnNames[0]);
                    setLink(item[columnNames[1]], columnNames[1]);
                });
            }
        },
        error: function (error) {
            alert('Error: ' + eval(error));
        }
    });
}

function setDownloadLink(link, that, place) {
    $(`<a href="${link}" download>Download csv ${that}</a><br />`).appendTo($("." + place));
}

function setLink(link, name) {
    if (link[0] === '/') {
        link = link.substr(1);
    }
    $(`<a href="${link}" download>Download csv ${name} ${link}</a><br />`).appendTo($(".files"));
}

function createTable(array) {
    if (!$("div").is("table")) {
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
        $(`<th class="table__headColumn">${heads[i]}</th>`).appendTo($(".table__headColumns"));
    }
}

function createTableContent(heads, array) {
    for (let i = 0; i < array.length; i++) {
        $(`<tr></tr>`).appendTo($(".table"));
        for (let j = 0; j < heads.length; j++) {
            $(`<td>${array[i][heads[j]]}</td>`).appendTo($("tr").last());
        }
    }
}
