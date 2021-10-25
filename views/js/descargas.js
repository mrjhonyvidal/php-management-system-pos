/**=================================================
CARGAR LA TABLA DINAMICA
 "data": {
        "usuario_id": $('#u').attr("data-id"),
        "cliente_id": $('#c').attr("data-cliente")
    },    
=================================================**/

var clientDescargas = $('#orderByC').data("c");


if(clientDescargas == 1){

/**<button class="btn btn-info btnImprimirDescarga" idDescarga numeroCarta><i class="fa fa-print"></i>*/
var defaultDivDescargas = '<div class="btn-group"></button><button class="btn btn-warning btnEditarDescarga" idDescarga data-toggle="modal" aria-hidden="true" data-target="#modalEditarDescarga" numeroCarta><i class="fa fa-pencil"></i></button><button class="btn btn-danger idDescarga btnEliminarDescarga" numeroCarta><i class="fa fa-times"></i></button></div>';
}else{

    var defaultDivDescargas = '<div class="btn-group"></button><button class="btn btn-warning btnMostrarDescarga" idDescarga data-toggle="modal" aria-hidden="true" data-target="#modalEditarDescarga" numeroCarta><i class="fa fa-search"></i></div>';    
}


var tableDescargas = $(".tablaDescargas").DataTable({

	"ajax": {
        "url" : "ajax/datatable-descargas.ajax.php",
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
            "defaultContent": defaultDivDescargas
        }       
      ],
      "dom": "Bfrtip",
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 descargas', '25 descargas', '50 descargas', 'Mostrar todas' ]
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


 /**
    TODO
    DON NOT DISPLAY ANY ROW IF IS EMPTY TABLE
    if(table.page.info().recordsTotal == 0){
        $('.tablaDescargas tbody').remove();
    }
    
  }
  console.log(table.page.info().recordsTotal);
**/



/** ===================================
ORDER BY ID THE TABLE
==================================**/
tableDescargas.order([0, 'desc']);



$('.tablaDescargas tbody').on('click', 'button', function () {

    var data = tableDescargas.row ( $(this).parents('tr') ).data();

    if(typeof data == 'undefined'){
        var data = tableDescargas.row ( this ).data();
    }    

    if(window.matchMedia("(min-width:992px)").matches){

        var data = tableDescargas.row( $(this).parents('tr') ).data();

    }else{

        var data = tableDescargas.row( $(this).parents('tbody tr ul li') ).data();
    }

    
    $(this).attr("idDescarga", data[0]);  
    $(this).attr("numeroCarta", data[1]);  


} );




/*** ==================================================================
IMPRIMIR PDF DESCARGA
======================================================================**/

$(".tablaDescargas").on("click", ".btnImprimirDescarga", function(){
  
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

  window.open("extensions/TCPDF/pdfs/descarga.php?codigo=PW234FG2mO2JLSOYRENKmk2llo2iu44j32398KL90k2&io=21&m=Dkmksk298092873u&n=" + numeroCarta + "&c=a2jo209982&cuit=" + cuitCliente + "&ic=442415512312&uc=" + idCliente, "_blank");

});



$("#descargaNuevoBruto").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBruto").val() - $("#descargaNuevoTara").val());             
                        
             $('#descargaNuevoNetoSinMerma').val(totalBrutoMenosTara);    

             var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - $("#descargaNuevoMermaTotal").val());

             $('#descargaNuevoNetoConMerma').val(totalBrutoMenosTara);    
});


$("#descargaNuevoTara").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBruto").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoSinMerma').val(totalBrutoMenosTara);



             var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - $("#descargaNuevoMermaTotal").val());

             $('#descargaNuevoNetoConMerma').val(totalBrutoMenosTara); 
    

});



$("#descargaNuevoNetoSinMerma").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBruto").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoSinMerma').val(totalBrutoMenosTara);

            var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - $("#descargaNuevoMermaTotal").val());
                                     
             $('#descargaNuevoNetoConMerma').val(totalNetoConMerma);




             var aplicarMermaPorcentaje = ( $("#descargaNuevoNetoSinMerma").val() * ($("#descargaNuevoPorcentajeMerma").val()/100) );
             

             $('#descargaNuevoMermaTotal').val(aplicarMermaPorcentaje);

            var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);                        
             $('#descargaNuevoNetoConMerma').val(totalNetoConMerma);
    

});


