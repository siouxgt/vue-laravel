$(document).ready(function () {
    let index = document.querySelector('#tabla_requisicion');
    if(index){
        let dataTable = $('#tabla_requisicion').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('requisiciones.data'),
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
                { data: 'requisicion', className: "text-center", },
                { data: 'objeto_requisicion' },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        return '$' + new Intl.NumberFormat().format(row.monto_autorizado);
                    }
                },
                 {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        return '$' + new Intl.NumberFormat().format(row.monto_adjudicado);
                    }
                },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        return '$' + new Intl.NumberFormat().format(row.monto_autorizado - row.monto_adjudicado);
                    }
                },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let content = "";
                        if(row.estatus == false){ 
                            content = `<span class="badge badge-secondary">Disponible</span>`; 
                        }
                        else{ 
                            content = `<span class="badge badge-warning">Adjudicada</span>`;
                        }
                        return content;
                    }
                },
                {
                    "orderable": false,
                    "className": "text-center",
                    "mRender": function (data, type, row) {

                        return `<a class="btn btn-cdmx" href="${ route('requisiciones.show', { requisicione: row.id_e }) }"><i class="fa fa-eye fa-lg"></i></a>`;
                    }
                },
                {
                    "orderable": false,
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let contenido = "";
                        if(row.cotizada > 0){
                            contenido += `<form action="${ route('requisiciones.export') }" method="POST">
                                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                                <input type="hidden" name="requisicion" value="${ row.id_e}">
                                                <input type="hidden" name="formato" value="PDF">
                                                <a href="javascript:$('form').submit()" class="btn btn-cdmx"><i class="fa fa-file-invoice-dollar fa-lg like-gold"></i></a>
                                            </form>`;
                        }
                        return contenido;
                    }
                },
                {
                    "orderable": false,
                    "mRender": function (data, type, row) {
                        return "";//`<a class="btn btn-cdmx" href="#"><i class="fa fa-receipt fa-lg like-gold"></i></a>`;
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

    //show
    let show = document.querySelector('#tabla_requisicion_show');
    if(show){
        let id = document.querySelector('#requisicion_id').value;
        let dataTable = $('#tabla_requisicion_show').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            scrollY: '300px',
            scrollCollapse: true,
            // colReorder: true,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('bien_servicio.data',{id: id}),
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
                { data: 'cabms', className: "text-center" },
                { data: 'descripcion' },
                { 
                    "orderable":      false,
                    "mRender": function(data, type, row){
                        return row.especificacion.substring(0,20);
                    }  
                },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { data: 'unidad_medida' },
                { data: 'cantidad', className: "text-center" },
                { 
                    "orderable":      false,
                    "className": "text-center",
                    "mRender": function(data, type, row){
                        let contenido = "";
                        contenido += `<input class="form-check-input ml-2" type="checkbox" value="1" id="bien">`;                            
                        return contenido;
                    }  
                },
                { 
                    "orderable":      false,
                    "className": "text-center",
                    "mRender": function(data, type, row){
                        let contenido = "";
                        contenido += `<i class="like-gold fa-solid fa-xmark fa-lg"></i>`;
                        if(row.cotizado){
                            contenido =`<i class="like-gold fa-solid fa-check fa-lg"></i>`;
                        }                            
                        return contenido;
                    }  
                },
                {   className: 'signoDinero text-center',
                    data: 'precio_maximo' },
                {   className: 'signoDinero text-center',
                    data: 'subtotal' },
                {   className: 'signoDinero text-center',
                    data: 'iva' },
                {   className: 'signoDinero text-center',
                    data: 'total' },                 
            ],

            footerCallback: function ( row, data) {
                let api = this.api();

                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                
                cantidad = api.column(6).data().reduce(function(a,b){
                    return intVal(a) + intVal(b);
                },0)
                $(api.column(6).footer()).html(cantidad);

                subtotal =api.column(9).data().reduce(function(a,b){
                    return intVal(a) + intVal(b);
                },0);
                $(api.column(9).footer()).html('$' + new Intl.NumberFormat().format(subtotal));

                iva = api.column(10).data().reduce(function(a,b){
                    return intVal(a) + intVal(b);
                },0);
                $(api.column(10).footer()).html('$' + new Intl.NumberFormat().format(iva));

                total = api.column(11).data().reduce(function(a,b){
                    return intVal(a) + intVal(b);
                },0);
                $(api.column(11).footer()).html('$' + new Intl.NumberFormat().format(total));
                
            }

        });
      
        
        dataTable.on('order.dt search.dt', function () {
            let i = 1;
            dataTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();

        $('#tabla_requisicion_show tbody').on('click', 'td.details-control', function () {
            let tr = $(this).closest('tr');
            let row = dataTable.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        });

        $('#tabla_requisicion_show tbody').on( 'click', '#bien', function () {
            $(this).closest('tr').toggleClass('selected');
        } );


        $('#envia').click( function () {
            let data = dataTable.rows('.selected').data();
            if(data.length != 0)
            {
                let producto = [];
                for(let i = 0; i < data.length; i++){
                    producto[i] = data[i].id_e;
                } 
                Swal.fire({
                    title: '¿Cotizar bien?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Cotizar'
                }).then((result) => {
                    if (result.value) {
                        cotizar(producto);
                    }
                });
            }
            else{
                Swal.fire('error','Selecciona uno o más bienes',"error");       
            }
        });

    } //ifshow
    
});


function format ( d ) {
    let table = `<table class="table justify-content-md-center">
        <tr>
            <td colspan="12"> ${ d.especificacion } </td>
        </tr>
        </table>`;

    return table;
}

const checkTodos = document.querySelector("#todos"); 

function todos(){
    let bienes = document.querySelectorAll("#bien");
    $.each(bienes,function(index, value){
        if(checkTodos.checked){
            value.checked = true;
        }else{
            value.checked = false;
        }
    });
    let tr = document.querySelectorAll("tbody tr");
    $.each(tr,function(index, value){
        if(checkTodos.checked){
            value.classList.add('selected');
        }
        else{
            value.classList.remove('selected');
        }
    });
}

function cotizar(producto){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('bien_servicio.update',{bien_servicio: producto}),
        type: 'PUT',
        data: {ids : producto},
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                checkTodos.checked = false;
                $('#tabla_requisicion_show').DataTable().ajax.reload();
                if(respuesta.data > 0){
                    let buscar = document.querySelector('#buscar');
                    buscar.removeAttribute("disabled","");
                }
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

function obtenerRequisicion(){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('requisiciones.obtener_requisicion'),
        type: 'GET',
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                $('#tabla_requisicion').DataTable().ajax.reload();
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}