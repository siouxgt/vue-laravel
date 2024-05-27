document.addEventListener("DOMContentLoaded", () => {
    let filtroActual = 0;
    cargarMensajes(1);

    function cargarMensajes(estatus) {
        filtroActual = estatus;

        if ($.fn.dataTable.isDataTable('#tbl_mensajes_proveedor')) {
            $('#tbl_mensajes_proveedor').DataTable().destroy();
        }

        $("#tbl_mensajes_proveedor").DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                url: url + "asset/datatables/Spanish.json",
            },
            ajax: {
                url: route("mensaje_proveedor.fetch_mensajes", estatus),
                type: "GET",
            },
            columnDefs: [{
                searchable: false,
                orderable: false,
                targets: 0,
            }],
            "createdRow": function (row, data, dataIndex) {
                if (!data.leido) $(row).addClass('font-weight-bold');
            },
            order: [],
            columns: [
                { "orderable": false, "mRender": function (data, type, row) { return `<input type="checkbox" class="check-mensaje form-check-input">`; } },
                { data: "id", defaultContent: "" },
                { "orderable": false, "className": "text-center", "mRender": function (data, type, row) { return `<a class='btn_establecer_destacado_unico' href='javascript:void(0)'><i class="${(row.tipo_remitente == 2) ? (row.destacado_remitente) ? 'fa-solid' : 'fa-regular' : (row.destacado) ? 'fa-solid' : 'fa-regular'} fa-star fa-lg"></i></a>`; } },
                { data: "fecha", className: "text-center" },
                { data: "nombre_usuario" },
                { data: "asunto" },
                { data: "origen" },
                { "className": 'dt-control', "orderable": false, "data": null, "defaultContent": '' },
                { "orderable": false, "className": "text-center", "mRender": function (data, type, row) { if (row.tipo_remitente != 2) return `<a class="btn btn-cdmx btn_abrir_modal" type="button" title="${(row.respuesta == null) ? 'Responder' : 'Respondido'}"><i class="fa-sharp fa-solid fa-paper-plane ${(row.respuesta == null) ? 'text-gold-2' : 'text-green-2'}"></i></a>`; else return null; } },
                { data: 'estado_destacado', "visible": false, "orderable": false},
                { data: 'estado_leido', "visible": false, "orderable": false},],
        });

        $('#tbl_mensajes_proveedor').DataTable().on("order.dt search.dt", function () {
            let i = $('#tbl_mensajes_proveedor').DataTable().rows().count(); $('#tbl_mensajes_proveedor').DataTable().cells(null, 1, { search: "applied", order: "applied" }).every(function (cell) { this.data(i--); });
        }).draw();

        $('#tbl_mensajes_proveedor').DataTable().on("click", ".btn_abrir_modal", function () {
            let tr = $(this).closest('tr');
            let row = $('#tbl_mensajes_proveedor').DataTable().row(tr);
            if (row.data().respuesta == null) {
                responderMensaje(row.data().id_e);
                if (!row.data().leido) establecerLeido(row.data().id_e, tr);
            }
        });

        $('#tbl_mensajes_proveedor').DataTable().on("click", ".btn_establecer_destacado_unico", function () {
            let tr = $(this).closest('tr');
            let row = $('#tbl_mensajes_proveedor').DataTable().row(tr);
            console.log('Mensaje a destacar: ',row.data().id_e);
            establecerDestacadoUnico(row.data().id_e);
        });

        $('#tbl_mensajes_proveedor').DataTable().on("change", ".check-mensaje", function () {
            let tr = $(this).closest('tr')[0];
            if (tr.children[0].firstChild.checked) {
                tr.classList.add('selected');
            } else {
                tr.classList.remove('selected');
            }
            totalCheckSeleccionados();
        });
    }

    $('#tbl_mensajes_proveedor tbody').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = $('#tbl_mensajes_proveedor').DataTable().row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(formatMensaje(row.data())).show();
            tr.addClass('shown');
            if (!row.data().leido && row.data().tipo_remitente != 2) establecerLeido(row.data().id_e, tr);
        }
    });

    function formatMensaje(d) {
        return '<table class="jtable_c fondo" cellpadding="0" cellspacing="0" border="0" style="width:100%">' +
            '<tr>' +
            '<td class="mensaje-titulo"><b>Remitente</b></td>' +
            '<td>' + d.nombre_usuario + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="mensaje-titulo"><b>Asunto</b></td>' +
            '<td>' + checarNull(d.asunto) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="mensaje-titulo"><b>Mensaje</b></td>' +
            '<td colspan="1" height="50">' + checarNull(d.mensaje) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="mensaje-titulo"><b>Imagen</b></td>' +
            '<td colspan="1" height="50"> ' + ((d.imagen != null) ? '<img src="' + url + 'storage/img-mensaje/' + d.imagen + '" width="200px">' : 'NO DISPONIBLE') + '</td>' +
            '</tr>' +
            '</table>';
    }

    const checarNull = (dato) => (dato != null ? dato : 'NO DISPONIBLE');

    const agregarEscuchaCantidadCaracteres = (nombreTxtArea, nombreTxtCantidad) => {
        $(`#${nombreTxtArea}`).on('input', function (e) {
            const target = e.target;
            document.querySelector(`#${nombreTxtCantidad}`).innerHTML = `${target.value.length}/1000`;
        });
    }

    // Apertura de modal
    let modalAbierto = false, idMensaje = 0;
    const responderMensaje = (id) => {
        if (modalAbierto) return false;
        modalAbierto = true;

        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            url: route("mensaje_proveedor.edit", id),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $('modal_responder') });
                        idMensaje = document.getElementById("id_mensaje").value;
                        agregarEscuchaCantidadCaracteres('respuesta', 'cantidad_caracteres_respuesta');
                    }).on("hidden.bs.modal", function () {
                        $(this).remove(); modalAbierto = false;
                    });
            },
            error: function (resp_success) { console.log(resp_success); },
        });
    }

    $(document).on("click", "#btn_responder_mensaje", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_responder_mensaje")) return false;

        let formData = new FormData($("#frm_responder_mensaje").get(0));
        let btnEnviar = $('#btn_responder_mensaje').attr('disabled', true).text("Enviando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("mensaje_proveedor.update", idMensaje),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Enviar");
                    btnEnviar.attr('disabled', false);
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_responder").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({ title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", })
                            .then((result) => { if (result.isConfirmed) $("#tbl_mensajes_proveedor").DataTable().ajax.reload(); });
                    });
                }
            },
        });
    });

    //Estados
    const establecerLeido = (id, tr) => {
        let formData = new FormData();
        formData.append("id", id);
        formData.append("leido", true);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("mensaje_proveedor.leido"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $('#tbl_mensajes_proveedor').DataTable().row(tr).data().leido = true;
                    tr.removeClass('font-weight-bold odd');
                    document.getElementById("sin-leer").innerHTML = 'Sin leer : ' + response.mensaje.sin_leer;
                }
            },
        });
    }

    let procesoDestacado = false;
    const establecerDestacadoUnico = (id) => {
        if (procesoDestacado) return false;
        procesoDestacado = true;

        let formData = new FormData();
        formData.append("id", id);
        formData.append("destacado", true);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("mensaje_proveedor.destacado_unico"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#tbl_mensajes_proveedor").DataTable().ajax.reload();
                    Swal.fire({ title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                    procesoDestacado = false;
                }
            },
        });
    }

    //Trabajando checkboxs
    $('#check-todos').change(function () {
        if ($(this).prop('checked') == true) {
            $('.check-mensaje').prop('checked', true);
            establecerSeleccionado(true);
        } else {
            $('.check-mensaje').prop('checked', false);
            establecerSeleccionado(false);
        }
    });

    const establecerSeleccionado = (checked) => {
        let tr = document.querySelectorAll("tbody tr");
        $.each(tr, function (index, value) {
            if (checked) {
                value.classList.add('selected');
            } else {
                value.classList.remove('selected');
            }
        });
    }

    const totalCheckSeleccionados = () => {
        let total = $(".check-mensaje").length;
        let checked = $(".check-mensaje:checked").length;

        if (total == checked) {
            $('#check-todos').prop('checked', true);
        } else {
            $('#check-todos').prop('checked', false);
        }
    }

    $('#btn-destacar').click(function () {
        obtenerSeleccionados(1);
    });

    $('#btn-archivar').click(function () {
        obtenerSeleccionados(2);
    });

    $('#btn-borrar').click(function () {
        obtenerSeleccionados(3);
    });

    const obtenerSeleccionados = (quien) => {
        // if (filtroActual != 2) {
        // }
        let data = $("#tbl_mensajes_proveedor").DataTable().rows('.selected').data();
        if (data.length != 0) {
            let mensajes = [];
            for (let i = 0; i < data.length; i++) { mensajes[i] = data[i].id_e; }
            guardarEstado(mensajes, quien);
        } else {
            Swal.fire('No se puede continuar', 'Selecciona uno o más mensajes', "error");
        }
    }

    const guardarEstado = (mensajes, quien) => {
        let ruta = '';
        if (quien == 1) ruta = 'destacar';
        if (quien == 2) ruta = 'archivar';
        if (quien == 3) ruta = 'borrar';

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route(`mensaje_proveedor.${ruta}`),
            type: 'POST',
            data: { ids: mensajes },
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tbl_mensajes_proveedor').DataTable().ajax.reload();
                    $('#check-todos').prop('checked', false);
                } else {
                    Swal.fire('error', respuesta.message, "error");
                }
            },
            error: function (respuesta) { Swal.fire('¡Alerta!', 'Error de conectividad de red USR-04', 'warning'); }
        });
    }

    //Filtros generales
    document.querySelector('#btn-filtro-todos').addEventListener("click", (event) => {
        cargarMensajes(1);
        modificarIconosBotones("Archivar", "Eliminar", 'btn-filtro-todos');
    });

    document.querySelector('#btn-filtro-enviados').addEventListener("click", (event) => {
        cargarMensajes(2);
        modificarIconosBotones("Archivar", "Eliminar", 'btn-filtro-enviados');
    });

    document.querySelector("#btn-filtro-archivados").addEventListener("click", (event) => {
        cargarMensajes(3);
        modificarIconosBotones("Desarchivar", "Eliminar", 'btn-filtro-archivados');
    });

    document.querySelector("#btn-filtro-eliminados").addEventListener("click", (event) => {
        cargarMensajes(4);
        modificarIconosBotones("Archivar", "Recuperar", 'btn-filtro-eliminados');
    });

    const modificarIconosBotones = (archivar, eliminar, btnVerde) => {
        document.getElementById("btn-archivar").dataset.originalTitle = archivar;
        document.getElementById("btn-borrar").dataset.originalTitle = eliminar;
        // document.getElementById("btn-destacar").disabled = (btnVerde == 'btn-filtro-enviados') ? true : false;
        // document.getElementById("btn-borrar").disabled = (btnVerde == 'btn-filtro-enviados') ? true : false;
        // document.getElementById("check-todos").disabled = (btnVerde == 'btn-filtro-enviados') ? true : false;
        document.getElementById("btn-archivar").disabled = (btnVerde == 'btn-filtro-eliminados') ? true : false;

        let bntFiltros = document.querySelector('.btn-filtros');
        $.each(bntFiltros.children, function (index, value) {
            value.children[0].classList.remove('btn-mensaje-green', 'btn-mensaje-gray', 'font-weight-bold');
            value.children[0].children[0].classList.remove('btn-mensaje-green', 'btn-mensaje-gray');
            if (value.children[0].id == btnVerde) {
                value.children[0].classList.add('btn-mensaje-green', 'font-weight-bold');
                value.children[0].children[0].classList.add('btn-mensaje-green');
            } else {
                value.children[0].classList.add('btn-mensaje-gray');
                value.children[0].children[0].classList.add('btn-mensaje-gray');
            }
        });

        $('#check-todos').prop('checked', false);
    }

    // Filtros internos
    let selFiltroMostrar = document.querySelector("#sel-mostrar");
    selFiltroMostrar.addEventListener("change", (event) => { filtrarMensajes(selFiltroMostrar.value); });

    function filtrarMensajes(buscado) {
        let mensajesFilter = document.querySelector('#tbl_mensajes_proveedor_filter');
        if (mensajesFilter != null) {
            mensajesFilter.firstChild.lastChild.value = buscado;
            const mouseupEvent = new MouseEvent("mouseup", { bubbles: true, cancelable: true });
            mensajesFilter.firstChild.lastChild.dispatchEvent(mouseupEvent);
        }
    }
});