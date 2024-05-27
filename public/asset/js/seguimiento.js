$(document).ready(function () {
   
    //Detectando si se esta usando el calendario
    $("#fecha_inicio").change(function () {
        comprobarFechas("fi");
    });
    $("#fecha_fin").change(function () {
        comprobarFechas("ff");
    });

    let anterior = window.location.href;
    anterior = anterior.split('/')
    if(anterior[anterior.length -1] == 'alta_contrato_5'){
        let contratoM = document.querySelector('#contrato_m_id');
        contratoM.value = archivo.options[archivo.selectedIndex].getAttribute('data3');
    }

    let mensaje = document.querySelector('#mensaje');
    if(mensaje != null){
        if(mensaje.value != ""){
            Swal.fire("error", mensaje.value ,"error");
        }
    }

});

function rechazadas(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.rechazadas_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#rechazados")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function cancelar(etapa){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.cancelar_modal',{'etapa': etapa}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#cancelar_modal")});
                let seccion = document.querySelector('#seccion');
                seccion.value = etapa;
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function cancelarSave(){
    if (!formValidate('#frm_cancel')) { return false; }
    Swal.fire({
      title: '¿Confirmas la cancelación?',
      text: "Esta por cancelar la compra. Al confirmar la acción no se podrá deshacer.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
             headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('orden_compra_urg.cancelar_save'),
            type: 'POST',
            data: $("#frm_cancel").serialize(),
            dataType: 'json',
            success: function (respuesta){
                if (respuesta.success == true) {
                    $('#cancelar_modal').modal('hide').on('hidden.bs.modal', function(){
                        let desCancelacion = document.querySelector('#des_cancelacion');
                        $('#cancelar').attr('disabled',true);
                        desCancelacion.innerHTML = `<p class="text-center text-rojo p-2"><b>ID Cancelación: ${respuesta.data.cancelacion }</b></p>
                                                    <p class="text-center"><b>Motivo de la cancelación:</b></p>
                                                    <p class="text-center text-2"> ${ respuesta.data.motivo }</p>
                                                    <p class="text-center"><b>Comentarios:</b></p>
                                                    <p class="text-center text-2">${ respuesta.data.descripcion }</p>`;
                    });
                }
            }
        });
      }
    })
}

function comprobarFechas(q) {
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
                    $("#fecha_inicio").datepicker({
                        format: 'dd/mm/yyyy',
                        update: fecha,
                        language: "es",
                    });
                }
            }
        break;
    }
}

function firmanteModalCreate(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.firmante_modal', {id: id}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#agregar_firmante")});
                let identificador = document.querySelector('#identificador');
                identificador.value = id;
                activarEscuchaRfc();
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}



function activarEscuchaRfc() {
    let rfc = document.getElementById("rfc");
    rfc.addEventListener("keyup", () => {
        if (rfc.value.length == 13) {
            $.ajax({
                url: route("orden_compra_urg.find_usuario", { rfc: rfc.value }),
                type: "GET",
                success: function (respuesta) {
                    let nombreCompleto = document.querySelector('#nombre_completo');
                    let nombre = document.querySelector('#nombre');
                    let primerApellido = document.querySelector('#primer_apellido');
                    let segundoApellido = document.querySelector('#segundo_apellido');
                    let puesto = document.querySelector('#puesto');
                    let telefono = document.querySelector('#telefono');
                    let extension = document.querySelector('#extension');
                    let correo = document.querySelector('#correo');
                    let identificador = document.querySelector('#identificador');
                    let error =  document.querySelector('#error') 
                    if (respuesta.success == true) {   
                        nombreCompleto.value = respuesta.data[0].nombre+" "+respuesta.data[0].primer_apellido+" "+respuesta.data[0].segundo_apellido;
                        nombre.value = respuesta.data[0].nombre;
                        primerApellido.value = respuesta.data[0].primer_apellido;
                        segundoApellido.value = respuesta.data[0].segundo_apellido;
                        puesto.value = respuesta.data[0].cargo;
                        telefono.value = respuesta.data[0].telefono;
                        extension.value = respuesta.data[0].extension;
                        correo.value = respuesta.data[0].email;
                        error.style.display = 'none';

                    } else {
                       error.style.display = 'block';
                       nombreCompleto.value = "";
                       nombre.value = "";
                       primerApellido.value = "";
                       segundoApellido.value = "";
                       puesto.value = "";
                       telefono.value = "";
                       extension.value = "";
                       correo.value = "";
                    }
                },
            });
        }
    });
}

