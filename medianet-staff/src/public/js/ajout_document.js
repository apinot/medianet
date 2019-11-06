$(document).ready(function () {
    $("#livre_div").show();
    $("#cd_div").hide();
    $("#dvd_div").hide();
    $("#type").change(function () {
        let select = document.getElementById('type');
        let valeur = select.options[select.selectedIndex].value;
        if( valeur=== String.raw`medianet\models\Livre`){
            $("#livre_div").show();
            $("#cd_div").hide();
            $("#dvd_div").hide();

        }
        if(valeur === String.raw`medianet\models\CD`){
            $("#livre_div").hide();
            $("#cd_div").show();
            $("#dvd_div").hide();
        }
        if(valeur === String.raw`medianet\models\DVD`){
            $("#livre_div").hide();
            $("#cd_div").hide();
            $("#dvd_div").show();
        }
    })


});