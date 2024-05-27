function filtroProducto(id){
	let estrellas = document.querySelector('#estrellas');
	if(estrellas == 0){ return false; }
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('tienda_urg.opinion_producto_filtro', {'producto': id, 'estrellas': estrellas.value}),
        type: 'GET',
        dataType: 'html',
        success: function(respuesta) {
           let comentarios = document.querySelector('#comentarios');
           comentarios.innerHTML = respuesta;
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}


function filtroProveedor(id){
	let estrellas = document.querySelector('#estrellas');
	if(estrellas == 0){ return false; }
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('tienda_urg.opinion_proveedor_filtro', {'proveedor': id, 'estrellas': estrellas.value}),
        type: 'GET',
        dataType: 'html',
        success: function(respuesta) {
           let comentarios = document.querySelector('#comentarios');
           comentarios.innerHTML = respuesta;
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}


