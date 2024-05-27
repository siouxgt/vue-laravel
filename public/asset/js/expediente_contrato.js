function updateExp(){
    let id = document.getElementById("expediente_id").value;
    if(!formValidate('#frm_expediente_cm')){ return false; }
    let formData = new FormData($("#frm_expediente_cm").get(0));
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('expedientes_contrato.update',{expedientes_contrato: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

const metodo = document.querySelector('#metodo');

metodo.addEventListener('change', (e) =>{ 
    let proceso = document.querySelector('#proceso');
     switch(metodo.value) {
        case '1':
            proceso.innerHTML = "Licitación pública";
        break;
        case '2':
            proceso.innerHTML = "Incitación restringida";
        break;
        case '3':
            proceso.innerHTML = "Adjudicación directa";
        break;
        default:
            proceso.innerHTML = "Expediente";
        break;
    }

});

$(document).ready(function() {

    let mensaje = document.querySelector('#mensaje');
    switch (mensaje.value) {
        case 'error':
            Swal.fire("error", 'Error al guardar el expediente.' ,"error");
        break;
        case 'success':
            Swal.fire("Proceso  correcto!", 'Expediente guardado correctamente.' ,"success");
        break;
    }
});

function liberar(){
    let expediente_id = document.getElementById("expediente_id").value;
    let divLiberar = document.getElementById('liberar');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('expedientes_contrato.liberar',{id: expediente_id}),
        type: 'PUT',
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
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