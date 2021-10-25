/*======================================
SUBIENDO LA FOTO DEL USUARIO
========================================*/

$(".nuevaFoto").change(function(){

  var imagen = this.files[0];

  /*====================================
  VALIDACIÓN DEL FORMATO DE LA IMAGEN
  =======================================*/

  if(imagen.type != "image/jpeg" && imagen.type != "image/png"){

    $(".nuevaFoto").val("");

    swal({
        title: "Error al subir la imagen",
        text: "La imagen debe estar en el formato JPG o PNG",
        type: "error",
        confirmButtonText: "Cerrar"
    });

  }else if(imagen.size > 2000000) {

    $(".nuevaFoto").val("");

    swal({
        title: "Error al subir la imagen",
        text: "La imagen no debe pesar más de 2MB",
        type: "error",
        confirmButtonText: "Cerrar"
    });

  }else{

    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function(event){
        var rutaImagen = event.target.result;

        $(".previsualizar").attr("src", rutaImagen);        

         $(".previsualizar-edicion").attr("src", rutaImagen);
    });
  }

});

/* ======================================================
EDITAR USUARIO
========================================================*/
$('.tablasUsuarios').on('click','.btnEditarUsuario', function(){
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

        $("#editarNombre").val(respuesta.nombre);
        $("#editarApellido").val(respuesta.apellido);
        $("#editarUsuario").val(respuesta.usuario);
        $("#editarCorreo").val(respuesta.correo);

        $('#editarClienteID').html(respuesta.razon_social);
        $('#editarClienteID').val(respuesta.cliente_id);

        
        $('#idUsuario').val(respuesta.id);
        //$('#editarClienteID').text(respuesta.razon_social);        

        $("#editarPerfil").html(respuesta.perfil);
        $("#editarPerfil").val(respuesta.perfil);
        
        $("#editarEstado").html(respuesta.estado);
        $("#editarEstado").val(respuesta.estado);

        //Hidden fields to keep data unless they were filled with new data
        $("#passwordActual").val(respuesta.password);
        $("#fotoActual").val(respuesta.foto);

        if(respuesta.foto != ""){
            $(".previsualizar-edicion").attr("src", respuesta.foto);
        }          

      }
    });

});


/** ====================================================================
ACTIVAR USUARIO ON STATUS BUTTON OF GRID
======================================================================**/

$(".tablasUsuarios").on("click", ".btnActivar",function(){

  var idUsuario = $(this).attr("idUsuario");
  var estadoUsuario  = $(this).attr("estadoUsuario");

  var datos = new FormData();
  datos.append("activarId", idUsuario);
  datos.append("activarUsuario", estadoUsuario);

  $.ajax({

      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
              
      }
  });


  if(estadoUsuario == 'DESACTIVADO'){

    $(this).removeClass('btn-success');
    $(this).addClass('btn-danger');    
    $(this).html('DESACTIVADO');
    $(this).attr('estadoUsuario', 'DESACTIVADO');

  }else{

    $(this).removeClass('btn-danger');
    $(this).addClass('btn-success');    
    $(this).html('ACTIVADO');
    $(this).attr('estadoUsuario', 'ACTIVADO');    
  }

});


/** ================================================
  
  REVISAR SI USUARIO O CORREO YA ESTÁN REGISTRADOS

==================================================== **/


$("#nuevoUsuario").change(function(){

  $(".alert").remove();

  var usuario = $(this).val();

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
          
          if(respuesta){
            $("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe.</div>');
            $("#nuevoUsuario").val("");
          }
      }
  });


});



 $("#nuevoCorreo").change(function(){

  $(".alert").remove();

  var correo = $(this).val();

  var datos = new FormData();
  datos.append("validarCorreo", correo);

  $.ajax({

      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){

          if(respuesta){
            $("#nuevoCorreo").parent().after('<div class="alert alert-warning">Este correo ya existe.</div>');
            $("#nuevoCorreo").val("");
          }
      }
  });

});




$("#editarUsuario").change(function(){

  $(".alert").remove();

  var usuario = $(this).val();

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
          
          if(respuesta){
            $("#editarUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe.</div>');
            $("#editarUsuario").val("");
          }
      }
  });


});



 $("#editarCorreo").change(function(){

  $(".alert").remove();

  var correo = $(this).val();

  var datos = new FormData();
  datos.append("validarCorreo", correo);

  $.ajax({

      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){

          if(respuesta){
            $("#editarCorreo").parent().after('<div class="alert alert-warning">Este correo ya existe.</div>');
            $("#editarCorreo").val("");
          }
      }
  });

});




 /** ================================================
  
  ELIMINAR USUARIO

==================================================== **/

$(".tablasUsuarios").on("click", ".btnEliminarUsuario",function(){

  var idUsuario = $(this).attr("iu");
  var fotoUsuario = $(this).attr("f"); 
  var usuario = $(this).attr("u"); 
  var cliente = $(this).attr("c");

  
  swal({
      type: "warning",
      title: "Está seguro de borrar el usuario?",
      text: "Si no lo está puede cancelar la acción",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",      
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si,borrar usuario!"
    }).then(function(result) {
      
      if (result.value) {
        window.location = "index.php?hub=usuarios&iu=" + idUsuario + "&f=" + fotoUsuario + "&u=" + usuario + "&c=" + cliente;
      }

    });

});