$(document).ready(function () {
    let mensaje = document.querySelector('#mensaje');
    if (mensaje.value) Swal.fire("error", `${mensaje.value}`, "error");
});

document.addEventListener("DOMContentLoaded", () => {
    const cantidadReq = document.getElementById("cantidad_req").value, cantidadElementos = document.getElementById("cantidad_elementos").value;
    const cantidadProductoSeleccionado = [], existencia = [], precioUnitario = [], productosSeleccionados = [];
    const arrayNombreProveedores = [], arrayNombresRequisiciones = [], arrayIdProductos = [];

    let arrayRequisicionesSeleccionadas = [], arrayProveedoresDeCheckProducto = [];
    let sumaSubTotalProveedor = [], sumaIvaTotalProvedor = [];

    setTimeout(function () {//Desplegar el primer collapse despues de 1 segundos
        $('#collapseExample_0').collapse();
    }, 500);

    $("input[name='nombre_proveedor']").each(function (indice, elemento) {
        sumaSubTotalProveedor[indice] = 0;
        sumaIvaTotalProvedor[indice] = 0;
        arrayNombreProveedores[indice] = $(elemento).val();
    });

    for (let c = 0; c < cantidadElementos; c++) {
        let idProducto = document.getElementById("id_de_producto_" + c).value,
            inputCantidadProducto = document.getElementById("cantidad_producto_" + c);
        cantidadProductoSeleccionado[c] = parseInt(inputCantidadProducto.value);
        existencia[c] = parseInt(document.getElementById("existencia_" + c).value);
        precioUnitario[c] = parseInt(document.getElementById("precio_unitario_" + c).value);
        productosSeleccionados[c] = false;
        arrayIdProductos[c] = idProducto;

        $(document).on("click", `#btn_eliminar_${c}`, function (e) {
            e.preventDefault();
            preguntarEliminar(idProducto, c);
        });

        $(document).on("click", `#btn_menos_${c}`, function (e) {
            e.preventDefault();
            quitarProducto(inputCantidadProducto, c);
        });

        $(document).on("click", `#btn_mas_${c}`, function (e) {
            e.preventDefault();
            agregarProducto(inputCantidadProducto, c);
        });

        document.getElementById("cantidad_producto_" + c).addEventListener('keyup', e => {
            let txtCantidadProducto = $('#cantidad_producto_' + c).val();
            if (txtCantidadProducto == "") {//Si el campo esta vacio, entonces esperar un par de segundos (Tal vez la URG escribira un valor diferente)
                setTimeout(function () {
                    realizarOperacion(txtCantidadProducto, c);
                }, 2000);
            } else realizarOperacion(txtCantidadProducto, c);
        });
    }

    function realizarOperacion(txtCantidadProducto, indice) {
        if (!isNaN(txtCantidadProducto)) {
            let cantidadReciente = parseInt(txtCantidadProducto);
            if (cantidadReciente >= 1 && cantidadReciente <= existencia[indice]) {
                cantidadProductoSeleccionado[indice] = cantidadReciente;
            } else {
                $('#cantidad_producto_' + indice).val(cantidadProductoSeleccionado[indice]);
                if (cantidadReciente > existencia[indice])
                    Swal.fire("Cantidad fuera de stock!", "La cantidad que intentas ingresar rebasa el stock disponible!", "warning");
            }
            desglosarPrecio();
        } else $('#cantidad_producto_' + indice).val(cantidadProductoSeleccionado[indice]);
    }

    function agregarProducto(inputCantidadProducto, posicion) {
        if (cantidadProductoSeleccionado[posicion] >= 1 && cantidadProductoSeleccionado[posicion] < existencia[posicion]) {
            cantidadProductoSeleccionado[posicion] = cantidadProductoSeleccionado[posicion] + 1;
            desglosarPrecio();
        }
        inputCantidadProducto.value = cantidadProductoSeleccionado[posicion];
    }

    function quitarProducto(inputCantidadProducto, posicion) {
        if (cantidadProductoSeleccionado[posicion] >= 2) {
            cantidadProductoSeleccionado[posicion] = cantidadProductoSeleccionado[posicion] - 1;
            desglosarPrecio();
        }
        inputCantidadProducto.value = cantidadProductoSeleccionado[posicion];
    }

    const preguntarEliminar = (idProducto, indice) => {
        let titulo = "¿Está seguro?",
            texto = "¿Desea eliminar el producto del carrito?";

        Swal.fire({
            title: titulo, text: texto, icon: "warning", showCancelButton: true, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Si", cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) eliminarProductoDeCarrito(idProducto, indice);
        });
    }

    const eliminarProductoDeCarrito = (idProducto, indice) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("carrito_compra.destroy", idProducto),
            type: 'DELETE',
            contentType: 'application/json',  // <---add this
            dataType: 'text',                // <---update this
            success: function (result) {
                eliminarDivContenedorProducto(indice);
            },
            error: function (result) { }
        });
    }

    const eliminarDivContenedorProducto = (indice) => {
        establecerCheckSeleccionado("chk_producto_" + indice, false);
        desglosarPrecio();
        let valor = parseInt(document.getElementById("chk_producto_" + indice).value);
        $('#div_contenedor_producto_' + indice).remove();
        let cantidadChecks = comprobarChecksSeleccionados(valor);
        if (cantidadChecks == 0) {
            $('#frm_requisicion_' + valor).remove();
            window.location.href = window.location.href;
        }
    }

    for (let i = 0; i < cantidadReq; i++) {//Checkbox general
        document.getElementById("check_" + i).addEventListener("click", (e) => {
            document.getElementById('check_' + i).checked ? checkAll(i) : uncheckAll(i);
            desglosarPrecio();
        });

        arrayNombresRequisiciones[i] = document.getElementById("numero_requisicion_" + i).value;
        arrayRequisicionesSeleccionadas[i] = false;
    }

    for (let i = 0; i < cantidadElementos; i++) {//Checkbox por producto
        let indiceProveedor = arrayNombreProveedores.indexOf(document.getElementById("chk_producto_" + i).name);
        arrayProveedoresDeCheckProducto[i] = indiceProveedor;

        document.getElementById("chk_producto_" + i).addEventListener("change", (e) => {
            establecerCheckSeleccionado("chk_producto_" + i, (document.getElementById("chk_producto_" + i).checked));
            desglosarPrecio();
            comprobarChecksSeleccionados(parseInt(document.getElementById("chk_producto_" + i).value));
        });
    }

    function desglosarPrecio() {
        let sumaSubTotal = 0, sumaIvaTotal = 0, sumaTotal = 0, guardaIndice = -1, verificador = false, contenedorDesgloce = ``;

        for (let j = 0; j < sumaSubTotalProveedor.length; j++) {
            sumaSubTotalProveedor[j] = 0;
            sumaIvaTotalProvedor[j] = 0;
        }

        for (let i = 0; i < productosSeleccionados.length; i++) {
            if (productosSeleccionados[i]) {//Si el producto está seleccionado (el check está seleccionado), entonces se obtiene el precio del producto
                let indice = arrayProveedoresDeCheckProducto[i];

                if (guardaIndice == -1) guardaIndice = indice;
                if (indice != guardaIndice) { sumaSubTotal = 0; guardaIndice = indice; }

                sumaSubTotal += (cantidadProductoSeleccionado[i] * precioUnitario[i]);
                sumaSubTotalProveedor[indice] = sumaSubTotal;
                sumaIvaTotal = (sumaSubTotalProveedor[indice] * .16);
                sumaIvaTotalProvedor[indice] = sumaIvaTotal;
            }
        }

        sumaSubTotal = sumaIvaTotal = sumaTotal = 0;

        for (let j = 0; j < arrayNombreProveedores.length; j++) {
            if (sumaSubTotalProveedor[j] != 0) {
                verificador = true;

                if (j != 0 || j == arrayNombreProveedores.length - 1) contenedorDesgloce += '<hr>';

                contenedorDesgloce += `<li class="list-group-item bg-white mt-1">
                                        <p class="text-2 font-weight-bold">${arrayNombreProveedores[j].slice(6, arrayNombreProveedores[j].length)}</p>
                                       </li>`;
                contenedorDesgloce += `<li class="list-group-item bg-white">
                                        <p class="text-1 float-right">Subtotal: <span class="font-weight-bold">${formatearNumero(sumaSubTotalProveedor[j])}</span></p>
                                       </li>`;
                contenedorDesgloce += `<li class="list-group-item bg-white">
                                        <p class="text-1 float-right">I.V.A. al 16%: <span class="font-weight-bold">${formatearNumero(sumaIvaTotalProvedor[j])}</span></p>
                                       </li>`;
                contenedorDesgloce += `<li class="list-group-item bg-white">
                                        <p class="text-1 float-right">Total por proveedor: <span class="font-weight-bold">${formatearNumero((sumaSubTotalProveedor[j] + sumaIvaTotalProvedor[j]))}</span></p>
                                       </li>`;

                sumaSubTotal += sumaSubTotalProveedor[j];
                sumaIvaTotal += sumaIvaTotalProvedor[j];
                sumaTotal += (sumaSubTotalProveedor[j] + sumaIvaTotalProvedor[j]);
            }
        }

        let contenedorDesgloceFinal = ``;

        if (verificador) {
            contenedorDesgloce += `<span class="border-bottom"></span>
                                    <li class="list-group-item bg-light border-bottom">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 col-sm-6">
                                                <p class="text-1 font-weight-bold">Subtotal:</p>
                                            </div>
                                            <div class="col-md-8 col-lg-8 col-sm-6 float-right">
                                                <p class="text-1 text-right font-weight-bold ml-5">${formatearNumero(sumaSubTotal)}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-3 ">
                                            <div class="col-md-4 col-lg-4 col-sm-6">
                                                <p class="text-1 font-weight-bold">16% I.V.A.</p>
                                            </div>
                                            <div class="col-md-8 col-lg-8 col-sm-6 float-right">
                                                <p class="text-1 text-right font-weight-bold ml-5">${formatearNumero(sumaIvaTotal)}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-lg-4 col-sm-6">
                                                <p class="text-1 font-weight-bold">TOTAL</p>
                                            </div>
                                            <div class="col-md-8 col-lg-8 col-sm-6 float-right">
                                                <p class="text-rojo text-right font-weight-bold ml-5">${formatearNumero(sumaTotal)}</p>
                                            </div>
                                        </div>
                                    </li>`;
            contenedorDesgloce += `<ul>`;
            contenedorDesgloceFinal = `<ul class="list-group list-group-flush bg-white border-bottom">`;
            contenedorDesgloceFinal += contenedorDesgloce;
        }
        document.querySelector("#div_desgloce_precios").innerHTML = contenedorDesgloceFinal;
    }

    function formatearNumero(valor) {
        return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(valor);
    }

    function checkAll(numeroFormulario) {
        document.querySelectorAll("#frm_requisicion_" + numeroFormulario + " input[type=checkbox]").forEach(function (checkElement, index) {
            establecerCheckSeleccionado(checkElement.id, true);
            checkElement.checked = true;
        });
        establecerRequisicionesSeleccionadas(numeroFormulario, true);
    }

    function uncheckAll(numeroFormulario) {
        document.querySelectorAll('#frm_requisicion_' + numeroFormulario + ' input[type=checkbox]').forEach(function (checkElement) {
            establecerCheckSeleccionado(checkElement.id, false);
            checkElement.checked = false;
        });
        establecerRequisicionesSeleccionadas(numeroFormulario, false);
    }

    function comprobarChecksSeleccionados(numeroFormulario) {
        let cantidadChecksSeleccionados = 0, totalChecks = 0, checkPadre;
        document.querySelectorAll('#frm_requisicion_' + numeroFormulario + ' input[type=checkbox]').forEach(function (checkElement) {
            if (checkElement.id != ('check_' + numeroFormulario)) {
                totalChecks++;
                if (checkElement.checked)
                    cantidadChecksSeleccionados++;
            } else checkPadre = ('check_' + numeroFormulario);
        });

        document.querySelector("#" + checkPadre).checked = (totalChecks == cantidadChecksSeleccionados) ? true : false;
        establecerRequisicionesSeleccionadas(numeroFormulario, (cantidadChecksSeleccionados == 0) ? false : true);
        return totalChecks;
    }

    function establecerCheckSeleccionado(elemento, status) {
        let indice = elemento.split('_')[2];
        productosSeleccionados[indice] = status;
    }

    const establecerRequisicionesSeleccionadas = (indice, status) => arrayRequisicionesSeleccionadas[indice] = status;

    const btnSeguirComprando = document.getElementById("btn_seguir_comprando");
    btnSeguirComprando.addEventListener("click", (e) => {
        window.location = route("tienda_urg.ver_tienda");
    });

    const btnComprar = document.getElementById("btn_comprar");
    btnComprar.addEventListener("click", (e) => {
        let totalRequisicionesSeleccionadas = 0;
        let mensaje, titulo, icono, lasRequisiciones = '';

        arrayRequisicionesSeleccionadas.forEach((element, index) => {
            if (element) {
                lasRequisiciones += "<li>";
                lasRequisiciones += "<strong>ID REQUISICIÓN: " + arrayNombresRequisiciones[index] + "</strong>";
                lasRequisiciones += "</li>";
                totalRequisicionesSeleccionadas++;
            }
        });


        if (totalRequisicionesSeleccionadas == 1) {
            actualizarCarrito();
            return true;
        } else if (totalRequisicionesSeleccionadas == 0) {
            Swal.fire("No se puede continuar!", 'Para poder continuar procede a seleccionar productos de <strong>una sola requisición</strong>.', "error");
            return true;
        } else {
            titulo = "No se puede continuar!";
            icono = "error";
            mensaje = "<br>Has seleccionado productos en " + totalRequisicionesSeleccionadas + " requisiciones:";
            mensaje += "<ul>";
            mensaje += lasRequisiciones;
            mensaje += "</ul>";
            mensaje += "<br>Para poder continuar procede a seleccionar productos de <strong>una sola requisición</strong>.";
        }

        Swal.fire({ title: titulo, icon: icono, html: mensaje, confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
    });

    const actualizarCarrito = () => {
        let formulario = document.getElementById('frm_requisicion');
        let productos = document.querySelector('#productos');
        let arrayDatos = [];
        let cont = 0;

        for (let i = 0; i < productosSeleccionados.length; i++) {
            if (productosSeleccionados[i]) {
                arrayDatos[cont] = {
                    'id_producto': arrayIdProductos[i],
                    'cantidad_producto_seleccionado': cantidadProductoSeleccionado[i],
                }
                cont++;
            }
        }
        productos.value = JSON.stringify(arrayDatos);
        formulario.submit();
    }
});