$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $('#table_orden_compra').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('orden_compra_admin.data'),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center"
            }
        ],
        order: [[1, 'asc']],
        columns: [
            { data: 'id_t', defaultContent: '' },
            { data: 'orden_compra', className: "text-center" },
            { data: 'fecha', className: "text-center" },
            { data: 'requisicion', className: "text-center" },
            { data: 'urg' },
            { data: 'proveedor', className: "text-center" },
            { data: 'cabms', className: "text-center" },
            { data: 'aceptadas', className: "text-center" },
            { data: 'rechazadas', className: "text-center" },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return '$' + new Intl.NumberFormat().format(row.total);
                }
            },
            {
                "orderable": false,
                "className": "text-center",
                "mRender": function (data, type, row) {

                    return `<a class="btn btn-cdmx" href="${ route('orden_compra_admin.show', { id: row.id_e }) }"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable": false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx"  href="${ route('orden_compra_admin.show_solicitud', { id: row.solicitud_id }) }"><i class="fa fa-file-invoice-dollar fa-lg like-gold"></i></a>`;
                }
            }
        ]
    });

    dataTable.on('order.dt search.dt', function () {
        let i = 1;
        dataTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

});