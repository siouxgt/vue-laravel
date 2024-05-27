document.addEventListener("DOMContentLoaded", () => {
    const cantidadElementos = document.getElementById("cantidad_elementos").value;
    const arrayIdProductos = [];

    for (let c = 0; c < cantidadElementos; c++) {
        let idProducto = document.getElementById("id_de_producto_" + c).value;
        arrayIdProductos[c] = idProducto;
    }

    const btnFinalizarCompra = document.getElementById("btn_finalizar_compra");
    btnFinalizarCompra.addEventListener("click", (e) => {

        chkConfirmacion = document.getElementById("chk_confirmacion");

        if (!comprobarFormularioInformacionEntrega()) {
            if (chkConfirmacion.checked) {
                preguntarFinalizarCompra();
            } else {
                Swal.fire("No se puede continuar!", 'Es necesario que aceptes los términos y condiciones de compra.', "error");
            }
        } else {
            Swal.fire({
                title: "No se puede continuar!",
                icon: "error",
                html: warnings,
                width: '600px'
            });
            //            Swal.fire("Proporciona correctamente la información para la entrega!", warnings, "error");
        }
    });

    let warnings = '';
    function comprobarFormularioInformacionEntrega() {
        const expresiones = {
            nombre: /^[a-zA-ZÀ-ÿ\s]{3,40}$/, // Letras y espacios, pueden llevar acentos.
            correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
            telefono: /^\d{10}$/,
            extension: /^\d{3}$/,
        }
        let entrar = false;
        warnings = `Proporciona correctamente la información de entrega:<br>`
        warnings += '<br><ul>';

        const direccion = document.getElementById("direccion");
        const responsableAlmacen = document.getElementById("responsable_almacen");
        const telefono = document.getElementById("telefono_almacen");
        const extension = document.getElementById("extension_almacen");
        const correoElectronico = document.getElementById("correo_almacen");
        const condicionesEntrega = document.getElementById("condiciones_entrega");

        if (!expresiones.nombre.test(responsableAlmacen.value)) {
            warnings += `<li>Proporciona <b>nombre del responsable</b> de almacén válido.</li>`
            entrar = true
        }
        if (!expresiones.telefono.test(telefono.value)) {
            warnings += `<li>Proporciona un número de <b>teléfono</b> válido.</li>`
            entrar = true
        }
        if (direccion.value == 'null') {
            warnings += `<li>Proporciona una <b>direccion</b> válida.</li>`
            entrar = true
        }
        if (!expresiones.correo.test(correoElectronico.value)) {
            warnings += `<li>Proporciona un <b>correo electrónico</b> válido.</li>`
            entrar = true
        }
        if (condicionesEntrega.value.trim() === "") {
            warnings += `<li>Proporciona las <b>condiciones para la entrega</b> de forma correcta.</li>`
            entrar = true
        }
        warnings += `</ul>`;

        return entrar;
    }

    function preguntarFinalizarCompra() {
        let titulo = "Seguro?",
            texto = "Estas por finalizar tu compra. ¿Deseas continuar?";

        Swal.fire({
            title: titulo,
            text: texto,
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                confirmarCompra();
            }
        });
    }

    const confirmarCompra = () => {
        let arrayDatos = [];
        let formulario = document.getElementById('frm_confirmar');
        let productos = document.querySelector('#productos');

        for (let i = 0; i < arrayIdProductos.length; i++) {
            arrayDatos[i] = { 'id_producto': arrayIdProductos[i], }
        }
        
        productos.value = JSON.stringify(arrayDatos)
        formulario.submit();        
    }

});

direccion.addEventListener("change", (e)=>{
    let responsableAlmacen = document.querySelector('#responsable_almacen');
    responsableAlmacen.value = direccion.options[direccion.selectedIndex].getAttribute('data');
});