function submenu_modal(seccion,data){
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('submenu.edit',{submenu: data}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
            $(modal).modal().on('shown.bs.modal', function() {
                let fechaInicio = document.querySelector('#fecha_inicio');
                let fechaFin = document.querySelector('#fecha_fin');
                let inputSeccion = document.querySelector('#seccion');
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#add_submenu")});
                $("#fecha_inicio,#fecha_fin").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es"
                }); 
                inputSeccion.value = seccion;
                fechaInicio.setAttribute('name','fecha_inicio_'+seccion);
                fechaFin.setAttribute('name','fecha_fin_'+seccion);
                 $("#fecha_inicio").change(function () {
                    comprobarFechasSub("fi");
                });
                $("#fecha_fin").change(function () {
                    comprobarFechasSub("ff");
                });
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function update_submenu(){
    let id = document.getElementById("submenu_id").value;
    let seccion = document.getElementById("seccion").value;
    if(!formValidate('#frm_submenu')){ return false; };
    let formData = new FormData($("#frm_submenu").get(0));
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('submenu.update',{submenu: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#add_submenu').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success"); 
                });
                reloadFecha(seccion, respuesta);
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


function reloadFecha(seccion, respuesta){
    const MESES = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre",];
    let fechaInicio = document.querySelector('#fecha_inicio_'+seccion);
    let fechaFin = document.querySelector('#fecha_fin_'+seccion);
    let auxI = respuesta.fecha_inicio.split('-');
    let auxI2 = auxI[2].split('T');
    let fechaI = new Date(auxI[0],auxI[1]-1,auxI2[0]);
    let auxF = respuesta.fecha_fin.split('-');
    let auxF2 = auxF[2].split('T');
    let fechaF = new Date(auxF[0],auxF[1]-1,auxF2[0]);
    fechaInicio.innerHTML = `${ auxI2[0] } ${MESES[fechaI.getMonth()]} ${ fechaI.getFullYear()}`;
    fechaFin.innerHTML = `${ auxF2[0] } ${MESES[fechaF.getMonth()]} ${ fechaF.getFullYear()}`;
}

function comprobarFechasSub(q) {
    let f_i = $("#fecha_inicio").val(),
        f_f = $("#fecha_fin").val();
        f_f = f_f.split('/');
        f_i = f_i.split('/');

    d_f = Date.parse(f_f[2]+'/'+f_f[1]+'/'+f_f[0]);
    d_i = Date.parse(f_i[2]+'/'+f_i[1]+'/'+f_i[0]);
    switch (q) {
        case "fi":
            if (d_f < d_i) {
                document.getElementById("fecha_fin").value = "";
            }
        break;
        case "ff":
            if(!isNaN(d_f)){
                if (d_f < d_i) {
                    let fecha  = new Date(f_f[2],f_f[1]-1,f_f[0]);
                    document.getElementById("fecha_inicio").value = fecha.toLocaleDateString();
                    $("#fecha_inicio").datepicker({format: 'dd/mm/yyyy'});
                    $("#fecha_inicio").datepicker("update", fecha);

                }
            }
        break;
    }
}