/** ============================================
INPUTS MASK FORMAT for CUIT format 00-00000000-0
==============================================**/

    var $form = $( "form" );    
    var $inputCUIT = $form.find(".cuit");

    $inputCUIT.focus();

    $inputCUIT.on("keyup", function( event ){

      // When the user select text in the document, also abort
      var selection = window.getSelection().toString();

      //Makes a selection within the input
      if( selection != '' ){
        return;
      }      

      //Presses the arrows keys on the keyboard
      if( $.inArray( event.keyCode, [38,40,37,39]) !== -1 ){
        return;
      }

      // Retrieve the value from the input
      var $this = $(this);
      var input = $this.val();

      // Sanitize the value using RegExp removing spaces, underscores, dashes and letters
      input = input.replace(/[\D\s\._\-]+/g, "");

      // Deploy parseInt() funtion to make sure the value is an integer(a round number)
      //input = input ? parseInt( input, 10 ) : 0;


      // Split the input into three chunks of characters
      var split = 3;
      var chunk = [];


      for (var i = 0, len = input.length; i < len; i += split){
        
        if( i < 2){
          split = 2
        }else if ( i >= 2 && i <= 9 ){
          split = 8
        }else{
          split = 1
        }
        
        chunk.push( input.substr( i, split ) );
      }

      // Merge each piece with a dash
      $this.val( function() {
        return chunk.join("-");
      });

    });



    var $form = $( "#modalEditarCarta #form" );    
    var $inputCUIT = $form.find(".cuit");

    $inputCUIT.focus();

    $inputCUIT.on("keyup", function( event ){

      // When the user select text in the document, also abort
      var selection = window.getSelection().toString();

      //Makes a selection within the input
      if( selection != '' ){
        return;
      }      

      //Presses the arrows keys on the keyboard
      if( $.inArray( event.keyCode, [38,40,37,39]) !== -1 ){
        return;
      }

      // Retrieve the value from the input
      var $this = $(this);
      var input = $this.val();

      // Sanitize the value using RegExp removing spaces, underscores, dashes and letters
      input = input.replace(/[\D\s\._\-]+/g, "");

      // Deploy parseInt() funtion to make sure the value is an integer(a round number)
      //input = input ? parseInt( input, 10 ) : 0;


      // Split the input into three chunks of characters
      var split = 3;
      var chunk = [];


      for (var i = 0, len = input.length; i < len; i += split){
        
        if( i < 2){
          split = 2
        }else if ( i >= 2 && i <= 9 ){
          split = 8
        }else{
          split = 1
        }
        
        chunk.push( input.substr( i, split ) );
      }

      // Merge each piece with a dash
      $this.val( function() {
        return chunk.join("-");
      });

    });


var $form = $( "#modalEditarCliente #form" );    
    var $inputCUIT = $form.find(".cuit");

    $inputCUIT.focus();

    $inputCUIT.on("keyup", function( event ){

      // When the user select text in the document, also abort
      var selection = window.getSelection().toString();

      //Makes a selection within the input
      if( selection != '' ){
        return;
      }      

      //Presses the arrows keys on the keyboard
      if( $.inArray( event.keyCode, [38,40,37,39]) !== -1 ){
        return;
      }

      // Retrieve the value from the input
      var $this = $(this);
      var input = $this.val();

      // Sanitize the value using RegExp removing spaces, underscores, dashes and letters
      input = input.replace(/[\D\s\._\-]+/g, "");

      // Deploy parseInt() funtion to make sure the value is an integer(a round number)
      //input = input ? parseInt( input, 10 ) : 0;


      // Split the input into three chunks of characters
      var split = 3;
      var chunk = [];


      for (var i = 0, len = input.length; i < len; i += split){
        
        if( i < 2){
          split = 2
        }else if ( i >= 2 && i <= 9 ){
          split = 8
        }else{
          split = 1
        }
        
        chunk.push( input.substr( i, split ) );
      }

      // Merge each piece with a dash
      $this.val( function() {
        return chunk.join("-");
      });

    });



// When Form Submit
 /** $form.on("submit", function( event) {

      var $this = $( this );
      var arr = $this.serializeArray();

      for (var i = 0; i < arr.length; i++){
        // Sanitize the values
        arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, '');
      }            

      //event.preventDefault();

  });
  **/

/** =================================
DATATABLES
=====================================**/
var tabla = $(".tablas").DataTable({
  responsive: true,
  "language": {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty": "Mostrando registros del 0 al 10 de un total de 0",
    "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
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
});


try{
  new $.fn.dataTable.FixedHeader( tabla );
}catch(err){
  // silent error // Do not initialize the dataTable in this page
}



