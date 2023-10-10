function diadeHoy() {
	const now = new Date();

	const day = ("0" + now.getDate()).slice(-2);
	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	const today = now.getFullYear() + "-" + month + "-" + day;
	return today;
}
function generarColorAleatorio() {
	return "#" + Math.floor(Math.random() * 16777215).toString(16);
}

$(document).ready(function () {
	// Genera un color hexadecimal aleatorio

	// Aplica el color aleatorio a la variable CSS
	document.documentElement.style.setProperty(
		"--color-random",
		generarColorAleatorio()
	);
	///BOTON CERRAR
	LlenarGrilla();
	console.log("LlenarGrilla()");
	LLenarComboSocios_abm(4);
	console.log("LLenarComboSocios_abm");
	LLenarComboSocios_abmRecibos(4);
	console.log("LLenarComboSocios_abmRecibosbm");
	LLenarComboSocios_Pagos(4);
	console.log("LLenarComboSocios_abmRecibosbm");
	LLenarComboSocios_Impresion(3);
	console.log("LLenarComboSocios_Impresion");
	LLenarComboSocios_filtro();
	console.log("LLenarComboSocios_filtro();");

	$("#fecha").val(diadeHoy());

	/* //////////////////////////////////////////////////////////////////////////////// */
	$.getScript("paginas/js/combos.js", function (data, textStatus, $xhr) {
		LLenarComboSector(5);
		console.log("LLenarComboSector();");
	});
	$("#btnCerrar").on("click", function () {});
	$("#btnCerrarAbajo").on("click", function () {});
	$("#btnCerrarAbajoMonto").on("click", function () {});

	$("#botonOcultar").trigger("click");

	$("#btnGuardar").click(function () {
		Guardar_Datos();
	});

	$("#btnGuardarElPago").click(function () {
		console.log("te pagare");
		Guardar_DatosPago();
	});

	$("#btnGuardarMonto").click(function () {
		Guardar_DatosMonto();
	});

	$("#btnNuevo").click(function () {
		//alert('PASE X AQUI');
		ReciboNuevo();
	});
	$("#btnNuevoMonto").click(function () {
		//alert('PASE X AQUI');
		ReciboNuevoMonto();
	});
	$("#btnPago").click(function () {
		//alert('PASE X AQUI');
		Pago_abm();
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
	$("#modalEmisionRecibosAbmMonto").on("hidden.bs.modal", function (e) {
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

	$("#comboSociosPagos").on("change", function (e) {
		let socioID = $("#comboSociosPagosSocio").val();
		console.log("Socio seleccionado:", socioID);

		if (socioID > 0) {
			const datos = new FormData();
			const strUrl = "../Controller/CombosController.php";
			let tabIndex = 3;
			datos.append("tabIndex", tabIndex);
			datos.append("combo", "recibosConSaldo");
			datos.append("idCombo", "comboRecibosConSaldo");
			datos.append("socioID", socioID);

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
					if (oRta.success == true) {
						$("#divcomboRecibos").html(oRta.combo);
						$("#comboRecibosConSaldo").select2();
						$("#comboRecibosConSaldo").removeAttr("disabled");
						$("comboRecibosConSaldo").select2("enable", false);
						// Agrega un controlador de eventos para el evento "change" de Select2
					} else {
						$("#cartel").html(oRta.mensaje);
					}
				}
			});
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
	const saldoFiltro = document.getElementById("saldoFiltro").value;

	const strUrl = "../Controller/EmisionDeRecibosController.php";
	const datos = new FormData();

	datos.append("socioID", socioID);
	datos.append("mesDesde", mesDesde);
	datos.append("anioDesde", anioDesde);
	datos.append("mesHasta", mesHasta);
	datos.append("anioHasta", anioHasta);
	datos.append("saldoFiltro", saldoFiltro);
	console.log("saldoFiltro:" + saldoFiltro);
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
					responsive: true,
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
	$("#modalEmisionRecibosAbm").modal("show");
}

function ReciboNuevoMonto() {
	const now = new Date();
	LLenarComboSocios_abm(4);
	$("#id").val("0");
	$("#fecha").val(diadeHoy());
	$("#periodoMes").val(now.getMonth() + 1);
	$("#periodoAnio").val(now.getFullYear());
	$("#socios_abm").val(0).trigger("change.select2");
	$("#observaciones").val("");
	$("#monto").val("0");
	$("#modalEmisionRecibosAbmMonto").modal("show");
}

function Pago_abm() {
	const now = new Date();
	LLenarComboSocios_Pagos(4);
	$("#id").val("0");
	$("#fecha").val(diadeHoy());
	$("#periodoMes").val(now.getMonth() + 1);
	$("#periodoAnio").val(now.getFullYear());
	$("#comboSociosPagosSocio").val(0).trigger("change.select2");
	$("#observaciones").val("");
	$("#monto").val("0");
	$("#modalEmisionPagosAbm").modal("show");
}

function imprimirRecibos() {
	$("#modalImpresionRecibos").modal("show");
}

function PasarDatosEmision() {
	const socioID = $("#socios_abmRecibos").val();
	const monto = 0;

	const emision = {
		fecha: $("#fecha").val(),
		periodoMes: $("#periodoMes").val(),
		periodoAnio: $("#periodoAnio").val(),
		socioId: socioID || 0,
		observaciones: $("#observaciones").val(),
		seguir: true,
		mensaje: "",
		esPorRecibo: "SI",
		monto: monto || 0 // Asigna 0 si monto es vacío o nulo
	};
	return emision;
}

function PasarDatosEmisionMonto() {
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
		esPorRecibo: "NO",
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

function ValidarMonto(emision) {
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

	emision.mensaje +=
		emision.socioId == 0
			? ((emision.seguir = false), "Debe seleccionar un socio</br>")
			: "";
	return emision;
}

function Guardar_DatosMonto() {
	let emision = PasarDatosEmisionMonto();

	emision = ValidarMonto(emision);

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

	titulo = "¿Guardar el recibo? ";
	content = "¿Guardar el recibo?";

	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarRecibosMonto(emision);
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

function Guardar_Datos() {
	let emision = PasarDatosEmision();

	emision = Validar(emision);

	if (emision.seguir == false) {
		$.alert({
			title: "¡Atención:!",
			content: emision.mensaje
		});
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

function GuardarRecibosMonto(emision) {
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
				$("#modalEmisionRecibosAbmMonto").modal("toggle");
				LlenarGrilla();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function EliminarMovimiento(Recibo) {
	const oRecibo = JSON.stringify(Recibo);
	const datos = new FormData();
	console.log(oRecibo);
	datos.append("ACTION", "eliminarMovimiento");
	datos.append("datosjson", oRecibo);
	console.log(datos);
	const strUrl = "../Controller/EmisionDeRecibosController.php";

	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		processData: false,
		contentType: false, // Agrega esto para evitar que jQuery establezca contentType automáticamente

		success: function (respuesta) {
			const oRta = JSON.parse(respuesta);
			console.log(oRta);
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
	datos.append("ComboRecibos", false);

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

function LLenarComboSocios_abmRecibos(tabIndex) {
	const datos = new FormData();
	const strUrl = "../Controller/CombosController.php";

	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "socios_abmRecibos");

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
				$("#divcomboSociosabmRecibos").html(oRta.combo);
				$("#socios_abmRecibos").select2();
				$("#socios_abmRecibos").removeAttr("disabled");
				$("socios_abmRecibos").select2("enable", false);
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}

function LLenarComboSocios_Pagos(tabIndex) {
	const datos = new FormData();
	const strUrl = "../Controller/CombosController.php";

	datos.append("tabIndex", tabIndex);
	datos.append("combo", "socios_abm");
	datos.append("idCombo", "comboSociosPagosSocio");

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
				$("#comboSociosPagos").html(oRta.combo);
				$("#comboSociosPagosSocio").select2();
				$("#comboSociosPagosSocio").removeAttr("disabled");
				$("comboSociosPagosSocio").select2("enable", false);
				// Agrega un controlador de eventos para el evento "change" de Select2
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

function eliminarMovimiento(btn) {
	// Accede a la fila completa (tr) desde el botón (this)
	var fila = btn.closest("tr");

	// Obtiene los valores de los atributos data- de la fila
	var id = fila.getAttribute("data-id");
	var socioId = fila.getAttribute("data-socioid");
	var socio = fila.getAttribute("data-socio");
	var fecha = fila.getAttribute("data-fecha");
	var periodoMes = fila.getAttribute("data-periodomes");
	var periodoAnio = fila.getAttribute("data-periodoanio");
	var reciboPago = fila.getAttribute("data-recibocobro");
	var debe = fila.getAttribute("data-debe");
	var haber = fila.getAttribute("data-haber");
	var saldo = fila.getAttribute("data-saldo");
	var pagoExistente = fila.getAttribute("data-pago-existente");
	var idPago = fila.getAttribute("data-idpago");
	var reciboPagadoID = fila.getAttribute("data-recibopagado");
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
		id: id,
		idPago: idPago,
		reciboPagadoID: reciboPagadoID,
		reciboPago: reciboPago,
		socioId: socioId,
		numeroReciboPagado: id,
		haber: debe,
		observaciones: "",
		seguir: true,
		mensaje: ""
	};
	var titulo = `¿Elimianr el ${reciboPago} para el socio: ${socio} para el perdiodo: ${periodoMes}/${periodoAnio}?`;
	var content = "Eliminar comprobante:" + id + "?";
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				EliminarMovimiento(emision);
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

function PasarDatosPago() {
	var socioID = $("#comboSociosPagosSocio").val();
	var monto = $("#montoPago").val();
	var numeroRecibo = $("#comboRecibosConSaldo").val();

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

function ValidarPago(pago) {
	blnContinuar = true;

	if (pago.fecha.length <= 0) {
		pago.mensaje = pago.mensaje + "Debe ingresar una fecha</br>";
		pago.seguir = false;
		blnContinuar = false;
	}
	if (pago.haber == 0) {
		pago.mensaje = pago.mensaje + "Debe ingresar un monto</br>";
		pago.seguir = false;
		blnContinuar = false;
	}

	if (pago.socioId == 0) {
		pago.mensaje = pago.mensaje + "Debe ingresar un socio</br>";
		pago.seguir = false;
		blnContinuar = false;
	}
	if (pago.numeroReciboPagado == 0) {
		pago.mensaje = pago.mensaje + "Debe ingresar un Nº de recibo</br>";
		pago.seguir = false;
		blnContinuar = false;
	}
	return pago;
}

function Guardar_DatosPago() {
	////CREO EL OBJETO
	var pago = PasarDatosPago();
	///Valido los datos de la emision
	pago = ValidarPago(pago);

	if (pago.seguir == false) {
		$.alert({
			title: "¡Atención:!",
			content: pago.mensaje
		});
		return false;
	}

	var titulo = "¿Guardar el pago? ";
	var content = "¿Guardar el pago?";
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarPago(pago);
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

function GuardarPago(pago) {
	var oPago = JSON.stringify(pago);
	var datos = new FormData();

	datos.append("ACTION", "ingresoPago");
	datos.append("datosjson", oPago);
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

				$("#modalEmisionPagosAbm").modal("toggle");
				LlenarGrilla();
			} else {
				$("#cartel").html(oRta.mensaje);
			}
		}
	});
}
