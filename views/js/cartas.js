/**=================================================
CARGAR LA TABLA DINAMICA
 "data": {
        "usuario_id": $('#u').attr("data-id"),
        "cliente_id": $('#c').attr("data-cliente")
    },    
=================================================**/

var client = $('#orderByC').data("c");


if(client == 1){

var defaultDiv = '<div class="btn-group"><button class="btn btn-info btnImprimirCarta" numeroCarta><i class="fa fa-print"></i></button><button class="btn btn-warning btnEditarCarta" idCarta data-toggle="modal" aria-hidden="true" data-target="#modalEditarCarta" numeroCarta><i class="fa fa-pencil"></i></button><button class="btn btn-danger idCarta btnEliminarCarta" numeroCarta><i class="fa fa-times"></i></button></div>';
}else{

    var defaultDiv = '<div class="btn-group"><button class="btn btn-info btnImprimirCarta" numeroCarta><i class="fa fa-print"></i></button><button class="btn btn-warning btnMostrarCarta" idCarta data-toggle="modal" aria-hidden="true" data-target="#modalEditarCarta" numeroCarta><i class="fa fa-search"></i></div>';    
}


var table = $(".tablaCartas").DataTable({

	"ajax": {
        "url" : "ajax/datatable-cartas.ajax.php",
        "type": "GET",
        "data": {
            "usuario_id": $('#orderByU').data("u"),
            "cliente_id": $('#orderByC').data("c"),
            "cliente_cuit": $('#orderByD').data("d")            
            } 
    },
	"columnDefs": [ 
		{
            "targets": -1,
            "data": null,
            "defaultContent": defaultDiv
        }       
      ],
      "dom": "Bfrtip",
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 cartas', '25 cartas', '50 cartas', 'Mostrar todas' ]
       ],
      "buttons": {
      "buttons": [
            {"extend": 'pageLength', "text": 'Mostrar 10'},
            {"extend": 'colvis', "text": 'Modificar Reporte'},
            {
                "extend": "pdfHtml5",
                "text": 'Descargar PDF',                                
                //"messageTop": 'Cuenca Sistema de Gestión Portuário',
                "exportOptions": {
                    "columns": ':visible'
                },                            
                "pageSize": 'A4',                    
                "customize": function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'left',
                        image: 'data:image/png;base64,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' 
                    } );
                }
            },            
            
        ]
      },
    "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 10 de un total de 0",
            "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Busque un valor",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",    
            "oPaginate": {
              "sFirst": "Primero",
              "sLast": "Último",
              "sNext": "Siguiente",
              "sPrevious": "Anterior"
            },
            "oAria": {
              "sSortAscending": "Activar para ordernar la columna de manera ascendente",
              "sSortDescending": "Activar para ordernar la columna de manera descendente"
            }
          }


    } );

/** ===================================
ORDER BY ID THE TABLE
==================================**/
table.order([0, 'desc']);


$('.tablaCartas tbody').on('click', 'button', function () {

    var data = table.row ( $(this).parents('tr') ).data();

    if(typeof data == 'undefined'){
        var data = table.row ( this ).data();
    }    

    /**if(window.matchMedia("(min-width:992px)").matches){

        var data = table.row( $(this).parents('tr') ).data();

    }else{

        var data = table.row( $(this).parents('tbody tr ul li') ).data();
    }**/

    
    $(this).attr("idCarta", data[0]);  
    $(this).attr("numeroCarta", data[1]);  


} );



$("#nuevoBruto").change(function(){

             var totalBrutoMenosTara = ($("#nuevoBruto").val() - $("#nuevoTara").val());             
                        
             $('#nuevoNetoSinMerma').val(totalBrutoMenosTara);    

             var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - $("#nuevoMermaTotal").val());

             $('#nuevoNetoConMerma').val(totalBrutoMenosTara);    
});


$("#nuevoTara").change(function(){

             var totalBrutoMenosTara = ($("#nuevoBruto").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#nuevoNetoSinMerma').val(totalBrutoMenosTara);



             var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - $("#nuevoMermaTotal").val());

             $('#nuevoNetoConMerma').val(totalBrutoMenosTara); 
    

});



