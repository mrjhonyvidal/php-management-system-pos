/* ======================================================
EDITAR USUARIO
========================================================*/
$('.tablasCliente').on('click','.btnEditarCliente', function(){
    var idusuario = $(this).attr("data-id");
    var idcliente = $(this).attr("data-c");
  
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

        $("#editarRazonSocial").val(respuesta.razon_social);
        $("#editarCUIT").val(respuesta.cuit);
        $("#editarIdentificacionID").val(respuesta.id_identificacion_interna);
        $("#editarPlanta").val(respuesta.planta);

        $("#editarNumeroPlanta").val(respuesta.numero_planta);
        $("#editarPais").val(respuesta.pais);       
      }
    });

});


$('.tablasCliente').on('click', '.btnHabilitarAcceso', function(){
    var idCliente = $(this).attr("data-id");
    var cuitCliente = $(this).attr("data-c");

     $("#nuevoClienteID").val(idCliente);
});


 /** ================================================
  
  ELIMINAR USUARIO

==================================================== **/

$(".tablasCliente").on("click", ".btnEliminarCliente",function(){
  
    
  var cliente = $(this).attr("iu");
  
  
  swal({
      type: "warning",
      title: "Está seguro de borrar el cliente?",
      text: "Si no lo está puede cancelar la acción",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",      
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si,borrar cliente!"
    }).then(function(result) {
      
      if (result.value) {
        window.location = "index.php?hub=clientes&token=21OPPSI6l34jj4k12j4llajkjJLADEWECWCWVvfsgw567k12jKJKJSJ&c=" + cliente;
      }

    });

});
