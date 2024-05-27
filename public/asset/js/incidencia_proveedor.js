document.addEventListener("DOMContentLoaded", () => {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $("#tbl_incidencias_proveedor").DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            url: url + "asset/datatables/Spanish.json",
        },
        ajax: {
            url: route("incidencia_proveedor.fetch_incidencias"),
            type: "GET",
        },
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0,
            className: "text-center"
        }],
        order: [],
        columns: [
            { data: "id", className: "text-center", defaultContent: "" },
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "urg" },
            { data: "fecha_apertura", className: "text-center" },
            { data: "origen", className: "text-center" },
            { data: "id_origen", className: "text-center" },
            { data: "motivo" },
            { "className": "text-center", "mRender": function (data, type, row) { return `<span class="${row.estatus == 'Abierta' ? 'incidencia-estatus-verde' : row.estatus == 'Cerrada' ? 'incidencia-estatus-rojo' : 'incidencia-estatus-gris'}">${row.estatus}</span>`; } },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx btn_abrir_modal" type="button"><i class="fa-regular fa-square-check" ${(row.estatus == 'Cerrada' || row.estatus == 'Abierta') ? "style='color: #c0bfbc;'" : ""}></i></a>`;
                }
            },
        ],
    });

    dataTable.on("order.dt search.dt", function () { let i = 1; dataTable.cells(null, 0, { search: "applied", order: "applied" }).every(function (cell) { this.data(i++); }); }).draw();
    dataTable.on("click", ".btn_abrir_modal", function () {
        let data = dataTable.row($(this).closest('tr')).data();
        if (data.estatus == "Respuesta") {
            cerrarIncidencia(data.id_e);
        }
    })

    $('#tbl_incidencias_proveedor tbody').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = dataTable.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(formatProveedor(row.data())).show();
            let table2 = $('#tbl_incidencias_proveedor_' + row.data().id).DataTable({
                paging: false,
                searching: false,
                info: false,
                language: {
                    "url": url + "asset/datatables/Spanish.json"
                },
            });
            tr.addClass('shown');
        }
    });

    function formatProveedor(d) {
        return '<table class="jtable_c algo" cellpadding="0" cellspacing="0" border="0" style="width:100%">' +
            '<tr>' +
            '<td class="incidencia-titulo"><b>Fecha apertura</b></td>' +
            '<td>' + d.fecha_apertura + '</td>' +
            '<td class="incidencia-titulo"><b>Fecha respuesta</b></td>' +
            '<td>' + checarNull(d.fecha_respuesta) + '</td>' +
            '<td class="incidencia-titulo"><b>Tiempo de respuesta</b></td>' +
            '<td>' + (checarNull(d.tiempo_respuesta) == 'NO DISPONIBLE' ? 'NO DISPONIBLE' : checarNull(d.tiempo_respuesta) + ' día(s)') + '</td>' +
            '<td class="incidencia-titulo"><b>Fecha de cierre</b></td>' +
            '<td>' + checarNull(d.fecha_cierre) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Origen</b></td>' +
            '<td>' + d.origen + '</td>' +
            '<td class="incidencia-titulo"><b>ID Orden compra</b></td>' +
            '<td>' + d.orden_compra + '</td>' +
            '<td class="incidencia-titulo"><b>ID Incidencia</b></td>' +
            '<td colspan="3">' + d.id_incidencia + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>URG</b></td>' +
            '<td colspan="8">' + d.urg + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Motivo</b></td>' +
            '<td colspan="8">' + d.motivo + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Descripción</b></td>' +
            '<td colspan="8" height="50" nowrap>' + d.descripcion + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Escala</b></td>' +
            '<td>' + checarNull(d.escala) + '</td>' +
            '<td class="incidencia-titulo"><b>Sanción</b></td>' +
            '<td colspan="5">' + checarNull(d.sancion) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Respuesta</b></td>' +
            '<td colspan="8">' + checarNull(d.respuesta) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Conformidad</b></td>' +
            '<td colspan="8">' + checarNull(d.conformidad) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Comentario</b></td>' +
            '<td colspan="8">' + checarNull(d.comentario) + '</td>' +
            '</tr>' +
            '</table>';
    }

    function checarNull(dato) { return (dato != null ? dato : 'NO DISPONIBLE'); }

    //Filtros table proveedor
    let selUrgs = document.querySelector('#urgs'),
        selEstatus = document.querySelector('#estatus'),
        fechaInicioProveedor = document.querySelector("#fecha_inicio_proveedor"),
        fechaFinProveedor = document.querySelector("#fecha_fin_proveedor");

    selUrgs.addEventListener("change", (event) => { filtrarIncidenciaProveedor(selUrgs.value); });
    selEstatus.addEventListener("change", (event) => { filtrarIncidenciaProveedor(selEstatus.value); });

    function filtrarIncidenciaProveedor(buscado) {
        let incidenciasTable = document.querySelector('#tbl_incidencias_proveedor_filter');
        if (incidenciasTable != null) {
            incidenciasTable.firstChild.lastChild.value = buscado;
            const mouseupEvent = new MouseEvent("mouseup", { bubbles: true, cancelable: true });
            incidenciasTable.firstChild.lastChild.dispatchEvent(mouseupEvent);
        }
    }

    //Filtro fechas
    fechaInicioProveedor.addEventListener("change", (event) => { filtrarProveedorFechas(); });
    fechaFinProveedor.addEventListener("change", (event) => { filtrarProveedorFechas(); });

    function filtrarProveedorFechas() {
        let fi = Date.parse(fechaInicioProveedor.value),
            ff = Date.parse(fechaFinProveedor.value);

        if (!isNaN(fi) && !isNaN(ff)) {
            if (ff < fi) {
                fechaFinProveedor.value = '';
                Swal.fire("¡Alerta!", 'La segunda fecha debe ser mayor o igual a la primera fecha seleccionada', "warning");
            } else {
                filtrar(dataTable, 3, 'fecha_inicio_proveedor', 'fecha_fin_proveedor')
            }
        }
    }

    let modalAbierto = false,
        idIncidencia = 0;

    function cerrarIncidencia(id) {
        if (modalAbierto) return false;
        modalAbierto = true;

        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            url: route("incidencia_proveedor.edit", id),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $('modal_cerrar_incidencia') });
                        idIncidencia = document.getElementById("id_incidencia").value;
                    }).on("hidden.bs.modal", function () {
                        $(this).remove(); modalAbierto = false;
                    });
            },
            error: function (resp_success) { console.log(resp_success); },
        });
    }

    $(document).on("click", "#btn_cerrar_incidencia", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_cerrar_incidencia")) {
            return false;
        }

        let formData = new FormData($("#frm_cerrar_incidencia").get(0));
        let btnCerrar = $('#btn_cerrar_incidencia').attr('disabled', true).text("Cerrando...");

        console.log(formData.get('comentario'))
        switch (formData.get('conformidad')) {
            case 'si': break;
            case 'no':
                if (formData.get('comentario') == '') {
                    Swal.fire("No es posible continuar!", 'Proporcione un comentario si no esta de acuerdo con la respuesta que se le ha proporcionado.', "error");
                    btnCerrar.text("Cerrar incidencia");
                    btnCerrar.attr('disabled', false);
                    return false;
                }
                break;
            default:
                Swal.fire("Error!", 'Conformidad no valida', "error");
                break;
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("incidencia_proveedor.update", idIncidencia),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnCerrar.text("Cerrar incidencia");
                    btnCerrar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({
                        title: "No se puede continuar",
                        html: mensaje += "</ul>",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK",
                    });
                } else {
                    $("#modal_cerrar_incidencia").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({ title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", })
                            .then((result) => {
                                if (result.isConfirmed) $("#tbl_incidencias_proveedor").DataTable().ajax.reload();
                            });
                    });
                }
            },
        });
    });

    /***** Incidencias admin *****/
    let tableIncidenciaAdmin = $("#tbl_incidencias_admin").DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            url: url + "asset/datatables/Spanish.json",
        },
        ajax: {
            url: route("incidencia_proveedor.fetch_incidencias_admin"),
            type: "GET",
        },
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0,
            className: "text-center"
        }],
        order: [],
        columns: [
            { data: "id", className: "text-center", defaultContent: "" },
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "fecha_apertura", className: "text-center" },
            { data: "id_incidencia", className: "text-center" },
            { data: "origen", className: "text-center" },
            { data: "id_origen", className: "text-center" },
            { data: "motivo", className: "text-center" },
            { data: "sancion" },
            { "className": "text-center", "mRender": function (data, type, row) { return `<span class="${row.escala == 'leve' ? 'incidencia-estatus-gris' : row.escala == 'moderada' ? 'incidencia-escala-amarillo' : 'incidencia-estatus-rojo'}">${row.escala.charAt(0).toUpperCase() + row.escala.slice(1)}</span>`; } },
        ],
    });

    tableIncidenciaAdmin.on("order.dt search.dt", function () { let i = 1; tableIncidenciaAdmin.cells(null, 0, { search: "applied", order: "applied" }).every(function (cell) { this.data(i++); }); }).draw();

    $('#tbl_incidencias_admin tbody').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = tableIncidenciaAdmin.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(formatAdmin(row.data())).show();
            let table2 = $('#tbl_incidencias_admin_' + row.data().id).DataTable({
                paging: false,
                searching: false,
                info: false,
                language: {
                    "url": url + "asset/datatables/Spanish.json"
                },
            });
            tr.addClass('shown');
        }
    });

    function formatAdmin(d) {
        return '<table class="jtable_c algo" cellpadding="0" cellspacing="0" border="0" style="width:100%">' +
            '<tr>' +
            '<td class="incidencia-titulo"><b>Fecha apertura</b></td>' +
            '<td>' + d.fecha_apertura + '</td>' +
            '<td class="incidencia-titulo"><b>ID incidencia</b></td>' +
            '<td colspan="5">' + checarNull(d.id_incidencia) + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Origen</b></td>' +
            '<td>' + d.origen + '</td>' +
            '<td class="incidencia-titulo"><b>ID { Ficha producto }</b></td>' +
            '<td colspan="5">' + d.id_origen + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Escala</b></td>' +
            '<td>' + checarNull(d.escala) + '</td>' +
            '<td class="incidencia-titulo"><b>Sanción</b></td>' +
            '<td colspan="5">' + checarNull(d.sancion) + '</td>' +
            '</tr>' +


            '<tr>' +
            '<td class="incidencia-titulo"><b>Motivo</b></td>' +
            '<td colspan="8">' + d.motivo + '</td>' +
            '</tr>' +

            '<tr>' +
            '<td class="incidencia-titulo"><b>Descripción</b></td>' +
            '<td colspan="8">' + d.descripcion + '</td>' +
            '</tr>' +
            '</table>';
    }

    //Filtros table admin
    let selOrigen = document.querySelector('#origenes'),
        selMotivo = document.querySelector('#motivos'),
        selEscala = document.querySelector('#escalas'),
        fechaInicioAdmin = document.querySelector("#fecha_inicio_admin"),
        fechaFinAdmin = document.querySelector("#fecha_fin_admin");

    selOrigen.addEventListener("change", (event) => { filtrarIncidenciaAdmin(selOrigen.value); });
    selMotivo.addEventListener("change", (event) => { filtrarIncidenciaAdmin(selMotivo.value); });
    selEscala.addEventListener("change", (event) => { filtrarIncidenciaAdmin(selEscala.value); });

    function filtrarIncidenciaAdmin(buscado) {
        if (buscado == '') {
            selOrigen.selectedIndex = 1;
            selMotivo.selectedIndex = 1;
            selEscala.selectedIndex = 1;
        }
        let tableIncidenciaAdmin = document.querySelector('#tbl_incidencias_admin_filter');
        if (tableIncidenciaAdmin != null) {
            tableIncidenciaAdmin.firstChild.lastChild.value = buscado;
            const mouseupEvent = new MouseEvent("mouseup", { bubbles: true, cancelable: true });
            tableIncidenciaAdmin.firstChild.lastChild.dispatchEvent(mouseupEvent);
        }
    }

    //Filtro fechas
    fechaInicioAdmin.addEventListener("change", (event) => { filtrarAdminFechas(); });
    fechaFinAdmin.addEventListener("change", (event) => { filtrarAdminFechas(); });

    function filtrarAdminFechas() {
        let fi = Date.parse(fechaInicioAdmin.value),
            ff = Date.parse(fechaFinAdmin.value);

        if (!isNaN(fi) && !isNaN(ff)) {
            if (ff < fi) {
                fechaFinAdmin.value = '';
                Swal.fire("¡Alerta!", 'La segunda fecha debe ser mayor o igual a la primera fecha seleccionada', "warning");
            } else {
                filtrar(tableIncidenciaAdmin, 2, 'fecha_inicio_admin', 'fecha_fin_admin')
            }
        }
    }

    function filtrar(tablaObjeto, indiceBuscado, fechaIni, fechaFin) {
        $.fn.dataTable.ext.search.pop();
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                let dateIni = conversor($('#' + fechaIni).val()).replace(/-/g, ""),
                    dateFin = conversor($('#' + fechaFin).val()).replace(/-/g, "");
                let dateCol = data[indiceBuscado].replace(/\//g, "");

                if (dateIni === "" && dateFin === "") { return true; }
                if (dateIni === "") { return dateCol <= dateFin; }
                if (dateFin === "") { return dateCol >= dateIni; }

                return dateCol >= dateIni && dateCol <= dateFin;
            });
        tablaObjeto.draw();
    }

    function conversor(fecha) {
        const today = new Date(fecha + "T00:00");
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1; // Months start at 0!
        let dd = today.getDate();

        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;

        return formattedToday = dd + '-' + mm + '-' + yyyy;
    }
});
