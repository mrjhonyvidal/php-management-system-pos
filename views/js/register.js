/**==========================================
VALIDAR EMAIL REPETIDO
=============================================**/
var validarEmailRepetido = false;

$("#regCorreo").change(function(){

	var email = $("#regCorreo").val();	
	$(".alert").remove();

	var datos = new FormData();
    datos.append("validarCorreo", email);
 
    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(!respuesta){
				            	
            }else{            	
            	$("#regCorreo").parent().before('<div class="alert alert-warning"><strong>Aviso: </strong> Ya existe un correo activo asociado con el CUIT');
            	$("#regCorreo").val('');            	
            }
        }
    });
});


$("#regUsuario").change(function(){
	
	var usuario = $("#regUsuario").val();
	$(".alert").remove();

	var datos = new FormData();    
    datos.append("validarUsuario", usuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(!respuesta){
				            	
            }else{            	
            	$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>Aviso: </strong> El nombre de usuario ya está asociado en el sistema');
            	$("#regUsuario").val('');            	
            }
        }
    });
});



var validarCUITRepetido = false;

$("#regCUIT").change(function(){

	var cuit = $("#regCUIT").val();
	$(".alert").remove();

	cuitTyped = cuit.replace(/[\D\s\._\-]+/g, "");    

	var datos = new FormData();
    datos.append("validarCUIT", cuitTyped);


    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(!respuesta){

            }else{            	
            	$("#regCUIT").parent().before('<div class="alert alert-warning"><strong>Aviso: </strong> el CUIT ya se encuentra registrado');
            	$("#regCUIT").val('');            	
            }
        }
    });
});