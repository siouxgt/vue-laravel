const convocatoria = document.querySelector('#convocatoria'),
	  emite = document.querySelector('#emite'),
	  objeto = document.querySelector('#objeto'),
	  motivo = document.querySelector('#motivo'),
	  numeroOficio = document.querySelector('#numero_oficio'),
	  fechaMesa = document.querySelector('#fecha_mesa'),
	  lugar = document.querySelector('#lugar'),
	  comentarios = document.querySelector('#comentarios'),
	  observaciones = document.querySelector('#observaciones'),
	  requisicionesInvitacion = document.querySelector('#requisiciones_invitacion'),
	  requisicionesFicha = document.querySelector('#requisiciones_ficha'),
	  requisicionesMinuta = document.querySelector('#requisiciones_minuta');


convocatoria.addEventListener('change',(e)=>{
	comentarios.innerHTML = observaciones.innerHTML = requisicionesInvitacion.innerHTML = requisicionesFicha.innerHTML = requisicionesMinuta.innerHTML = "";
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('service.convocatoria', {convocatoria: convocatoria.value}),
        type: 'GET',
        success: function(respuesta) {
            if (respuesta.success == true) {
                let data = JSON.parse(respuesta.data);
                emite.value = data.data.emite;
                objeto.innerHTML = data.data.objeto_bien_servicio_cm;
                motivo.innerHTML = data.data.motivo_convocatoria;
                numeroOficio.value = data.data.numero_oficio_invitacion_mesa_trabajo;
                fechaMesa.value = data.data.fecha_mesa_trabajo;
                lugar.value = data.data.lugar_mesa_trabajo;
                $.each(data.data.comentarios, function(index, value){
                    comentarios.innerHTML += value.comentarios_ficha+"\n";
                }); 
                $.each(data.data.minutas, function(index, value){
                    observaciones.innerHTML += value.observaciones+"\n";
                	requisicionesMinuta.innerHTML = value.archivo_minuta;
                });
                requisicionesInvitacion.innerHTML = data.data.documento_oficio_invitacion_mesa_trabajo;
                requisicionesFicha.innerHTML = data.data.archivo_ficha_tecnica
               	
            }else {
                Swal.fire('error', respuesta.message,"error");
                emite.removeAttribute("readonly","");
                emite.value = "";
                objeto.removeAttribute("readonly","");
                objeto.innerHTML = "";
                motivo.removeAttribute("readonly","");
                motivo.innerHTML = "";
                numeroOficio.removeAttribute("readonly","");
                numeroOficio.value = "";
                fechaMesa.removeAttribute("readonly","");
                fechaMesa.value = "";
                lugar.removeAttribute("readonly","");
                lugar.value = "";
                comentarios.removeAttribute("readonly","");
                comentarios.innerHTML = ""
                observaciones.removeAttribute("readonly","");
                observaciones.innerHTML = "";
                requisicionesInvitacion.removeAttribute("readonly","");
                requisicionesInvitacion.innerHTML = "";
                requisicionesFicha.removeAttribute("readonly","");
                requisicionesFicha.innerHTML = "";
                requisicionesMinuta.removeAttribute("readonly","");
                requisicionesMinuta.innerHTML = "";
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
});


function contador(element){
    let urg = document.querySelector('#contador_urg');
    let contador = parseInt(urg.innerHTML);
    
    if(element.checked){
        contador++; 
    }
    else{
        contador--;
    }    
    
    let contadorUrg = document.querySelector('#contador_urg');
    let numeroUrg = document.querySelector("#numero_urg");
    contadorUrg.innerHTML = numeroUrg.value = contador;

}

$(document).ready(function() {

    let mensaje = document.querySelector('#mensaje');
    switch (mensaje.value) {
        case 'error':
            Swal.fire("error", 'Error al guardar el grupo revisor.' ,"error");
        break;
        case 'success':
            Swal.fire("Proceso  correcto!", 'Grupo revisor guardado correctamente.' ,"success");
        break;
    }

});