$("#btnGenerateReporteCSV").click(function(){

    var cuitTyped = $('#filtroCUITCartaTitular').val();
    var calidadFilter = $('#filtroCalidad').val();
   	var situacionFilter = $('#filtroSituacion').val();   	
   	var fechaDescargaInicial = $('#filtroFechaDescargaInicial').val();
   	var fechaDescargaFinal = $('#filtroFechaDescargaFinal').val();   	

   	cuitFilter = cuitTyped.replace(/[\D\s\._\-]+/g, "");      	


  	window.open("helpers/csvGenerator.php?codigo=882iih2ihjknnOSWk2ShncWiasf8s&io=21&m=Dkmksk298092873u&cuitFilter=" + cuitFilter + "&calidadFilter=" + calidadFilter + "&situacionFilter=" + situacionFilter + "&fechaDescargaInicial=" + fechaDescargaInicial + "&fechaDescargaFinal=" + fechaDescargaFinal);  
});


$("#btnGenerateReportePDF").click(function(){

    var cuitTyped = $('#filtroCUITCartaTitular').val();
    var calidadFilter = $('#filtroCalidad').val();
   	var situacionFilter = $('#filtroSituacion').val();   	
   	var fechaDescargaInicial = $('#filtroFechaDescargaInicial').val();
   	var fechaDescargaFinal = $('#filtroFechaDescargaFinal').val();   	

   	cuitFilter = cuitTyped.replace(/[\D\s\._\-]+/g, "");      	   

  	window.open("extensions/TCPDF/pdfs/reportecartas.php?codigo=j2oOJin20HisuUSj678SpMKS6029JLSKbvn652&io=21&m=Dkmksk298092873u&cuitFilter=" + cuitFilter + "&calidadFilter=" + calidadFilter + "&situacionFilter=" + situacionFilter + "&fechaDescargaInicial=" + fechaDescargaInicial + "&fechaDescargaFinal=" + fechaDescargaFinal, "_blank");  	
});