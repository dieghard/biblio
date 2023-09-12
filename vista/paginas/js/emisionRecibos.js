function diadeHoy() {
	const now = new Date();

	const day = ("0" + now.getDate()).slice(-2);
	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	const today = now.getFullYear() + "-" + month + "-" + day;
	return today;
}
$(document).ready(function () {
	///BOTON CERRAR
	LlenarGrilla();
	LLenarComboSocios_abm(4);
	LLenarComboSocios_Impresion(3);
	LLenarComboSocios_filtro();
	$("#fecha").val(diadeHoy());

	/* //////////////////////////////////////////////////////////////////////////////// */
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
		//alert('PASE X AQUI');
		ReciboNuevo();
	});
	$("#btnImprimir").click(function () {
		imprimirRecibos();
	});
	$("#btnbuscar").click(function () {
		LlenarGrilla();
	});

	$("#btnImprimirRecibo").click(function () {
		Impresion_de_todos_los_recibos();
	});
	$("#modalEmisionRecibosAbm").on("hidden.bs.modal", function (e) {
		LlenarGrilla();
	});
	const theDate = new Date();
	const currMonth = theDate.getMonth();
	$("#mesDesde").val(currMonth + 1);
	$("#mesHasta").val(currMonth + 1);
	/// COMBO cmbSocio
	$("#cmbSocio").on("select2:select", function (e) {
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
function LLenarComboSocios_Impresion(tabIndex) {
	const datos = new FormData();
	const strUrl = "../Controller/CombosController.php";
	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "socios_impresion");
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			//alert(respuesta);
			const oRta = JSON.parse(respuesta);

			if (oRta.success == true) {
				$("#comboSociosImpresion").html(oRta.combo);
				$("#socios_impresion").select2();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function Impresion_de_todos_los_recibos() {
	const socioID = $("#socios_impresion").val();
	const mesImpresion = $("#periodoMesImpresion").val();
	const anioImpresion = $("#periodoAnioImpresion").val();
	const numeroReciboImpresion = $("#numeroReciboImpresion").val();
	const sectorImpresion = $("#cmbSector").val();
	if (mesImpresion == null) {
		mesImpresion = 0;
	}
	if (mesImpresion == "") {
		mesImpresion = 0;
	}

	if (anioImpresion == null) {
		anioImpresion = 0;
	}

	const strUrl = "paginas/recibos/impresionrecibos.php";
	$("#tabla").html(
		'<div class="loading"><h7>Aguarde Un momento, por favor...</h7><img src="../vista/images/save.gif"  width="50" height="50" alt="loading"/></div>'
	);
	$("#idTablaUser").html("");
	document.location.href =
		strUrl +
		"?ACTION=impresionRecibos&socioID=" +
		socioID +
		"&mesImpresion=" +
		mesImpresion +
		"&anioImpresion=" +
		anioImpresion +
		"&numeroReciboImpresion=" +
		numeroReciboImpresion +
		"&sectorImpresion=" +
		sectorImpresion;
}
function LlenarGrilla() {
	const socioID = $("#comboSociosfiltro").val();
	const mesDesde = $("#mesDesdeFiltro").val();
	const anioDesde = $("#anioDesdeFiltro").val();
	const mesHasta = $("#mesHastaFiltro").val();
	const anioHasta = $("#anioHastaFiltro").val();
	const strUrl = "../Controller/EmisionDeRecibosController.php";
	const datos = new FormData();

	datos.append("socioID", socioID);
	datos.append("mesDesde", mesDesde);
	datos.append("anioDesde", anioDesde);
	datos.append("mesHasta", mesHasta);
	datos.append("anioHasta", anioHasta);
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
			console.log(respuesta);
			const oRta = JSON.parse(respuesta);
			console.log(oRta);
			if (oRta.success == true) {
				$("#tabla").html(oRta.tabla);
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
	const now = new Date();
	LLenarComboSocios_abm(4);
	$("#id").val("0");
	$("#fecha").val(diadeHoy());
	$("#periodoMes").val(now.getMonth() + 1);
	$("#periodoAnio").val(now.getFullYear());

	$("#socios_abm").val(0).trigger("change.select2");

	$("#observaciones").val("");
	$("#observaciosnes").val("");
	$("#modalEmisionRecibosAbm").modal("show");
}

function imprimirRecibos() {
	$("#modalImpresionRecibos").modal("show");
}
function PasarDatosEmision() {
	const socioID = $("#socios_abm").val();
	const monto = $("#monto").val();

	const emision = {
		fecha: $("#fecha").val(),
		periodoMes: $("#periodoMes").val(),
		periodoAnio: $("#periodoAnio").val(),
		socioId: socioID || 0,
		observaciones: $("#observaciones").val(),
		seguir: true,
		mensaje: "",
		monto: monto || 0 // Asigna 0 si monto es vacío o nulo
	};
	return emision;
}

function Validar(emision) {
	emision.seguir = true;

	emision.mensaje += !emision.fecha
		? ((emision.seguir = false), "Debe ingresar un fecha</br>")
		: "";

	emision.mensaje += !emision.periodoMes
		? ((emision.seguir = false), "Debe ingresar un mes</br>")
		: "";

	emision.mensaje += !emision.periodoAnio
		? ((emision.seguir = false), "Debe ingresar un año</br>")
		: "";

	return emision;
}

function Guardar_Datos() {
	let emision = PasarDatosEmision();

	emision = Validar(emision);

	if (emision.seguir == false) {
		$("#error").html(
			'<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Se econtraron errores!</strong></br>' +
				emision.mensaje +
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
		);
		return false;
	}
	let titulo = "";
	let content = "";
	if (emision.socioId == 0) {
		titulo = "¿Guardar el / los  recibos? ";
		content =
			"AL NO SELECCIONAR NINGUN SOCIO SE GENERARA LOS RECIBOS PARA TODOS LOS SOCION, ¿Continuar?";
	} else {
		titulo = "¿Guardar el / los  recibos? ";
		content = "¿Guardar el / los  recibos?";
	}
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarRecibos(emision);
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

function GuardarRecibos(emision) {
	const oEmision = JSON.stringify(emision);
	const datos = new FormData();
	datos.append("ACTION", "ingresoEmision");
	datos.append("datosjson", oEmision);
	////LO PASO CON FORM DATA
	const strUrl = "../Controller/EmisionDeRecibosController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			const oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				console.log(oRta);
				alert("Cantidad de registros nuevos:" + oRta.registrosNuevos);
				$("#modalEmisionRecibosAbm").modal("toggle");
				LlenarGrilla();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function fnProcesaEliminar(x) {
	const id = $(x).closest("tr").data("id");
	const socio = { id: id };

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
	const oRecibo = JSON.stringify(Recibo);
	const datos = new FormData();
	datos.append("ACTION", "eliminarSocio");
	datos.append("datosjson", oRecibo);
	////LO PASO CON FORM DATA
	const strUrl = "../Controller/userController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		contentType: "application/json; charset=utf-8",
		data: datos,
		cache: false,
		processData: false,
		success: function (respuesta) {
			const oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				LlenarGrilla();
			} else {
				alert(oRta.mensaje);
			}
		}
	});
}

function LLenarComboSocios_abm(tabIndex) {
	const datos = new FormData();
	const strUrl = "../Controller/CombosController.php";

	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "socios_abm");

	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			const oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#divcomboSociosabm").html(oRta.combo);
				$("#socios_abm").select2();
				$("#socios_abm").removeAttr("disabled");
				$("socios_abm").select2("enable", false);

				LLenarComboSocios_Impresion(4);
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function LLenarComboSocios_filtro(tabIndex) {
	const datos = new FormData();
	const strUrl = "../Controller/CombosController.php";
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
			const oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#comboSocios").html(oRta.combo);
				if ($("#comboSocios").length > 0) {
					$("#comboSociosfiltro").select2();
				}
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}
