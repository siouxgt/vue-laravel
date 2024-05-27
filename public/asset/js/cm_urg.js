$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $("#tbl_ucm").DataTable({
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
            url: route(
                "cm_urg.fetch_cmu",
                document.getElementById("id_cm").value
            ),
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
            { data: "ccg", className: "text-center", },
            { data: "nombre" },
            { data: "fecha_firma", className: "text-center", },
            {
                //Ver documento terminos especificos
                className: "text-center",
                orderable: false,
                data: "a_terminos_especificos",
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        "<a  class='btn btn-cdmx' target='_blank' href='" +
                        route(
                            "cm_urg.ver_archivo",
                            oData.a_terminos_especificos
                        ) +
                        "'><i class='fa-solid fa-lg fa-file-pdf'></i></a>"
                    );
                },
            },
            {
                //Ver más
                className: "text-center",
                orderable: false,
                data: "id_e",
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        '<a class="btn btn-cdmx" href="' +
                        route("urg.ver_show", [oData.id_e, true]) +
                        '"><i class="fa fa-eye fa-lg dorado"></i></a>'
                    );
                },
            },
            {
                //Editar CM URG
                className: "text-center",
                orderable: false,
                mRender: function (data, type, row) {
                    return (
                        '<a class="btn btn-cdmx" onClick="mEditarCMU(\'' +
                        row.id_cmu +
                        '\');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>'
                    );
                },
            },
            {
                //Habilitar o Inhabilitar
                className: "text-center",
                orderable: false,
                data: "estatus",
                data: "id_cmu",
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(pintarCheck(oData.estatus, oData.id_cmu));
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

function pintarCheck(estatus, id) {
    let frase = `<div class="custom-control custom-switch">
                <label class="switch">
                <input type="checkbox" name="estatus" id="estatus${id}" 
                value="1" onchange="escucharCambiosCheck(this, '${id}')" `;

    estatus ? (frase += `checked>`) : (frase += `>`);

    frase += `<span class="slider round"></span>
                </label>
                </div>`;

    return frase;
}

function escucharCambiosCheck(obj, id) {
    let opcion = "",
        titulo = "",
        miCheck = $("[id$=" + obj.id + "]");

    if (!$(miCheck).is(":checked")) {
        titulo = "¿Inhabilitar URG?";
        opcion = "¿Está seguro de inhabilitar la URG participante?";
    } else {
        titulo = "¿Habilitar URG?";
        opcion = "¿Está seguro de habilitar la URG participante?";
    }

    !obj.checked
        ? miCheck.prop("checked", true)
        : miCheck.prop("checked", false);

    Swal.fire({
        title: titulo,
        text: opcion,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            habilitarParticipante(!obj.checked, id);
        }
    });
}

function habilitarParticipante(opcion, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "GET",
        url: route("cm_urg.habilitar_participante", [opcion, id]),
        success: function (response) {
            if (response.status == 400) {
                Swal.fire("¡Alerta!", response.message, "warning");
            } else {
                $("#tbl_ucm").DataTable().ajax.reload();
                Swal.fire("Proceso correcto!", response.message, "success");
            }
        },
    });
}

let btnAgregarUCM = document.querySelector("#btnAgregarUCM");
btnAgregarUCM.addEventListener("click", (e) => {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("cm_urg.abrir_au", document.getElementById("id_cm").value),
        dataType: "html",
        success: function (resp_success) {
            $(resp_success)
                .modal()
                .on("shown.bs.modal", function () {

                    $("[class='make-switch']").bootstrapSwitch("animate", true);
                    $(".select2").select2({ dropdownParent: $("#add_urg_cm") });
                    $(function () {
                        let today = new Date();
                        let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                        $("#fecha_firma").datepicker({
                            format: "dd/mm/yyyy",
                            language: "es",
                            daysOfWeekDisabled: [0,6],
                            endDate: date,
                        });
                    });
                })
                .on("hidden.bs.modal", function () {
                    $(this).remove();
                });
        },
        error: function (respuesta) {
            console.log(respuesta);
        },
    });
});

