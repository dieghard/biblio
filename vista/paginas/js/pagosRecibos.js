function generarColorAleatorio() {
	return "#" + Math.floor(Math.random() * 16777215).toString(16);
}
$(document).ready(function () {
	///BOTON CERRAR
	// Aplica el color aleatorio a la variable CSS
	document.documentElement.style.setProperty(
		"--color-random",
		generarColorAleatorio()
	);
	LlenarGrilla();
	LLenarComboSocios_abm(4);
	LLenarComboSocios_filtro(1);

	/* //////////////////////////////////////////////////////////////////////////////// */

	// Order by the grouping
	$("#idTablaUser tbody").on("click", "tr.group", function () {
		var currentOrder = table.order()[0];
		if (currentOrder[0] === groupColumn && currentOrder[1] === "asc") {
			table.order([groupColumn, "desc"]).draw();
		} else {
			table.order([groupColumn, "asc"]).draw();
		}
	});

	$.getScript("paginas/js/combos.js", function (data, textStatus, $xhr) {
		LLenarComboSector(5);
	});

	$("#btnCerrar").on("click", function () {});
	$("#btnCerrarAbajo").on("click", function () {});
	$("#botonOcultar").trigger("click");
	$("#btnGuardar").click(function () {
		Guardar_Datos();
	});
	$("#btnNuevo").click(function () {
		ReciboNuevo();
	});
	$("#btnbuscar").click(function () {
		LlenarGrilla();
	});
	$("#modalEmisionRecibosAbm").on("hidden.bs.modal", function (e) {
		LlenarGrilla();
	});

	var theDate = new Date();
	var currMonth = theDate.getMonth();
	$("#mesDesde").val(currMonth + 1);
	$("#mesHasta").val(currMonth + 1);

	/// COMBO cmbSocio
	$("#comboSocios").on("select2:select", function (e) {
		LlenarGrilla();
	});

	$("#periodoMes").change(function () {
		if ($("#periodoMes").val() <= 0) {
			$("#periodoMes").val(1);
		}
		if ($("#periodoMes").val() > 12) {
			$("#periodoMes").val(12);
		}
	});
	$("#periodoAnio").change(function () {
		if ($("#periodoAnio").val() <= 2015) {
			$("#periodoAnio").val(2015);
		}
		if ($("#periodoAnio").val() > 2050) {
			$("#periodoAnio").val(2050);
		}
	});
});

