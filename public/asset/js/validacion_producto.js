let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {

    let slides = document.getElementsByClassName("mySlides"),
        dots = document.getElementsByClassName("demo"),
        i;

    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

$(document).ready(function() {
    $('.zoom').hover(function() {
        $(this).addClass('transition');
    }, function() {
        $(this).removeClass('transition');
    });
});

desglosarPrecio();

function cantidad(operacion) {
    let numero = $('#txt_cantidad').val();
    if (operacion == '1') {
        numero++;
    } else {
        if (numero == 1) {
            numero = 1;
        } else {
            numero--;
        }
    }
    $('#txt_cantidad').val(numero);
    desglosarPrecio();
}

function desglosarPrecio() {
    let elPrecioUnitario = document.getElementById("el_precio_unitario").value,
        cantidad = document.getElementById("txt_cantidad").value,
        unidadMedida = document.getElementById("unidad_medida").value;
    let total = new Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MXN"
    }).format(elPrecioUnitario * cantidad);

    document.getElementById("el_precio").innerHTML = total;
    document.getElementById("el_desglose").innerHTML = "$" + elPrecioUnitario + " x " + cantidad + " " + unidadMedida;
}


const id = document.querySelector('#producto_id');
const validacionEconomica = document.querySelector('#modal_economica');

validacionEconomica.addEventListener('click', (e) => {
    $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route('habilitar_productos.modal_economica',{producto: id.value}),
            dataType: 'html',
            success: function (resp_success) {
                var modal = resp_success;
                $(modal).modal().on('shown.bs.modal', function () {
                    $("[class='make-switch']").bootstrapSwitch('animate', true);
                    $('.select2').select2({ dropdownParent: $("#modal_eco") });
                }).on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', xhr, 'warning');
            }
        });
});

const validacionAdministrativa = document.querySelector("#modal_admin");

validacionAdministrativa.addEventListener('click', (e)=> {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('validacion_administrativas.edit',{validacion_administrativa: id.value}),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#modal_add_admin") });
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $("#fecha_revision").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    startDate: date,
                    endDate: date
                }); 
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
});

function add_admin(){
    let valAdmin = document.querySelector('#valAdmin');
    if(!formValidate('#frm_admin')){ return false; };
    let formData = new FormData($("#frm_admin").get(0));
    formData.append('producto_id',id.value);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validacion_administrativas.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#modal_add_admin').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                });

                if(respuesta.data != 0)
                {
                    valAdmin.innerHTML = `<p class="indicador-count-card fa-solid fa-check text-center"></p>`;
                }
                else{
                    valAdmin.innerHTML = `<p class="indicador-count-card-3 fa-solid fa-xmark text-center"></p>`;
                }

            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

const tecnica = document.querySelector("#modal_tecnica");

tecnica?.addEventListener('click', (e)=> {
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('habilitar_productos.modal_show_tecnica',{producto: id.value}),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#modal_publica") });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
});


const publicar = document.querySelector("#modal_publicar");

publicar.addEventListener('click', (e)=> {
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('habilitar_productos.modal_publicar',{producto: id.value}),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#modal_publica") });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
});

function publicarProducto(){
    let valPub = document.querySelector('#valPub');
    let formData = new FormData();
    formData.append('producto_id',id.value);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('habilitar_productos.publicar_producto'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#modal_publica').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                });
                valPub.innerHTML = `<p class="indicador-count-card fa-solid fa-check text-center"></p>`;
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