function cargarUrgsParticipantesP() {
    console.log("Buscando URG participante");
    // $.ajax({
    //     type: "GET",
    //     url: route("contrato.cupp", document.getElementById("id_cm").value),
    //     success: function (data) {
    //         let selectValTec = $("#validaciones_seleccionadas")
    //             .empty()
    //             .append();
    //         $.each(data, function (key, value) {
    //             selectValTec.append(
    //                 $("<option></option>")
    //                     .attr("value", value.id)
    //                     .text(value.siglas + " -- " + value.direccion)
    //             );
    //         });
    //         selectValTec.trigger("change");
    //         document.getElementById(
    //             "validaciones_seleccionadas"
    //         ).disabled = false;
    //     },
    // });
}

$(document).on("click", "#btn_guardar_ucm", function (e) {
    e.preventDefault();

    let formData = new FormData($("#frmUCM").get(0));
    let btnEditarCMU = $("#btn_guardar_ucm").attr("disabled", true);
    btnEditarCMU.text("Guardando...");
    console.log("--> Guardando URG participante");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: route("cm_urg.store"),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status == 400) {
                $("#alerta_guardado_ucm").html("");
                $("#alerta_guardado_ucm").addClass("alert alert-danger");
                $.each(response.errors, function (key, err_value) {
                    $("#alerta_guardado_ucm").append("- " + err_value + "<br>");
                });
                Swal.fire(
                    "¡Alerta!",
                    "Existen campos sin llenar, revise por favor",
                    "warning"
                );
                btnEditarCMU.text("Guardar");
                btnEditarCMU.attr("disabled", false);
            } else {
                $("#alerta_guardado_ucm").html("");
                $("#add_urg_cm")
                    .modal("hide")
                    .on("hidden.bs.modal", function () {
                        $("#tbl_ucm").DataTable().ajax.reload();
                        Swal.fire(
                            "Proceso correcto!",
                            response.message,
                            "success"
                        );
                    });
            }
        },
    });
});

function mEditarCMU(data) {
    console.log("Id a editar: " + data);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route("cm_urg.edit", data),
        dataType: "html",
        success: function (resp_success) {
            let modal = resp_success;
            $(modal)
                .modal()
                .on("shown.bs.modal", function () {
                    $("[class='make-switch']").bootstrapSwitch("animate", true);
                    $(".select2").select2({
                        dropdownParent: $("#edit_urg_cm"),
                    });
                    $(function () {
                        let today = new Date();
                        let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                        $("#fecha_firma").datepicker({
                            format: "dd/mm/yyyy",
                            language: "es",
                            daysOfWeekDisabled: [0,6],
                            endDate: date,
                        });
                    });
                })
                .on("hidden.bs.modal", function () {
                    $(this).remove();
                });
        },
        error: function (respuesta) {
            Swal.fire(
                "¡Alerta!",
                "Error de conectividad de red USR-03",
                "warning"
            );
        },
    });
}

$(document).on("click", "#btn_edit_ucm", function (e) {
    e.preventDefault();

    let formData = new FormData($("#frmCMU").get(0));
    let btnEditarCMU = $("#btn_edit_ucm").attr("disabled", true);
    btnEditarCMU.text("Guardando...");
    console.log("--> Actualizando URG participante");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: route("cm_urg.update", 1),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status == 400) {
                $("#alerta_modificado_ucm").html("");
                $("#alerta_modificado_ucm").addClass("alert alert-danger");
                $.each(response.errors, function (key, err_value) {
                    $("#alerta_modificado_ucm").append(
                        "- " + err_value + "<br>"
                    );
                });
                Swal.fire(
                    "¡Alerta!",
                    "Existen campos sin llenar, revise por favor",
                    "warning"
                );
                btnEditarCMU.text("Guardar");
                btnEditarCMU.attr("disabled", false);
            } else {
                $("#alerta_modificado_ucm").html("");
                $("#edit_urg_cm")
                    .modal("hide")
                    .on("hidden.bs.modal", function () {
                        $("#tbl_ucm").DataTable().ajax.reload();
                        Swal.fire(
                            "Proceso correcto!",
                            response.message,
                            "success"
                        );
                    });
            }
        },
    });
});

function liberar(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('contrato.liberar'),
        type: 'PUT',
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let divLiberar = document.getElementById('liberar');
                divLiberar.innerHTML = "";
                
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
 }