function LlenarGrilla() {
	var socioID = $("#comboSociosfiltro").val();
	var mesDesde = $("#mesDesdeFiltro").val();
	var anioDesde = $("#anioDesdeFiltro").val();
	var mesHasta = $("#mesHastaFiltro").val();
	var anioHasta = $("#anioHastaFiltro").val();

	var strUrl = "../Controller/EmisionDeRecibosController.php";
	var datos = new FormData();

	datos.append("socioID", socioID);
	datos.append("mesDesde", mesDesde);
	datos.append("anioDesde", anioDesde);
	datos.append("mesHasta", mesHasta);
	datos.append("anioHasta", anioHasta);
	datos.append("bibliotecaID", "llenarGrilla");
	datos.append("ACTION", "llenarGrilla");

	$("#tabla").html(
		'<div class="loading"><h7>Aguarde Un momento, por favor...</h7><img src="../vista/images/save.gif"  width="50" height="50" alt="loading"/></div>'
	);
	$("#idTablaUser").html("");
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#tabla").html(oRta.tabla);
				//TRADUCCION DE LA GRILLA DE MAESTRO SECTOR!!!
				$("#idTablaUser").DataTable({
					dom: "Bfrtip",
					buttons: ["excel"],
					order: [[1, "asc"]],
					rowGroup: {
						dataSrc: 1
					},
					language: {
						lengthMenu: "Mostrando _MENU_ registros por página",
						zeroRecords: "Nada para Mostrar",
						info: "Mostrando Pagina _PAGE_ de _PAGES_",
						infoEmpty: "No hay registros disponibles",
						search: "Buscar",
						paginate: {
							first: "Primero",
							last: "Ultimo",
							next: "Siguiente",
							previous: "Anterior"
						},
						infoFiltered: "(Filtrado de _MAX_ total registros),"
					}
				});
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function ReciboNuevo() {
	var now = new Date();
	$("#id").val("0");
	$("#fecha").val(diadeHoy());
	$("#periodoMes").val(now.getMonth() + 1);
	$("#periodoAnio").val(now.getFullYear());
	LLenarComboSocios_abm(4);
	$("#cmbsocios_impresion").val("Seleccione");
	$("#cmbsocios_impresion option[value=0]").attr("selected", true);
	$("#observaciones").val("");

	$("#montoPago").val(0);
	$("#nRecibo").val(0);

	$("#modalEmisionRecibosAbm").modal("show");
}

function realizarPago(btn) {
	// Accede a la fila completa (tr) desde el botón (this)
	var fila = btn.closest("tr");

	// Obtiene los valores de los atributos data- de la fila
	var id = fila.getAttribute("data-id");
	var socioId = fila.getAttribute("data-socioid");
	var socio = fila.getAttribute("data-socio");
	var fecha = fila.getAttribute("data-fecha");
	var periodoMes = fila.getAttribute("data-periodomes");
	var periodoAnio = fila.getAttribute("data-periodoanio");
	var debe = fila.getAttribute("data-debe");
	var haber = fila.getAttribute("data-haber");
	var saldo = fila.getAttribute("data-saldo");
	var pagoExistente = fila.getAttribute("data-pago-existente");

	// Hacer lo que necesites con los datos
	console.log("ID: " + id);
	console.log("Socio ID: " + socioId);
	console.log("Socio: " + socio);
	console.log("Fecha: " + fecha);
	console.log("Periodo Mes: " + periodoMes);
	console.log("Periodo Año: " + periodoAnio);
	console.log("Debe: " + debe);
	console.log("Haber: " + haber);
	console.log("Saldo: " + saldo);
	console.log("Pago Existente: " + pagoExistente);
	// Obtener la fecha de hoy en formato 'yyyy-mm-dd'
	var fechaHoy = new Date().toISOString().slice(0, 10);

	var emision = {
		fecha: fechaHoy,
		periodoMes: periodoMes,
		periodoAnio: periodoAnio,
		socioId: socioId,
		numeroReciboPagado: id,
		haber: debe,
		observaciones: "",
		seguir: true,
		mensaje: ""
	};
	var titulo =
		"¿Guardar el pago para el socio:" +
		socio +
		" para el perdiodo:" +
		periodoMes +
		"/" +
		periodoAnio +
		"?";
	var content = "¿Guardar el pago del comprobante:" + id + "?";
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarPagoBoton(emision);
			},
			Cancelar: {
				//text: 'Cancelar', // With spaces and symbols
				action: function () {
					return;
				}
			}
		}
	});
}