$("#nuevoNetoSinMerma").change(function(){

             var totalBrutoMenosTara = ($("#nuevoBruto").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#nuevoNetoSinMerma').val(totalBrutoMenosTara);

            var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - $("#nuevoMermaTotal").val());
                                     
             $('#nuevoNetoConMerma').val(totalNetoConMerma);




             var aplicarMermaPorcentaje = ( $("#nuevoNetoSinMerma").val() * ($("#nuevoPorcentajeMerma").val()/100) );
             

             $('#nuevoMermaTotal').val(aplicarMermaPorcentaje);

            var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);                        
             $('#nuevoNetoConMerma').val(totalNetoConMerma);
    

});


$("#nuevoPorcentajeMerma").change(function(){

             var aplicarMermaPorcentaje = ( ($("#nuevoNetoSinMerma").val() * $(this).val() ) / 100 );
             

             $('#nuevoMermaTotal').val(aplicarMermaPorcentaje);

              var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#nuevoNetoConMerma').val(totalNetoConMerma);
    
});


$("#nuevoMermaTotal").change(function(){

    var totalNetoConMerma = ($("#nuevoNetoSinMerma").val() - $(this).val());
            
                         
    $('#nuevoNetoConMerma').val(totalNetoConMerma);
});



/*** ==========================================================
 CAPTURAR Y LLENAR CAMPOS A PARTIR DEL CUIT INGRESADO
==============================================================**/

$("#nuevoCUITCartaPorteTitular").change(function(){
    var cuitTyped = $(this).val();

    // Remove the slashs before lookup in the database
    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    


    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(respuesta){
                $("#nuevoRazonTitular").val(respuesta.razon_social);
                $("#nuevoIDInternoTitular").val(respuesta.id_identificacion_interna);
                $("#nuevoNumPlantaTitular").val(respuesta.numero_planta);
                $("#nuevoPlantaTitular").val(respuesta.planta);                
            }
        }
    });
});


$("#nuevoCUITEntregador").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");


    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(respuesta){
                $("#nuevoRazonEntregador").val(respuesta.razon_social);
                $("#nuevoIDEntregador").val(respuesta.id_identificacion_interna);                
            }

        }
    });
});


$("#nuevoCUITIntermediario").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

             if(respuesta){
                $("#nuevoRazonIntermediario").val(respuesta.razon_social);
                $("#nuevoIDIntermediario").val(respuesta.id_identificacion_interna);                                
                $("#nuevoNumPlantaIntermediario").val(respuesta.numero_planta);                                
                $("#nuevoPlantaIntermediario").val(respuesta.planta);                                
            }
        }
    });
});


$("#nuevoCUITRemitenteComercial").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    // buscar el CUIT en la tabla Clientes
    // y traer los datos que queremos llenar en el formulario

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            
              if(respuesta){
                $("#nuevoRazonRemitente").val(respuesta.razon_social);
                $("#nuevoIDRemitente").val(respuesta.id_identificacion_interna);                                
                $("#nuevoNumPlantaRemitente").val(respuesta.numero_planta);                                
                $("#nuevoPlantaRemitente").val(respuesta.planta);                                
            }
        }
    });
});


$("#nuevoCUITDestinatario").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            
             if(respuesta){
                $("#nuevoRazonDestinatario").val(respuesta.razon_social);
                $("#nuevoIDRemitente").val(respuesta.id_identificacion_interna);                                                
            }
        }
    });
})



$("#nuevoCUITCorredor").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");
    
    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){           
            
            $("#nuevoRazonCorredor").val(respuesta.razon_social);                
        }
    });
});


$("#nuevoCUITProcedencia").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            $("#nuevoRazonProcedencia").val(respuesta.razon_social);                
            
        }
    });
});

$("#nuevoCUITTransportista").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            $("#nuevoRazonTransportista").val(respuesta.razon_social);
        }
    });
});




/*** ==========================================================
 CAPTURAR Y LLENAR CAMPOS A PARTIR DEL CUIT INGRESADO
==============================================================**/

$("#editarCUITCartaPorteTitular").change(function(){
    var cuitTyped = $(this).val();

    // Remove the slashs before lookup in the database
    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    


    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            
            
            if(respuesta){
                $("#editarClienteID").val(respuesta.id_cliente);
                $("#editarRazonTitular").val(respuesta.razon_social);
                $("#editarIDInternoTitular").val(respuesta.id_identificacion_interna);
                $("#editarNumPlantaTitular").val(respuesta.numero_planta);
                $("#editarPlantaTitular").val(respuesta.planta);                
            }
        }
    });
});


