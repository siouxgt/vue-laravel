$(document).ready(function() {
    filtroGeneral = { "cm": '', "cabms": '', "precio": '', "tamanio": '', "entrega": '', "temporalidad": '', "orden": '', "buscado": '', "empresa": '', 'requisicion': '', 'favoritos': '' };
    
    let buscador = document.getElementById("buscador");
    let timeout;

    buscador.addEventListener('keydown', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            datoBuscado = document.getElementById("buscador").value;
            filtroGeneral['buscado'] = datoBuscado;
            clearTimeout(timeout);
            cargarProductos()
        }, 500)
    });

    cargarProductos();
});

function contrato(contratoId){
    let formData = new FormData($("#frm_filtro_cm").get(0));
    filtroGeneral['cm'] = formData.get('cm');
    cargarProductos();
}

function cmModal(){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('producto_admin.cm_modal', {'filtro': JSON.stringify(filtroGeneral)}),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {

            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}
$('#btn_quitar_filtros').click(function () {
    filtroGeneral = { "cm": '', "cabms": '', "precio": '', "tamanio": '', "entrega": '', "temporalidad": '', "orden": '', "buscado": '', "empresa": '', 'requisicion': '', 'favoritos': '' };
    cargarProductos();
});

function cargarProductos(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('producto_admin.productos', {'filtro': JSON.stringify(filtroGeneral)}),
        type: 'GET',
        dataType: 'html',
        success: function(respuesta) {
           let productos = document.querySelector('#productos');
           productos.innerHTML = respuesta;
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

