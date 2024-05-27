$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $('#tabla_contratos').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('contrato_oc_urg.data'),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center",
            }
        ],
        order: [[1, 'asc']],
        columns: [
            { data: 'id_t', defaultContent: '' },
            { data: 'orden_compra', className: "text-center" },
            { data: 's_fecha', className: 'text-center' },
            { data: 'nombre_proveedor' },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let proveedor = "";
                    if(row.proveedor){
                        proveedor = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return proveedor;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let titular = "";
                    if(row.titular){
                        titular = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return titular;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let adquisiciones = "";
                    if(row.adquisiciones){
                        adquisiciones = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return adquisiciones;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let financiera = "";
                    if(row.financiera){
                        financiera = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return financiera;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let requiriente = "";
                    if(row.requiriente){
                        requiriente = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return requiriente;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    return `<a href="${url}storage/contrato-pedido/contrato_pedido_${row.contrato_pedido}.pdf" class="mx-4" target="_blank"><i class="fa-solid fa-file-signature text-gold"></i></a>`;
                }
            },
        ]
    });

    dataTable.on('order.dt search.dt', function () {
        let i = 1;
        dataTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

});