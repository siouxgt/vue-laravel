document.addEventListener("DOMContentLoaded", () => {
    let idContratoMarco = document.getElementById('id_contrato_marco')?.value,
        num = 1;

    (() => {
        let getMeTo = document.getElementById("punto-encuentro");
        getMeTo?.scrollIntoView({ behavior: 'smooth' }, false);
    })();

    //-- Para editar
    if (document.getElementById('total_capitulos_partidas')) num = parseInt(document.getElementById('total_capitulos_partidas').value);

    for (let i = 0; i < num; i++) {
        $(document).on("change", `#capitulo${i}`, function (e) {
            e.preventDefault();
            buscarPartida(`capitulo${i}`);
        });
    }

    if (num > 1) {//Solo si hay botones quitar
        for (let i = 1; i < num; i++) {
            $(document).on("click", `#btn-eliminar-input-${i}`, function (e) {
                e.preventDefault();
                eliminarInput(`hijo[${i}]`);
            });
        }
    }
    //-- Para editar

    $(document).on("change", "#val_tec", function (e) {
        e.preventDefault();
        buscarRvt();
    });

    $(document).on("click", "#btn-guardar-contrato", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_datos_generales")) return false;

        let formData = new FormData($("#frm_datos_generales").get(0));
        let btnGuardar = $('#btn-guardar-contrato').attr('disabled', true);
        btnGuardar.text("Guardando...");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("contrato.store"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    btnGuardar.text("Guardar y continuar");
                    btnGuardar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(respuesta.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    setTimeout(function () {
                        window.location = route("anexos_contrato.index");
                    }, 1500);
                }
            },
            error: function (xhr) {
                Swal.fire("¡Alerta!", xhr, "warning");
            },
        });
    });

    $(document).on("click", "#btn-actualizar-contrato", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_datos_generales")) return false;

        let btnGuardar = $('#btn-actualizar-contrato').attr('disabled', true);
        btnGuardar.text("Actualizando...");

        let formData = new FormData($("#frm_datos_generales").get(0));
        formData.append('_method', 'PUT');

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("contrato.update", idContratoMarco),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    btnGuardar.text("Actualizar y continuar");
                    btnGuardar.attr('disabled', false);
                    let mensaje = "<ul>";

                    $.each(respuesta.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    setTimeout(function () {
                        window.location = route("anexos_contrato.index");
                    }, 1500);
                }
            },
            error: function (xhr) {
                Swal.fire("¡Alerta!", xhr, "warning");
            },
        });
    });

    // let datosgenclick = document.getElementById("nav-home-tab");
    // datosgenclick.addEventListener("click", () => {
    //     console.log("Home")
    //     if (getNameURLWeb() == "create") {
    //         console.log("Algo pasa aquyi")
    //         if (idContratoMarco != "") window.location = route("contrato.edit", idContratoMarco);
    //     } else {
    //         console.log("Home")
    //     }
    // });

    //keydown, keyup, keypress
    let escuchado = document.getElementById("nombre_cm");
    escuchado.addEventListener("keyup", () => {
        if (escuchado.value != "") {
            let nom_cm = escuchado.value.replace(/\s/g, '-'); //Capturando y quitando todos los espacios a nombre del contrato
            let id_cm = document.getElementById("id_contrato").value,
                año = new Date().getFullYear(),
                num_cm = nom_cm + "-" + id_cm + "-" + año + "-" + "CDMX";
            document.getElementById("numero_cm").value = num_cm;
        }
        else {
            document.getElementById("numero_cm").value = " ";
        }
    });

    $(document).ready(function () {
        dataTable = $('#tabla_anexos_contrato').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            }
        });

        $('#sector,#validaciones_seleccionadas,#partida,#capitulo0').select2();
        $('[data-toggle="popover"]').popover();
    });

    let selectEntAdm = document.getElementById("entidad_administradora");
    selectEntAdm.addEventListener("change", function () {
        document.getElementById("domicilio_ea").value = selectEntAdm.options[selectEntAdm.selectedIndex].getAttribute('data');
        cargarURGResponsables();
    });

    function getNameURLWeb() {
        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf("/") + 1);
        return sPage;
    }

    $(document).ready(function () {
        if (getNameURLWeb() != "create") {
            cargarURGResponsables(document.getElementById("urg_responsable").value);
            banderaTabla = false;
        }
    });

    function cargarURGResponsables(editado = null) {
        let responsables = $('#responsable_sel');
        $.ajax({
            type: "GET",
            url: route("contrato.responsables", $("#entidad_administradora").val()),
            success: function (r) {
                if (editado == null) {
                    responsables.empty().append()
                    responsables.append("<option value='0' disabled='' selected=''>Seleccione</option>");
                    document.getElementById("cargo").value = "";
                    if (r.responsables.length != 0) {
                        $.each(r.responsables, function (index, value) {
                            responsables.append(`<option value="${value.id_e}" data="${value.cargo}"> ${value.nombre} ${value.primer_apellido} ${value.segundo_apellido}</option>`);
                        });
                    }
                } else {
                    if (r.responsables.length != 0) {
                        let seleccionado = responsables[0].options[responsables[0].selectedIndex].text;
                        let nombre;
                        $.each(r.responsables, function (index, value) {
                            nombre = value.nombre + " " + value.primer_apellido + " " + value.segundo_apellido;
                            if (nombre != seleccionado) {
                                responsables.append(`<option value="${value.id_e}" data="${value.cargo}"> ${value.nombre} ${value.primer_apellido} ${value.segundo_apellido}</option>`);
                            }
                        });
                    }
                }
                addEscuchaResponsables();
            },
        });
    }

    function addEscuchaResponsables() {
        let selectResponsable = document.getElementById("responsable_sel"); //
        selectResponsable.addEventListener("change", function () {
            document.getElementById("cargo").value = selectResponsable.options[selectResponsable.selectedIndex].getAttribute('data');
        });
    }

    $(document).on("click", '#btn-agregar-cp', function (e) {
        e.preventDefault();
        agregarCapituloPartida();
    });

    function agregarCapituloPartida() {
        $(document.getElementById('btn-agregar-cp')).closest(".parentDivCP").append(
            $(`
        <div class="form-row mx-3 text-1 parentDiv" id="hijo[${num}]">    
            <div class="form-group col-12 col-md-6">
                <label for="capitulo">Capítulo</label>
                <select class="form-control text-1" id="capitulo${num}" name="capitulo[${num}]" required>
                    <option value="0" disabled="" selected="">Seleccione</option>
                    <option value="1">1000 SERVICIOS PERSONALES</option>
                    <option value="2">2000 MATERIALES Y SUMINISTROS</option>
                    <option value="3">3000 SERVICIOS GENERALES</option>
                    <option value="4">4000 TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS</option>
                    <option value="5">5000 BIENES MUEBLES, INMUEBLES E INTANGIBLES</option>
                </select>                                
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="partida">Partida</label>
                <select class="form-control text-1 optionsPartida" id="partida${num}" name="partida[${num}]" required>
                    <option value="0" disabled="" selected="">Seleccione</option>
                </select>                                
            </div>
            <div class="form-row col-12 mt-2 modal-footer">
                <button type="button" id="btn-eliminar-input-${num}" class="btn boton-1">Quitar</button>
            </div>
        </div>`));

        let cap = `capitulo${num}`,
            hijo = `hijo[${num}]`;

        $(`#${cap}`).select2();
        $(`#partida${num}`).select2();

        $(document).on("change", `#capitulo${num}`, function (e) {
            e.preventDefault();
            buscarPartida(cap);
        });

        $(document).on("click", `#btn-eliminar-input-${num}`, function (e) {
            e.preventDefault();
            eliminarInput(hijo);
        });

        num++;
    }

    function buscarPartida(id) {
        let element = document.getElementById(id);
        $.ajax({
            url: route("contrato.service", element.value),
            type: "GET",
            success: function (respuesta) {
                if (respuesta.success == true) {
                    let selectPartidas = $(element).closest(".parentDiv").find(".optionsPartida");
                    selectPartidas.empty().append();
                    selectPartidas.append($("<option></option>").attr("value", 0).attr("disabled", "").attr("selected", "").text("Seleccione"));
                    for (let i = 0; i < respuesta.data.length; i++) {
                        selectPartidas.append(
                            $("<option></option>")
                                .attr("value", respuesta.data[i].par_pre + "-" + respuesta.data[i].descripcion)
                                .text(respuesta.data[i].par_pre + " -- " + respuesta.data[i].descripcion)
                        );
                    }
                } else Swal.fire("error", respuesta.message, "error");
            },
        });
    }

    function eliminarInput(id) {
        let element = document.getElementById(id);
        if (typeof element != "undefined" && element != null) {
            element.remove();
        }
    }

    function buscarRvt() {
        let chk1 = $("[id$=val_tec]");
        if ($(chk1).is(":checked")) {
            obtenerRVT();
        } else {
            $("#validaciones_seleccionadas").empty().append();
            document.getElementById("validaciones_seleccionadas").disabled = true;
        }
    }

    function obtenerRVT() {
        $.ajax({
            type: "GET",
            url: route("contrato.responsablesvt"),
            success: function (data) {
                let selectValTec = $("#validaciones_seleccionadas").empty().append();
                $.each(data, function (key, value) {
                    selectValTec.append($("<option></option>").attr("value", value.id).text(value.siglas + " -- " + value.direccion));
                });
                selectValTec.trigger("change");
                document.getElementById("validaciones_seleccionadas").disabled = false;
            },
        });
    }
});
