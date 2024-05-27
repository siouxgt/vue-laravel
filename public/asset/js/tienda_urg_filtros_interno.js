function addFavoritos(iconoFavorito, inputFavorito, idProducto) {
    iconoFavorito = document.querySelector('#' + iconoFavorito);
    let aceptarClicFav = false,
        estadoFav = $('#' + inputFavorito).val() != "" ? true : false,
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
            iconoFavorito.classList.remove('fa-regular');
            iconoFavorito.classList.add('fa-solid');
            console.log("Agregar")
        } else {
            iconoFavorito.classList.remove('fa-solid');
            iconoFavorito.classList.add('fa-regular');
            console.log("Quitar")
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    let nombreCm = '';
    const filtroGeneral = { "cm": '', "cabms": '', "precio": '', "tamanio": '', "entrega": '', "temporalidad": '', "orden": '', "buscado": '', "empresa": '', 'requisicion': '', 'favoritos': '' };
    const filtroTamanioEntrega = { "cm": '', "cabms": '', "precio": '', "tamanio": '', "entrega": '', "temporalidad": '', "orden": '', "empresa": '', "buscado": '', 'requisicion': '', 'favoritos': '' };

    (function () {
        filtroGeneral['orden'] = 'todos';
        establecerFiltrarPor("empresa");
        establecerFiltrarPor("favoritos");
        establecerFiltrarPor("cm");
        cargarFiltradores();

        let buscador = document.getElementById("buscador");
        let timeout;

        buscador.addEventListener('keydown', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                datoBuscado = document.getElementById("buscador").value;
                vaciarOrden();//orden = ''
                busqueda(datoBuscado);
                clearTimeout(timeout);
            }, 500)
        });

        function establecerFiltrarPor(quien) {
            let filtro = localStorage.getItem(quien);
            if (filtro != null) {
                vaciarOrden();
                filtroGeneral[quien] = filtro;
            }

            localStorage.removeItem(quien);
        }
    })();

    (function () {
        const btnCabms = document.querySelector("#btn_cabms");
        let activo = false;

        btnCabms.addEventListener("click", (e) => {
            abrirModalFiltroCabms();
        });

        function abrirModalFiltroCabms() {
            if (activo) { return false; }
            activo = true;

            filtroGeneral['cabms'] = (filtroGeneral['cabms'] != "" ? filtroGeneral['cabms'] : 0);
            filtroGeneral['cm'] = (filtroGeneral['cm'] != "" ? filtroGeneral['cm'] : 0);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: route("tienda_urg.abrir_mcabms", { filtro: JSON.stringify(filtroGeneral) }),
                dataType: "html",
                success: function (resp_success) {
                    $(resp_success).modal().on("shown.bs.modal", function () {
                            $("[class='make-switch']").bootstrapSwitch("animate", true);
                            $(".select2").select2({dropdownParent: $("#modal_productos_cm")});
                        })
                        .on("hidden.bs.modal", function () {
                            filtroGeneral['cabms'] = (filtroGeneral['cabms'] != "" ? filtroGeneral['cabms'] : '');
                            filtroGeneral['cm'] = (filtroGeneral['cm'] != "" ? filtroGeneral['cm'] : '');
                            $(this).remove();
                            activo = false;
                        });
                },
                error: function (respuesta) {
                    Swal.fire('¡Alerta!', xhr, 'warning');
                },
            });
        }
    })();

    function filtrarPorContratosM(idCM, cm) {
        filtroGeneral['cm'] = idCM;
        nombreCm = cm;
        vaciarOrden();
        cargarFiltradores();
    }

    function refrescarArrayFiltroTamaniosEntrega() {
        for (let clave in filtroGeneral) {
            filtroTamanioEntrega[clave] = filtroGeneral[clave];
        }
    }

    function cargarFiltradores() {
        refrescarArrayFiltroTamaniosEntrega();
        cargarFiltroTamaniosTiempo();
        cargarProductos();
    }

    function cargarFiltroTamaniosTiempo() {//Función que permite cargar los elementos para filtro: tamaño
        $.ajax({
            type: "GET",
            url: route("tienda_urg.cargar_filtro_tamanios_tiempo", JSON.stringify(filtroTamanioEntrega)),
            success: function (datos) {

                let tiempos = datos.temporalidad,
                    contenidoTamanio = ``,
                    contenidoTiempoEntrega = ``;

                contenidoTamanio += `<form id="frm_tamanios">`;
                contenidoTamanio += datos.contenido_tamanio;
                contenidoTamanio += '</form>';
                document.querySelector("#filtroTamanios").innerHTML = contenidoTamanio;

                $('#frm_tamanios input').on('change', function () {
                    filtrarPorTamanio($('input[name=radio_tamanio]:checked', '#frm_tamanios').val());
                });

                contenidoTiempoEntrega += `<form id="frm_tiempo_entrega">`;
                contenidoTiempoEntrega += datos.contenido_tiempo_entrega;
                contenidoTiempoEntrega += '</form>';
                document.querySelector("#filtroTiempo").innerHTML = contenidoTiempoEntrega;

                $('#frm_tiempo_entrega input').on('change', function () {
                    let enviarTemporalidad = tiempos[$('input[name=radio_tiempo_entrega]:checked', '#frm_tiempo_entrega')[0].id];
                    filtrarPorTiempoEntrega($('input[name=radio_tiempo_entrega]:checked', '#frm_tiempo_entrega').val(), enviarTemporalidad);
                });
            },
        });
    }

    $(document).on("click", "#filtrarPorCabms", function (e) {//Botón ubicado en modal para filtros por cabms
        e.preventDefault();

        let formData = new FormData($("#frm_filtros_cabms").get(0));
        filtrarPorCabms(formData.get('cabms'));
    });

    function filtrarPorCabms(elCambs) {
        filtroGeneral['cm'] = (filtroGeneral['cm'] != "" ? filtroGeneral['cm'] : '');
        filtroGeneral['cabms'] = elCambs;
        vaciarOrden();
        cargarFiltradores();
    }

    function filtrarPorTamanio(elTamanio) {
        filtroGeneral['tamanio'] = elTamanio;
        vaciarOrden();
        cargarProductos();
    }

    function filtrarPorTiempoEntrega(elTiempo, laTempo) {
        filtroGeneral['entrega'] = elTiempo;
        filtroGeneral['temporalidad'] = laTempo;
        vaciarOrden();
        cargarProductos();
    }

    function ordenarPor(tipoOrden) {
        console.log(tipoOrden);//=[.
        if (tipoOrden == 'todos') {
            vaciarFiltroGeneral();
            filtroGeneral['orden'] = tipoOrden;
            cargarFiltradores();
        } else {
            filtroGeneral['orden'] = tipoOrden;
            cargarProductos();
        }
    }

    function vaciarFiltroGeneral() {
        for (let clave in filtroGeneral) {
            filtroGeneral[clave] = '';
        }

        document.getElementById("buscador").value = "";//Tambien se va a limpiar  el buscador
    }

    function vaciarOrden() {
        if (filtroGeneral['orden'] == 'todos') {
            filtroGeneral['orden'] = '';
        }
    }

    function resetOrdenarPor() {
        document.getElementById("ordenarPor").options.item(0).selected = 'selected';
    }

    function busqueda(elBuscado) {
        filtroGeneral['buscado'] = elBuscado;
        cargarProductos();
    }

    function mayusculaPrimeraLetra(texto) {
        return texto.charAt(0).toUpperCase() + texto.slice(1);
    }

    function cargarProductos() {
        $.ajax({
            type: "GET",
            url: route("tienda_urg.cargar_productos", JSON.stringify(filtroGeneral)),
            success: function (datos) {
                for (let index = 0; index < datos.la_cabms.length; index++) {
                    $(document).on("click", `#${datos.la_cabms[index]}_${index}`, function (e) {
                        e.preventDefault();
                        filtrarPorCabms(datos.la_cabms[index]);
                    });
                }

                let descripcion = '', tituloFiltroActual = '';

                if (filtroGeneral['cm'] != '') {
                    tituloFiltroActual = nombreCm;
                    descripcion += checarDescripcion(descripcion) + "Contrato Marco: " + mayusculaPrimeraLetra(nombreCm.toLowerCase());
                }
                if (filtroGeneral['empresa'] != '') {
                    tituloFiltroActual = filtroGeneral['empresa'];
                    descripcion += checarDescripcion(descripcion) + "Empresa: " + filtroGeneral['empresa'];
                }
                if (filtroGeneral['requisicion'] != '') {
                    tituloFiltroActual = filtroGeneral['requisicion'];
                    descripcion += checarDescripcion(descripcion) + "Requisicion: " + filtroGeneral['requisicion'];
                }
                if (filtroGeneral['favoritos'] != '') {
                    tituloFiltroActual = 'Favoritos';
                    descripcion += checarDescripcion(descripcion) + "Tus favoritos";
                }
                if (filtroGeneral['buscado'] != '') {
                    filtroGeneral['favoritos'] === '' ? tituloFiltroActual = filtroGeneral['buscado'] : '';
                    descripcion += checarDescripcion(descripcion) + "Buscando: " + filtroGeneral['buscado'];
                }

                if (filtroGeneral['tamanio'] != '') {
                    tituloFiltroActual = 'Tamaño';
                    descripcion += checarDescripcion(descripcion) + "Tamaño: " + mayusculaPrimeraLetra(filtroGeneral['tamanio'].toLowerCase());
                }
                if (filtroGeneral['entrega'] != '') {
                    tituloFiltroActual = 'Tiempo de entrega';
                    let temporalidades = ['día(s)', 'semana(s)', 'mes(es)'];
                    descripcion += checarDescripcion(descripcion) + "Tiempo de entrega: " + filtroGeneral['entrega'] + " " + temporalidades[filtroGeneral['temporalidad']];
                }
                if (filtroGeneral['cabms'] != '') {
                    tituloFiltroActual = filtroGeneral['cabms'];
                    descripcion += checarDescripcion(descripcion) + "CABMS: " + filtroGeneral['cabms'];
                }
                if (filtroGeneral['orden'] != '') {
                    switch (filtroGeneral['orden']) {
                        case 'todos':
                            tituloFiltroActual === '' ? tituloFiltroActual = 'Todos' : '';
                            descripcion += checarDescripcion(descripcion) + "Ordenado por: " + 'Todos';
                            break;
                        case 'nuevos':
                            tituloFiltroActual === '' ? tituloFiltroActual = 'Nuevos' : ''
                            descripcion += checarDescripcion(descripcion) + "Ordenado por: " + 'Nuevos';
                            break;
                        case 'bajo':
                            tituloFiltroActual === '' ? tituloFiltroActual = 'Precio más bajo' : '';
                            descripcion += checarDescripcion(descripcion) + "Ordenado por: " + 'Precio más bajo';
                            break;
                        case 'alto':
                            tituloFiltroActual === '' ? tituloFiltroActual = 'Precio más alto' : '';
                            descripcion += checarDescripcion(descripcion) + "Ordenado por: " + 'Precio más alto';
                            break;
                    }
                }

                if (tituloFiltroActual === '' && descripcion === '') {
                    tituloFiltroActual = 'Todos';
                    descripcion = 'Ordenado por: Todos';
                }

                function checarDescripcion(desc) {
                    if (desc === '') { return ''; } else { return ', '; }
                }

                document.getElementById("total_resultados").innerHTML = datos.total_resultados + " resultados";
                document.getElementById("producto_mostrado").innerHTML = tituloFiltroActual.toUpperCase();
                document.getElementById("producto_mostrado_lista").innerHTML = descripcion + ".";
                document.getElementById("divProductos").innerHTML = datos.contenido;
            }
        });
    }

    function requisicion(bienes) {
        filtroGeneral['requisicion'] = bienes;
        filtroTamanioEntrega['requisicion'] = bienes;
        vaciarOrden();
        cargarFiltradores();
    }

    $(document).ready(function () {
        $('#btn_quitar_filtros').click(function () {
            ordenarPor($(this).val());
            resetOrdenarPor();
        });

        $('#ordenarPor').change(function () {
            ordenarPor($(this).val())
        });

        let bienes = document.querySelector('#bienes');
        if (bienes.value !== '') {
            if (bienes.value != '[]') {
                requisicion(bienes.value);
            }
        }
    });

});