$("#descargaNuevoPorcentajeMerma").change(function(){

             var aplicarMermaPorcentaje = ( ($("#descargaNuevoNetoSinMerma").val() * $(this).val() ) / 100 );
             

             $('#descargaNuevoMermaTotal').val(aplicarMermaPorcentaje);

              var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoConMerma').val(totalNetoConMerma);
    
});


$("#descargaNuevoMermaTotal").change(function(){

    var totalNetoConMerma = ($("#descargaNuevoNetoSinMerma").val() - $(this).val());
            
                         
    $('#descargaNuevoNetoConMerma').val(totalNetoConMerma);
});





$("#descargaNumeroCartaInterno").change(function(){
    
    var numeroCartaTyped = $(this).val();
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

    $(".alert").remove();

    var datos = new FormData();
    datos.append("numeroCartaTyped", numeroCartaTyped);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);

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
                $("#descargaCUITCartaPorteTitular").val(respuesta.cuit_titular_carta_porte);
                $("#descargaRazonTitular").val(respuesta.razon_social_titular);
                $("#descargaIDInternoTitular").val(respuesta.titular_interno_id);

                $("#descargaClienteID").val(respuesta.id_cliente);
                $("#descargaIDCartaPorte").val(respuesta.id_carta_porte);                          
                
                $("#descargaNuevoCalidad").val(respuesta.calidad);
                $("#descargaNuevoCalidad").html(respuesta.calidad);                

                // CHECK: ?Bring Bruto, Neto, NetSinMerma, TotalMerma, TotalConMerma??
                //$("#").val();               
            }else{               
                $("#descargaNumeroCartaInterno").parent().after('<div class="alert alert-warning">Carta de porte no encontrada. Intente otra vez por favor, o verifique si fue creada en la sección:<a href="cartas-de-porte"> Cartas de Porte</a></div>');
                $("#descargaNumeroCartaInterno").val("");          
            }
        }
    });
});



/*** EVENTS RELATED TO EDIT DESCARGA **/



$("#descargaNumeroCartaInternoEditar").change(function(){
    
    var numeroCartaTyped = $(this).val();
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

    $(".alert").remove();

    var datos = new FormData();
    datos.append("numeroCartaTyped", numeroCartaTyped);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);

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
                $("#descargaCUITCartaPorteTitularEditar").val(respuesta.cuit_titular_carta_porte);
                $("#descargaRazonTitularEditar").val(respuesta.razon_social_titular);
                $("#descargaIDInternoTitularEditar").val(respuesta.titular_interno_id);

                $("#descargaClienteIDEditar").val(respuesta.id_cliente);
                $("#descargaIDCartaPorteEditar").val(respuesta.id_carta_porte);                          
                
                $("#descargaNuevoCalidadEditar").val(respuesta.calidad);
                $("#descargaNuevoCalidadEditar").html(respuesta.calidad);                

                // CHECK: ?Bring Bruto, Neto, NetSinMerma, TotalMerma, TotalConMerma??
                //$("#").val();               
            }else{               
                $("#descargaNumeroCartaInternoEditar").parent().after('<div class="alert alert-warning">Carta de porte no encontrada. Intente otra vez por favor, o verifique si fue creada en la sección:<a href="cartas-de-porte"> Cartas de Porte</a></div>');
                $("#descargaNumeroCartaInternoEditar").val("");          
            }
        }
    });
});






$("#descargaNuevoBrutoEditar").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBrutoEditar").val() - $("#descargaNuevoTaraEditar").val());             
                        
             $('#descargaNuevoNetoSinMermaEditar').val(totalBrutoMenosTara);    

             var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - $("#descargaNuevoMermaTotalEditar").val());

             $('#descargaNuevoNetoConMermaEditar').val(totalBrutoMenosTara);    
});


$("#descargaNuevoTaraEditar").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBrutoEditar").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoSinMermaEditar').val(totalBrutoMenosTara);



             var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - $("#descargaNuevoMermaTotalEditar").val());

             $('#descargaNuevoNetoConMermaEditar').val(totalBrutoMenosTara); 
    

});



$("#descargaNuevoNetoSinMermaEditar").change(function(){

             var totalBrutoMenosTara = ($("#descargaNuevoBrutoEditar").val() - $(this).val());

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoSinMermaEditar').val(totalBrutoMenosTara);

            var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - $("#descargaNuevoMermaTotalEditar").val());
                                     
             $('#descargaNuevoNetoConMermaEditar').val(totalNetoConMerma);




             var aplicarMermaPorcentaje = ( $("#descargaNuevoNetoSinMermaEditar").val() * ($("#descargaNuevoPorcentajeMermaEditar").val()/100) );
             

             $('#descargaNuevoMermaTotalEditar').val(aplicarMermaPorcentaje);

            var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);                        
             $('#descargaNuevoNetoConMermaEditar').val(totalNetoConMerma);
    

});


