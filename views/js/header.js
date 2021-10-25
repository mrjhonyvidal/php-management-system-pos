/* ======================================================
EDITAR USUARIO
========================================================*/
$('#profile').on('click', '.btnEditarProfile', function(){
    var idusuario = $(this).attr("data-id");
    var idcliente = $(this).attr("data-c");    

    var datos = new FormData();
    datos.append("idUsuario", idusuario);
    datos.append("idCliente", idcliente);


    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){        

        $("#profileNombre").val(respuesta.nombre);
        $("#profileApellido").val(respuesta.apellido);
        $("#profileUsuario").val(respuesta.usuario);
        $("#profileCorreo").val(respuesta.correo);

        $('#profileClienteID').html(respuesta.razon_social);
        $('#profileClienteID').val(respuesta.cliente_id);

        
        $('#profileIDUsuario').val(respuesta.id);
        //$('#editarClienteID').text(respuesta.razon_social);        

        $("#profilePerfil").html(respuesta.perfil);
        $("#profilePerfil").val(respuesta.perfil);
        
        $("#profileEstado").html(respuesta.estado);
        $("#profileEstado").val(respuesta.estado);

        //Hidden fields to keep data unless they were filled with new data
        $("#profilePasswordActual").val(respuesta.password);
        $("#profileFotoActual").val(respuesta.foto);

        if(respuesta.foto != ""){
            $(".previsualizar-edicion").attr("src", respuesta.foto);
        }          

      }
    });


    var datos = new FormData();
    datos.append("idUsuario", idusuario);
    datos.append("idCliente", idcliente);


    $.ajax({
      url: "ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){        

        $("#profileRazonSocial").val(respuesta.razon_social);
        $("#profileCUIT").val(respuesta.cuit);
        $("#profileIdentificacionID").val(respuesta.id_identificacion_interna);
        $("#profilePlanta").val(respuesta.planta);

        $("#profileNumeroPlanta").val(respuesta.numero_planta);
        $("#profilePais").val(respuesta.pais);       

      }
    });


    var datos = new FormData();    
    datos.append("idCliente", idcliente);
  
    $.ajax({
      url: "ajax/configuraciones.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){        

        $("#secret_key").val(respuesta.online_correo_provider_secret_key);     
        $("#correo_name").val(respuesta.correo_name);     
        $("#correo_from").val(respuesta.correo_from);     
      }
    });



      


});