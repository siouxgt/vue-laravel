$(document).ready(function() {
   mensajes(1);

   $('#table_mensajes tbody').on('click', 'td.details-control', function () {
        let data = dataTable.rows(this).data();
        if(data[0].leido == 0){
            leido(data);
        }
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

   $('#table_mensajes tbody').on( 'click', '#mensaje', function () {
        $(this).closest('tr').toggleClass('selected');
    } );

});

function mensajes(estado){
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    if($.fn.dataTable.isDataTable( '#table_mensajes' )){
        dataTable.destroy();
    }

    let ruta = route('mensajes_urg.mensajes_data',{id: estado});

    dataTable = $('#table_mensajes').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": ruta,
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 1,
                className: "text-center",
            }
        ],
        order: [[3, 'asc']],
        columns: [
            { 
                "className": "text-center",
                "orderable":      false,
                "mRender": function(data, type, row){
                    let conten = "";
                    if(row.leido == false){
                        conten = `<span class="no_leido" id="${row.id_e}"></span>`
                    }
                    if(row.enviado != true){
                        conten += `<input class="form-check-input ml-2" type="checkbox" value="1" id="mensaje">`;
                    }
                   return conten;
                }  
            },
            { data: 'id_t', defaultContent: '' },
            { 
                "className": "text-center",
                "orderable":      false,
                "mRender": function (data, type, row) {
                    let conten = '<i class="fa-regular fa-star gris ml-3"></i>'
                    if(row.destacado && row.enviado != true){
                        conten = `<i class="fa-regular fa-star gold ml-3"></i>`;
                    }
                    return conten;
                }
            },
            { data: 'fecha', className: 'text-center' },
            { data: 'remitente' },
            { 
                "orderable":      false,
                "mRender": function(data, type, row){
                    return row.asunto.substring(0,20);
                }  
            },
            {   
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'origen' },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let conten = "";
                    if(row.tipo_remitente != 0 && row.enviado != true){
                        conten = `<a onclick="responderModal('${row.id_e}');" href="javascript:void(0)"><i class="fa-sharp fa-solid fa-paper-plane gold"></i></a>`;
                    }
                    return  conten;
                }
            }
        ]
    });
     
    dataTable.on('order.dt search.dt', function () {
        let i = 1;
        dataTable.cells(null, 1, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

    $('#destaca').click( function () {
        let data = dataTable.rows('.selected').data();
        if(data.length != 0)
        {
            let mensajes = [];
            for(let i = 0; i < data.length; i++){
                mensajes[i] = data[i].id_e;
            } 
            destacar(mensajes);
        }
        else{
            Swal.fire('error','Selecciona uno o más mensajes',"error");       
        }
    });

    $('#archiva').click( function () {
        let data = dataTable.rows('.selected').data();
        if(data.length != 0)
        {
            let mensajes = [];
            for(let i = 0; i < data.length; i++){
                mensajes[i] = data[i].id_e;
            } 
           archivar(mensajes);
        }
        else{
            Swal.fire('error','Selecciona uno o más mensajes',"error");       
        }
    });

    $('#elimina').click( function () {
        let data = dataTable.rows('.selected').data();
            console.log(data.length);
        if(data.length != 0)
        {
            let mensajes = [];
            for(let i = 0; i < data.length; i++){
                mensajes[i] = data[i].id_e;
            } 
           Swal.fire({
                title: '¿Deseas eliminar los mensajes seleccionados?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.value) {
                    eliminar(mensajes);
                }
            });
        }
        else{
            Swal.fire('error','Selecciona uno o más mensajes',"error");       
        }
    });

}

function format ( d ) {
    let table = `<table class="table justify-content-md-center">
        <tr>
            <td class="bg-light" colspan="4">Remitente</td>
            <td> ${ d.remitente } </td>
        </tr>
        <tr>
            <td class="bg-light" colspan="4">Asunto</td>
            <td colspan="5"> ${ d.asunto } </td>
        </tr>
        <tr>
            <td class="bg-light" colspan="4">Mensaje</td>
            <td colspan="5"> ${ d.mensaje } </td>
        </tr>`;
    if(d.imagen != null){
        table += `
            <tr>
                <td class="bg-light" colspan="4">Imagen</td>
                <td colspan="5"> <img src="${url}storage/img-mensaje/${d.imagen}" class="img_mensaje"></td>
            </tr>`;
    }
    if(d.producto != null){
        table += `
            <tr>
                <td class="bg-light" colspan="4">Producto</td>
                <td colspan="5"> ${ d.producto } </td>
            </tr>`;
    }

    if(d.orden_compra != null){
        table += `
            <tr>
                <td class="bg-light" colspan="4">Orden Compra</td>
                <td colspan="5"> ${ d.orden_compra } </td>
            </tr>`;
    }
    if(d.respuesta != null){
        table += `<tr>
            <td class="bg-light" colspan="4">Respuesta</td>
            <td colspan="5"> ${ d.respuesta } </td>
        </tr>`;
    }
    table +=`<tr>
        <td colspan="9"></td>
    </tr></tr></table>`;

    return table;
}

const checkTodos = document.querySelector("#todos"); 

function todos(){
    let mensaje = document.querySelectorAll("#mensaje");
    if(mensaje.length > 0){
        $.each(mensaje,function(index, value){
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
}

function destacar(mensajes){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_destacar'),
        type: 'POST',
        data: {ids : mensajes},
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                checkTodos.checked = false;
                $('#table_mensajes').DataTable().ajax.reload();
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

function archivar(mensajes) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_archivar'),
        type: 'POST',
        data: {ids : mensajes},
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                checkTodos.checked = false;
                $('#table_mensajes').DataTable().ajax.reload();
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

function eliminar(mensajes){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_eliminar'),
        type: 'POST',
        data: {ids : mensajes},
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                checkTodos.checked = false;
                $('#table_mensajes').DataTable().ajax.reload();
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

function leido(data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_leido'),
        type: 'POST',
        data: {id : data[0].id_e},
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                data[0].leido = true;
                let sinLeer = document.querySelector('#sin_leer');
                let contador = sinLeer.innerHTML - 1;
                sinLeer.innerHTML = contador;
                $('#'+data[0].id_e).removeClass('no_leido');
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
    });    
}

const mostrar = document.querySelector('#mostrar');

mostrar.addEventListener('change',()=>{
    mensajes(mostrar.value);
});

function responderModal(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_responder_modal',{'id': id}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#responder_modal")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function caracteres(text,contador) {
    let longitudAct = text.value.length;
    document.querySelector(`#${contador}`).innerHTML = `${longitudAct}/1000 palabras`;
}

function respuestaSave(){
    if (!formValidate('#frm_responder')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('mensajes_urg.mensaje_responder_save'),
        type: 'POST',
        data: $("#frm_responder").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#responder_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let sinLeer = document.querySelector('#sin_leer');
                    let contador = sinLeer.innerHTML - 1;
                    sinLeer.innerHTML = contador;
                    $('#table_mensajes').DataTable().ajax.reload();
                });
            }
            else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}