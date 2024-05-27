document.addEventListener("DOMContentLoaded", () => {
    const totalInputs = 3, cel = parseInt(document.getElementById('celda').value);;
    let errores = false, foco = false;
    let expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]{3,50}$/,
        expRegApellidos = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/,
        expRegLetrasEspacio = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/,
        expRegSoloTel = /^[0-9]{10}$/,
        expRegSoloExt = /^[0-9]{3,5}$/,
        expRegCorreo = /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/;

    let inputNombres = [], inputPrimerApellido = [], inputSegundoApellido = [], inputCargos = [], inputTel = [], inputExt = [], inputCel = [], inputCorreo = [];
    let alertaNombres = [], alertaPrimerApellido = [], alertaSegundoApellido = [], alertaCargo = [], alertaTelefono = [], alertaExtension = [], alertaCel = [], alertaCorreo = [];
    
    for (let i = 0; i < totalInputs; i++) {
        inputNombres[i] = document.getElementById(`nombre_${i + 1}`);
        inputPrimerApellido[i] = document.getElementById(`primer_apellido_${i + 1}`);
        inputSegundoApellido[i] = document.getElementById(`segundo_apellido_${i + 1}`);
        inputCargos[i] = document.getElementById(`cargo_${i + 1}`);
        inputTel[i] = document.getElementById(`telefono_${i + 1}`);
        inputExt[i] = document.getElementById(`extension_${i + 1}`);
        inputCel[i] = document.getElementById(`celular_${i + 1}`);
        inputCorreo[i] = document.getElementById(`correo_${i + 1}`);
        alertaNombres[i] = document.getElementById(`div_alerta_nombre_${i + 1}`);//Alertas
        alertaPrimerApellido[i] = document.getElementById(`div_alerta_primer_apellido_${i + 1}`);
        alertaSegundoApellido[i] = document.getElementById(`div_alerta_segundo_apellido_${i + 1}`);
        alertaCargo[i] = document.getElementById(`div_alerta_cargo_${i + 1}`);
        alertaTelefono[i] = document.getElementById(`div_alerta_telefono_${i + 1}`);
        alertaExtension[i] = document.getElementById(`div_alerta_extension_${i + 1}`);
        alertaCel[i] = document.getElementById(`div_alerta_celular_${i + 1}`);
        alertaCorreo[i] = document.getElementById(`div_alerta_correo_${i + 1}`);

        agregarEventKeyUp(inputNombres[i], alertaNombres[i], 1);
        agregarEventKeyUp(inputPrimerApellido[i], alertaPrimerApellido[i], 2);
        agregarEventKeyUp(inputSegundoApellido[i], alertaSegundoApellido[i], 2);
        agregarEventKeyUp(inputCargos[i], alertaCargo[i], 3);
        agregarEventKeyUp(inputTel[i], alertaTelefono[i], 4);
        agregarEventKeyUp(inputExt[i], alertaExtension[i], 5);
        agregarEventKeyUp(inputCel[i], alertaCel[i], 6);
        agregarEventKeyUp(inputCorreo[i], alertaCorreo[i], 7);
    }

    function agregarEventKeyUp(input, alerta, quien) {
        let controladorTiempo = ``;
        input?.addEventListener("keyup", () => {
            clearTimeout(controladorTiempo);
            controladorTiempo = setTimeout(function () {
                if (quien == 1) validarNombres(input, alerta);
                if (quien == 2) validarApellidos(input, alerta);
                if (quien == 3) validarCargos(input, alerta);
                if (quien == 4) validarTelefonos(input, alerta);
                if (quien == 5) validarExtens(input, alerta);
                if (quien == 6) validarCels(input, alerta);
                if (quien == 7) validarCorreos(input, alerta);
            }, 500);
        });
    }

    function validarNombres(inputNombre, alertaNombre) {
        if (!inputNombre.value) {
            errorLocalizado(inputNombre, alertaNombre, `<p class="text-danger" style="font-size: 12px">El nombre es requerido</p>`);
        } else {
            if (!expRegNombre.exec(inputNombre.value)) {
                errorLocalizado(inputNombre, alertaNombre, `<p class="text-danger" style="font-size: 12px">El dato no es un nombre aceptable</p>`);
            } else {
                alertaNombre.innerHTML = '';
            }
        }
    }

    function validarApellidos(inputApellido, alertaApellido) {
        if (inputApellido.value) {
            if (!expRegApellidos.exec(inputApellido.value)) {
                errorLocalizado(inputApellido, alertaApellido, `<p class="text-danger" style="font-size: 12px">El dato no es un apellido aceptable</p>`);
            } else {
                alertaApellido.innerHTML = '';
            }
        } else {
            alertaApellido.innerHTML = '';
        }
    }

    function validarCargos(inputCargos, alertaCargo) {
        if (!inputCargos.value) {
            errorLocalizado(inputCargos, alertaCargo, `<p class="text-danger" style="font-size: 12px">El cargo es requerido</p>`);
        } else {
            if (!expRegLetrasEspacio.exec(inputCargos.value)) {
                errorLocalizado(inputCargos, alertaCargo, `<p class="text-danger" style="font-size: 12px">El dato no es un cargo aceptable</p>`);
            } else {
                alertaCargo.innerHTML = '';
            }
        }
    }

    function validarTelefonos(inputTel, alertaTel) {
        if (inputTel.value) {
            if (!expRegSoloTel.exec(inputTel.value)) {
                errorLocalizado(inputTel, alertaTel, `<p class="text-danger" style="font-size: 12px">Número inválido (se esperan 10 dígitos)</p>`);
            } else {
                alertaTel.innerHTML = '';
            }
        } else {
            alertaTel.innerHTML = '';
        }
    }

    function validarExtens(inputExt, alertaExt) {
        if (inputExt.value) {
            if (!expRegSoloExt.exec(inputExt.value)) {
                errorLocalizado(inputExt, alertaExt, `<p class="text-danger" style="font-size: 12px">Núm. inválido (se esperan 3 a 5 dígitos)</p>`);
            } else {
                alertaExt.innerHTML = '';
            }
        } else {
            alertaExt.innerHTML = '';
        }
    }

    function validarCels(inputCel, alertaCel) {
        if (!inputCel.value) {
            errorLocalizado(inputCel, alertaCel, `<p class="text-danger" style="font-size: 12px">El número de celular es requerido</p>`);
        } else {
            if (!expRegSoloTel.exec(inputCel.value)) {
                errorLocalizado(inputCel, alertaCel, `<p class="text-danger" style="font-size: 12px">Número inválido (se esperan 10 dígitos)</p>`);
            } else {
                alertaCel.innerHTML = '';
            }
        }
    }

    function validarCorreos(inputCorreo, alertaCorreo) {
        if (!inputCorreo.value) {
            errorLocalizado(inputCorreo, alertaCorreo, `<p class="text-danger" style="font-size: 12px">El correo electrónico es requerido</p>`);
        } else {
            if (!expRegCorreo.exec(inputCorreo.value)) {
                errorLocalizado(inputCorreo, alertaCorreo, `<p class="text-danger" style="font-size: 12px">El correo no es válido</p>`);
            } else {
                alertaCorreo.innerHTML = '';
            }
        }
    }

    function errorLocalizado(input, alerta, mensaje) {
        if (foco) input.focus();
        alerta.innerHTML = mensaje;
        errores = true;
    }

    validarFormulario();
    foco = true;

    function validarFormulario() {
        errores = false;
        for (let i = 0; i < totalInputs; i++) {
            validarNombres(inputNombres[i], alertaNombres[i]);
            validarApellidos(inputPrimerApellido[i], alertaPrimerApellido[i]);
            validarApellidos(inputSegundoApellido[i], alertaSegundoApellido[i]);
            validarCargos(inputCargos[i], alertaCargo[i]);
            validarTelefonos(inputTel[i], alertaTelefono[i]);
            validarExtens(inputExt[i], alertaExtension[i]);
            validarCels(inputCel[i], alertaCel[i]);
            validarCorreos(inputCorreo[i], alertaCorreo[i]);
        }
    }

    $(document).on("click", "#btnGuardarME", function (e) {
        e.preventDefault();

        validarFormulario();

        if (errores) {
            Swal.fire({ title: "No se puede continuar", html: "<p class='text-center'>Existen campos obligatorios que no has proporcionado o el llenado de los campos es incorrecto, procede a revisar para su corrección por favor.</p>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
            return false;
        } else {
            guardarM();
        }
    });

    const guardarM = () => {
        let formData = new FormData($("#frm_m_escalamiento").get(0));
        let btnEnviar = $('#btnGuardarME').attr('disabled', true);
        btnEnviar.text("Guardando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route(cel ? 'proveedor.actualizar_me' : 'proveedor.guardar_me_vigente'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Actualizar y continuar");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else if (response.status == 200) {
                    Swal.fire({ title: "Proceso  correcto!", icon: 'success', html: response.message, confirmButtonText: "OK" })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location = route("proveedor.redirigir_actualizado");
                            }
                        });
                } else {
                    Swal.fire("Error!", 'No fue posible continuar', 'error')
                }
            },
        });
    }
});