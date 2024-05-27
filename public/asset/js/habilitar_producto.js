const cabms =  document.querySelector("#cabms");
$(document).ready(function(){

    dataTable = $('#table_producto').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route('habilitar_productos.data'),
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
            { data: 'producto', className: "text-center" },
            {   "orderable": false,
                "className": "text-center",
                "mRender": function(data, type, row){
                    let habilitado = ""
                    if(row.habilitado){
                        habilitado += `<i class="gris fa-solid fa-check fa-lg"></i>`;
                    }
                    else{
                        habilitado += `<i class="gris fa-solid fa-xmark fa-lg"></i>`;
                    }
                    return habilitado;
                }

            },
            { data: 'estatus', className: "text-center" },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" href="${route('cat_producto.show',{cat_producto: row.cat_producto_id})}"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let editar;
                    if(row.estatus == "Activo"){
                        editado = `<a class="btn btn-cdmx" onClick="edit_modal('${row.id_e}');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>`;
                    }else{
                        editado = `<a class="btn btn-cdmx" href="javascript:void(0)"><i class="fa fa-edit fa-lg gris"></i></a>`;
                    }
                    return editado;
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

    cabms.selectedIndex = 0;
    
});

function edit_modal(data){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('habilitar_productos.edit',{habilitar_producto: data}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#edit_producto")});
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $("#fecha_estudio").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    daysOfWeekDisabled: [0,6],
                    endDate: date,
                });                
                $("#fecha_estudio,#fecha_formulario,#fecha_carga,#fecha_administrativa,#fecha_tecnica,#fecha_publicacion").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    daysOfWeekDisabled: [0,6],
                });                
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
            $(modal).modal('show');
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
        }
    });
}

function update_producto(){
    let id = document.getElementById("id_habilitar_producto").value;
    if(!formValidate('#frm_producto')){ return false; };
    let formData = new FormData($("#frm_producto").get(0));
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('habilitar_productos.update',{habilitar_producto: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_producto').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#table_producto').DataTable().ajax.reload();
                });     
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
            $(modal).modal('show');
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

cabms.addEventListener('change',(e)=>{
    let descripcion = document.querySelector('#descripcion'),
     estatus = document.querySelector('#estatus'),
     numeroFicha = document.querySelector('#numero_ficha'),
     unidad = document.querySelector('#unidad'),
     version = document.querySelector('#version'),
     nombre = document.querySelector('#nombre'),
     especificacion = document.querySelector('#especificacion');
    if(cabms.value != 0){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('habilitar_productos.catalogo',{id: cabms.value }),
            type: 'GET',
            success: function(respuesta) {
                if (respuesta.success == true) {
                    descripcion.value = respuesta.data.descripcion;
                    estatus.innerHTML = respuesta.data.estatus == 1 ? 'Activo' : 'Inactivo';
                    numeroFicha.innerHTML = respuesta.data.numero_ficha;
                    nombre.innerHTML = respuesta.data.nombre_corto;
                    unidad.innerHTML = respuesta.data.medida;
                    version.innerHTML = respuesta.data.version;
                    especificacion.innerHTML = respuesta.data.especificaciones;
                    productoLoad(cabms.value);
                } else {
                    Swal.fire('error', respuesta.message,"error");
                }
            },
            error: function(xhr) {
                Swal.fire('¡Alerta!', xhr, 'warning');
            }
        });
    }
    else {
        descripcion.value = "";
        estatus.innerHTML = "";
        numeroFicha.innerHTML = "";
        nombre.innerHTML = "";
        unidad.innerHTML = "";
        version.innerHTML = "";
        especificacion.innerHTML = "";
        dataTable.clear().draw();    
    }
});

function productoLoad(id){
    if($.fn.dataTable.isDataTable( '#habilitar_producto' )){
        dataTable.destroy();
    }
    
    dataTable = $('#habilitar_producto').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route('habilitar_productos.producto',{id: id}),
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
            { data: 'cabms', className: "text-center" },
            { data: 'nombre_producto' },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let proceso, clase = "rojo";
                    if( row.economica == true || row.economica == false || row.economica == null){
                        if(row.economica == true) { clase = "verde"; }
                        proceso = `<span class="${ clase }"> Validación económica </span>`;
                    }
                    clase = "rojo";
                    if( (row.administrativa == true || row.administrativa == false) && row.administrativa != null && row.tecnica == null)
                    {
                        if(row.administrativa == true) { clase = "verde"; }
                        proceso = `<span class="${ clase }"> Validación administrativa </span>`;   
                    }
                    clase = "rojo";
                    if( (row.tecnica == true || row.tecnica == false) && (row.administrativa == true || row.administrativa == false) ){
                        if(row.tecnica == true) { clase = "verde"; }
                        proceso = `<span class="${ clase }"> Validación técnica </span>`;   
                    }
                    if( row.publicado == true){
                        proceso = `<span class="dorado"> Publicado </span>`;   
                    }
                    return proceso;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" href="${route('habilitar_productos.show_producto',{id: row.id_e }) }" "><i class="fa fa-edit fa-lg dorado"></i></a>`;
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


function buscar(id){
    let palabra = ['Validación económica','Validación administrativa','Validación técnica','Publicado'];
    let productos = document.querySelector('#habilitar_producto_filter');
    if(productos != null){
        productos.firstChild.lastChild.value = palabra[id];
        var clickEvent = document.createEvent('MouseEvents');
        clickEvent.initEvent ("mouseup", true, true);
        productos.firstChild.lastChild.dispatchEvent (clickEvent);
    }
}