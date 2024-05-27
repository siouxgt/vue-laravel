$('#nav-profile-tab').click(function(){
    let id_contrato_marco = $('#id_contrato_marco').val();
    console.log(id_contrato_marco);
    sleep(300).then(()=> {anexosLoad(id_contrato_marco);}); 
})

function anexosLoad(id){
    if($.fn.dataTable.isDataTable( '#tabla_anexos_contrato' )){
        dataTable.destroy();
    }

    dataTable = $('#tabla_anexos_contrato').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route("anexos_contrato.fetch_anexoscm", id),
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
            { data: 'nombre_documento' },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/anexos_contrato/${row.archivo_publico}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
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
 }