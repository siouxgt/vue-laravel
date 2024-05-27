$(document).ready(function () {
    let dataTable = $("#tabla_urg").DataTable({
        processing: true,
        serverSide: false,
        dom:
            "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            url: url + "asset/datatables/Spanish.json",
        },
        ajax: {
            url: route("urg.fetchurgs"),
            type: "GET",
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center"
            },
        ],
        order: [[1, "asc"]],
        columns: [
            { data: "id", defaultContent: "" },
            { data: "ccg", className: "text-center" },
            { data: "nombre" },
            { data: "fecha_adhesion", className: "text-center" },
            { data: "estatus", className: "text-center" },
            {
                //Ver documento
                "orderable": false,
                "className": "text-center",
                mRender: function (data, type, row) {
                    return (
                        '<a class="btn btn-cdmx"  target="_blank" href="' +
                        route("urg.show", { urg: row.id + " " }) +
                        '"><i class="fa-solid fa-lg fa-file-pdf"></i></a>'
                    );
                },
            },
            {
                //Ver más
                "className": "text-center",
                data: "id_e",
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        '<a class="btn btn-cdmx" href="' +
                        route("urg.ver_show", oData.id_e) +
                        '"><i class="fa fa-eye fa-lg dorado"></i></a>'
                    );
                },
            },
            {
                //Editar URG
                "orderable": false,
                "className": "text-center",
                mRender: function (data, type, row) {
                    return ('<a class="btn btn-cdmx" onClick="edit_urg_modal(\'' +row.id_e +'\');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>');
                },
            },
        ],
    });

    dataTable
        .on("order.dt search.dt", function () {
            let i = 1;
            dataTable
                .cells(null, 0, { search: "applied", order: "applied" })
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();
});

function activarEscuchaCCG() {
    let escuchado = document.getElementById("ccg");
    //El evento lo puedes reemplazar con keydown, keyup, keypress y el tiempo a tu necesidad
    escuchado.addEventListener("keyup", () => {
        if (escuchado.value.length == 6) {
            buscarUrg(escuchado.value);
            apiUrg(escuchado.value);
        }
    });
}

// function cargarInfoURGs(ccg) {
//     const divPersonal = document.querySelector("#miscroll");
//     let contenido = "";

//     $.ajax({
//         url: route("service.acceso_unico", {ccg: ccg}),
//         type: "GET",
//         success: function (respuesta){
//             let data = JSON.parse(respuesta.data);
            
//             if(data.data.length != 0){
                
//                 for (personal of data.data)
//                 {
//                     contenido +=  ` <div class="row">
//                             <div class="col-12 col-sm-2">
//                                 <div class="form-group">
//                                     <label for="nombrer">Nombre</label>
//                                 </div>
//                             </div>
//                             <div class="col-12 col-sm-7">
//                                 <div class="form-group">
//                                     <input type="text" class="form-control" name="nombre[]" id="nombrer" value="${personal.nombre} ${personal.primer_apellido} ${personal.segundo_apellido}" readonly>
//                                     <input type="hidden" name="rfc[]" value="${personal.rfc}">
//                                 </div>
//                             </div>
//                             <div class="col-12 col-sm-1">
//                                 <div class="form-group">
//                                     <label for="formGroupExampleInput">Activo</label>
//                                 </div>
//                             </div>
//                             <div class="col-12 col-sm-2 text-align-center">
//                                 <div class="form-group">
//                                     <div class="custom-control custom-switch">
//                                         <label class="switch">
//                                             <input type="checkbox" id="estatus" name="estatus[${personal.rfc}]" value="1">
//                                             <span class="slider round"></span>
//                                         </label>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                             <div class="col-12 col-sm-2">
//                                 <div class="form-group">
//                                     <label for="cargo">Cargo</label>
//                                 </div>
//                             </div>
//                             <div class="col-12 col-sm-7">
//                                 <div class="form-group">
//                                     <input type="text" class="form-control" name="cargo[]" id="cargo" value="${personal.cargo}" placeholder="Cargo del URG responsable" readonly>
//                                 </div>
//                             </div>
//                         </div> 
//                         <div class="row">
//                             <div class="col-12 col-sm-2">
//                                 <div class="form-group">
//                                     <label for="permiso">Permiso</label>
//                                 </div>
//                             </div>
//                             <div class="col-12 col-sm-4">
//                                 <div class="form-group">
//                                     <select name="permiso[]" class="form-control text-1">
//                                         <option value="">Seleccione una opción..</option>
//                                         <option value="supadmin">Super Administrador</option>
//                                         <option value="admin">Administrador</option>
//                                         <option value="urlCompra">URL Compras</option>
//                                         <option value="urlVista">URL Vista</option>
//                                     </select> 
//                                 </div>
//                             </div>
//                         </div>
//                         <hr>`;
//                 }
//                 divPersonal.style.height = "300px";    
//                 divPersonal.innerHTML = contenido; 
//             } else {
//                 divPersonal.style.height = "50px";    
//                 divPersonal.innerHTML = `<div class="row">
//                                        <div class="col-12 col-sm-12">
//                                             <div class="form-group">
//                                                 <p class="text-center">Sin usuarios registrados en Acceso Unico</p>
//                                             </div>
//                                         </div>`; 
//             }
//         }
//     });
// }

