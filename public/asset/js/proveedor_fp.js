(function () {
    $(function () { $('[data-toggle="tooltip"]').tooltip() })
    //===============================================================
    //                          Variables
    let ipfp = document.getElementById("pfp_id").value,
        validacionTecDisponible = document.getElementById("e_validacion_tec");

    let flechaProducto = document.querySelector("#flecha_producto"),
        flechaFichaTec = document.querySelector("#flecha_ficha_tec"),
        flechaCaracteristicas = document.querySelector("#flecha_caracteristicas"),
        flechaEntrega = document.querySelector("#flecha_entrega"),
        flechaPrecio = document.querySelector("#flecha_precio"),
        flechaValidacionTec = document.querySelector("#flecha_validacion_tec");

    let elegido = false;

    let estatusInicio = true,
        estatusProducto = false,
        estatusFichaTec = false,
        estatusOtroDoc = [false, false, false],
        estatusColores = false,
        estatusDimensiones = false,
        estatusCaracteristicas = false,
        estatusEntrega = false,
        estatusPrecio = false,
        estatusValidacionTec = false;

    let estatusAFT = false;

    let contarOtroDoc = 0,
        numColores = 0;

    let estatusFoto = [false, false, false, false, false];
    let nombreFotos = ["foto_uno", "foto_dos", "foto_tres", "foto_cuatro", "foto_cinco", "foto_seis"];
    let opcionesNav = ['inicio', 'producto', 'ficha_tec', 'caracteristicas', 'entrega', 'precio', 'validacion_tec'];
    //===============================================================
    //                          Inicializando
    if (document.getElementById("e_producto").value == true) {
        estatusProducto = true;
    } else establecerElegido('producto');

    if (document.getElementById("e_ficha_tec").value == true) {
        estatusFichaTec = estatusAFT = true;
        document.getElementById("doc_ficha_tecnica").disabled = true;
    } else establecerElegido('ficha_tec');

    if (document.getElementById("e_caracteristicas").value == true) {
        estatusCaracteristicas = true;
    } else establecerElegido('caracteristicas');

    if (document.getElementById("e_entrega").value == true) {
        estatusEntrega = true;
    } else establecerElegido('entrega');

    if (document.getElementById("e_precio").value == true) {
        estatusPrecio = true;
        if (!document.getElementById("e_validacion_tec")) establecerElegido('precio');
    } else establecerElegido('precio');

    if (document.getElementById("e_validacion_tec")) {
        if (document.getElementById("e_validacion_tec").value == true) {
            estatusValidacionTec = true;
            document.getElementById("prueba").disabled = true;
            establecerElegido('validacion_tec');
        } else establecerElegido('validacion_tec');
    }

    function establecerElegido(nombreElegido) {
        if (!elegido) {
            clickOpcionNav(nombreElegido);
            elegido = true;
        }
    }

    if (document.getElementById("doc_adicional_uno")) estatusOtroDoc[0] = true;
    if (document.getElementById("doc_adicional_dos")) estatusOtroDoc[1] = true;
    if (document.getElementById("doc_adicional_tres")) estatusOtroDoc[2] = true;
    estatusDimensiones = (document.getElementById("las_dimensiones").value != "") ? true : false;
    estatusColores = (document.getElementById("los_colores").value != "") ? true : false;
    recorrerArrayOtrosDoc();

    for (let i = 0; i < nombreFotos.length; i++) {
        comprobarEstatusFotos(nombreFotos[i]);
    }

    if (estatusFichaTec) generarEscuchaBotonEliminar("ficha_tec");
    if (estatusOtroDoc[0]) generarEscuchaBotonEliminar("doc_adicional_uno");
    if (estatusOtroDoc[1]) generarEscuchaBotonEliminar("doc_adicional_dos");
    if (estatusOtroDoc[2]) generarEscuchaBotonEliminar("doc_adicional_tres");
    if (estatusValidacionTec) generarEscuchaBotonEliminar("validacion_tec");

    //===============================================================
    //                          Botones
    document.getElementById("btn_guardar_producto").addEventListener("click", (e) => {
        guardarFichaProducto('', 'producto', '')
    });

    opcionesNav.forEach(nav => {
        $(document).on("click", `#btn_hacia_${nav}`, function (e) {
            e.preventDefault();
            clickOpcionNav(nav);
        });

        $(document).on("click", `#btn_atras_${nav}`, function (e) {
            e.preventDefault();
            clickOpcionNav(nav);
        });
    });

    nombreFotos.forEach(nom => {
        $(document).on("click", `#btn_eliminar_${nom}`, function (e) {
            e.preventDefault();
            comprobarEliminarFoto(nom);
        });
    });

    $(document).on("change", "#doc_ficha_tecnica", function (e) {
        e.preventDefault();
        if (this.files.length <= 0) return; // si no hay archivos, regresamos

        if (estatusFichaTec) {
            Swal.fire("No se puede continuar!", "Solo tienes permitido subir 1 ficha técnica.", "warning");
        } else {
            if (this.files[0].size > 30000000) {
                document.getElementById(this.id).value = ""; // Limpiar
                Swal.fire("Documento demasiado grande", `El tamaño máximo aceptable es de: 30 MB`, "error");
            } else guardarFichaProducto(new FormData($("#frm_ficha_tec").get(0)), "ficha_tec", "agregar_ft");
        }
    });

    $(document).on("change", "#el_doc_adicional", function (e) {
        e.preventDefault();
        if (this.files.length <= 0) return; // si no hay archivos, regresamos

        for (let i = 0; i < estatusOtroDoc.length; i++) {
            if (estatusOtroDoc[i] == false) {
                let tipoDocAdicional = "";
                switch (i) {
                    case 0: tipoDocAdicional = "doc_adicional_uno"; break;
                    case 1: tipoDocAdicional = "doc_adicional_dos"; break;
                    case 2: tipoDocAdicional = "doc_adicional_tres"; break;
                }

                if (this.files[0].size > 30000000) {
                    document.getElementById(this.id).value = ""; // Limpiar
                    Swal.fire("Documento demasiado grande", `El tamaño máximo aceptable es de: 30 MB`, "error");
                } else {
                    let formData = new FormData($("#frm_otro_doc").get(0));
                    formData.append("tipo_doc_adicional", tipoDocAdicional);
                    guardarFichaProducto(formData, "doc_adicional", i);
                }

                break;
            } else contarOtroDoc++;

            (contarOtroDoc == 3) ? Swal.fire("No se puede continuar!", "Solo tienes permitido subir 3 documentos como máximo.", "warning") : '';
        }
        contarOtroDoc = 0;
    });

    $(document).on("click", "#btn_guardar_ficha_tec", function (e) {
        e.preventDefault();
        if (estatusFichaTec) {
            clickOpcionNav("caracteristicas");
            flechaFichaTec.classList.add('bac-green');
            establecerColorNav("ficha_tec");
            Swal.fire("Proceso correcto!", "Documentos guardados", "success");
        } else Swal.fire("No se puede continuar!", "La ficha técnica es necesaria", "error");
    });

    let e_modal_color = false, e_modal_dim = false;
    $(document).on("click", "#btn_modal_agregar_color", function (e) {
        e.preventDefault();
        if (e_modal_color) return false;
        e_modal_color = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("proveedor_fp.m_color", ipfp),
            dataType: "html",
            success: function (resp_success) {
                let modal = resp_success;
                $(modal)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#mod_colores"), });
                        numColores = document.getElementById("mi_contador").value;
                        if (numColores >= 2) {
                            for (let i = 0; i < numColores; i++) {
                                agregarEscuchaEliminarInputColor(`color_otro_${numColores}`, `color_otro_div_${numColores}`);
                            }
                        }
                    })
                    .on("hidden.bs.modal", function () { $(this).remove(); e_modal_color = false; });
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    });

    $(document).on("click", "#btn_agregar_colores", function (e) {
        e.preventDefault();
        guardarFichaProducto('', 'colores', '');
    });

    $(document).on("click", "#btn_agregar_input_color", function (e) {
        e.preventDefault();
        agregarInputColor();
    });

    function agregarInputColor(valor = "") {
        let contenido = `<div id="color_otro_div_${numColores}" class="form-inline" style='margin-top: 5px'>
                        <label for="color_" class="ml-2">Color</label>
                        <input type="text" class="form-control ml-3" id="color_[]" name="color_[]" placeholder="Inserte nombre del color" require value='${valor}'>
                        <button type="button" class="close ml-1" data-dismiss="alert" aria-label="Close" id="color_otro_${numColores}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;

        $("#color_todos").append($(contenido));
        agregarEscuchaEliminarInputColor(`color_otro_${numColores}`, `color_otro_div_${numColores}`);
        numColores++;
    }

    function agregarEscuchaEliminarInputColor(btn, div) {
        $(document).on("click", `#${btn}`, function (e) {
            e.preventDefault();
            quitarInputColor(div);
        });
    }

    function quitarInputColor(div) {
        let element = document.getElementById(div);
        if (typeof element != "undefined" && element != null) element.remove();
    }

    $(document).on("click", "#btn_modal_agregar_dimensiones", function (e) {
        e.preventDefault();
        if (e_modal_dim) return false;
        e_modal_dim = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("proveedor_fp.m_dimensiones", ipfp),
            dataType: "html",
            success: function (resp_success) {
                var modal = resp_success;
                $(modal)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#modal_dimensiones"), });
                    })
                    .on("hidden.bs.modal", function () { $(this).remove(); e_modal_dim = false; });
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    });

    $(document).on("click", "#btn_guardar_dimensiones", function (e) {
        e.preventDefault();
        guardarFichaProducto('', 'dimensiones', '');
    });

    $(document).on("click", "#btn_guardar_caracteristicas", function (e) {
        e.preventDefault();
        guardarFichaProducto('', 'caracteristicas', '');
    });

    $(document).on("click", "#btn_guardar_entrega", function (e) {
        e.preventDefault();
        guardarFichaProducto('', 'entrega', '');
    });

    $(document).on("click", "#btn_guardar_precio", function (e) {
        e.preventDefault();
        guardarFichaProducto('', 'precio', '');
    });

    $(document).on("change", "#prueba", function (e) {
        e.preventDefault();

        if (this.files.length <= 0) return; // si no hay archivos, regresamos

        if (estatusValidacionTec) {
            Swal.fire("No se puede continuar!", "Solo tienes permitido subir 1 validación técnica.", "warning");
        } else {
            if (this.files[0].size > 30000000) {
                document.getElementById(this.id).value = ""; // Limpiar
                Swal.fire("Documento demasiado grande", `El tamaño máximo aceptable es de: 30 MB`, "error");
            } else guardarFichaProducto(new FormData($("#frm_validacion_tec").get(0)), "validacion_tec", "");
        }
    });

    $(document).on("click", "#btn_revisar", function (e) {
        e.preventDefault();
        if (estatusProducto && estatusFichaTec && estatusCaracteristicas && estatusEntrega && estatusPrecio && comprobarEstatusArrayFotos() >= 1) {
            if (validacionTecDisponible) {
                if (estatusValidacionTec) {
                    window.location = route("proveedor_fp.show", ipfp);
                } else {
                    Swal.fire("No se puede continuar!", "Es necesario que llene los campos requeridos de las secciones", "warning");
                }
            } else {
                window.location = route("proveedor_fp.show", ipfp);
            }
        } else {
            Swal.fire("No se puede continuar!", "Es necesario que llene los campos requeridos de las secciones", "warning");
        }
    });
    //===============================================================
    //              Guardado para la ficha de productos
    //===============================================================
    let guardando = false;
    function guardarFichaProducto(formulario = "", emisor, quienClic = "") {
        if (guardando) return false;
        guardando = true;

        if (!estatusInicio) return false;

        let formData = formulario, darClic = quienClic;
        switch (emisor) {
            case 'producto':
                if (comprobarEstatusArrayFotos() >= 1) {
                    formData = new FormData($("#frm_producto").get(0));
                    let comparador = '(ESTO_ES_UNA_COPIA)';
                    if ((formData.get('p_nombre_producto').split(' ')[0]).toUpperCase() == comparador || (formData.get('p_descripcion_producto').split(' ')[0]).toUpperCase() == comparador) {
                        Swal.fire("Campos con nombre copia!", "Le invitamos a que quite las copias en el nombre y descripción de su producto.", "warning");
                        guardando = false;
                        return false
                    }
                    darClic = "ficha_tec";
                } else {
                    Swal.fire("No se puede continuar!", "Es necesario que por lo menos agregues 1 foto antes de continuar.", "warning");
                    guardando = false;
                    return false;
                }
                break;
            case 'caracteristicas':
                if (estatusColores) {
                    formData = new FormData($("#frm_caracteristicas").get(0));
                    darClic = "entrega";
                } else {
                    Swal.fire("No se puede continuar!", "Define el <b>color o los colores</b> de tu producto por favor.", "error");
                    guardando = false;
                    return false;
                }
                break;
            case 'colores':
                formData = new FormData($("#frm_colores").get(0));
                break;
            case "dimensiones":
                formData = new FormData($("#frm_dimensiones").get(0));
                break;
            case "entrega":
                formData = new FormData($("#frm_tiempo_entrega").get(0)); darClic = "precio";
                break;
            case "precio":
                if (estatusInicio && estatusProducto && estatusFichaTec && estatusCaracteristicas && estatusEntrega && comprobarEstatusArrayFotos() >= 1) {
                    formData = new FormData($("#frm_precio").get(0));
                    darClic = "validacion_tec";
                } else {
                    Swal.fire("Faltan secciones por completar!", `Para poder GUARDAR y REVISAR es necesario que llene los campos requeridos de las demás secciones.`, "error");
                    guardando = false;
                    return false;
                }
                break;
        }

        formData.append("emisor", emisor);
        formData.append("accion", '');
        formData.append("_method", "PUT");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("proveedor_fp.update", ipfp),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    let mensaje = "<ul>";
                    $.each(respuesta.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";
                    Swal.fire({ title: "Existen campos faltantes", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    switch (emisor) {
                        case 'foto':
                            pintarFoto(formData.get("campo"), URL.createObjectURL(formData.get(formData.get("campo"))));
                            estatusFoto[retornarIndiceArrayFoto(formData.get("campo"))] = true;
                            if (estatusProducto && comprobarEstatusArrayFotos() >= 1) {
                                establecerColorNav("producto");
                                flechaProducto.classList.add('bac-green');
                            }
                            break;
                        case "producto":
                            estatusProducto = true;
                            establecerColorNav(emisor);
                            flechaProducto.classList.add('bac-green');
                            break;
                        case "ficha_tec":
                            estatusAFT = estatusFichaTec = true;
                            pintarFichaTec(respuesta.doc_ficha_tecnica);
                            document.getElementById("doc_ficha_tecnica").disabled = true;
                            establecerColorNav(emisor);
                            flechaFichaTec.classList.add('bac-green');
                            break;
                        case "doc_adicional":
                            estatusOtroDoc[darClic] = true;//darClic equivale a un número
                            recorrerArrayOtrosDoc();
                            pintarOtroDoc(respuesta.doc_adicional, formData.get("tipo_doc_adicional"));
                            break;
                        case "colores":
                            $("#mod_colores")
                                .modal("hide")
                                .on("hidden.bs.modal", function () { estatusColores = true; numColores = 0; e_modal_color = false; });
                            break;
                        case "dimensiones":
                            $("#modal_dimensiones")
                                .modal("hide")
                                .on("hidden.bs.modal", function () { estatusDimensiones = true; e_modal_dim = false; });
                            break;
                        case "caracteristicas":
                            estatusCaracteristicas = true;
                            establecerColorNav(emisor);
                            flechaCaracteristicas.classList.add('bac-green');
                            break;
                        case "entrega":
                            estatusEntrega = true;
                            establecerColorNav(emisor)
                            flechaEntrega.classList.add('bac-green');
                            break;
                        case "precio":
                            estatusPrecio = true;
                            establecerColorNav(emisor);
                            flechaPrecio.classList.add('bac-green');
                            if (!validacionTecDisponible) {
                                abrirShow(ipfp);
                                darClic = "";
                            }
                            break;
                        case "validacion_tec":
                            estatusValidacionTec = true;
                            establecerColorNav(emisor);
                            flechaValidacionTec.classList.add('bac-green');
                            document.getElementById("prueba").disabled = true;
                            pintarValidacionTec(respuesta.doc_validacion_tec);
                            break;
                    }

                    clickOpcionNav(darClic);
                    Swal.fire("Proceso correcto!", respuesta.message, "success");
                }
                guardando = false;
            },
            error: function (xhr) { Swal.fire("¡Alerta!", xhr, "warning"); },
        });
    }

    function eliminarDeFichaProducto(formData) {
        formData.append("accion", "eliminar");
        formData.append("_method", "PUT");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: route("proveedor_fp.update", ipfp),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    Swal.fire("¡Alerta!", response.message, "warning");
                } else {
                    switch (formData.get("emisor")) {
                        case "ficha_tec":
                            pintarFichaTec("");
                            document.getElementById("doc_ficha_tecnica").disabled = estatusFichaTec = estatusAFT = false;
                            flechaFichaTec.classList.remove('bac-green');
                            quitarColorNav(formData.get("emisor"));
                            break;
                        case "doc_adicional":
                            let indice = null;
                            switch (formData.get("el_eliminado")) {
                                case "doc_adicional_uno": indice = 0; break;
                                case "doc_adicional_dos": indice = 1; break;
                                case "doc_adicional_tres": indice = 2; break;
                            }
                            estatusOtroDoc[indice] = false;
                            recorrerArrayOtrosDoc();
                            pintarOtroDoc("", formData.get("el_eliminado"));
                            break;
                        case "validacion_tec":
                            pintarValidacionTec("");
                            document.getElementById("prueba").disabled = estatusValidacionTec = false;
                            flechaValidacionTec.classList.remove('bac-green');
                            quitarColorNav(formData.get("emisor"));
                            break;
                    }
                    Swal.fire("Proceso correcto!", response.message, "success");
                }
            },
        });
    }

    //===============================================================
    //                  Zona de funciones
    //===============================================================
    function clickOpcionNav(opcion) {
        $("#v_pills_" + opcion + "_tab").tab("show");
    }

    function establecerColorNav(opcion) {
        document.querySelector("#v_pills_" + opcion + "_tab").classList.add('nav-verde');
    }

    function quitarColorNav(opcion) {
        document.querySelector("#v_pills_" + opcion + "_tab").classList.remove('nav-verde');
    }

    function recorrerArrayOtrosDoc() {
        let cuenta = 0;
        for (let i = 0; i < estatusOtroDoc.length; i++) {
            if(estatusOtroDoc[i]) cuenta++;
        }
        document.getElementById("el_doc_adicional").disabled = (cuenta == 3) ? true : false;
    }

    function abrirShow(quien) {
        window.location = route("proveedor_fp.show", quien);
    }

    //-------------------------------------------------------------------------------
    // INICIO: Trabajando con las fotos del producto
    //-------------------------------------------------------------------------------
    $(".foto_click").on("click", function (e) { document.getElementById(this.getAttribute("name")).click(); });

    $(document).on("change", ".input_foto", function (e) {
        e.preventDefault();
        if (this.files.length <= 0) return; // si no hay archivos, regresamos

        let miInput = document.getElementById(this.id); // Obtener referencia al elemento
        let archivo = this.files[0]; // Validamos el primer archivo únicamente

        if (archivo.size > 1000000) {
            miInput.value = ""; // Limpiar
            Swal.fire("Foto demasiado grande", `El tamaño máximo aceptable es de: 1 MB`, "error");
        } else guardarFoto(this.id, this.files[0]);
    });

    function guardarFoto(campo, foto) {
        let formData = new FormData();
        formData.append("campo", campo);
        formData.append(campo, foto);

        guardarFichaProducto(formData, "foto", "ninguna");
    }

    function pintarFoto(nInputFoto, rutaFoto) {
        if (rutaFoto != "") {
            let imagen = document.getElementById(nInputFoto + "_imagen");
            imagen.setAttribute("src", rutaFoto);
            imagen.style.width = "80px";
            imagen.style.height = "80px";
        }
    }

    function comprobarEliminarFoto(laFoto) {
        let fullPath = document.getElementById(laFoto + "_imagen").src;
        let filename = fullPath.replace(/^.*[\\\/]/, '');

        if (filename != "bac_imag_fondo.svg") {
            let formData = new FormData();
            formData.append("emisor", "foto");
            formData.append("la_foto", laFoto);
            if (!eliminarDeFichaProducto(formData)) {
                estatusFoto[retornarIndiceArrayFoto(laFoto)] = false;
                pintarFoto(laFoto, url + "asset/img/bac_imag_fondo.svg");
                if (comprobarEstatusArrayFotos() == 0) {
                    flechaProducto.classList.remove('bac-green');
                    quitarColorNav('producto');
                }
            }
        }
    }

    function comprobarEstatusFotos(laFoto) {
        let fullPath = document.getElementById(laFoto + "_imagen").src;
        let filename = fullPath.replace(/^.*[\\\/]/, '');
        if (filename != "bac_imag_fondo.svg") estatusFoto[retornarIndiceArrayFoto(laFoto)] = true;
    }

    function retornarIndiceArrayFoto(campo) {
        switch (campo) {
            case 'foto_uno': return 0;
            case 'foto_dos': return 1;
            case 'foto_tres': return 2;
            case 'foto_cuatro': return 3;
            case 'foto_cinco': return 4;
            case 'foto_seis': return 5;
        }
    }

    function comprobarEstatusArrayFotos() {
        let cuantos = 0;
        for (let i = 0; i < estatusFoto.length; i++) {
            (estatusFoto[i]) ? cuantos++ : "";
        }
        return cuantos;
    }
    //-------------------------------------------------------------------------------
    // FIN: Trabajando con las fotos del producto ^^^^^^^^^^^^
    //-------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------
    // INICIO: Trabajando con archivos: Ficha Tecnica, Otros Documentos, Validación Tecnica
    //-------------------------------------------------------------------------------
    function pintarFichaTec(archivo) {
        pintar("doc_ficha_tecnica", "#pintar_ficha_tec", archivo, 'ficha_tec');
    }

    function pintarOtroDoc(archivo, receptor) {
        pintar("el_doc_adicional", "#" + receptor + "_div", archivo, receptor);
    }

    function pintarValidacionTec(archivo) {
        pintar("prueba", "#pintar_validacion_tec", archivo, "validacion_tec");
    }

    function pintar(elFile, elDiv, archivo, receptor) {
        let contenido = "";
        archivo = archivo.substring(18, archivo.length);//Formateando el nombre del archivo con el fin de solo dejar el nombre original del arhcivo que subio el proveedor

        if (archivo != "") {
            contenido = `<div class="col-6 d-flex justify-content-start" id="${receptor}">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="btn_eliminar_archivo_${receptor}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p class="text-1 ml-3">${archivo}</p>
                        </div>`;
        }

        document.getElementById(elFile).value = "";
        document.querySelector(elDiv).innerHTML = contenido;

        generarEscuchaBotonEliminar(receptor);
    }

    function generarEscuchaBotonEliminar(elReceptor) {
        $(document).on("click", `#btn_eliminar_archivo_${elReceptor}`, function (e) {
            e.preventDefault();
            preguntarEliminar(elReceptor);
        });
    }

    //Función para eliminar archivos subidos
    function preguntarEliminar(quien) {
        let titulo = "¿Está seguro?",
            texto = "¿Desea eliminar el documento?";

        Swal.fire({
            title: titulo, text: texto, icon: "warning", showCancelButton: true, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Si", cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();

                if (quien == "ficha_tec") {
                    formData.append("emisor", "ficha_tec");
                } else if (quien == "validacion_tec") {
                    formData.append("emisor", "validacion_tec");
                } else if (quien == "doc_adicional_uno" || quien == "doc_adicional_dos" || quien == "doc_adicional_tres") {
                    formData.append("emisor", "doc_adicional");
                    formData.append("el_eliminado", quien); //QUien = doc_adicional_uno
                }

                eliminarDeFichaProducto(formData);
            }
        });
    }

})();
