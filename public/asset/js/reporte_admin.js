$(document).ready(function () {

    $("#de").change(function () {
        comprobarFechas("de");
    });
    $("#hasta").change(function () {
        comprobarFechas("hasta");
    });

    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    
	let dataTableReporte = $('#tabla_reportes').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('reporte_admin.data'),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center",
            }
        ],
        order: [[1, 'asc']],
        columns: [
            { data: 'id_t', defaultContent: '' },
            { data: 'nombre_reporte' },
            { data: 'fecha', className: "text-center" },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                   return `Creado`;
                }
            },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                   return `<a class="btn btn-cdmx" href="${ route('reporte_admin.show',{id: row.id_e}) }"><i class="fa fa-eye fa-lg"></i></a>`;
                }
            },
        ]
    });

    dataTableReporte.on('order.dt search.dt', function () {
        let i = 1;
        dataTableReporte.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

});

function reporte(){
	if (!formValidate('#frm_reporte')) { return false; }
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('reporte_admin.save'),
        type: 'POST',
        data: $("#frm_reporte").serialize(),
        dataType: 'json',
        success: function(respuesta) {
           if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                $('#tabla_reportes').DataTable().ajax.reload();
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}

const tipoReporte = document.querySelector('#reporte');

tipoReporte.addEventListener('change',(e)=>{
    let contrato = document.querySelector('#contrato');
    let proveedor = document.querySelector('#proveedor');
    let urg = document.querySelector('#urg');
    switch(tipoReporte.options[tipoReporte.selectedIndex].getAttribute('data')){
        case '1':
            proveedor.options[0].selected = true;
            proveedor.setAttribute("disabled","");
            urg.options[0].selected = true;
            urg.setAttribute("disabled","");
            contrato.removeAttribute("disabled","");
        break;
        case '2':
            contrato.options[0].selected = true;
            contrato.setAttribute("disabled","");
            proveedor.removeAttribute("disabled","");
            urg.options[0].selected = true;
            urg.setAttribute("disabled","");
        break;
        case '3':
            contrato.options[0].selected = true;
            contrato.setAttribute("disabled","");
            proveedor.options[0].selected = true;
            proveedor.setAttribute("disabled","");
            urg.removeAttribute("disabled","");
        break;
        case '4':
            contrato.removeAttribute("disabled","");
            proveedor.removeAttribute("disabled","");
            urg.options[0].selected = true;
            urg.setAttribute("disabled","");
        break;
        case '5':
            contrato.options[0].selected = true;
            contrato.setAttribute("disabled","");
            proveedor.removeAttribute("disabled","");
            urg.removeAttribute("disabled","");
        break;
        case '6':
            contrato.removeAttribute("disabled","");
            proveedor.options[0].selected = true;
            proveedor.setAttribute("disabled","");
            urg.removeAttribute("disabled","");
        break;
        case '7':
            contrato.removeAttribute("disabled","");
            proveedor.removeAttribute("disabled","");
            urg.removeAttribute("disabled","");
        break;
    }
});

const anio = document.querySelector('#anio');

anio.addEventListener('change',(e)=>{
    let trimestre = document.querySelector('#trimestre');
    trimestre.removeAttribute("disabled","");
    let de = document.querySelector('#de');
    let hasta = document.querySelector('#hasta');
    de.value = ""; 
    hasta.value = "";
});

function comprobarFechas(q) {
    anio.options[0].selected = true;
    let trimestre = document.querySelector('#trimestre');
    trimestre.setAttribute("disabled","");
    trimestre.options[0].selected = true;

    let de = $("#de").val(),
        hasta = $("#hasta").val();
    hasta = hasta.split('/');
    de = de.split('/');

    auxHasta = Date.parse(hasta[2] + '/' + hasta[1] + '/' + hasta[0]);
    auxDe = Date.parse(de[2] + '/' + de[1] + '/' + de[0]);
    switch (q) {
        case "de":
            if (auxHasta < auxDe) {
                document.getElementById("hasta").value = "";
            }
            break;
        case "hasta":
            if (!isNaN(auxHasta)) {
                if (auxHasta < auxDe) {
                    let fecha = new Date(hasta[2],hasta[1]-1,hasta[0]);
                    document.getElementById("de").value = fecha.toLocaleDateString();
                    $("#de").datepicker({ 
                        format: 'dd/mm/yyyy', 
                        setDate: fecha,  
                        language: "es",
                        daysOfWeekDisabled: [0,6],
                    }).datepicker('update');
                }
            }
            break;
    }
}