const create = document.querySelector("#urg_modal");
create.addEventListener("click", (e) => {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("urg.create"),
        dataType: "html",
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
            $(modal)
                .modal()
                .on("shown.bs.modal", function () {
                    $("[class='make-switch']").bootstrapSwitch("animate", true);
                    $(".select2").select2({ dropdownParent: $("#add_urg") });
                    $(function () {
                        let today = new Date();
                        let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                        $("#fecha_adhesion").datepicker({
                            format: "dd-mm-yyyy",
                            language: "es",
                            daysOfWeekDisabled: [0,6],
                            endDate: date
                        });
                    });
                    activarEscuchaCCG();
                })
                .on("hidden.bs.modal", function () {
                    $(this).remove();
                });
        },
    
        error: function (respuesta) {
            Swal.fire("¡Alerta!", "Error de conectividad de red USR-03", "warning");
        },
    });
});

$(document).on("click", ".create_urg", function (e) {
    e.preventDefault();

    let formData = new FormData($("#frm_urg").get(0));
    let btnCrear = $('#create_urg').attr('disabled', true);
    btnCrear.text("Guardando...");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: route("urg.store"),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status == 400) {
                btnCrear.text("Guardar");
                btnCrear.attr('disabled', false);
                Swal.fire('error', response.message,"error");
            } else {
                $("#save_msgList").html("");
                $("#add_urg")
                    .modal("hide")
                    .on("hidden.bs.modal", function () {
                        /* $("#str").empty().append(); //Quitando el valor actual del total de urgs
                        $("#str").append(response.totalUrgs); //Imprimiendo el valor actual dde total de urgs */
                        $("#tabla_urg").DataTable().ajax.reload();
                        Swal.fire(
                            "Proceso  correcto!",
                            response.message,
                            "success"
                        );
                    });
            }
        },
    });
});

function edit_urg_modal(data) {
    $(document).on("change", 'input[type="file"]', function () {
        var ruta = $("input:file[name=archivo]").val();
        var newStr = ruta.slice(12);
        document.getElementById("rutarc").innerHTML = newStr; //Inner permite cambiar el valor del Label
    });

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("urg.edit", { urg: data }),
        dataType: "html",
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
            $(modal)
                .modal()
                .on("shown.bs.modal", function () {
                    $("[class='make-switch']").bootstrapSwitch("animate", true);
                    $(
                        "#tipo > option[value=" + resp_success.tipoUrg + "]"
                    ).attr("selected", true);
                    $(".select2").select2({
                        dropdownParent: $("#mod_edit_urg"),
                    });
                    $(function () {
                        $("#fecha_adhesion").datepicker({
                            format: "dd-mm-yyyy",
                        });
                    });
                })
                .on("hidden.bs.modal", function () {
                    $(this).remove();
                });
        },
        error: function (respuesta) {
            Swal.fire("¡Alerta!", "Error de conectividad de red USR-03", "warning"
            );
        },
    });
}

function urg_update() {
    if (!formValidate("#frm_urg")) {
        return false;
    }
    let btnActualizar = $('#store_urg').attr('disabled', true);
    btnActualizar.text("Actualizando...");

    let id = document.getElementById("id").value;
    let formData = new FormData($("#frm_urg").get(0));
    formData.append("_method", "PUT");

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("urg.update", { urg: id }),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (respuesta) {
            if (respuesta.success == true) {
                $("#edit_urg")
                    .modal("hide")
                    .on("hidden.bs.modal", function () {
                        Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        $("#tabla_urg").DataTable().ajax.reload();
                    });
            } else {
                btnActualizar.text("Actualizar");
                btnActualizar.attr('disabled', false);
                Swal.fire("error", respuesta.message, "error");
            }
        },
        error: function (respuesta) {
            Swal.fire("¡Alerta!", "Error de conectividad de red USR-04", "warning");
        },
    });
}

function apiUrg(ccg) {
    $.ajax({
        url: route("service.almacen", { ccg: ccg }),
        type: "GET",
        success: function (respuesta) {
            if(respuesta.success){
                let nombre = document.querySelector("#nombre");
                if (respuesta.direcciones.length != 0) {
                    nombre.value = respuesta.elurg;
                    let selectDireccion = $("#direccion").empty().append();
                    if (respuesta.length > 1) {
                        selectDireccion.append(
                            $("<option></option>")
                                .attr("value", -1)
                                .attr("disabled", "")
                                .attr("selected", "")
                                .text("Seleccione dirección")
                        );
                    }
                    $.each(respuesta.direcciones, function (key, value) {
                        selectDireccion.append(
                            $("<option></option>").attr("value", value).text(value)
                        );
                    });
                    // cargarInfoURGs(ccg);
                } else {
                    Swal.fire('error', respuesta.message,"error");
                }
            }
            else {
                nombre.value = "";
                let selectDireccion = $("#direccion").empty().append();
                Swal.fire('error', respuesta.message,"error");
            }
        },
    });
}


function buscarUrg(ccg){
    $.ajax({
        url: route("urg.buscar_urg", { ccg: ccg }),
        type: "GET",
        success: function (respuesta) {
            if(respuesta.success){
                let msgList = document.querySelector('#save_msgList');
               if(respuesta.data.length != 0){
                msgList.classList.add("alert", "alert-danger");
                msgList.innerHTML = '-ESTA CLAVE DE CENTRO GESTOR YA HA SIDO REGISTRADA, INGRESA UNA CLAVE DIFERENTE PARA CONTINUAR CON EL REGISTRO.';
               }else{
                msgList.classList.remove("alert", "alert-danger");
                msgList.innerHTML = ' ';
               }
            }
            else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
    });
}