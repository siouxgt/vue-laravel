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
    mostrarPreguntas()
    desglosarPrecio();
});


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

function mostrarPreguntas() {
    let id = document.querySelector('#producto');
    $.ajax({
        type: "GET",
        url: route("pro_pre.cpr", id.value),
        success: function (respuesta) {
            const divAreaPreguntas = document.querySelector("#area_preguntas_respuestas");
            divAreaPreguntas.innerHTML = respuesta.contenido;
            document.getElementById("cantidad_preguntas").innerHTML = respuesta.total;

            let contenidoBtn = `
                                <div class="col-6 text-center">
                                    <button type="button" class="btn btn-outline-light-v" id="btn_ver_preguntas">Todas las preguntas</button>
                                </div>`;

            if (respuesta.total > 3) {
                const divAreaBtn = document.querySelector("#area_btn_ver_preguntas");
                divAreaBtn.innerHTML = contenidoBtn;
            }
        },
    });
}


$(document).on("click", "#btn_ver_preguntas", function (e) {
    e.preventDefault();
    let producto = document.querySelector('#producto');
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("pro_pre.show", producto.value),
        dataType: "html",
        success: function (respuesta) {
            $(respuesta).modal().on("shown.bs.modal", function () {
                $("[class='make-switch']").bootstrapSwitch("animate", true);
                $(".select2").select2({ dropdownParent: $("#mod_preguntas") });
            })
            .on("hidden.bs.modal", function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        },
    });
});