$(document).on('change', "#serbinario_bundle_jadibundle_radiotv_emissoraEmissora", function () {
    var emissora = $("#serbinario_bundle_jadibundle_radiotv_emissoraEmissora").val();

    if (emissora !== "") {
        var dados = {
            idEmissora: emissora
        }

        jQuery.ajax({
            type: 'POST',
            url: "consultaPrograma",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var option = '';

            if (json['msg'] === "sucesso") {
                option += '<option value="">Selecione o Programa</option>';
                for (var i = 0; i < json['dados'].length; i++) {
                    option += '<option value="' + json['dados'][i]['idPrograma'] + '">' + json['dados'][i]['programa'] + '</option>';
                }

                $('#serbinario_bundle_jadibundle_radiotv_programaPrograma option').remove();
                $("#serbinario_bundle_jadibundle_radiotv_programaPrograma").append(option);
            } else {
                bootbox.alert("Não há programa para essa emissora selecionada");
                //alert("Não há programa para essa emissora selecionada");
                //$('#cola_subcategoria option').remove();
            }

        });
    }
});

$(document).on('change', "#serbinario_bundle_jadibundle_radiotv_programaPrograma", function () {
    var programa = $("#serbinario_bundle_jadibundle_radiotv_programaPrograma").val();

    if (programa !== "") {
        var dados = {
            idPrograma: programa
        };

        jQuery.ajax({
            type: 'POST',
            url: "consultaApresentador",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            console.log(json);
            if (json['msg'] === "sucesso") {

                $('#serbinario_bundle_jadibundle_radiotv_apresentador').val(json['apresentador']);

            } else {
                bootbox.alert("Não há apresentador para o programa selecionado");
                //alert("Não há apresentador para o programa selecionado");
                //$('#serbinario_bundle_jadibundle_radiotv_apresentador').val("");
            }

        });
    } else {
        $('#serbinario_bundle_jadibundle_radiotv_apresentador').val("");
    }
});

$(document).on('change', "#assunto", function () {
    var assunto = $("#assunto").val();

    $('#serbinario_bundle_jadibundle_radiotv_assunto').val(assunto);
});



