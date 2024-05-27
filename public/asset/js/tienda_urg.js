let slideIndex = 1;

showSlides(slideIndex);
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

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

$(document).ready(function () {
    $('.zoom').hover(function () {
        $(this).addClass('transition');
    }, function () {
        $(this).removeClass('transition');
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const idPFP = $('#pfp_id').val(),
        stockDisponible = parseInt($('#stock_disponible').val()),
        cantidadProductoCarrito = parseInt($('#cantidad_producto').val() != "" ? $('#cantidad_producto').val() : 0);
    let totalInterno = 0, numero = parseInt($('#txt_cantidad').val()), pressed = false, operacion = false, intervalId, tiempo = 200; const btnIncremento = document.getElementById('btn_incremento'),
        btnDecremento = document.getElementById('btn_decremento'),
        txtCantidad = document.getElementById('txt_cantidad');

    desglosarPrecio();
    mostrarPreguntas();

    txtCantidad.addEventListener('keyup', e => {
        let cantidadActual = $('#txt_cantidad').val();
        if (cantidadActual == "") {//Si el campo esta vacio, entonces esperar un par de segundos (Tal vez la URG escribira un valor diferente)
            setTimeout(function () {
                comprobarOperacion(cantidadActual);
            }, 2000);
        } else {
            comprobarOperacion(cantidadActual);
        }
    });

    function comprobarOperacion(cantidadActual) {
        if (!isNaN(cantidadActual)) {
            cantidadActual = parseInt(cantidadActual);
            if (cantidadActual >= 1 && cantidadActual <= (stockDisponible - cantidadProductoCarrito)) {
                numero = cantidadActual;
            } else {
                $('#txt_cantidad').val(numero);
                if (cantidadActual > (stockDisponible - cantidadProductoCarrito)) {
                    if (cantidadProductoCarrito != 0) {
                        Swal.fire("Hola!", 'Se comprobo que ya has agregado ' + cantidadProductoCarrito + ' ejemplares del mismo producto.', "warning");
                    } else {
                        Swal.fire("Cantidad fuera de stock!", "La cantidad que intentas ingresar rebasa el stock disponible!", "warning");
                    }
                }
            }
            desglosarPrecio();
        } else {
            $('#txt_cantidad').val(numero);
        }
    }

    btnDecremento.addEventListener('click', function (e) {
        hacerOperacion();
    });

    btnIncremento.addEventListener('click', function (e) {
        hacerOperacion();
    });

    btnDecremento.addEventListener('mousedown', function (e) {
        asignarOperacion(false);
        e = e || window.event;
        if (e.buttons == 1) {
            pressed = true;
            intervalId = setInterval(whilePressed, tiempo);
        }
    });

    btnIncremento.addEventListener('mousedown', function (e) {
        asignarOperacion(true);
        e = e || window.event;
        if (e.buttons == 1) {
            pressed = true;
            intervalId = setInterval(whilePressed, tiempo);
        }
    });

    btnDecremento.addEventListener('mouseup', function (e) {
        pressed = false;
    });

    btnIncremento.addEventListener('mouseup', function (e) {
        pressed = false;
    });

    function whilePressed() {
        if (pressed) {
            hacerOperacion();
        } else {
            desglosarPrecio();
            clearInterval(intervalId);
        }
    }

    function hacerOperacion() {
        if (operacion) {
            (numero < (stockDisponible - cantidadProductoCarrito)) ? numero++ : informe();
        } else {
            numero == 1 ? numero = 1 : numero--;
        }
        $('#txt_cantidad').val(numero);
    }

    function asignarOperacion(valor) {
        operacion = valor;
    }

    let cuentaClic = 0;
    const informe = () => {
        if (cantidadProductoCarrito != 0) {
            cuentaClic++;
            if (cuentaClic == 3) {
                Swal.fire("Hola!", 'Se comprobo que ya has agregado ' + cantidadProductoCarrito + ' ejemplares del mismo producto.', "warning");
                cuentaClic = 0;
            }
        } else {
            Swal.fire("Cantidad fuera de stock!", "La cantidad que intentas ingresar rebasa el stock disponible!", "warning");
        }
        pressed = false;
    }

    function desglosarPrecio() {
        let elPrecioUnitario = document.getElementById("el_precio_unitario").value,
            cantidad = document.getElementById("txt_cantidad").value,
            unidadMedida = document.getElementById("unidad_medida").value;
        totalInterno = cantidad;
        let total = new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(elPrecioUnitario * cantidad);

        document.getElementById("el_precio").innerHTML = total;
        document.getElementById("el_precio_abajo").innerHTML = total;
        document.getElementById("el_desglose").innerHTML = "$" + elPrecioUnitario + " x " + cantidad + " " + unidadMedida;
        document.getElementById("el_desglose_abajo").innerHTML = "$" + elPrecioUnitario + " x " + cantidad + " " + unidadMedida;
    }

    //-----------------------------------------------------------------------------
    const btnEnviarPreguntas = document.getElementById("btn_enviar_preguntas");
    btnEnviarPreguntas.addEventListener("click", (e) => {
        abrirModalEnviarPreguntas();
    });

    let activoModalEnviarPreguntas = false;
    function abrirModalEnviarPreguntas() {
        if (activoModalEnviarPreguntas) { return false; }
        activoModalEnviarPreguntas = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("pro_pre.modal_enviar_preguntas"),
            dataType: "html",
            success: function (respuesta) {
                $(respuesta)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#modal_enviar_preguntas") });
                    })
                    .on("hidden.bs.modal", function () {
                        activoModalEnviarPreguntas = false;
                        $(this).remove();
                    });
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', xhr, 'warning');
            },
        });
    }

    $(document).on("click", "#btn_guardar_pregunta", function (e) {
        e.preventDefault();
        guardarPregunta();
    });

    let activoGuardarPregunta = false;
    function guardarPregunta() {
        if (activoGuardarPregunta) { return false }
        activoGuardarPregunta = true;

        let formData = new FormData($("#frm_enviar_pregunta").get(0));
        formData.append("pfp_id", idPFP);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("pro_pre.store"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    let mensaje = "<ul>";
                    $.each(respuesta.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    mensaje += "</ul>";

                    Swal.fire({
                        title: "Existen campos faltantes",
                        html: mensaje,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK",
                    });
                } else {
                    document.getElementById('pregunta').value = "";
                    $("#modal_enviar_preguntas")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {
                            mostrarPreguntas();
                            Swal.fire("Proceso correcto!", respuesta.message, "success");
                        });
                }
                activoGuardarPregunta = false;
            },
        });
    }

    let activoModalVerPreguntas = false;
    $(document).on("click", "#btn_ver_preguntas", function (e) {
        e.preventDefault();
        if (activoModalVerPreguntas) { return false }
        activoModalVerPreguntas = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("pro_pre.show", idPFP),
            dataType: "html",
            success: function (respuesta) {
                $(respuesta)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#mod_preguntas") });
                    })
                    .on("hidden.bs.modal", function () {
                        activoModalVerPreguntas = false;
                        $(this).remove();
                    });
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', xhr, 'warning');
            },
        });
    });

    function mostrarPreguntas() {
        $.ajax({
            type: "GET",
            url: route("pro_pre.cpr", idPFP),
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

    //----------------------------------------------------------------------
    //                          Saltar a zona de preguntas
    const btnSaltarA = document.getElementById("saltar_a");
    btnSaltarA.addEventListener("click", (e) => {
        saltarA("#btn_enviar_preguntas");
    });

    function saltarA(id) {
        var tiempo = tiempo || 1000;
        $("html, body").animate({ scrollTop: $(id).offset().top }, tiempo);
    }

    //---------------------------------------------------------------
    //                          Agregando a Favoritos
    const btnAgregarFavoritos = document.getElementById("btn_agregar_favoritos");
    let iconoFav, tituloFav, estadoFav, idFav;

    if (btnAgregarFavoritos != null) {
        iconoFav = document.querySelector("#corazon_favorito");
        tituloFav = document.querySelector("#titulo_favoritos");
        estadoFav = $('#es_favorito').val();
        idFav = $('#id_favorito').val() != "" ? $('#id_favorito').val() : 0;
    }

    btnAgregarFavoritos?.addEventListener("click", (e) => {
        agregarFavorito();
    });

    let aceptarClicFav = false;
    function agregarFavorito() {
        if (aceptarClicFav) { return false }
        aceptarClicFav = true;

        let formData = new FormData();
        formData.append("pfp_id", idPFP);
        formData.append("id_favorito", idFav);

        estadoFav ? estadoFav = false : estadoFav = true;
        guardarEstadoFavorito(formData);
    }

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
                    estadoFav ? idFav = response.id_favorito : idFav = 0;
                    colorearEstadoFavorito();//Este va una vez que el estado de favorito haya sido guardado.
                    Swal.fire({ title: "Listo!", text: response.message, icon: "success", timer: 1500 });
                }
                aceptarClicFav = false;
            },
        });
    }

    function colorearEstadoFavorito() {
        if (estadoFav) {
            iconoFav.classList.remove('fa-regular');
            iconoFav.classList.add('fa-solid');
            tituloFav.innerHTML = "Quitar de favoritos";
        } else {
            iconoFav.classList.remove('fa-solid');
            iconoFav.classList.add('fa-regular');
            tituloFav.innerHTML = "Agregar a favoritos";
        }
    }

    //---------------------------------------------------------------------------------
    let selectColores = document.getElementById("select_colores"), colorSeleccionado = selectColores.options[selectColores.selectedIndex].value;

    const statesElement = document.querySelector('#select_colores')
    statesElement.addEventListener("change", (evt) => {
        colorSeleccionado = selectColores.options[selectColores.selectedIndex].value;
    });

    let cantidadActualCarrito = 0;
    if (numero == (document.getElementById("cantidad_carrito_compras").innerHTML)) {
        cantidadActualCarrito = parseInt(document.getElementById("cantidad_carrito_compras").innerHTML);
    }
    const nombreEmpresa = $('#nombre_empresa').val();
    const btnBuscarEmpresa = document.getElementById("buscar_empresa");
    btnBuscarEmpresa.addEventListener("click", (e) => {
        clicEmpresa(nombreEmpresa);
    });

    function clicEmpresa(laEmpresa) {
        localStorage.setItem('empresa', laEmpresa)
        window.location = route("tienda_urg.ver_tienda");
    }

    const btnSeleccionarRequisicion = document.getElementById("btn_seleccionar_requisicion");
    if (btnSeleccionarRequisicion != null) {
        btnSeleccionarRequisicion.addEventListener("click", (e) => {
            let cabms = document.querySelector('#participacion');
            abrirModalSeleccionarRequisicion(cabms.value);
        });
    }

    let activoModalSelecReq = false;
    function abrirModalSeleccionarRequisicion(cabms) {
        if (activoModalSelecReq) { return false }
        activoModalSelecReq = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("requisiciones.modal_seleccionar_requisicion", { cabms: cabms }),
            dataType: "html",
            success: function (respuesta) {
                $(respuesta)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#modal_seleccionar_requisicion") });
                    })
                    .on("hidden.bs.modal", function () {
                        $(this).remove();
                        activoModalSelecReq = false;
                    });
            },
            error: function (respuesta) {
                console.log(respuesta);
            },
        });
    }

    $(document).on("click", "#btn_guardar_requisicion", function (e) {
        e.preventDefault();
        procesarCarrito();
    });

    let activoGuardarReq = false;
    function procesarCarrito() {
        if (activoGuardarReq) { return false; }
        activoGuardarReq = true;

        guardarProductoCarrito();
        cantidadActualCarrito = document.getElementById("cantidad_carrito_compras").value;

        $("#modal_seleccionar_requisicion")
            .modal("hide")
            .on("hidden.bs.modal", function () {
                activoGuardarReq = false;
            });
    }

    function guardarProductoCarrito() {
        let selectRequisiciones = document.getElementById("select_requisiciones"),
            idRequisicion = selectRequisiciones.options[selectRequisiciones.selectedIndex].value,
            formData = new FormData();
        formData.append("id_requisicion", idRequisicion);
        formData.append("id_pfp", idPFP);
        formData.append("cantidad_producto", totalInterno);
        formData.append("color", colorSeleccionado);
        let carrito = document.getElementById("cantidad_carrito_compras").innerHTML;
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route("carrito_compra.store"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    Swal.fire("¡Alerta!", response.message, "warning");
                } else {
                    console.log(response);
                    document.getElementById("cantidad_carrito_compras").innerHTML = parseInt(carrito)+1;
                    Swal.fire("Proceso correcto!", response.message, "success");
                }
            },
        });
    }

    $(document).on("click", "#btn_ver_carrito_uno", function (e) {
        e.preventDefault();
        window.location = route("carrito_compra.index");
    });
});