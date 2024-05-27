document.addEventListener("DOMContentLoaded", () => {
    let tipoReporte = parseInt(document.getElementById('tipo_reporte').value),
        columnas;

    switch (tipoReporte) {
        case 1:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    { data: "orden_compra", className: "text-center" },
                    { data: "requisicion", className: "text-center" },
                    { data: "nombre_urg" },
                    { "className": "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.monto_total); } },
                    { data: "capitulos", className: "text-center" },
                    { data: "estatus", className: "text-center" },
                    { data: "nombre_proveedor" },
                    { data: "rfc", className: "text-center" },
                    { data: "fecha_oc", className: "text-center" },
                ]
            break;
        case 2:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    // { data: "id_e" },
                    { data: "nombre_urg" },
                    { data: "correo" },
                    { data: "telefono", className: "text-center" },
                    { data: "fecha_creacion", className: "text-center" },
                ]
            break;
        case 3:// Reporte de orden compra completo (este es general, si se quiere por URG esta en el case 10)
            columnas =
                [
                    { data: "orden_compra", className: "text-center", defaultContent: "" },
                    { data: "orden_compra", className: "text-center" },
                    { data: "requisicion", className: "text-center" },
                    { data: "urg" },
                    { data: "cabms", className: "text-center" },
                    { data: "descripcion_producto" },
                    { data: "unidad_medida", className: "text-center" },
                    { "className": "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.precio_unitario); } },
                    { data: "cantidad", className: "text-center" },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.monto_total_iva); } },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.monto_total_sin_iva); } },
                    { data: "capitulo", className: "text-center" },
                    { data: "estatus", className: "text-center" },
                    { data: "nombre" },
                    { data: "rfc", className: "text-center" },
                    { data: "tipo_contrato", className: "text-center" },
                    { data: "id_contrato" },
                    { data: "nombre_contrato" },
                    { data: "fecha_creacion", className: "text-center" },
                ]
            break;
        case 4:
            columnas =
                [
                    { data: "id_identificacion", className: "text-center", defaultContent: "" },
                    { data: "id_identificacion", className: "text-center" },
                    { data: "urg" },
                    { data: "nombre_cm" },
                    { data: "numero_cm" },
                    { data: "motivo" },
                    { data: "descripcion" },
                    { data: "ccg", className: "text-center" },
                    { data: "fecha_incidencia", className: "text-center" },
                    { className: "text-center", "mRender": function (data, type, row) { return "INCIDENCIA"; } },
                    { data: "etapa", className: "text-center" },
                ]
            break;
        case 5:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    { data: "partida", className: "text-center" },
                    { data: "cabms", className: "text-center" },
                    { data: "capitulo", className: "text-center" },
                    { data: "fecha_publicacion", className: "text-center" },
                    { data: "validacion_economica", className: "text-center" },
                    { data: "validacion_tecnica", className: "text-center" },
                    { data: "validacion_administrativa", className: "text-center" },
                    { data: "nombre_cm" },
                    { data: "numero_cm" },
                    { data: "estatus", className: "text-center" },
                    { data: "nombre" },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.precio_unitario); } },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.precio_unitario_iva); } },
                    { data: "unidad_medida", className: "text-center" },
                    { data: "nombre_producto" },
                    { data: "descripcion_producto" },
                    { data: "fecha_modificacion_precio", className: "text-center" },
                    { data: "numero_ficha" },
                    { data: "version", className: "text-center" },
                ]
            break;
        case 6:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    { data: "partida", className: "text-center" },
                    { data: "cabms", className: "text-center" },
                    { data: "capitulo", className: "text-center" },
                    { data: "nombre_producto" },
                    { data: "fecha_publicacion", className: "text-center" },
                    { data: "validacion_precio", className: "text-center" },
                    { data: "validacion_tecnica", className: "text-center" },
                    { data: "validacion_administracion", className: "text-center" },
                    { data: "nombre_cm" },
                    { data: "numero_cm" },
                    { data: "estatus", className: "text-center" },
                    { data: "nombre" },
                    { data: "numero_ficha" },
                    { data: "version", className: "text-center" },
                ]
            break;
        case 7:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    { data: "numero_archivo_adhesion", className: "text-center" },
                    { data: "fecha_registro", className: "text-center" },
                    { data: "numero_cm" },
                    { data: "nombre_cm" },
                    { data: "objetivo" },
                    { data: "nombre" },
                    { data: "ccg", className: "text-center" },
                    { data: "fecha_firma", className: "text-center" },
                    { data: "f_fin", className: "text-center" },
                    { data: "estatus", className: "text-center" },
                ]
            break;
        case 8:
            columnas =
                [
                    { data: "created_at", className: "text-center", defaultContent: "" },
                    { data: "mes", className: "text-center" },
                    { data: "numero_cm" },
                    { data: "objetivo" },
                    { data: "tipo_contratacion" },
                    { data: "fecha_creacion", className: "text-center" },
                    { data: "f_fin", className: "text-center" },
                    { data: "fecha_modificacion", className: "text-center" },
                    { data: "nombre_responsable_alta" },
                    { data: "fecha_ingreso_urg", className: "text-center" },
                    { data: "fecha_ingreso_proveedor", className: "text-center" },
                    { data: "capitulo", className: "text-center" },
                    { data: "partida", className: "text-center" },
                    { data: "urg" },
                    { data: "estatus_urg", className: "text-center" },
                    { data: "rfc", className: "text-center" },
                    { data: "nombre_proveedor" },
                    { data: "estatus_proveedor", className: "text-center" },
                    { data: "estatus_contrato", className: "text-center" },
                    { data: "id_orden_compra", className: "text-center" },
                ]
            break;
        case 9:
            columnas =
                [
                    { data: "id_e", className: "text-center", defaultContent: "" },
                    { data: "partida", className: "text-center" },
                    { data: "capitulo", className: "text-center" },
                    { data: "cabms", className: "text-center" },
                    { data: "numero_cm" },
                    { data: "nombre_cm" },
                    { data: "descripcion_producto" },
                ]
            break;
        case 10:// Reporte de orden compra completo por URG
            columnas =
                [
                    { data: "orden_compra", className: "text-center", defaultContent: "" },
                    { data: "orden_compra", className: "text-center" },
                    { data: "requisicion", className: "text-center" },
                    { data: "urg" },
                    { data: "cabms", className: "text-center" },
                    { data: "descripcion_producto" },
                    { data: "unidad_medida", className: "text-center" },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.precio_unitario); } },
                    { data: "cantidad", className: "text-center" },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.monto_total_iva); } },
                    { className: "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.monto_total_sin_iva); } },
                    { data: "capitulo", className: "text-center" },
                    { data: "estatus", className: "text-center" },
                    { data: "nombre" },
                    { data: "rfc", className: "text-center" },
                    { data: "tipo_contrato", className: "text-center" },
                    { data: "id_contrato" },
                    { data: "nombre_contrato" },
                    { data: "fecha_creacion", className: "text-center" },
                    { data: "director" },
                    { data: "responsable" },
                ]
            break;
    }

    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $("#tbl_reportes_desgloce").DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            url: url + "asset/datatables/Spanish.json",
        },
        ajax: {
            url: route("reporte_proveedor.fetch_reportes_desgloce"),
            type: "GET",
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center"
            },
        ],
        order: [[1, "asc"]],
        columns: columnas,
    });

    dataTable.on("order.dt search.dt", function () { let i = 1; dataTable.cells(null, 0, { search: "applied", order: "applied" }).every(function (cell) { this.data(i++); }); }).draw();
});