$("#editarCUITEntregador").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");


    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(respuesta){
                $("#editarRazonEntregador").val(respuesta.razon_social);
                $("#editarIDEntregador").val(respuesta.id_identificacion_interna);                
            }

        }
    });
});





$("#editarBruto").change(function(){

             var totalBrutoMenosTara = ($("#editarBruto").val() - $("#editarTara").val());             
                        
             $('#editarNetoSinMerma').val(totalBrutoMenosTara);    

             var totalNetoConMerma = ($("#editarNetoSinMerma").val() - $("#editarMermaTotal").val());

             $('#editarNetoConMerma').val(totalBrutoMenosTara);    
});


$("#editarTara").change(function(){

             var totalBrutoMenosTara = ($("#editarBruto").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#editarNetoSinMerma').val(totalBrutoMenosTara);



             var totalNetoConMerma = ($("#editarNetoSinMerma").val() - $("#editarMermaTotal").val());

             $('#editarNetoConMerma').val(totalBrutoMenosTara); 
    

});



$("#editarNetoSinMerma").change(function(){

             var totalBrutoMenosTara = ($("#editarBruto").val() - $("#editarTara").val() );

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#editarNetoSinMerma').val(totalBrutoMenosTara);


              var totalNetoConMerma = ($("#editarNetoSinMerma").val() - $("#editarMermaTotal").val());
            
                         
                $('#editarNetoConMerma').val(totalNetoConMerma);
    

});


$("#editarPorcentajeMerma").change(function(){

             var aplicarMermaPorcentaje = ( ($("#editarNetoSinMerma").val() * $(this).val() ) / 100 );
             

             $('#editarMermaTotal').val(aplicarMermaPorcentaje);

              var totalNetoConMerma = ($("#editarNetoSinMerma").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#editarNetoConMerma').val(totalNetoConMerma);
    
});


$("#editarMermaTotal").change(function(){

    var totalNetoConMerma = ($("#editarNetoSinMerma").val() - $(this).val());
            
                         
    $('#editarNetoConMerma').val(totalNetoConMerma);
});




$("#editarCUITIntermediario").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

             if(respuesta){
                $("#editarRazonIntermediario").val(respuesta.razon_social);
                $("#editarIDIntermediario").val(respuesta.id_identificacion_interna);                                
                $("#editarNumPlantaIntermediario").val(respuesta.numero_planta);                                
                $("#editarPlantaIntermediario").val(respuesta.planta);                                
            }
        }
    });
});


$("#editarCUITRemitenteComercial").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    // buscar el CUIT en la tabla Clientes
    // y traer los datos que queremos llenar en el formulario

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            
              if(respuesta){
                $("#editarRazonRemitente").val(respuesta.razon_social);
                $("#editarIDRemitente").val(respuesta.id_identificacion_interna);                                
                $("#editarNumPlantaRemitente").val(respuesta.numero_planta);                                
                $("#editarPlantaRemitente").val(respuesta.planta);                                
            }
        }
    });
});


$('#modalEditarCarta').on('change','#editarCUITDestinatario',function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            
             if(respuesta){
                $("#editarRazonDestinatario").val(respuesta.razon_social);                                                            
            }
        }
    });
})



$("#editarCUITCorredor").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");
    
    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            
            
            $("#editarRazonCorredor").val(respuesta.razon_social);                
        }
    });
});


$("#editarCUITProcedencia").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");    

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            $("#editarRazonProcedencia").val(respuesta.razon_social);                
            
        }
    });
});

$("#editarCUITTransportista").change(function(){
    var cuitTyped = $(this).val();

    cuitTyped = cuitTyped.replace(/[\D\s\._\-]+/g, "");

    var datos = new FormData();
    datos.append("cuitTyped", cuitTyped);

    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            $("#editarRazonTransportista").val(respuesta.razon_social);
        }
    });
});