function GuardarPagoBoton(emision) {
	var oEmision = JSON.stringify(emision);
	var datos = new FormData();

	datos.append("ACTION", "ingresoPago");
	datos.append("datosjson", oEmision);
	////LO PASO CON FORM DATA
	var strUrl = "../Controller/EmisionDeRecibosController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);

			if (oRta.success == true) {
				$("#error").html("");
				LlenarGrilla();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}
function PasarDatosEmision() {
	var socioID = $("#cmbsocios_impresion").val();
	var monto = $("#montoPago").val();
	var numeroRecibo = $("#nRecibo").val();

	if (socioID == "") {
		socioID = 0;
	}
	if (monto == null) {
		monto = 0;
	}
	if (monto == "") {
		monto = 0;
	}
	if (numeroRecibo == null) {
		numeroRecibo = 0;
	}
	if (numeroRecibo == "") {
		numeroRecibo = 0;
	}

	var emision = {
		fecha: $("#fecha").val(),
		periodoMes: $("#periodoMes").val(),
		periodoAnio: $("#periodoAnio").val(),
		socioId: socioID,
		numeroReciboPagado: numeroRecibo,
		haber: monto,
		observaciones: $("#observaciones").val(),
		seguir: true,
		mensaje: ""
	};
	return emision;
}

function Validar(emision) {
	blnContinuar = true;

	if (emision.fecha.length <= 0) {
		emision.mensaje = emision.mensaje + "Debe ingresar una fecha</br>";
		emision.seguir = false;
		blnContinuar = false;
	}
	if (emision.haber == 0) {
		emision.mensaje = emision.mensaje + "Debe ingresar un monto</br>";
		emision.seguir = false;
		blnContinuar = false;
	}

	if (emision.periodoMes.length <= 0) {
		emision.mensaje = emision.mensaje + "Debe ingresar un mes</br>";
		emision.seguir = false;
		blnContinuar = false;
	}
	if (emision.periodoAnio <= 0) {
		emision.mensaje = emision.mensaje + "Debe ingresar un año</br>";
		emision.seguir = false;
		blnContinuar = false;
	}
	if (emision.socioId == 0) {
		emision.mensaje = emision.mensaje + "Debe ingresar un socio</br>";
		emision.seguir = false;
		blnContinuar = false;
	}
	return emision;
}

function Guardar_Datos() {
	////CREO EL OBJETO
	var emision = PasarDatosEmision();
	///Valido los datos de la emision
	emision = Validar(emision);

	if (emision.seguir == false) {
		$("#error").html(
			'<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Se econtraron errores!</strong></br>' +
				emision.mensaje +
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
		);
		return false;
	}
	///SI PASA LO STRINGIFICO

	var titulo = "¿Guardar el pago? ";
	var content = "¿Guardar el pago?";
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarPago(emision);
			},
			Cancelar: {
				//text: 'Cancelar', // With spaces and symbols
				action: function () {
					return;
				}
			}
		}
	});
}

function GuardarPago(emision) {
	var oEmision = JSON.stringify(emision);
	var datos = new FormData();

	datos.append("ACTION", "ingresoPago");
	datos.append("datosjson", oEmision);
	////LO PASO CON FORM DATA
	var strUrl = "../Controller/EmisionDeRecibosController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);

			if (oRta.success == true) {
				$("#error").html("");

				$("#modalEmisionRecibosAbm").modal("toggle");
				LlenarGrilla();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}
///Eliminar Socio
function fnProcesaEliminar(x) {
	var id = $(x).closest("tr").data("id");
	////CREO EL OBJETO
	var socio = { id: id };

	$.confirm({
		theme: "Modern",
		title: "ELIMINACIÓN SOCIO",
		content:
			"¿Desea eliminar el socio?- Atención:si el socio tiene movimientos no va a ser eliminado",
		buttons: {
			Confirmar: function () {
				EliminarSocio(socio);
			},
			Cancelar: {
				//text: 'Cancelar', // With spaces and symbols
				action: function () {
					return;
				}
			}
		}
	});
}

function EliminarRecibo(Recibo) {
	///SI PASA LO STRINGIFICO
	var oRecibo = JSON.stringify(Recibo);
	var datos = new FormData();
	datos.append("ACTION", "eliminarSocio");
	datos.append("datosjson", oRecibo);
	////LO PASO CON FORM DATA
	var strUrl = "../Controller/userController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		contentType: "application/json; charset=utf-8",
		data: datos,
		cache: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				LlenarGrilla();
			} else {
				alert(oRta.mensaje);
			}
		}
	});
}

function LLenarComboSocios_abm(tabIndex) {
	var datos = new FormData();
	var strUrl = "../Controller/CombosController.php";
	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "cmbsocios_impresion");
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#comboSociosabm").html(oRta.combo);
				$("#cmbsocios_impresion").select2();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function LLenarComboSocios_filtro(tabIndex) {
	var datos = new FormData();
	var strUrl = "../Controller/CombosController.php";
	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "comboSociosfiltro");

	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#comboSocios").html(oRta.combo);
				$("#comboSociosfiltro").select2();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}
function diadeHoy() {
	var now = new Date();

	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + month + "-" + day;
	return today;
}
