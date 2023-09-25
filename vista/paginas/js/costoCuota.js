$(document).ready(function () {
	///BOTON CERRAR
	LlenarGrilla();
	$("#error").html("");
	$("#btnCerrar").on("click", function () {});
	$("#btnCerrarAbajo").on("click", function () {});
	$("#btnCerrarAbajoMonto").on("click", function () {});

	$("#botonOcultar").trigger("click");

	$("#btnGuardar").click(function () {
		Guardar_Datos();
	});
	$("#btnNuevo").click(function () {
		costoCuotaNuevo();
	});

	$("#modalCostoCuota").on("hidden.bs.modal", function (e) {
		LlenarGrilla();
	});

	$("#descripcion").keypress(function (e) {
		//no recuerdo la fuente pero lo recomiendan para
		//mayor compatibilidad entre navegadores.
		var code = e.keyCode ? e.keyCode : e.which;
		if (code == 13) {
			$("#btnGuardar").trigger("click");
		}
	});
});

function LlenarGrilla() {
	var strUrl = "../Controller/CostoCuotaController.php";

	var datos = new FormData();
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
					buttons: [{ extend: "excelHtml5" }],
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
				$("#error").html(oRta.mensaje);
			}
		}
	});
}
function costoCuotaNuevo() {
	$("#id").val("0");
	$("#descripcion").val("");
	$("#valorCuota").val("");
	$("#modalCostoCuota").modal("show");
}

function PasarDatosCostoCuota() {
	var id = $("#id").val();
	if (id == "") {
		id = 0;
	}
	var costoCuota = {
		id: id,
		descripcion: $("#descripcion").val(),
		valorCuota: $("#valorCuota").val(),
		seguir: true,
		mensaje: ""
	};
	return costoCuota;
}
function Validar(costoCuota) {
	blnContinuar = true;

	if (costoCuota.descripcion != null && costoCuota.descripcion.length <= 0) {
		costoCuota.mensaje =
			costoCuota.mensaje + "Debe ingresar una descripción</br>";
		costoCuota.seguir = false;
		blnContinuar = false;
	}
	if (costoCuota.valorCuota != null && costoCuota.valorCuota.length <= 0) {
		costoCuota.mensaje =
			costoCuota.mensaje + "Debe ingresar un valor de cuota</br>";
		costoCuota.seguir = false;
		blnContinuar = false;
	}

	return costoCuota;
}
function Guardar_Datos() {
	////CREO EL OBJETO
	var costoCuota = PasarDatosCostoCuota();
	///Valido los datos de la Localidad
	costoCuota = Validar(costoCuota);

	if (costoCuota.seguir == false) {
		$("#error").html(
			'<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Se econtraron errores!</strong></br>' +
				costoCuota.mensaje +
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
		);
		return false;
	}
	///SI PASA LO STRINGIFICO

	var titulo = "¿Guardar datos? ";
	var content = "¿Guardar datos?";
	$.confirm({
		theme: "Modern",
		title: titulo,
		content: content,
		buttons: {
			Confirmar: function () {
				GuardarDatos(costoCuota);
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
function GuardarDatos(costoCuota) {
	var oCostoCuota = JSON.stringify(costoCuota);
	var datos = new FormData();
	$("#error").html(
		'<div class="loading"><h7>Aguarde Un momento, por favor...</h7><img src="../vista/images/save.gif"  width="50" height="50" alt="loading"/></div>'
	);
	datos.append("ACTION", "ingresarActualizarCostoCuota");
	datos.append("datosjson", oCostoCuota);

	////LO PASO CON FORM DATA
	var strUrl = "../Controller/CostoCuotaController.php";
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			alert(respuesta);
			var oRta = JSON.parse(respuesta);
			if (oRta.success == true) {
				$("#modalCostoCuota").modal("toggle");
				LlenarGrilla();
				$("#error").html("");
			} else {
				$("#error").html(oRta.mensaje);
			}
		}
	});
}
///Eliminar Socio
function fnProcesaEliminar(x) {
	var id = $(x).closest("tr").data("id");

	////CREO EL OBJETO
	var costoCuota = { id: id };

	$.confirm({
		theme: "Modern",
		title: "ELIMINACIÓN",
		content: "¿Desea eliminar el item?",
		buttons: {
			Confirmar: function () {
				eliminarCostoCuota(costoCuota);
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
function fnProcesaEditar(x) {
	var id = $(x).closest("tr").data("id");
	var descripcion = $(x).closest("tr").data("descripcion");
	var valorCuota = $(x).closest("tr").data("valorcuota");

	$("#id").val(id);
	$("#descripcion").val(descripcion);
	$("#valorCuota").val(valorCuota);

	$("#modalCostoCuota").modal("show");
}
function eliminarCostoCuota(costoCuota) {
	///SI PASA LO STRINGIFICO
	var oCostoCuota = JSON.stringify(costoCuota);
	var datos = new FormData();
	datos.append("ACTION", "eliminarCostoCuota");
	datos.append("datosjson", oCostoCuota);
	////LO PASO CON FORM DATA
	var strUrl = "../Controller/CostoCuotaController.php";
	$("#tabla").html(
		'<div class="loading"><h7>Aguarde Un momento, por favor...</h7><img src="../vista/images/save.gif"  width="50" height="50" alt="loading"/></div>'
	);
	$.ajax({
		url: strUrl,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			var oRta = JSON.parse(respuesta);

			if (oRta.success == false) {
				alert(oRta.mensaje);
			}
			LlenarGrilla();
		}
	});
}
