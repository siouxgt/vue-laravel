$(document).ready(function() {

    let dataTable = $('#tabla_producto').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('cat_producto.data'),
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
            { data: 'nombre_cm' },
            { data: 'cabms', className: "text-center" },
            { data: 'descripcion' },
            { data: 'numero_ficha', className: "text-center" },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return parseFloat(row.version).toFixed(1);
                }
            },
            { data: 'estatus', className: "text-center" },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    
                    return `<a class="btn btn-cdmx" href="${route('cat_producto.show',{cat_producto: row.id_e})}"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" href="${route('cat_producto.edit',{cat_producto: row.id_e})}"><i class="fa fa-edit fa-lg dorado"></i></a>`;
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

    let mensaje = document.querySelector('#mensaje');
    switch (mensaje.value) {
        case 'error':
            Swal.fire("error", 'Error al guardar el catalogo del producto.' ,"error");
        break;
        case 'success':
            Swal.fire("Proceso  correcto!", 'Catalogo del producto guardado correctamente.' ,"success");
        break;
    }

    if(validacion?.checked){
        prueba.removeAttribute("disabled","");
        equipo.removeAttribute("disabled","");
    }

});

const capitulo = document.querySelector('#capitulo'),
      partida = document.querySelector('#partida'),
      cabms = document.querySelector('#cabms'),
      descripcion = document.querySelector('#descripcion'),
      validacion = document.querySelector('#validacion_tecnica'),
      contrato = document.querySelector('#contrato'),
      numero_ficha = document.querySelector('#numero_ficha'),
      prueba = document.querySelector('#tipo_prueba'),
      equipo = document.querySelector('#equipo_validacion'),
      nombre = document.querySelector('#nombre_corto');

capitulo?.addEventListener('change',(e)=>{
    let capitulo_id = capitulo.options[capitulo.selectedIndex].getAttribute('data');
	partida.innerHTML = `<option value="">Seleccione una opción...</option>`;
    cabms.innerHTML = `<option value="">Seleccione una opción...</option>`;
    descripcion.value = "";
    if(capitulo.value != ""){
    	$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('service.capitulo', {capitulo: capitulo_id}),
            type: 'GET',
            success: function(respuesta) {
                if (respuesta.success == true) {
                    $.each(respuesta.data, function(index, value){
                    	let opciones = `<option value="${ value['partida'] }" data-partida="${ value['value'] }">${ value['partida'] } </option>`;
                    	partida.innerHTML += opciones; 
                    });
                   	$('#partida').select2();
                }else {
                    Swal.fire('error', respuesta.message,"error");
                }
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
         });
    }
});

$('#partida').on("select2:select", function (e) {
    // let partida_id = partida.options[partida.selectedIndex].getAttribute('data');
    let partida_id = $('#partida').select2().find(":selected").data("partida");
    cabms.innerHTML = `<option value="">Seleccione una opción</option>`;
    descripcion.value = "";
    if(partida.value != ""){
    	$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('service.partida', {partida: partida_id}),
            type: 'GET',
            success: function(respuesta) {
                if (respuesta.success == true) {
                	 $.each(respuesta.data, function(index, value){
                        let opciones = `<option value="${ value['cabms'] }">${ value['cabms'] } - ${ value['descripcion'] }</option>`;
                        cabms.innerHTML += opciones; 
                    });
                    $('#cabms').select2();
                }else {
                    Swal.fire('error', respuesta.message,"error");
                }
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
        });
    }
});

$('#cabms').on("select2:select", function (e) {
    let partida_id = $('#partida').select2().find(":selected").data("partida");
    if(cabms.value != ""){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('service.cabms', {partida: partida_id, cabms: e.params.data.id}),
            type: 'GET',
            success: function(respuesta) {
                if (respuesta.success == true) {
                    let version = document.querySelector('#version');
                    let ultimo = document.querySelector('#ultimo');
                    let fecha = document.querySelector('#fecha');
                    descripcion.value = respuesta.data[0].descripcion;
                }else {
                    Swal.fire('error', respuesta.message,"error");
                }
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
         });
    }else{
        descripcion.value = "";
    }
});

contrato?.addEventListener('change', (e)=>{
    let contrato_nombre = document.querySelector('#contrato_nombre');
    contrato_nombre.value = contrato.options[contrato.selectedIndex].getAttribute('data');
});


validacion?.addEventListener('change',(e)=>{
    if(validacion.checked){
        prueba.removeAttribute("disabled","");
        equipo.removeAttribute("disabled","");
    }
    else{
        prueba.setAttribute("disabled","");
        equipo.setAttribute("disabled","");
    }
});

nombre?.addEventListener('change',(e)=>{
    let nombreCorto = nombre.value.replace(" ","-");
    numero_ficha.value = nombreCorto+"CDMX"+fecha.value+ultimo.value+cabms.value+version.value;
})