/**** =========================================================
MULTIPLE IMAGES SCANNED
============================================================**/
$("#nuevaScannedImages").change(function(){


    var images = this.files;
    var output = $("#resultPreview");  


    $("#resultPreview div").remove(); 



    if(images && images[0]){



        for (var i = 0; i < images.length; i++){

                var currentImage = images[i];

                if(currentImage.type != "image/jpeg" && currentImage.type != "image/png"){

                $(".nuevaScannedImages").val("");

                swal({
                    title: "Error al subir las imágenes",
                    text: "Las imágenes deben estar en el formato JPG o PNG",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

              }else if(currentImage.size > 2000000) {

                $(".nuevaScannedImages").val("");

                    swal({
                        title: "Error al subir las imágenes",
                        text: "Cada Imágen debe pesar menos de 2MB",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                   

            }else{

                var datosImagen = new FileReader();                


                $(datosImagen).on("load", function(e){

                    var rutaImagen = event.target;

                    //$('#image_upload_preview').attr('src', rutaImagen);                              

                    $("#resultPreview").append("<div><img class='thumbnail-preview' class='previewImage' src='" + rutaImagen.result + "'" +  " title='" + rutaImagen.name + "' /></div>");        

                });

                datosImagen.readAsDataURL(currentImage);

            }                     

        }
         

    }

});


/**** =========================================================
MULTIPLE EDITAR IMAGES SCANNED
============================================================**/
$("#editarScannedImages").change(function(){


    var images = this.files;
    var output = $("#resultEditarPreview"); 


    if(images && images[0]){



        for (var i = 0; i < images.length; i++){

                var currentImage = images[i];

                if(currentImage.type != "image/jpeg" && currentImage.type != "image/png"){

                $(".editarScannedImages").val("");

                swal({
                    title: "Error al subir las imágenes",
                    text: "Las imágenes deben estar en el formato JPG o PNG",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

              }else if(currentImage.size > 2000000) {

                $(".editarScannedImages").val("");

                    swal({
                        title: "Error al subir las imágenes",
                        text: "Cada Imágen debe pesar menos de 2MB",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                   

            }else{

                var datosImagen = new FileReader();                


                $(datosImagen).on("load", function(e){

                    var rutaImagen = event.target;

                    //$('#image_upload_preview').attr('src', rutaImagen);                              

                    $("#resultEditarPreview").append("<div><img class='thumbnail-preview' src='" + rutaImagen.result + "'" +  " title='" + rutaImagen.name + "' /></div>");

                });

                datosImagen.readAsDataURL(currentImage);

            }                     

        }
         

    }

});



/***========================================================
EDITAR CARTA
=========================================================*/

$(".tablaCartas tbody").on("click", ".btnEditarCarta", function(){

    var idCarta = $(this).attr("idCarta");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");




    $("#resultEditarPreview").find('div').remove();
    $("#editarScannedImages").val("");

    
    var datos = new FormData();
    datos.append("idCarta", idCarta);
    datos.append("numeroCarta", numeroCarta);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);
    

    $.ajax({
        url:"ajax/cartas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
                                    

             $('#editarNumeroCartaInterno').val(respuesta["numero_carta_porte"]);             
             $('#editarNumeroCartaInterno').val(respuesta["numero_carta_porte"]);


             $('#editarNumeroCTG').val(respuesta["numero_ctg"]);                          

             $('#editarNumeroCCCTG').val(respuesta["numero_ccctg"]);                          
             
             $('#editarCartaID').val(respuesta["id_carta_porte"]);             


             $('#editarClienteID').val(respuesta["id_cliente"]);


             $('#editarProcedenciaBruto').val(respuesta["procedencia_kilo_bruto"]);
             $('#editarProcedenciaTara').val(respuesta["procedencia_tara"]);             
             $('#editarProcedenciaNeto').val(respuesta["neto_procencia"]);              


             $('#editarCUITEntregador').val(respuesta["cuit_entregador"]);
             $('#editarRazonEntregador').val(respuesta["razon_entregador"]);
             

             $('#editarIDEntregador').val(respuesta["entregador_id"]);


             $('#editarIDInternoTitular').val(respuesta["titular_interno_id"]);


             $('#editarIDRemitente').val(respuesta["remitente_id"]);

             $('#editarIDIntermediario').val(respuesta["intermediario_id"]);
                


             $('#editarClienteID').val(respuesta["id_cliente"]);
             $('#editarClienteID').attr("readonly", "true");        



             $('#editarContrato').val(respuesta["contrato"]);



             $('#editarBruto').val(respuesta["bruto"]);

             $('#editarTara').val(respuesta["tara"]);
             
             
             $('#editarMermaTotal').val(respuesta["merma_total"]);

             $('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);                    

             $('#editarNetoConMerma').val(respuesta["neto_con_merma"]);


             $('#editarFechaDescarga').val(respuesta["fecha_descarga"]);
             $('#editarHoraIngreso').val(respuesta["hora_ingreso"]);
             $('#editarPuertoCOD').val(respuesta["codigo_puerto"]);

             $('#editarNombrePuerto').val(respuesta["puerto"]);
             $('#editarCUITDestinatario').val(respuesta["cuit_destino"]);
             $('#editarRazonDestinatario').val(respuesta["razon_social_destino"]);


             $('#editarCUITCartaPorteTitular').val(respuesta["cuit_titular_carta_porte"]);

             $('#editarRazonTitular').val(respuesta["razon_social_titular"]);


             $('#editarRazonIntermediario').val(respuesta["razon_social_intermediario"]);

             $('#editarNumPlantaTitular').val(respuesta["numero_planta_titular"]);
             $('#editarPlantaTitular').val(respuesta["planta_titular"]);



             $('#editarNumPlantaIntermediario').val(respuesta["numero_planta_intermediario"]);

             $('#editarNumPlantaRemitente').val(respuesta["numero_planta_remitente"]);
             


             $('#editarPlantaRemitente').val(respuesta["planta_remitente"]);
             $('#editarPlantaIntermediario').val(respuesta["planta_intermediario"]);


             
             if(respuesta["titular_atencion_entrega"] == 1){
                $('#editarCheckboxEntrPlantaTitular').attr("checked", true);                
             }


             if(respuesta["titular_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaTitular').attr("checked", true);
             }


             if(respuesta["intermediario_atencion_entrega"] == 1){
               $('#editarCheckboxEntrPlantaIntermediario').attr("checked", true);
             }


            if(respuesta["intermediario_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaIntermediario').attr("checked", true);
             }



             if(respuesta["remitente_atencion_entrega"] == 1){
                 $('#editarCheckboxEntrPlantaRemitente').attr("checked", true);
             }

             if(respuesta["remitente_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaRemitente').attr("checked", true);
             }



             $('#editarCUITCorredor').val(respuesta["cuit_corredor"]);

             $('#editarRazonCorredor').val(respuesta["razon_corredor"]);

             $('#editarCorredorComprador').val(respuesta["corredor_comprador"]);            



             $('#editarTipoEntrega').val(respuesta["tipo_entrega"]);
             $('#editarTipoEntrega').html(respuesta["tipo_entrega"]);


             $('#editarLocalidadDestino').val(respuesta["localidad_destino"]);

             $('#editarLocalidadProcedencia').val(respuesta["localidad_procedencia"]);



             $('#editarKiloNeto').val(respuesta["neto_procencia"]);


             $('#editarObservaciones').val(respuesta["observaciones_carta_porte"]);
             $('#editarCUITTransportista').val(respuesta["cuit_empresa_transportista"]);
             $('#editarRazonTransportista').val(respuesta["razon_social_transportista"]);

             $('#editarCUITProcedencia').val(respuesta["cuit_procedencia"]);

             $('#editarRazonProcedencia').val(respuesta["procedencia"]);


             $('#editarPatente').val(respuesta["patente_chasis"]);             
                        


             $('#editarCalidad').val(respuesta["calidad"]);
             $('#editarCalidad').html(respuesta["calidad"]);


             $('#editarSituacion').val(respuesta["estado"]);
             $('#editarSituacion').html(respuesta["estado"]);


             $('#editarIDMercaderia').val(respuesta["mercaderia_id"]); 
             $('#editarNombreMercaderia').val(respuesta["nombre_mercaderia"]); 

             $('#editarCUITIntermediario').val(respuesta["cuit_intermediario"]); 

             $('#editarCUITRemitenteComercial').val(respuesta["cuit_remitente"]); 
             $('#editarRazonRemitente').val(respuesta["razon_remitente"]); 
             $('#editarTurno').val(respuesta["turno"]); 


              var currentCarta = new FormData();
               currentCarta.append("currentCartaID", respuesta['id_carta_porte']);
               currentCarta.append("numeroCarta", numeroCarta);
               currentCarta.append("idCliente", idCliente);
               currentCarta.append("cuitCliente", cuitCliente);    

             $.ajax({
                url: "ajax/cartas.ajax.php",
                method: "POST",
                data: currentCarta,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){                    

                    for (var i = 0; i < respuesta.length; i++){                                                                

                        $("#resultEditarPreview").append("<div><img class='thumbnail-preview' src='" + respuesta[i].imagen_archivo + "'" +  " title='" + respuesta[i].imagen_archivo + "' /><button type='button' class='btn btn-danger btnEliminarImagen' data-cid='" + respuesta[i].id_carta_imagen + "' data-im='" + respuesta[i].imagen_archivo + "'><i class='fa fa-times'></i></button></div>");                                           

                        //if(respuesta[i].imagen_archivo != ""){
                        //    $("#scannedActual").
                        //}    
                    }
                }
             })                      

        }
    })

});





/***========================================================
ONLY READ VIEW CARTA FOR CLIENTES
=========================================================*/

$(".tablaCartas tbody").on("click", "button.btnMostrarCarta", function(){

    var idCarta = $(this).attr("idCarta");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

    
    var datos = new FormData();
    datos.append("idCarta", idCarta);
    datos.append("numeroCarta", numeroCarta);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);

    
    $("#resultEditarPreview").find('div').remove();
    $("#editarScannedImages").val("");
    

    $.ajax({
        url:"ajax/cartas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){


             $('#editarNumeroCartaInterno').val(respuesta["numero_carta_porte"]);             
             $('#editarNumeroCartaInterno').attr("readonly", "true");  


             $('#editarProcedenciaBruto').val(respuesta["procedencia_kilo_bruto"]);
             $('#editarProcedenciaBruto').attr("readonly", "true")

             $('#editarProcedenciaTara').val(respuesta["procedencia_tara"]);             
             $('#editarProcedenciaTara').attr("readonly", "true")

             $('#editarProcedenciaNeto').val(respuesta["neto_procencia"]);              
             $('#editarProcedenciaNeto').attr("readonly", "true")

             $('#editarNumeroCTG').val(respuesta["numero_ctg"]);             
             $('#editarNumeroCTG').attr("readonly", "true");  

             $('#editarNumeroCCCTG').val(respuesta["numero_ccctg"]);             
             $('#editarNumeroCCCTG').attr("readonly", "true");  

             $('#editarIDEntregador').val(respuesta["entregador_id"]);
             $('#editarIDEntregador').attr("readonly", "true");


             $('#editarIDInternoTitular').val(respuesta["titular_interno_id"]);
             $('#editarIDInternoTitular').attr("readonly", "true");


             $('#editarIDIntermediario').val(respuesta["intermediario_id"]);
             $('#editarIDIntermediario').attr("readonly", "true");             


             $('#editarIDRemitente').val(respuesta["remitente_id"]);
             $('#editarIDRemitente').attr("readonly", "true");



             $('#editarClienteID').val(respuesta["id_cliente"]);
             $('#editarClienteID').attr("readonly", "true");             




             $('#editarCUITEntregador').val(respuesta["cuit_entregador"]);
             $('#editarCUITEntregador').attr("readonly", "true");             

             $('#editarRazonEntregador').val(respuesta["razon_entregador"]);
             $('#editarRazonEntregador').attr("readonly", "true"); 


             $('#editarIDEntregador').val(respuesta["entregador_id"]);
             $('#editarIDEntregador').attr("readonly", "true"); 


             $('#editarCorredorComprador').val(respuesta["corredor_comprador"]);
             $('#editarCorredorComprador').attr("readonly", "true"); 
             

             $('#editarBruto').val(respuesta["bruto"]);
             $('#editarBruto').attr("readonly", "true");

             $('#editarTara').val(respuesta["tara"]);
             $('#editarTara').attr("readonly", "true");


             $('#editarMermaTotal').val(respuesta["merma_total"]);
             $('#editarMermaTotal').attr("readonly", "true");

             $('#editarNetoConMerma').val(respuesta["neto_con_merma"]);
             $('#editarNetoConMerma').attr("readonly", "true");


             $('#editarContrato').val(respuesta["contrato"]);
             $('#editarContrato').attr("readonly", "true");


             
             $('#editarKiloMercaderiaProced').val(respuesta["procedencia_kilo_bruto"]);
             $('#editarKiloMercaderiaProced').attr("readonly", "true");


             $('#editarFechaDescarga').val(respuesta["fecha_descarga"]);
             $('#editarFechaDescarga').attr("readonly", "true");


             $('#editarHoraIngreso').val(respuesta["hora_ingreso"]);
             $('#editarHoraIngreso').attr("readonly", "true");


             $('#editarPuertoCOD').val(respuesta["codigo_puerto"]);
             $('#editarPuertoCOD').attr("readonly", "true");


             $('#editarNombrePuerto').val(respuesta["puerto"]);
             $('#editarNombrePuerto').attr("readonly", "true");


             $('#editarCUITDestinatario').val(respuesta["cuit_destino"]);
             $('#editarCUITDestinatario').attr("readonly", "true");


             $('#editarRazonDestinatario').val(respuesta["razon_social_destino"]);
             $('#editarRazonDestinatario').attr("readonly", "true");


             $('#editarCUITCartaPorteTitular').val(respuesta["cuit_titular_carta_porte"]);
             $('#editarCUITCartaPorteTitular').attr("readonly", "true");


             $('#editarRazonTitular').val(respuesta["razon_social_titular"]);
             $('#editarRazonTitular').attr("readonly", "true");


             $('#editarRazonIntermediario').val(respuesta["razon_social_intermediario"]);
             $('#editarRazonIntermediario').attr("readonly", "true");


             $('#editarNumPlantaTitular').val(respuesta["numero_planta_titular"]);
             $('#editarNumPlantaTitular').attr("readonly", "true");


             $('#editarPlantaTitular').val(respuesta["planta_titular"]);
             $('#editarPlantaTitular').attr("readonly", "true");



             $('#editarNumPlantaRemitente').val(respuesta["numero_planta_remitente"]);
             $('#editarNumPlantaRemitente').attr("readonly", "true");  


             $('#editarPlantaRemitente').val(respuesta["planta_remitente"]);
             $('#editarPlantaRemitente').attr("readonly", "true");



             $('#editarNumPlantaIntermediario').val(respuesta["numero_planta_intermediario"]);
             $('#editarNumPlantaIntermediario').attr("readonly", "true");  


             $('#editarPlantaIntermediario').val(respuesta["planta_intermediario"]);
             $('#editarPlantaIntermediario').attr("readonly", "true");

    
            $('#editarCheckboxEntrPlantaTitular').attr("disabled", "disabled");                


             if(respuesta["titular_atencion_entrega"] == 1){
                $('#editarCheckboxEntrPlantaTitular').attr("checked", true);
                $('#editarCheckboxEntrPlantaIntermediario').attr("disabled", "disabled");
                 
             }


             if(respuesta["titular_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaTitular').attr("checked", true);
                $('#editarCheckboxExpPlantaTitular').attr("disabled", "disabled");                
             }


             if(respuesta["intermediario_atencion_entrega"] == 1){
               $('#editarCheckboxEntrPlantaIntermediario').attr("checked", true);
             }


            if(respuesta["intermediario_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaIntermediario').attr("checked", true);
                $('#editarCheckboxExpPlantaIntermediario').attr("disabled", "disabled");
             }



             if(respuesta["remitente_atencion_entrega"] == 1){
                 $('#editarCheckboxEntrPlantaRemitente').attr("checked", true);
                 $('#editarCheckboxEntrPlantaRemitente').attr("disabled", "disabled");
             }

             if(respuesta["remitente_atencion_exportacion"] == 1){
                $('#editarCheckboxExpPlantaRemitente').attr("checked", true);
                 $('#editarCheckboxExpPlantaRemitente').attr("disabled", "disabled");
             }


                         

             $('#editarCUITCorredor').val(respuesta["cuit_corredor"]);
             $('#editarCUITCorredor').attr("readonly", "true");


             $('#editarRazonCorredor').val(respuesta["razon_corredor"]);
             $('#editarRazonCorredor').attr("readonly", "true");


             $('#editarTipoEntrega').val(respuesta["tipo_entrega"]);
             $('#editarTipoEntrega').attr("disabled", "true");

             $('#editarTipoEntrega').html(respuesta["tipo_entrega"]);


             $('#editarLocalidadDestino').val(respuesta["localidad_destino"]);
             $('#editarLocalidadDestino').attr("readonly", "true");


             $('#editarKiloNeto').val(respuesta["neto_procencia"]);
             $('#editarKiloNeto').attr("readonly", "true");


             $('#editarObservaciones').val(respuesta["observaciones_carta_porte"]);
             $('#editarObservaciones').attr("readonly", "true");

             $('#editarCUITTransportista').val(respuesta["cuit_empresa_transportista"]);
             $('#editarCUITTransportista').attr("readonly", "true");


             $('#editarRazonTransportista').val(respuesta["razon_social_transportista"]);
             $('#editarRazonTransportista').attr("readonly", "true");

             $('#editarCUITProcedencia').val(respuesta["cuit_procedencia"]);
             $('#editarCUITProcedencia').attr("readonly", "true");


             $('#editarRazonProcedencia').val(respuesta["procedencia"]);
             $('#editarRazonProcedencia').attr("readonly", "true");


             $('#editarPatente').val(respuesta["patente_chasis"]);             
             $('#editarPatente').attr("readonly", "true");             
                        


             $('#editarCalidad').val(respuesta["calidad"]);
             $('#editarCalidad').attr("readonly", "true");

             $('#editarCalidad').html(respuesta["calidad"]);


             $('#editarSituacion').val(respuesta["estado"]);
             $('#editarSituacion').attr("readonly", "true");

             $('#editarSituacion').html(respuesta["estado"]);


             $('#editarIDMercaderia').val(respuesta["mercaderia_id"]); 
             $('#editarIDMercaderia').attr("readonly", "true"); 

             $('#editarNombreMercaderia').val(respuesta["nombre_mercaderia"]); 
             $('#editarNombreMercaderia').attr("readonly", "true"); 

             $('#editarCUITIntermediario').val(respuesta["cuit_intermediario"]); 
             $('#editarCUITIntermediario').attr("readonly", "true"); 

             $('#editarCUITRemitenteComercial').val(respuesta["cuit_remitente"]); 
             $('#editarCUITRemitenteComercial').attr("readonly", "true"); 

             $('#editarRazonRemitente').val(respuesta["razon_remitente"]); 
             $('#editarRazonRemitente').attr("readonly", "true"); 

             $('#editarTurno').val(respuesta["turno"]); 
             $('#editarTurno').attr("readonly", "true"); 


             $('#editarScannedImages').attr("disabled", "disabled");


             $('#saveButton').remove();


              var currentCarta = new FormData();
               currentCarta.append("currentCartaID", respuesta['id_carta_porte']);
               currentCarta.append("numeroCarta", numeroCarta);
               currentCarta.append("idCliente", idCliente);
               currentCarta.append("cuitCliente", cuitCliente);    

             $.ajax({
                url: "ajax/cartas.ajax.php",
                method: "POST",
                data: currentCarta,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){                    

                    for (var i = 0; i < respuesta.length; i++){                                            

                        $("#resultEditarPreview").append("<div><img class='thumbnail-preview' disabled='disabled' src='" + respuesta[i].imagen_archivo + "'" +  " title='" + respuesta[i].imagen_archivo + "' /></div>")                                           
                    }
                }
             })                      

        }
    })

});


/***========================================================
BORRAR CARTA
=========================================================*/

$(".tablaCartas tbody").on("click", "button.btnEliminarCarta", function(){

    var idCarta = $(this).attr("idCarta");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");


    swal({

        title: '¿Estás seguro de borrar la carta de porte?',
        text: 'Si, no lo está puede cancelar la acción',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar carta'
    }).then( function(result){
        if(result.value){

            window.location = 'index.php?hub=cartas-de-porte&numeroCliente=kmdlMLKAMKMKMpALKMLdsmak&i=' + idCarta + '&c=' + cuitCliente + '&ci=' + idCliente + '&n=' + numeroCarta;
        }
    })
    
});



/** ==================================================
Borrar Imagen
===============================**/
$('#resultEditarPreview').on('click', '.btnEliminarImagen', function(){   

    var $thisImage = $(this);
    var imagenPath = $thisImage.data('im');
    var imagenID = $thisImage.data('cid');
    

    var datos = new FormData();
    datos.append("borrarIndividualImg", imagenID);
    datos.append("imagePath", imagenPath);

    $.ajax({
        url: "ajax/cartas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){            

            if(respuesta){

                 $thisImage.parent().remove()

                 swal({                    
                    text: "La imagen fue borrada con éxito",
                    type: "success",
                    confirmButtonText: "Cerrar"
                });
            }            
        }
    });    

});


/*** ==================================================================
IMPRIMIR PDF CARTA
======================================================================**/

$(".tablaCartas").on("click", ".btnImprimirCarta", function(){

    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

  window.open("extensions/TCPDF/pdfs/cartaporte.php?codigo=PW234FG2mO2JLSOYRENKmk2llo2iu44j32398KL90k2&io=21&m=Dkmksk298092873u&n=" + numeroCarta + "&c=a2jo209982&cuit=" + cuitCliente + "&ic=442415512312&uc=" + idCliente, "_blank");

});