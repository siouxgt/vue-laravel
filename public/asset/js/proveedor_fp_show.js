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

    if (n > slides.length) slideIndex = 1;
    if (n < 1) slideIndex = slides.length;

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

document.addEventListener("DOMContentLoaded", () => {
    const idP = document.getElementById('id_o').value;

    $(document).on("click", "#btn-ver-preguntas", function (e) {
        irPreguntas();
    });

    const irPreguntas = () => $('html, body').animate({ scrollTop: $("#punto-encuentro-preguntas").offset().top }, 1000);//Con JQuery
    // document.getElementById("punto-encuentro-preguntas")?.scrollIntoView({ behavior: 'smooth' }, false); //Con JS

    (function () {
        $(document).ready(function () {
            $('.zoom').hover(function () {
                $(this).addClass('transition');
            }, function () {
                $(this).removeClass('transition');
            });
        });

        $.each($('#btn_decremento'), function (index, value) {
            $(this).css('pointer-events', 'none');
            $(this).css('cursor', 'not-allowed');
        });

        $.each($('#btn_incremento'), function (index, value) {
            $(this).css('pointer-events', 'none');
            $(this).css('cursor', 'not-allowed');
        });

        let elPrecioUnitario = document.getElementById("el_precio_unitario").value,
            cantidad = document.getElementById("txt_cantidad").value,
            unidadMedida = document.getElementById("unidad_medida").value;
        let total = new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(elPrecioUnitario * cantidad);

        document.getElementById("el_precio").innerHTML = total;
        document.getElementById("el_desglose").innerHTML = "$" + elPrecioUnitario + " x " + cantidad + " " + unidadMedida;
    })();

    (function () {
        const catProductoId = document.getElementById('cat_producto_id').value;
        const estadoEdicion = document.getElementById('estado_edicion') != null ? true : false;

        if (!estadoEdicion) {
            $(document).on("click", "#btn_enviar_revision", function (e) {
                e.preventDefault();
                enviarRevision();
            });
        }

        function enviarRevision() {
            let titulo = "¡Felicidades!",
                texto = "Tu producto será enviado a revisión, presta atención a las evaluaciones que recibirás por parte del SAF.";

            Swal.fire({
                title: titulo, text: texto, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "Ok", allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "GET",
                        url: route("proveedor_fp.validacion_economica", { id: idP })
                    });

                    let formData = new FormData();
                    formData.append("emisor", "cambiar");
                    formData.append("estatus", true);
                    formData.append("_method", "PUT");

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        url: route("proveedor_fp.update", { id: idP }),
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status == 400) {
                                Swal.fire("¡Alerta!", response.message, "warning");
                            } else {
                                window.location = route("proveedor_fp.abrir_index", catProductoId);
                            }
                        },
                    });
                }
            });
        }
    })();

    setTimeout(function () {//Desplegar el primer collapse despues de 1 segundos
        cargarPreguntasRespuestas();
    }, 5);

    const cargarPreguntasRespuestas = () => {
        document.getElementById('area_preguntas_respuestas').innerHTML = '';

        $.ajax({
            type: "GET",
            url: route("pro_pre.get_preguntas_respuestas", idP),
            success: function (respuesta) {
                document.getElementById('cantidad_preguntas').innerText = respuesta.contenido.length;

                if (respuesta.contenido.length != 0) {
                    for (let index = 0; index < respuesta.contenido.length; index++) {
                        let dato = respuesta.contenido[index];

                        let divGlobalPreguntas = document.createElement("div"),
                            divText = document.createElement("div"),
                            divTemaPregunta = document.createElement("div"),
                            divPregunta = document.createElement("div"),
                            divFechaPregunta = document.createElement("div");
                        let temaPregunta = document.createElement("p"),
                            pregunta = document.createElement("p"),
                            fechaPregunta = document.createElement("p"),
                            hr = document.createElement("hr");

                        divGlobalPreguntas.setAttribute('class', 'col-12');
                        divText.setAttribute('class', 'text-center vl-2 col-1');
                        hr.setAttribute('class', 'mt-2 mb-2'); //-7rem o -4rem

                        divTemaPregunta.setAttribute('class', 'col-12');
                        divTemaPregunta.setAttribute('style', 'top: -5rem');
                        temaPregunta.setAttribute('class', 'text-1 font-weight-bold');
                        temaPregunta.innerText = dato.tema_pregunta;
                        divTemaPregunta.appendChild(temaPregunta);

                        divPregunta.setAttribute('class', 'col-12');
                        divPregunta.setAttribute('style', 'top: -4.8rem');
                        pregunta.setAttribute('class', 'text-2 text-justify');
                        pregunta.innerText = dato.pregunta;
                        divPregunta.appendChild(pregunta);

                        divFechaPregunta.setAttribute('class', 'col-12');
                        divFechaPregunta.setAttribute('style', 'top: -4.5rem');
                        fechaPregunta.setAttribute('class', 'text-12 font-italic');
                        fechaPregunta.innerText = dato.nombre_urg + ' - ' + dato.fecha_pregunta;
                        divFechaPregunta.appendChild(fechaPregunta);
                        divFechaPregunta.appendChild(hr);

                        divGlobalPreguntas.appendChild(divText);
                        divGlobalPreguntas.appendChild(divTemaPregunta);
                        divGlobalPreguntas.appendChild(divPregunta);
                        divGlobalPreguntas.appendChild(divFechaPregunta);

                        let divDinamico = document.createElement("div");
                        if (dato.respuesta == null) {//Si no hay respuesta aún, mostrar botón
                            let btnResponder = document.createElement("button");
                            divDinamico.setAttribute('class', 'col-12 text-right'); //text-right
                            divDinamico.setAttribute('style', 'top: -4rem'); //-7rem o -4rem
                            btnResponder.setAttribute('class', 'btn bg-white text-green-2')
                            btnResponder.setAttribute('type', "button");
                            btnResponder.setAttribute('style', "font-size: 1rem;");
                            btnResponder.setAttribute('id', "btn-responder-mensaje-" + index);
                            btnResponder.innerText = 'Responder'
                            divDinamico.appendChild(btnResponder);
                        } else {//Si ya existe respuesta, mostrarla
                            divDinamico.setAttribute('class', 'col-12');
                            divDinamico.setAttribute('style', 'top: -4.8rem');
                            createElementRespuesta(divDinamico, dato.respuesta, dato.fecha_respuesta);
                        }
                        divDinamico.setAttribute('id', 'div-dinamico-' + index);
                        divGlobalPreguntas.appendChild(divDinamico);

                        document.getElementById('area_preguntas_respuestas').appendChild(divGlobalPreguntas);

                        if (dato.respuesta == null) {
                            $(document).on("click", "#btn-responder-mensaje-" + index, function (e) {
                                abrirModalResponder(dato.id_e, 'div-dinamico-' + index, "btn-responder-mensaje-" + index);
                            });
                        }
                    }
                } else {
                    let divSin = document.createElement("div"),
                        sinPreguntas = document.createElement("p"),
                        areaPreguntas = document.getElementById('area_preguntas_respuestas');
                    divSin.setAttribute('class', 'col-12 mt-5 text-center');
                    sinPreguntas.setAttribute('class', 'titel-2');
                    sinPreguntas.setAttribute('style', 'font-size: 3rem');
                    sinPreguntas.innerHTML = 'NO HAY PREGUNTAS';
                    divSin.appendChild(sinPreguntas);
                    areaPreguntas.style.setProperty('height', 'auto')
                    areaPreguntas.appendChild(divSin);
                }
            },
        });
    }

    const createElementRespuesta = (divDinamico, laRespuesta, laFechaRespuesta) => {
        let divFechaRespuesta = document.createElement("div"),
            respuesta = document.createElement("p"),
            fechaRespuesta = document.createElement("p");

        respuesta.setAttribute('class', 'ml-3 text-2 text-justify');
        respuesta.innerHTML = '<span class="font-italic font-weight-bold">Tu respuesta: </span>' + laRespuesta;
        fechaRespuesta.setAttribute('class', 'text-12 font-italic');
        fechaRespuesta.innerText = laFechaRespuesta;
        divFechaRespuesta.setAttribute('class', 'col-12');
        divFechaRespuesta.appendChild(fechaRespuesta);
        divDinamico.appendChild(respuesta);
        divDinamico.appendChild(divFechaRespuesta);
    }

    let estatusModal = false, idPregunta = 0, elBtn = elDiv = '';
    const abrirModalResponder = (id, padre, hijo) => {
        if (estatusModal) return false;
        estatusModal = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("pro_pre.edit", id),
            dataType: "html",
            success: function (respuesta) {
                $(respuesta)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#modal_responder_preguntas") });
                        elDiv = document.getElementById(padre);
                        elBtn = document.getElementById(hijo);
                        idPregunta = id;
                    })
                    .on("hidden.bs.modal", function () {
                        $(this).remove();
                        estatusModal = false;
                    });
            },
            error: function (respuesta) {
                console.log(respuesta);
            },
        });
    }

    $(document).on("click", "#btn_responder_pregunta", function (e) {
        if (!formValidate("#frm_responder_pregunta")) return false;

        let formData = new FormData($("#frm_responder_pregunta").get(0));
        let btnResponder = $('#btn_responder_pregunta').attr('disabled', true);
        btnResponder.text("Respondiendo...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("pro_pre.update", idPregunta),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnResponder.text("Responder");
                    btnResponder.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_responder_preguntas").modal("hide").on("hidden.bs.modal", function () {
                        elDiv.removeChild(elBtn);
                        elDiv.classList.remove('text-right');
                        elDiv.style.setProperty('top', '-4.8rem');
                        createElementRespuesta(elDiv, response.respuesta, response.fechaRespuesta);
                        Swal.fire("Proceso  correcto!", response.message, "success");
                    });
                }
            },
        });
    });
});