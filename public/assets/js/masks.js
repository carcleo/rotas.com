$('#zip').mask('99999-999');
$("#precoUnitario").mask("999999");
$("#estoque").mask("999");
$("#peso").mask("999");
$("#comprimento").mask("999");
$("#largura").mask("999");
$("#prensagem").mask("999");
$("#potencia").mask("9999");
$("#consumo").mask("99");
$("#cabo").mask("999");
$("#disjuntor").mask("999");
$("#corrente").mask("99");

var options = {
    onKeyPress: function (field, ev, el, op) {     
        var masks = [
                       '000.000.000-00#', 
                       '00.000.000/0000-00',
                       '(00)0000-0000#', 
                       '(00)00000-0000'
                    ];
        $('#document').mask(
            field.length > 14 
                ? masks[1] 
                : masks[0], op
        );
        $('#tel').mask(
            field.length > 13
               ? masks[3] 
               : masks[2], op
        );
    }
}
if ($('#document').length) {
    $('#document').val().length > 11 
        ? $('#document').mask('00.000.000/0000-00', options) 
    : $('#document').mask('000.000.000-00#', options);
}
if ($('#tel').length) {
    $('#tel').val().length > 10 
        ? $('#tel').mask('(00)00000-0000', options) 
        : $('#tel').mask('(00)0000-0000#', options);
}