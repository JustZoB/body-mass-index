function SubmitFormData() {
    let mass = $("#mass").val(),
        height = $("#height").val(),
        chest = $("#chest").val();
    if (mass < 0 || height < 0 || chest < 0 || !$.isNumeric(mass) || !$.isNumeric(height) || !$.isNumeric(chest)) {
        alert("Enter nonzero positive numbers.");
    } else {
        $.post("submit.php", {mass: mass, height: height, chest: chest});
    }
}

$("#csv").css("display", "none");
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
    