$("#descargaNuevoPorcentajeMermaEditar").change(function(){

             var aplicarMermaPorcentaje = ( ($("#descargaNuevoNetoSinMermaEditar").val() * $(this).val() ) / 100 );
             

             $('#descargaNuevoMermaTotalEditar').val(aplicarMermaPorcentaje);

              var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - aplicarMermaPorcentaje);

             //$('#editarNetoSinMerma').val(respuesta["neto_sin_merma"]);
             
             
             $('#descargaNuevoNetoConMermaEditar').val(totalNetoConMerma);
    
});


$("#descargaNuevoMermaTotalEditar").change(function(){

    var totalNetoConMerma = ($("#descargaNuevoNetoSinMermaEditar").val() - $(this).val());
            
                         
    $('#descargaNuevoNetoConMermaEditar').val(totalNetoConMerma);
});



/***========================================================
EDITAR CARTA
=========================================================*/

$(".tablaDescargas tbody").on("click", ".btnEditarDescarga", function(){

    var idDescarga = $(this).attr("idDescarga");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

    
    var datos = new FormData();
    datos.append("idDescarga", idDescarga);
    datos.append("numeroCarta", numeroCarta);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);
    

    $.ajax({
        url:"ajax/descargas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

          console.log(respuesta);
                                    

             $('#descargaNumeroCartaInternoEditar').val(respuesta["numero_carta_porte"]);                          
             
             $('#descargaNuevoBrutoEditar').val(respuesta["descarga_bruto"]);             

             $('#descargaNuevoCTGCodEditar').val(respuesta["ctg_cod_cancelacion"]);             

             $('#descargaNuevoCCCTGCodEditar').val(respuesta["numero_ccctg"]);                          


             $('#descargaNuevoTaraEditar').val(respuesta["descarga_tara"]);


             $('#descargaClienteIDEditar').val(respuesta["id_cliente"]);             


             $('#descargaCUITCartaPorteTitularEditar').val(respuesta["cuit_titular_carta_porte"]);
             $('#descargaRazonTitularEditar').val(respuesta["razon_social_titular"]);
             $('#descargaIDInternoTitularEditar').val(respuesta["titular_interno_id"]);


              
             $('#descargaNuevoNetoSinMermaEditar').val(respuesta["descarga_neto"]);

             $('#descargaNuevoPorcentajeMermaEditar').val(respuesta["descarga_porcentaje_merma"]);
             

             $('#descargaNuevoMermaTotalEditar').val(respuesta["descarga_kilos_merma"]);
          
             
             $('#descargaNuevoCalidadEditar').val(respuesta["calidad"]);
             $('#descargaNuevoCalidadEditar').html(respuesta["calidad"]);


             $('#descargaNuevoNetoConMermaEditar').val(respuesta["descarga_neto_con_merma"]);

             $('#descargaNuevoHoraSalidaEditar').val(respuesta["hora_salida"]);
             $('#descargaNuevoFechaSalidaEditar').val(respuesta["dia_salida"]);
             $('#descargaNuevoReciboEditar').val(respuesta["recibo"]);
             
             $('#descargaNuevoObservacionesEditar').val(respuesta["obs_calidad"]);
                    
        }
    })

});





/***========================================================
ONLY READ VIEW CARTA FOR CLIENTES
=========================================================*/