function firmanteSave(){
    if(!formValidate('#fm_firmante')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.firmante_save'),
        type: 'POST',
        data: $("#fm_firmante").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#agregar_firmante').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let identificador = respuesta.data.identificador;
                    let responsable = document.querySelector('#responsable'+identificador);
                    let rfc = document.querySelector('#rfc'+identificador);
                    let nombre = document.querySelector('#nombre'+identificador);
                    let puesto = document.querySelector('#puesto'+identificador);
                    let agregarPersona = document.querySelector('#agregar_persona'+identificador);
                    responsable.classList.remove("ocultar");
                    rfc.innerHTML = respuesta.data.rfc;
                    nombre.innerHTML = respuesta.data.nombre +" "+ respuesta.data.primer_apellido +" "+ respuesta.data.segundo_apellido;
                    puesto.innerHTML = respuesta.data.puesto;
                    agregarPersona.innerHTML = `<a class="btn mt-3 m-2 boton-2" href="javascript: void(0);" onclick="firmanteModalEdit('${respuesta.data.id_e}');"><span><i class="fa-solid fa-plus"></i></span>Editar persona</a>`;
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function firmanteModalEdit(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.firmante_modal_edit', {id: id}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#editar_firmante")});
                activarEscuchaRfc();
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function firmanteEdit(){
    if(!formValidate('#fm_firmante')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.firmante_edit'),
        type: 'PUT',
        data: $("#fm_firmante").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#editar_firmante').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let identificador = respuesta.data.identificador;
                    let rfc = document.querySelector('#rfc'+identificador);
                    let nombre = document.querySelector('#nombre'+identificador);
                    let puesto = document.querySelector('#puesto'+identificador);
                    rfc.innerHTML = respuesta.data.rfc;
                    nombre.innerHTML = respuesta.data.nombre +" "+ respuesta.data.primer_apellido +" "+ respuesta.data.segundo_apellido;
                    puesto.innerHTML = respuesta.data.puesto;
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function almacenModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.almacen_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#agregar_almacen")});
                activarEscuchaCCG();
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function activarEscuchaCCG() {
    let ccg = document.getElementById("ccg");
    let direcciones = document.querySelector('#direcciones');
    let responsable = document.querySelector('#responsable'); 
    let puesto = document.querySelector('#puesto'); 
    let telefono = document.querySelector('#telefono'); 
    if(ccg.value.length == 6){
        console.log('ola');
        $.ajax({
            url: route("orden_compra_urg.almacen_responsable", { ccg: ccg.value.toUpperCase() }),
            type: "GET",
            success: function (respuesta) {
                responsable.value = "";
                puesto.value = "";
                telefono.value = "";
                direcciones.innerHTML = `<option >Seleccione una opción</option>`;
                if (respuesta.success == true) {
                    $.each(respuesta.data.almacenes, function(index, value){
                        let opciones = `<option value="${value['direccion']}" data_1="${ value['responsable'] }" data_2="${value['puesto']}" data_3="${value['telefono']}" >${ value['direccion'] }  Tipo: ${ value['tipo'] }</option>`;
                        direcciones.innerHTML += opciones; 
                    });
                    direcciones.addEventListener('change',(e)=>{
                        responsable.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_1');
                        puesto.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_2');
                        telefono.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_3');
                    });
                } else {
                    Swal.fire('error', respuesta.message,"error");
                }
            },
        });
    }
    ccg.addEventListener("keyup", () => {
        if (ccg.value.length == 6) {
            console.log(ccg.value);
            $.ajax({
                url: route("orden_compra_urg.almacen_responsable", { ccg: ccg.value.toUpperCase() }),
                type: "GET",
                success: function (respuesta) {
                    responsable.value = "";
                    puesto.value = "";
                    telefono.value = "";
                    direcciones.innerHTML = `<option >Seleccione una opción</option>`;
                    if (respuesta.success == true) {
                        $.each(respuesta.data.almacenes, function(index, value){
                            let opciones = `<option value="${value['direccion']}" data_1="${ value['responsable'] }" data_2="${value['puesto']}" data_3="${value['telefono']}" >${ value['direccion'] }  Tipo: ${ value['tipo'] }</option>`;
                            direcciones.innerHTML += opciones; 
                        });
                        direcciones.addEventListener('change',(e)=>{
                            responsable.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_1');
                            puesto.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_2');
                            telefono.value = direcciones.options[direcciones.selectedIndex].getAttribute('data_3');
                        });
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
            });
        }
    });
}

function almacenSave(){
    if(!formValidate('#frm_almacen')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.almacen_save'),
        type: 'POST',
        data: $("#frm_almacen").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#agregar_almacen').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let div = document.querySelector('#almacen');
                    let ccgAlmacen = document.querySelector('#ccg_almacen');
                    let responsableAlmacen = document.querySelector('#responsable_almacen');
                    let domicilioAlmacen = document.querySelector('#domicilio_almacen');
                    let telefonoAlmacen = document.querySelector('#telefono_almacen');
                    div.classList.remove("ocultar");
                    ccgAlmacen.innerHTML = respuesta.data.ccg;
                    responsableAlmacen.innerHTML = respuesta.data.responsable_almacen;
                    domicilioAlmacen.innerHTML = respuesta.data.direccion_almacen;
                    telefonoAlmacen.innerHTML = respuesta.data.telefono_almacen;
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


function almacenModalEditar(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.almacen_modal_edit'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#agregar_almacen")});
                activarEscuchaCCG();
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


function facturacionModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.facturacion_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#editar_facturacion")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function facturacionEdit(){
   if(!formValidate('#frm_facturacion')){ return false; };
       $.ajax({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url : route('orden_compra_urg.facturacion_edit'),
           type: 'PUT',
           data: $("#frm_facturacion").serialize(),
           dataType: 'json',
           success: function(respuesta) {
               if (respuesta.success == true) {
                   $('#editar_facturacion').modal('hide').on('hidden.bs.modal', function () {
                       Swal.fire("Proceso  correcto!", respuesta.message, "success");
                       let razonSocial = document.querySelector('#razon_social');
                       let usoCfdi = document.querySelector('#uso_cfdi');
                       let rfcFiscal = document.querySelector('#rfc_fiscal');
                       let domicilioFiscal = document.querySelector('#domicilio_fiscal');
                       razonSocial.innerHTML = respuesta.data.razon_social_fiscal;
                       usoCfdi.innerHTML = respuesta.data.uso_cfdi;
                       rfcFiscal.innerHTML = respuesta.data.rfc_fiscal;
                       domicilioFiscal.innerHTML = respuesta.data.domicilio_fiscal;
                   });
               } else {
                   Swal.fire('error', respuesta.message,"error");
               }
           },
           error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
           }
       });
}

const archivo = document.querySelector("#oficio_adhesion");

archivo?.addEventListener('change',(e)=>{
    let antecedente = document.querySelector('#antecedente');
    let numeroContrato = document.querySelector('#numero_contrato');
    let contratoM = document.querySelector('#contrato_m_id');
    
    antecedente.value = archivo.options[archivo.selectedIndex].getAttribute('data');
    numeroContrato.value = archivo.options[archivo.selectedIndex].getAttribute('data2');
    contratoM.value = archivo.options[archivo.selectedIndex].getAttribute('data3');
});

function firmar(){
    let formulario = document.querySelector('#frm_firma');
    let key = document.querySelector('#archivo_key');
    let cer = document.querySelector('#archivo_cer');
    let pass = document.querySelector('#contrasena');

    if(key.value != "" && cer.value != "" && pass.value != ""){
        Swal.fire({
            html: `Al dar de alta el contrato se comunicará a todos los involucrados. Contarán con 2 días para firmarlo. <br><br> 
            Al confirmar la acción no se podrá deshacer.<br><br>
            <span class="red">¿Confirmas el alta del contrato?</span>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    }
    else{
        Swal.fire('¡Alerta!','LLena todos los campos');
    }
}

function reportarModal(etapa){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.reporte_modal',{'etapa': etapa}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#reporte_modal")});
                let seccion = document.querySelector('#seccion');
                seccion.value = etapa;
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function reporteSave(){
    if (!formValidate('#frm_reporte')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.reporte_save'),
        type: 'POST',
        data: $("#frm_reporte").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#reporte_modal').modal('hide').on('hidden.bs.modal', function(){
                    let desReporte = document.querySelector('#des_reporte');
                    desReporte.innerHTML += `<p class="text-center text-rojo p-2"><b>ID Reporte: ${respuesta.data.id_reporte }</b></p>`;
                });
            }
        }
    });
}

function incidenciaModal(etapa){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.incidencia_modal',{'etapa': etapa}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#incidencia_modal")});
                let seccion = document.querySelector('#seccion');
                seccion.value = etapa;
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function incidenciaSave(){
    if (!formValidate('#frm_incidencia')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('orden_compra_urg.incidencia_save'),
            type: 'POST',
            data: $("#frm_incidencia").serialize(),
            dataType: 'json',
            success: function (respuesta){
                if (respuesta.success == true) {
                    $('#incidencia_modal').modal('hide').on('hidden.bs.modal', function(){
                        Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        let desInsidencia = document.querySelector('#des_incidencia');
                        let incidencia = document.querySelector('#incidencia');
                        desInsidencia.innerHTML = `<p class="text-center text-rojo p-2"><b>ID Incidencia: ${respuesta.data.id_incidencia }</b></p>`;
                        incidencia.setAttribute('disabled',true);
                    });
                }
            }
        });
}

function responderProrrogaModal(prorroga){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.prorroga_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                let aceptadoSi = document.querySelector('#aceptadosi');
                let aceptadoNo = document.querySelector('#aceptadono');
                let divCancelacion = document.querySelector('#cancelacion');
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#prorroga_modal")});
                let prorrogaId = document.querySelector('#prorroga');
                prorrogaId.value = prorroga;

                aceptadoSi.addEventListener('change', (e)=>{
                    divCancelacion.classList.add('ocultar');
                });

                aceptadoNo.addEventListener('change', (e)=>{
                    divCancelacion.classList.remove('ocultar');
                });

            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function responderProrrogaUpdate(){
    if (!formValidate('#frm_prorroga')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.prorroga_update'),
        type: 'POST',
        data: $("#frm_prorroga").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#prorroga_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let descarga = document.querySelector('#descarga');
                    descarga.setAttribute('href',url+'storage/acuse-prorroga/acuse_prorroga_'+respuesta.data.id+'.pdf');
                    descarga.setAttribute('download','acuse_prorroga_'+respuesta.data.id);
                    descarga.click();
                    let fechaRespuesta = document.querySelector('#fecha_respuesta');
                    fechaRespuesta.innerHTML = `${respuesta.data.fecha_aceptacion}`;
                    let responder = document.querySelector('#responder');
                    responder.setAttribute('disabled',true);
                });
            }
        }
    });
}

function subirAcuseModal(prorroga){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.acuse_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#acuse_modal")});
                let prorrogaId = document.querySelector('#prorroga');
                prorrogaId.value = prorroga;

            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function subirAcuseUpdate(){
    if(!formValidate('#frm_acuse')){ return false; };
    Swal.fire({
        title: 'Solicitud de prórroga',
        html: `Esta por guardar el acuse de recepción de prórroga<br><br>Al confirmar la acciónno se podrá deshacer<br><br><span class="red">Confirmas la acción</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData($("#frm_acuse").get(0));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : route('orden_compra_urg.acuse_update'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(respuesta) {
                    if (respuesta.success == true) {
                        $('#acuse_modal').modal('hide').on('hidden.bs.modal', function(){
                           Swal.fire("Proceso  correcto!", respuesta.message, "success");
                           let divAcuse = document.querySelector('#acuse');
                           divAcuse.innerHTML = `<a href="${url}storage/acuse-prorroga/acuse_prorroga_firma_${respuesta.data.id}.pdf" target="_black">
                                                <p class="text-5 mt-3 mb-3"><i class="fa-solid fa-file-invoice text-5"></i><strong>Acuse</strong></p>
                                            </a>`;
                        });
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
                error: function(xhr) {
                    Swal.fire('¡Alerta!', xhr, 'warning');
                }
            });
        }
        else{
            $('#acuse_modal').modal('hide').on('hidden.bs.modal', function(){});
        }
    })
}

function aceptarEnvio(estatus){
    Swal.fire({
        title: 'Confirmación',
        html: `Esta por ${estatus} el pedido. Al confirmar la acción no se podrá deshacer.<br><br><span class="red">¿${estatus.charAt(0).toUpperCase()}${estatus.slice(1)} el pedido?</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : route('orden_compra_urg.aceptar_envio'),
                type: 'POST',
                data: {'estatus': estatus},
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success == true) {
                        Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        let divfecha = document.querySelector('#div_fecha');
                        let botonSi = document.querySelector('#boton_si');
                        let botonNo = document.querySelector('#boton_no');
                        let divAcuse = document.querySelector('#div_acuse');
                        let idSustitucion = document.querySelector('#numero_sustitucion');
                        divfecha.innerHTML = `<p class="text-1 text-center">Entrega ${estatus}</p><p class="text-1 text-center">${respuesta.data.fecha_entrega_aceptada}</p>`;
                        divfecha.classList.remove('ocultar');
                        botonSi.setAttribute('disabled','');
                        botonNo.setAttribute('disabled','');
                        if(estatus == 'rechazar')
                        {
                            divAcuse.classList.remove('ocultar');
                            idSustitucion.classList.remove('ocultar');
                            idSustitucion.innerHTML = `ID Solicitud: ${ respuesta.data2.sustitucion }`;
                        }
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
                error: function(xhr) {
                    Swal.fire('¡Alerta!', xhr, 'warning');
                }
            });
        }
    })
}

function datosFacturacion(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.datos_facturacion'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#facturacion_modal")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function productosSustituirModal(){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.productos_sustituir_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#productos_sustituir_modal")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

let producto = 0;
function contador(element){
    if(element.checked){
        producto++; 
    }
    else{
        producto--;
    }    
    
    let contadorProducto = document.querySelector('#contador');
    contadorProducto.innerHTML =  producto;
}

function acuseSustitucion(){
    if (!formValidate('#frm_sustitucion')) { return false; }
    let productos = $('input:checkbox');
    let contador = 0;
    $.each(productos,function(index, value){
        if(value.checked ){
            contador++;
        }
    });
    if(contador == 0){ 
        Swal.fire('¡Alerta!', 'Selecciona productos a sustituir.', 'warning');
        return false;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.acuse_sustitucion'),
        type: 'POST',
        data: $("#frm_sustitucion").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#productos_sustituir_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    let botonAcuse = document.querySelector('#boton_acuse');
                    let acuse = document.querySelector('#acuse');
                    let dias = document.querySelector('#dias');
                    acuse.setAttribute('href',url+'storage/acuse-sustitucion/'+respuesta.data.archivo_acuse_sustitucion);
                    acuse.classList.remove('ocultar');
                    botonAcuse.setAttribute('disabled',true);
                    dias.innerHTML = 5;
                });
            }
            else{
                Swal.fire('¡Alerta!', xhr, 'warning');
            }
        }
    });
}

function aceptarSustitucion(){
    Swal.fire({
        title: 'Confirmación',
        html: `Esta por aceptar la sustitución del pedido. Al confirmar la acción no se podrá deshacer.<br><br><span class="red">¿Aceptas la sustitución del pedido?</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : route('orden_compra_urg.aceptar_sustitucion'),
                type: 'POST',
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success == true) {
                        Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        let botonSi = document.querySelector('#sustitucionSi');
                        botonSi.setAttribute('disabled','');
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
                error: function(xhr) {
                    Swal.fire('¡Alerta!', xhr, 'warning');
                }
            });
        }
    })
}

function aceptarFactura(tipo){
    Swal.fire({
        html: `Estas por aceptar la prefactura. Una vez confirmada la acción, el proveedor timbrará el archivo.<br><br><span class="red">¿Aceptas la prefactura?</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : route('orden_compra_urg.aceptar_factura'),
                type: 'POST',
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success == true) {
                        Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        let aceptar = document.querySelector('#aceptar');
                        let cambios = document.querySelector('#cambios');
                        aceptar.setAttribute('disabled','');
                        cambios.setAttribute('disabled','');
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
                error: function(xhr) {
                    Swal.fire('¡Alerta!', xhr, 'warning');
                }
            });
        }
    })
}

function solicitarCambiosModal(tipo_factura) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.solicitar_cambios_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#solicitar_cambios_modal")});
                let tipoFactura = document.querySelector('#tipo_factura');
                tipoFactura.value = tipo_factura;

            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function solicitarCambioSave(){
    let cambios = document.querySelector('#cambios');
    let divCambio = document.querySelector('#div_cambios');
    let correcion = document.querySelector('#correccion');
    let descripcion = document.querySelector('#descripcion');
    if (!formValidate('#frm_solicitud')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.solicitar_cambios_save'),
        type: 'POST',
        data: $("#frm_solicitud").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#solicitar_cambios_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    cambios.setAttribute('disabled',true);
                    divCambio.classList.remove('ocultar');
                    correcion.innerHTML = respuesta.data.tipo_correccion;
                    descripcion.innerHTML = respuesta.data.descripcion;
                });
            }
            else{
                Swal.fire('¡Alerta!', respuesta.message, 'warning');
            }
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function facturaSapModal() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.aceptar_sap_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#sap_modal")});
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $('.input-group.date').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    startDate: date,
                    endDate: date,
                });
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function aceptarFacturaSap(){
    let sap = document.querySelector('#factura_sap');
    let fecha = document.querySelector('#fecha');
    if (!formValidate('#frm_sap')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.factura_en_sap'),
        type: 'POST',
        data: $("#frm_sap").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#sap_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    sap.setAttribute('disabled',true);
                    fecha.innerHTML = respuesta.data.fecha_sap;
                });
            }
            else{
                Swal.fire('¡Alerta!', respuesta.message, 'warning');
            }
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function comprobanteClcModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.comprobante_clc_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#sap_modal")});
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $('.input-group.date').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    startDate: date,
                    endDate: date,
                });
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function comprobanteClcSave(){
    let fechaIngreso = document.querySelector('#fecha_ingreso');
    let archivoClc = document.querySelector('#archivo_clc');
    let adjuntarClc = document.querySelector('#adjuntar_clc');
    let divArchivo = document.querySelector('#div_archivo');
    let retraso = document.querySelector('#retraso')
    if(!formValidate('#frm_clc')){ return false; };
    let formData = new FormData($("#frm_clc").get(0));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.comprobante_clc_save'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#clc_modal').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    fechaIngreso.innerHTML = respuesta.data.fecha_ingreso;
                    archivoClc.setAttribute('href',url+'storage/comprobante-clc/'+respuesta.data.archivo_clc);
                    adjuntarClc.setAttribute('disabled','');
                    divArchivo.classList.remove('ocultar');
                    retraso.setAttribute('disabled','');
                });     
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function retrasoModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.retraso_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#retraso_modal")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function retrasoSave(){
    if (!formValidate('#frm_retraso')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('orden_compra_urg.retraso_save'),
        type: 'POST',
        data: $("#frm_retraso").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#retraso_modal').modal('hide').on('hidden.bs.modal', function(){
                    let divRetraso = document.querySelector('#div_retraso');
                    let retraso = document.querySelector('#retraso')
                    divRetraso.innerHTML += `<p class="text-center text-rojo p-2"><b>ID Retraso: ${respuesta.data.id_retraso }</b></p>`;
                    retraso.setAttribute('disabled','');
                });
            }
        }
    });
}

function calificar(item){
    let contador = item.id[0];
    let nombre = item.id.substring(1);
    for (let i = 1; i <= 5; i++) {
        if(i <= contador){
            $('#'+i+nombre).addClass("active");
        }
        else{
            $('#'+i+nombre).removeClass("active");
        }
    }
    $("#"+nombre).val(contador);
}

function caracteres(text,contador) {
    let longitudAct = text.value.length;
    document.querySelector(`#${contador}`).innerHTML = `${longitudAct}/1000 palabras`;
}