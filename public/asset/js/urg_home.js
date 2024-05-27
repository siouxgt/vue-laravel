function clicEmpresa(laEmpresa) {
    localStorage.setItem('empresa', laEmpresa)
    window.location = route("tienda_urg.ver_tienda");
}

$('#myCarousel').carousel({
    interval: 4000
})

$('#myCarousel2').carousel({
    interval: 4000
})

$('.carousel .carousel-item').each(function() {
    var minPerSlide = 4;
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    for (var i = 0; i < minPerSlide; i++) {
        next = next.next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }

        next.children(':first-child').clone().appendTo($(this));
    }
});

function addFavoritos(iconoFavorito, inputFavorito, idProducto) {
    iconoFavorito = document.querySelectorAll('.' + idProducto);

    let aceptarClicFav = false,
        estadoFav = $('#' + inputFavorito).val() != 0 ? true : false,
        idFavorito = estadoFav ? $('#' + inputFavorito).val() : 0;

    (function () {
        if (aceptarClicFav) { return false }
        aceptarClicFav = true;

        let formData = new FormData();
        formData.append("pfp_id", idProducto);
        formData.append("id_favorito", idFavorito);

        estadoFav ? estadoFav = false : estadoFav = true;
        guardarEstadoFavorito(formData);
    })();

    function guardarEstadoFavorito(formData) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("pfu.store"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    let mensaje = estadoFav ? "No se pudo agregar a favoritos." : "No se pudo quitar de favoritos.";
                    Swal.fire({ title: "Oops!", text: mensaje, icon: "error", timer: 1000 });
                } else {
                    colorearEstadoFavorito();
                    $('#' + inputFavorito).val(response.id_favorito);
                    Swal.fire({ title: "Listo!", text: response.message, icon: "success", timer: 1500 });
                }
                aceptarClicFav = false;
            },
        });
    }

    function colorearEstadoFavorito() {

        if (estadoFav) {
            iconoFavorito.forEach(
                node => {
                    node.classList.remove('fa-regular');
                    node.classList.add('fa-solid');
                }
            );
        } else {
            iconoFavorito.forEach(
                node => {
                    node.classList.remove('fa-solid');
                    node.classList.add('fa-regular');
                }
            );
        }
    }
}

function contrato(contrato,nombreContrato){
    localStorage.setItem('cm', contrato);
    localStorage.setItem('nombre', nombreContrato);
    window.location = url + "tienda_urg/ver_tienda/";
}


function mensajeModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('tienda_urg.modal_mensaje'),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#modal_mensaje") });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function storeMensaje(){
    if(!formValidate('#frm_mensaje')){ return false; };
    let formData = new FormData($("#frm_mensaje").get(0));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('tienda_urg.store_mensaje'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#modal_mensaje').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_producto').DataTable().ajax.reload();     
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function caracteres(text,contador,hasta) {
    let longitudAct = text.value.length;
    document.querySelector(`#${contador}`).innerHTML = `${longitudAct}/${hasta} palabras`;
}