$(".tablaDescargas tbody").on("click", ".btnMostrarDescarga", function(){

    var idDescarga = $(this).attr("idDescarga");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");

    
    var datos = new FormData();
    datos.append("idDescarga", idDescarga);
    datos.append("numeroCarta", numeroCarta);
    datos.append("idCliente", idCliente);
    datos.append("cuitCliente", cuitCliente);
    

    $.ajax({
        url:"ajax/descargas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){


             $('#descargaNumeroCartaInternoEditar').val(respuesta["numero_carta_porte"]);                          
             $('#descargaNumeroCartaInternoEditar').attr("readonly", "true");;                          
             

             $('#descargaNumeroCCCTG').val(respuesta["numero_ccctg"]);             
             $('#descargaNumeroCCCTG').attr("readonly", "true");  

             $('#descargaNuevoCTGCodEditar').val(respuesta["ctg_cod_cancelacion"]);
             $('#descargaNuevoCTGCodEditar').attr("readonly", "true");


             $('#descargaNuevoCCCTGCodEditar').val(respuesta["numero_ccctg"]); 
             $('#descargaNuevoCCCTGCodEditar').attr("readonly", "true");                         
             

             $('#descargaNuevoBrutoEditar').val(respuesta["descarga_bruto"]);             
             $('#descargaNuevoBrutoEditar').attr("readonly", "true");



              $('#descargaCUITCartaPorteTitularEditar').val(respuesta["cuit_titular_carta_porte"]);
              $('#descargaCUITCartaPorteTitularEditar').attr("readonly", "true");


             $('#descargaRazonTitularEditar').val(respuesta["razon_social_titular"]);
             $('#descargaRazonTitularEditar').attr("readonly", "true");


             $('#descargaIDInternoTitularEditar').val(respuesta["titular_interno_id"]);
             $('#descargaIDInternoTitularEditar').attr("readonly", "true");


             $('#descargaCUITCartaPorteTitularEditar').val(respuesta["cuit_titular_carta_porte"]);
             $('#descargaCUITCartaPorteTitularEditar').attr("readonly", "true");


             $('#descargaRazonTitularEditar').val(respuesta["razon_social_titular"]);
             $('#descargaRazonTitularEditar').attr("readonly", "true");


             $('#descargaIDInternoTitularEditar').val(respuesta["titular_interno_id"]);
             $('#descargaIDInternoTitularEditar').attr("readonly", "true");



             $('#descargaNuevoTaraEditar').val(respuesta["descarga_tara"]);
             $('#descargaNuevoTaraEditar').attr("readonly", "true");


             $('#descargaNuevoNetoSinMermaEditar').val(respuesta["descarga_neto"]);
             $('#descargaNuevoNetoSinMermaEditar').attr("readonly", "true");


             $('#descargaNuevoPorcentajeMermaEditar').val(respuesta["descarga_porcentaje_merma"]);
             $('#descargaNuevoPorcentajeMermaEditar').attr("readonly", "true");
             

             $('#descargaNuevoMermaTotalEditar').val(respuesta["descarga_kilos_merma"]);
             $('#descargaNuevoMermaTotalEditar').attr("readonly", "true");


             $('#descargaNuevoCalidadEditar').val(respuesta["calidad"]);
             $('#descargaNuevoCalidadEditar').html(respuesta["calidad"]);
             $('#descargaNuevoCalidadEditar').attr("disabled", "disabled"); 



             $('#descargaNuevoNetoConMermaEditar').val(respuesta["descarga_neto_con_merma"]);
             $('#descargaNuevoNetoConMermaEditar').attr("readonly", "true");


             $('#descargaNuevoHoraSalidaEditar').val(respuesta["hora_salida"]);
             $('#descargaNuevoHoraSalidaEditar').attr("readonly", "true");


             $('#descargaNuevoFechaSalidaEditar').val(respuesta["dia_salida"]);
             $('#descargaNuevoFechaSalidaEditar').attr("readonly", "true");


             $('#descargaNuevoReciboEditar').val(respuesta["recibo"]);
             $('#descargaNuevoReciboEditar').attr("readonly", "true");        



             //$('#descargaNuevoCalidadEditar').val(respuesta["calidad"]);
             $('#descargaNuevoObservacionesEditar').val(respuesta["obs_calidad"]);
             $('#descargaNuevoObservacionesEditar').attr("readonly", "true");


             $('#saveButton').remove();

        }
    })

});


/***========================================================
BORRAR CARTA
=========================================================*/

$(".tablaDescargas tbody").on("click", "button.btnEliminarDescarga", function(){

    var idDescarga = $(this).attr("idDescarga");
    var numeroCarta = $(this).attr("numeroCarta");
    var idCliente = $('#orderByC').data("c");
    var cuitCliente = $('#orderByD').data("d");


    swal({

        title: '¿Estás seguro de borrar la descarga?',
        text: 'Si no lo está puede cancelar la acción',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar descarga'
    }).then( function(result){
        if(result.value){

            window.location = 'index.php?hub=descargas&numeroCliente=kmdlMLKAMKMKMpALKMLdsmak&i=' + idDescarga + '&c=' + cuitCliente + '&ci=' + idCliente + '&n=' + numeroCarta;
        }
    })
    
});
