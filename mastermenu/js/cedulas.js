
img = '<img id="c_img" src="https://erp.cr/cedulas/refresh.svg" style="display:none" width="20" height="20"><img id="c_si" src="https://erp.cr/cedulas/si.svg" style="display:none" width="20" height="20"><span id="v_si" style="color:green;display:none">Cliente de NG TECHNOLOGY</span><span id="v_si2" style="color:green;display:none">Cliente encontrado en hacienda</span><img id="c_no" src="https://erp.cr/cedulas/no.svg" style="display:none" width="20" height="20">';
$("input[name='cedula']").after(img);
$("select[name='tipo_cedula']").change(function(){
code = $(this).val();
if(code=="5061") {
 $("input[name='cedula']").inputmask("9999999999",{ "placeholder": "----------" });
}	
if(code=="5062") {
 $("input[name='cedula']").inputmask("999999999",{ "placeholder": "---------" });
}	
if(code=="5063") {
 $("input[name='cedula']").inputmask("999999999999",{ "placeholder": "------------" });
}
})

function comprobar(){
var tipo = $("select[name='tipo_cedula']").val();
if(tipo !== 0){
if(tipo==5063){tipo="E"};
if(tipo==5062){tipo="N"};
if(tipo==5061){tipo="J"};

var ced = $("input[name='cedula']").val();
$("#c_no").hide();
$("#c_si").hide();	
$("#c_img").show();

$.ajax({
type: "POST",
//url: "https://erp.cr/cedulas/index.php",
url: "https://ng.erp.cr/webapp2/clientes.php",
data: {ced:ced,tipo:tipo},
dataType: "json",
success: function(resp) {
//console.log(resp);
if(resp=="-1" || resp==null ){
$("#c_no").show();$("#c_img").hide();$("#v_si").hide();$("#v_si2").hide();
//ajax cedulas 
$.ajax({
type: "POST",
url: "https://erp.cr/cedulas/index.php",
data: {ced:ced,tipo:tipo},
dataType: "json",
success: function(resp) {

//console.log(resp);
if(resp=="0" || resp==null ){
$("#c_no").show();$("#c_img").hide();
}
else{
JSON.stringify(resp);
$("input[name='firstname']").val(resp.nombre);
$("input[name='lastname']").val(resp.apellidos);
$("#c_img").hide();
$("#c_no").hide();
$("#v_si").hide();
$("input[name='email']").val('');
$("input[name='telefono']").val('');
$("#c_si").show();
$("#v_si2").show();

//llenado formulario de cliente
$('#cedula_c').val(ced);
$('#nom_c').val(resp.nombre);

$('#form_cli').modal('show')
}

}
})
//ajax cedulas


}
else{

$("input[name='firstname']").val(resp[0].nom);
$("input[name='lastname']").val(resp[0].name_alias);
$("input[name='email']").val(resp[0].email);
$("input[name='telefono']").val(resp[0].telefono);
$("#fk_soc").val(resp[0].id);
$("input[name='firstname']").focus();
$("input[name='lastname']").focus();
$("input[name='email']").focus();
$("input[name='telefono']").focus();
$("#c_img").hide();
$("#c_no").hide();
$("#v_si2").hide();
$("#c_si").show();
$("#v_si").show();

}

}
})
//envio por ajax
}
}

$('#form_cli').on('hidden.bs.modal', function (e) {
var ced = $("input[name='cedula']").val();	
var tipo = $("select[name='tipo_cedula']").val();

cedula = $('#cedula_c').val();
email = $('#email_c').val();
nom = $('#nom_c').val();
tel = $('#telefono_c').val();
name_alias = $('#name_alias_c').val();
$.ajax({
type: "POST",
url: "https://ng.erp.cr/webapp2/clientes_crear.php",
data: {ced:ced,tipo:tipo,email:email,nom:nom,name_alias:name_alias,tel:tel},
dataType: "json",
success: function(resp) {
$("input[name='firstname']").val(resp.nom);
$("input[name='lastname']").val(resp.name_alias);
$("input[name='email']").val(resp.email);
$("input[name='telefono']").val(resp.telefono);
$("#fk_soc").val(resp.id);
}
})
//envio por ajax
})


$("input[name='cedula']").blur(function(){
comprobar()	
});
